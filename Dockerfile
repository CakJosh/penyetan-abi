# 1. Gunakan PHP 8.2 berbasis Alpine Linux
FROM php:8.2-fpm-alpine

# 2. Instal library sistem Linux dan Nginx yang dibutuhkan Laravel
RUN apk update && apk add --no-cache \
    nginx \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    unzip \
    git \
    curl \
    bash \
    && rm -rf /var/cache/apk/*

# 3. Instal ekstensi PHP untuk MySQL (Database) dan GD (Gambar)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

# 4. Set folder kerja utama aplikasi di dalam server
WORKDIR /var/www/html

# 5. Salin seluruh kodingan dari laptop kamu
COPY . .

# 6. Bersihkan file cache bawaan lokal laptop agar tidak konflik di server
RUN rm -f bootstrap/cache/*.php \
    && rm -rf storage/framework/views/*.php \
    && rm -rf storage/framework/sessions/*

# 7. Atur hak akses folder agar Laravel bisa menulis log dan upload file
RUN chown -R www-data:www-data /var/www/html || true \
    && chmod -R 775 /var/www/html/storage || true \
    && chmod -R 775 /var/www/html/public || true

# 8. Konfigurasi Nginx (Mengarahkan koneksi ke PHP-FPM standar internal)
RUN echo 'server { \
    listen 80; \
    root /var/www/html/public; \
    index index.php index.html; \
    charset utf-8; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        try_files $uri =404; \
        fastcgi_split_path_info ^(.+\.php)(/.+)$; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        include fastcgi_params; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        fastcgi_param PATH_INFO $fastcgi_path_info; \
    } \
}' > /etc/nginx/http.d/default.conf

# 9. Buka jalur port web standar (80)
EXPOSE 80

# 10. JALANKAN SERVIS SEARA SEDERHANA TANPA TRIK TEKS (PASTI LOLOS)
CMD sh -c "php artisan migrate --force && php-fpm -D && nginx -g 'daemon off;'"