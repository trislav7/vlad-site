#!/bin/bash

set -e

echo "=== Starting Vlad Site ==="

# Создаем директории
mkdir -p /var/log/nginx /var/www/html/public_html/assets/{client,admin}
chown -R www-data:www-data /var/www/html

# Копируем package.json в правильное место
echo "Setting up build system..."
if [ -f "/tmp/package.json" ]; then
    cp /tmp/package.json /var/www/html/package.json
    echo "✅ package.json copied to /var/www/html/"
else
    echo "⚠️ package.json not found in /tmp/"
fi

# Запускаем PHP-FPM
echo "Starting PHP-FPM..."
service php8.1-fpm start
sleep 2

# Устанавливаем npm зависимости в правильной директории
echo "Installing npm dependencies..."
if [ -f "/var/www/html/package.json" ]; then
    cd /var/www/html && npm install --silent
    echo "✅ npm dependencies installed"
else
    echo "❌ package.json not found for npm install"
fi

# Первая сборка
if [ ! -f "/var/www/html/.built" ] && [ -f "/var/www/html/package.json" ]; then
    echo "📦 Running first build..."
    cd /var/www/html
    if npm run build:all; then
        touch /var/www/html/.built
        echo "✅ Build completed successfully"
    else
        echo "⚠️ Build had issues, but continuing..."
    fi
fi


if [ ! -f "/var/www/html/.watch-started" ]; then
    echo "🚀 Starting watch processes in background..."
    cd /var/www/html
    npm run watch:all &
    touch /var/www/html/.watch-started
    echo "✅ Watch processes started"
fi
# ✅ ДОБАВЛЯЕМ: Исправляем права при запуске
echo "🔧 Setting correct permissions..."
chown -R developer:developer /var/www/html/public_html/assets/ 2>/dev/null || true
chmod -R 755 /var/www/html/public_html/assets/ 2>/dev/null || true

# Проверяем Nginx
echo "Testing Nginx configuration..."
nginx -t

# Запускаем Nginx
echo "🌐 Starting Nginx..."
echo "🎉 Server is ready!"
echo "📍 Access: http://localhost"

exec nginx -g "daemon off;"