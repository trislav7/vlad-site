#!/bin/bash

echo "👀 Watching ADMIN files for changes..."
echo "📁 Watching: /var/www/html/public_html/modules/*/managers/{css,js}/*"

while true; do
    echo "🕒 Waiting for file changes..."
    
    # Ожидаем изменения в CSS и JS файлах админки
    inotifywait -r -e modify,create,delete \
        /var/www/html/public_html/modules/*/managers/css/ \
        /var/www/html/public_html/modules/*/managers/js/
    
    echo "🔄 File changed! Rebuilding admin assets..."
    /usr/local/bin/build-admin.sh
    echo "✅ Admin rebuild completed at $(date)"
    echo "---"
done