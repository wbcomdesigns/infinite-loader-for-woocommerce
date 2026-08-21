#!/usr/bin/env bash
#
# Fail when a committed minified bundle does not match what its source
# minifies to. Covers CSS and JS alike.
#
# Production serves the minified copy whenever SCRIPT_DEBUG is off, so a stale
# bundle means every customer runs assets that no longer exist in this repo.
# That is not hypothetical, and it has now happened twice:
#
#   JS  - the shipped infinite_loader_products.min.js sat four days behind its
#         source from June 2025 until August 2026, so every live store ran an
#         archive loader with no request timeout and no scroll distance check
#         while the repo looked fixed.
#   CSS - v1.3.0 shipped an admin.min.css with no FAQ accordion rules in it.
#         The accordion fix was real, was in the source, and was verified - but
#         the minified bundle customers actually load never got rebuilt, so the
#         bug the fix closed was still on every customer's screen.
#
# The CSS half is why this file now tracks both: the gate was written for JS
# only, so cssmin was never run and never compared, and CSS could go stale
# indefinitely without any gate noticing.
#
# Timestamps cannot catch this - a fresh clone rewrites every mtime - so the
# check rebuilds the bundles and compares the bytes against what is committed.

set -euo pipefail

cd "$( dirname "${BASH_SOURCE[0]}" )/.."

if [ ! -x node_modules/.bin/grunt ]; then
	echo "verify-build-freshness: grunt is not installed; run 'npm install' first." >&2
	exit 2
fi

TRACKED_DIRS="public/js/min admin/js/min public/css/min admin/css/min"

# One list, used to rebuild AND quoted in the failure message. When those were
# two literals the advice drifted from the check: the message told a developer
# to run only the uglify tasks, so following it exactly left CSS stale and the
# gate failed again on the next run.
BUILD_TASKS="uglify:public uglify:admin cssmin:public cssmin:admin"

# Keep whatever is in the tree so a run never destroys uncommitted work.
SCRATCH="$( mktemp -d )"
trap 'rm -rf "$SCRATCH"' EXIT
for dir in $TRACKED_DIRS; do
	if [ -d "$dir" ]; then
		mkdir -p "$SCRATCH/$dir"
		cp -R "$dir/." "$SCRATCH/$dir/"
	fi
done

node_modules/.bin/grunt $BUILD_TASKS >/dev/null

# Compare against HEAD, not the working tree, so staged-but-uncommitted
# bundles cannot mask a stale commit.
STALE="$( git diff --name-only HEAD -- $TRACKED_DIRS )"

# Put the caller's files back before reporting either way.
for dir in $TRACKED_DIRS; do
	if [ -d "$SCRATCH/$dir" ]; then
		cp -R "$SCRATCH/$dir/." "$dir/"
	fi
done

if [ -z "$STALE" ]; then
	echo "verify-build-freshness: OK - every committed bundle matches its source."
	exit 0
fi

echo "verify-build-freshness: FAILED - these bundles do not match their sources:" >&2
echo "$STALE" >&2
echo >&2
echo "Production serves these files, so shipping now would release assets that" >&2
echo "do not match this repo. Rebuild and commit them:" >&2
echo "    npx grunt $BUILD_TASKS && git add $TRACKED_DIRS" >&2
exit 1
