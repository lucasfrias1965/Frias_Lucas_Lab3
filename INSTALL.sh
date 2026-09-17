#!/usr/bin/env bash
# Installs a static PHP CLI binary into ~/bin (no sudo) and runs lab.php.
set -euo pipefail

PHP_VERSION="8.4.8"
BIN_DIR="$HOME/bin"
PHP_BIN="$BIN_DIR/php"

mkdir -p "$BIN_DIR"

if [ ! -x "$PHP_BIN" ]; then
	URL="https://dl.static-php.dev/static-php-cli/common/php-${PHP_VERSION}-cli-linux-x86_64.tar.gz"
	TMP_DIR="$(mktemp -d)"
	trap 'rm -rf "$TMP_DIR"' EXIT

	echo "Downloading static PHP ${PHP_VERSION} (x86_64)..."
	curl -fsSL "$URL" -o "$TMP_DIR/php.tar.gz"

	tar -xzf "$TMP_DIR/php.tar.gz" -C "$TMP_DIR"
	find "$TMP_DIR" -type f -name php -exec cp {} "$PHP_BIN" \;
	chmod +x "$PHP_BIN"
	echo "Installed php to $PHP_BIN"
fi

# Add ~/bin to PATH for future shells if it's not already there.
for RC in "$HOME/.bashrc" "$HOME/.profile"; do
	if [ -f "$RC" ] && ! grep -qs 'HOME/bin' "$RC"; then
		echo 'export PATH="$HOME/bin:$PATH"' >> "$RC"
	fi
done

export PATH="$BIN_DIR:$PATH"

echo "php version: $("$PHP_BIN" -v | head -n1)"
echo "Running lab.php..."
"$PHP_BIN" lab.php
