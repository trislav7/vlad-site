#!/bin/bash

echo "=== Building CLIENT assets ==="

cd /var/www/html

mkdir -p /var/www/html/public_html/assets/client

echo "🔍 Searching for CSS and JS files..."

# Сборка CSS
echo "📁 Processing CSS files..."
find /var/www/html/public_html/modules -name "*.css" -path "*/css/*" ! -path "*/managers/*" | while read css_file; do
    if [ -f "$css_file" ]; then
        module_name=$(echo "$css_file" | grep -o 'modules/[^/]*' | cut -d'/' -f2)
        filename=$(basename "$css_file" .css)
        output_dir="/var/www/html/public_html/assets/client/${module_name}"

        mkdir -p "$output_dir"

        # Проверяем есть ли Tailwind директивы в файле
        if grep -q "@tailwind" "$css_file"; then
            echo "🔄 Processing with Tailwind: $css_file"
            npx tailwindcss -i "$css_file" -o "${output_dir}/${filename}.min.css" --config /tmp/tailwind.config.js --minify
        else
            echo "📦 Copying plain CSS: $css_file"
            cp "$css_file" "${output_dir}/${filename}.min.css"
        fi
        echo "✅ CSS: $module_name/${filename}.min.css"
    fi
done

# Сборка JS - ИСПРАВЛЕННАЯ ЧАСТЬ
echo "📁 Processing JS files..."
find /var/www/html/public_html/modules -name "*.js" -path "*/js/*" ! -path "*/managers/*" | while read js_file; do
    if [ -f "$js_file" ]; then
        module_name=$(echo "$js_file" | grep -o 'modules/[^/]*' | cut -d'/' -f2)
        filename=$(basename "$js_file" .js)
        output_dir="/var/www/html/public_html/assets/client/${module_name}"

        mkdir -p "$output_dir"

        echo "🔄 Processing JS: $js_file"

        # Минификация JS
        if command -v npx &> /dev/null && npx uglify-js --version &> /dev/null; then
            npx uglify-js "$js_file" -o "${output_dir}/${filename}.min.js" --compress --mangle
            echo "✅ JS (minified): $module_name/${filename}.min.js"
        else
            # Просто копируем если uglify-js не доступен
            cp "$js_file" "${output_dir}/${filename}.min.js"
            echo "✅ JS (copied): $module_name/${filename}.min.js"
        fi
    fi
done

echo "✅ Client build completed!"

echo "🔧 Fixing permissions..."
chown -R developer:developer /var/www/html/public_html/assets/ 2>/dev/null || true
chmod -R 755 /var/www/html/public_html/assets/ 2>/dev/null || true

# Дополнительная проверка - что собралось
echo "📊 Build results:"
find /var/www/html/public_html/assets/client -name "*.js" -o -name "*.css" | while read file; do
    echo "📄 $(basename $(dirname "$file"))/$(basename "$file")"
done