# 1. Gunakan image PHP resmi dengan Apache
FROM php:8.2-apache

# 2. Instal library sistem Linux yang dibutuhkan oleh Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# 3. Konfigurasi dan instal ekstensi PHP (PDO MySQL & GD)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

# 4. Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# 5. Set folder kerja utama
WORKDIR /var/www/html

# 6. Salin seluruh kodingan dari laptop kamu
COPY . .

# 7. Bersihkan file cache sampah bawaan lokal laptop agar tidak konflik
RUN rm -f bootstrap/cache/*.php \
    && rm -rf storage/framework/views/*.php \
    && rm -rf storage/framework/sessions/*

# 8. Berikan hak akses (permission) penuh ke folder storage dan public
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/public

# 9. Ubah Document Root Apache ke folder public bawaan Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 10. Buka jalur port web standar (80)
EXPOSE 80

# 11. LANGSUNG JALANKAN APACHE (TANPA EMBEL-EMBEL MIGRATE YANG BIKIN MACET)
CMD ["apache2-foreground"]