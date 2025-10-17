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

# Создаем тестовый файл
cat > /var/www/html/public_html/index.php << 'EOF'
<?php
echo "<h1>✅ PHP is working!</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
?>
EOF

# Создаем базовые модули для тестирования сборки
mkdir -p /var/www/html/public_html/modules/shop/{css,js,managers/{css,js}}

# Тестовый CSS
cat > /var/www/html/public_html/modules/shop/css/main.css << 'EOF'
.btn-primary {
    background: blue;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
EOF

# Тестовый JS
cat > /var/www/html/public_html/modules/shop/js/app.js << 'EOF'
console.log('Shop module loaded');
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.btn-primary')?.addEventListener('click', function() {
        alert('Build system working!');
    });
});
EOF

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

# Проверяем Nginx
echo "Testing Nginx configuration..."
nginx -t

# Запускаем Nginx
echo "🌐 Starting Nginx..."
echo "🎉 Server is ready!"
echo "📍 Access: http://localhost"

exec nginx -g "daemon off;"