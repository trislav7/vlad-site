#!/bin/bash

echo "=== Building ADMIN assets ==="

# Создаем директории
mkdir -p /var/www/html/public_html/assets/admin

# Проверяем есть ли модули
if [ ! -d "/var/www/html/public_html/modules" ]; then
    echo "⚠️ No modules found for admin build"
    exit 0
fi

# Сборка CSS для админки
find /var/www/html/public_html/modules -name "*.css" -path "*/managers/css/*" | while read css_file; do
    if [ -f "$css_file" ]; then
        module_name=$(echo "$css_file" | grep -o 'modules/[^/]*' | cut -d'/' -f2)
        filename=$(basename "$css_file" .css)
        output_dir="/var/www/html/public_html/assets/admin/${module_name}"
        
        mkdir -p "$output_dir"
        cp "$css_file" "${output_dir}/${filename}.min.css"
        echo "✅ Admin CSS: $module_name/${filename}.min.css"
    fi
done

# Сборка JS для админки
find /var/www/html/public_html/modules -name "*.js" -path "*/managers/js/*" | while read js_file; do
    if [ -f "$js_file" ]; then
        module_name=$(echo "$js_file" | grep -o 'modules/[^/]*' | cut -d'/' -f2)
        filename=$(basename "$js_file" .js)
        output_dir="/var/www/html/public_html/assets/admin/${module_name}"
        
        mkdir -p "$output_dir"
        
        # Простая минификация
        sed 's/\/\/.*//g' "$js_file" | tr -s '\n' '\n' > "${output_dir}/${filename}.min.js"
        echo "✅ Admin JS: $module_name/${filename}.min.js"
    fi
done

echo "✅ Admin build completed!"