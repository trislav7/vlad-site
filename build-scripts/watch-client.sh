#!/bin/bash

echo "👀 Watching CLIENT files for changes..."
echo "📁 Watching: /var/www/html/public_html/modules/*/{css,js}/*"

# Используем inotifywait для отслеживания изменений
while true; do
    echo "🕒 Waiting for file changes..."
    
    # Ожидаем изменения в CSS и JS файлах клиента
    inotifywait -r -e modify,create,delete \
        /var/www/html/public_html/modules/*/css/ \
        /var/www/html/public_html/modules/*/js/ \
        --exclude '/var/www/html/public_html/modules/*/managers/'
    
    echo "🔄 File changed! Rebuilding client assets..."
    /usr/local/bin/build-client.sh
    echo "✅ Client rebuild completed at $(date)"
    echo "---"
done