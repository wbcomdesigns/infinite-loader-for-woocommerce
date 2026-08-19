#!/usr/bin/env bash
#
# Fail when a committed .min.js does not match what its source minifies to.
#
# Production serves .min.js whenever SCRIPT_DEBUG is off, so a stale bundle
# means every customer runs code that no longer exists in this repo. That is
# not hypothetical: the shipped infinite_loader_products.min.js sat four days
# behind its source from June 2025 until August 2026, so every live store ran
# an archive loader with no request timeout and no scroll distance check while
# the repo looked fixed.
#
# Timestamps cannot catch this - a fresh clone rewrites every mtime - so the
# check rebuilds the bundles and compares the bytes against what is committed.

set -euo pipefail

cd "$( dirname "${BASH_SOURCE[0]}" )/.."

if [ ! -x node_modules/.bin/grunt ]; then
	echo "verify-build-freshness: grunt is not installed; run 'npm install' first." >&2
	exit 2
fi

TRACKED_DIRS="public/js/min admin/js/min"

# Keep whatever is in the tree so a run never destroys uncommitted work.
SCRATCH="$( mktemp -d )"
trap 'rm -rf "$SCRATCH"' EXIT
for dir in $TRACKED_DIRS; do
	if [ -d "$dir" ]; then
		mkdir -p "$SCRATCH/$dir"
		cp -R "$dir/." "$SCRATCH/$dir/"
	fi
done

node_modules/.bin/grunt uglify:public uglify:admin >/dev/null

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
echo "Production serves these files, so shipping now would release code that" >&2
echo "does not match this repo. Rebuild and commit them:" >&2
echo "    npx grunt uglify:public uglify:admin && git add $TRACKED_DIRS" >&2
exit 1
