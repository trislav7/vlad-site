#!/bin/bash

echo "=== Building CLIENT assets ==="

mkdir -p /var/www/html/public_html/assets/client

# Сборка CSS с Tailwind
find /var/www/html/public_html/modules -name "*.css" -path "*/css/*" ! -path "*/managers/*" | while read css_file; do
    if [ -f "$css_file" ]; then
        module_name=$(echo "$css_file" | grep -o 'modules/[^/]*' | cut -d'/' -f2)
        filename=$(basename "$css_file" .css)
        output_dir="/var/www/html/public_html/assets/client/${module_name}"
        
        mkdir -p "$output_dir"
        
        # Сборка с Tailwind CSS
        npx tailwindcss -i "$css_file" -o "${output_dir}/${filename}.min.css" --config /tmp/tailwind.config.js --minify
        echo "✅ CSS with Tailwind: $css_file → ${output_dir}/${filename}.min.css"
    fi
done

# Остальная часть скрипта для JS...