# Gunakan image PHP + Apache
FROM php:8.2-cli

# Install ekstensi yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Tentukan direktori kerja dalam container
WORKDIR /app

# Salin file proyek Lumen ke dalam container
COPY . .

# Install dependensi Lumen
RUN composer install --no-dev --optimize-autoloader

# Expose port untuk Lumen
EXPOSE 8000

# Jalankan Lumen saat container dimulai
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
