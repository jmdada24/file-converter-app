FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    pkg-config \
    libzip-dev \
    libsqlite3-dev \
    sqlite3 \
    zip \
    nodejs \
    npm \
    imagemagick \
    ghostscript \
    poppler-utils \
    python3 \
    python3-pip \
    python3-venv \
    && docker-php-ext-install pdo_sqlite zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY python/requirements.txt /tmp/python-requirements.txt

RUN python3 -m venv /opt/venv \
    && /opt/venv/bin/pip install --upgrade pip \
    && /opt/venv/bin/pip install --no-cache-dir -r /tmp/python-requirements.txt

COPY . .

RUN mkdir -p \
    bootstrap/cache \
    storage/app/temp \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    && chmod -R 775 bootstrap/cache storage

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV PYTHON_BINARY=/opt/venv/bin/python
ENV IMAGEMAGICK_BINARY=magick
ENV GHOSTSCRIPT_BINARY=gs

EXPOSE 8000

CMD sh -c "php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"