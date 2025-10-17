FROM ubuntu:22.04

ENV TZ=Europe/Moscow
ENV DEBIAN_FRONTEND=noninteractive

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Устанавливаем пакеты в несколько RUN для надежности
RUN apt-get update && apt-get install -y \
    nginx \
    php8.1-fpm \
    php8.1-mysql \
    php8.1-cli \
    curl \
    wget \
    vim \
    git \
    procps \
    net-tools \
    iputils-ping \
    dnsutils \
    htop \
    inotify-tools

# Устанавливаем Node.js отдельно
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Очистка
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Настраиваем PHP-FPM для работы на порту 9000
RUN sed -i 's/listen = \/run\/php\/php8.1-fpm.sock/listen = 127.0.0.1:9000/g' /etc/php/8.1/fpm/pool.d/www.conf

# Создаем директории
RUN mkdir -p /var/www/html/public_html /run/php
RUN chown -R www-data:www-data /var/www/html

# Копируем конфиги
COPY nginx.conf /etc/nginx/nginx.conf
COPY package.json /tmp/package.json
COPY start.sh /start.sh

# Устанавливаем npm зависимости
RUN cd /tmp && npm install

# Копируем скрипты сборки
COPY build-scripts/ /usr/local/bin/
RUN chmod +x /usr/local/bin/*.sh

RUN chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]