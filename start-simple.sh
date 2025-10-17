#!/bin/bash

# Создаем тестовый PHP файл
mkdir -p /var/www/html
cat > /var/www/html/index.php << 'EOF'
<?php
echo "<h1>✅ PHP + Nginx is working!</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
phpinfo();
?>
EOF

# Запускаем PHP-FPM (уже запущен в базовом образе)
# Запускаем Nginx
nginx -g "daemon off;"