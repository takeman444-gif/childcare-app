FROM php:8.4-apache

# 必要な拡張機能をインストール
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libpq-dev \
    nodejs npm \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apacheの設定
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

# ファイルをコピー
WORKDIR /var/www/html
COPY . .

# PHP依存関係インストール
RUN composer install --no-dev --optimize-autoloader

# フロントエンドのビルド
RUN npm install && npm run build

# 権限設定
RUN chown -R www-data:www-data storage bootstrap/cache

# 起動スクリプト
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]
