#!/bin/bash

echo "👀 WATCH-CLIENT FIXED VERSION"
echo "📁 Watching: /var/www/html/public_html/modules/"
echo "🚀 Started at: $(date)"
echo "⏹️  Press Ctrl+C to stop"

cd /var/www/html

# Проверяем доступность inotify
if ! command -v inotifywait &> /dev/null; then
    echo "❌ inotifywait not found. Using polling method..."
    # Будем использовать polling ниже
    USE_INOTIFY=false
else
    echo "✅ inotifywait available"
    USE_INOTIFY=true
fi

if [ "$USE_INOTIFY" = true ]; then
    # ВЕРСИЯ С INOTIFY - с улучшенными параметрами
    while true; do
        echo "🕒 Waiting for file changes (inotify)..."

        # Используем -q для тихого режима и -t для таймаута
        if inotifywait -r -q -e modify,create,delete --timeout 300 \
            /var/www/html/public_html/modules/ \
            --exclude '/var/www/html/public_html/modules/*/managers/'; then

            echo "🔄 Change detected! Building..."
            /usr/local/bin/build-client.sh
            echo "✅ Build completed at $(date)"
            echo "---"
        else
            # Таймаут - просто продолжаем цикл
            echo "⏰ No changes in 300 seconds, still watching..."
        fi
    done
else
    # ВЕРСИЯ С POLLING - гарантированно работает
    echo "🔄 Using polling method (check every 3 seconds)"

    while true; do
        echo "🔍 Checking for changes..."
        /usr/local/bin/build-client.sh
        echo "💤 Sleeping 3 seconds..."
        sleep 3
    done
fi

echo "🔧 Fixing permissions..."
chown -R developer:developer /var/www/html/public_html/assets/ 2>/dev/null || true
chmod -R 755 /var/www/html/public_html/assets/ 2>/dev/null || true