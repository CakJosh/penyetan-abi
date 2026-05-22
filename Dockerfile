# 1. Gunakan image PHP resmi yang sudah lengkap dengan web server Apache
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

# 3. Konfigurasi dan instal ekstensi PHP (PDO MySQL untuk database & GD untuk gambar)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

# 4. FIX ERROR MPM: Aktifkan mod_rewrite dan pastikan HANYA mpm_prefork yang jalan (matikan mpm_event)
RUN a2enmod rewrite \
    && a2dismod mpm_event || true \
    && a2enmod mpm_prefork || true

# 5. Set folder kerja utama di dalam server Linux
WORKDIR /var/www/html

# 6. Salin seluruh kodingan dari laptop kamu ke dalam server Linux
COPY . .

# 7. Berikan hak akses (permission) penuh ke folder storage dan public asset agar fitur upload foto berjalan lancar
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/public

# 8. Ubah Document Root Apache agar langsung mengarah ke folder public bawaan Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 9. Buka jalur port web standar (80)
EXPOSE 80

# 10. Jalankan Apache Web Server di latar belakang secara otomatis
CMD ["apache2-foreground"]