#!/usr/bin/env bash
#
# Build the customer zip, then prove it is actually shippable.
#
# The checks below are not ceremony. Two of them exist because of real Wbcom
# releases: a zip that shipped with a bundled SDK's sources stripped by an
# unanchored exclude glob, and a plugin whose production bundle was months
# behind its source. Both passed every dev-tree gate, because the source tree
# was fine and only the package was wrong. So the assertions run against the
# ARTIFACT, by name, and delete the zip if any of them fails.

set -euo pipefail

cd "$( dirname "${BASH_SOURCE[0]}" )/.."

SLUG="infinite-loader-for-woocommerce"
VERSION="$( grep -m1 "^ \* Version:" "$SLUG.php" | awk '{print $3}' )"
DIST="dist"
STAGE="$DIST/$SLUG"
ZIP="$DIST/$SLUG-$VERSION.zip"

if [ -z "$VERSION" ]; then
	echo "build-release: could not read a version from $SLUG.php" >&2
	exit 1
fi

# --- Gate 1: the version must agree everywhere it is written down. ----------
# A mismatch here is what makes WordPress offer an update that never applies.
CONST_VERSION="$( grep -m1 "define( 'INFINITE_LOADER_FOR_WOOCOMMERCE_VERSION'" "$SLUG.php" | sed "s/.*'\([0-9.]*\)'.*/\1/" )"
README_VERSION="$( grep -m1 "^Stable tag:" README.txt | awk '{print $3}' )"
PKG_VERSION="$( node -p "require('./package.json').version" 2>/dev/null || echo "$VERSION" )"

for pair in "constant:$CONST_VERSION" "readme:$README_VERSION" "package.json:$PKG_VERSION"; do
	name="${pair%%:*}"; value="${pair##*:}"
	if [ "$value" != "$VERSION" ]; then
		echo "build-release: version mismatch - header says $VERSION, $name says $value" >&2
		exit 1
	fi
done
echo "build-release: version $VERSION agrees across header, constant, readme and package.json"

# --- Gate 2: PHP must parse. -----------------------------------------------
find . -name '*.php' -not -path './node_modules/*' -not -path './dist/*' -not -path './.git/*' \
	-print0 | xargs -0 -n1 -P4 php -l > /dev/null
echo "build-release: PHP lint clean"

# --- Gate 3: shipped bundles must match their sources. ----------------------
bash bin/verify-build-freshness.sh

# --- Stage, honouring .distignore. -----------------------------------------
rm -rf "$DIST"
mkdir -p "$STAGE"

EXCLUDES=()
while IFS= read -r line; do
	[ -z "$line" ] && continue
	case "$line" in \#*) continue ;; esac
	EXCLUDES+=( --exclude "$line" )
done < .distignore

rsync -a "${EXCLUDES[@]}" ./ "$STAGE/"

( cd "$DIST" && zip -qr "$SLUG-$VERSION.zip" "$SLUG" )

# --- Gate 4: assert NAMED FILES inside the artifact. ------------------------
# Directory-level checks are not enough: the files that go missing are usually
# the ones sitting outside an obvious directory, and a zip with an empty dir
# still "contains" it.
REQUIRED_FILES=(
	"$SLUG/$SLUG.php"
	"$SLUG/README.txt"
	"$SLUG/includes/class-infinite-loader-for-woocommerce.php"
	"$SLUG/admin/class-infinite-loader-for-woocommerce-admin.php"
	"$SLUG/public/class-infinite-loader-for-woocommerce-public.php"
	"$SLUG/public/js/infinite_loader_products.js"
	"$SLUG/public/js/min/infinite_loader_products.min.js"
	"$SLUG/lib/wbcom-settings/loader.php"
	"$SLUG/lib/wbcom-settings/class-wbcom-settings-page.php"
	"$SLUG/lib/wbcom-settings/settings.css"
	"$SLUG/lib/wbcom-settings/settings.js"
	"$SLUG/assets/vendor/lucide.min.js"
	"$SLUG/edd-license/edd-plugin-license.php"
	"$SLUG/edd-license/class-edd-wb-infinite-loader-plugin-updater.php"
)

# List the archive ONCE. Piping `unzip | grep -q` per file looks tidier but is
# quietly broken under `set -o pipefail`: grep exits as soon as it matches, unzip
# takes SIGPIPE, and the pipeline reports failure for a file that is present.
# That produced random "missing" files that were in the zip all along.
ZIP_CONTENTS="$( unzip -Z1 "$ZIP" )"

MISSING=0
for f in "${REQUIRED_FILES[@]}"; do
	if ! printf '%s\n' "$ZIP_CONTENTS" | grep -Fxq -- "$f"; then
		echo "build-release: MISSING FROM ZIP: $f" >&2
		MISSING=1
	fi
done

# --- Gate 5: dev artefacts must NOT be in the artifact. ---------------------
while IFS= read -r leaked; do
	echo "build-release: DEV FILE LEAKED INTO ZIP: $leaked" >&2
	MISSING=1
done < <( printf '%s\n' "$ZIP_CONTENTS" | grep -E "/(node_modules|\.git|bin|dist)/|/(CLAUDE\.md|package\.json|gruntfile\.js|\.distignore)$" || true )

if [ "$MISSING" -ne 0 ]; then
	rm -f "$ZIP"
	echo "build-release: FAILED - zip deleted so a broken package cannot be shipped by accident." >&2
	exit 1
fi

rm -rf "$STAGE"
echo "build-release: OK - $ZIP ($( du -h "$ZIP" | cut -f1 )), $( printf '%s\n' "$ZIP_CONTENTS" | wc -l | tr -d ' ' ) files"
