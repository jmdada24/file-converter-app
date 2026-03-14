FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    pkg-config \
    procps \
    libzip-dev \
    libsqlite3-dev \
    sqlite3 \
    zip \
    nodejs \
    npm \
    imagemagick \
    ghostscript \
    && docker-php-ext-install pdo_sqlite zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN mkdir -p bootstrap/cache storage/app/temp storage/framework/cache storage/framework/sessions storage/framework/views \
    && chmod -R 775 bootstrap/cache storage

RUN composer install
RUN npm install

EXPOSE 8000 5173

CMD ["composer", "run", "dev"]