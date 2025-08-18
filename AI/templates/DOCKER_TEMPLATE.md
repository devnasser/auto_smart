# 🐳 Docker Template - نمط الأسطورة ⚔️

## 📦 **Dockerfile محسن**
```dockerfile
FROM php:8.4-fpm-alpine

# تثبيت الامتدادات
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip

# تثبيت PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# إعداد مجلد العمل
WORKDIR /var/www

# نسخ ملفات المشروع
COPY . /var/www

# تثبيت التبعيات
RUN composer install --optimize-autoloader --no-dev

# إعداد الصلاحيات
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
```

## 🔧 **docker-compose.yml**
```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    image: zeropay-app
    container_name: zeropay-app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
    networks:
      - zeropay-network

  webserver:
    image: nginx:alpine
    container_name: zeropay-nginx
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/var/www
      - ./docker/nginx:/etc/nginx/conf.d
    networks:
      - zeropay-network

  database:
    image: mysql:8.0
    container_name: zeropay-mysql
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: zeropay
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_PASSWORD: secret
      MYSQL_USER: zeropay
    volumes:
      - dbdata:/var/lib/mysql
    ports:
      - "3306:3306"
    networks:
      - zeropay-network

  redis:
    image: redis:alpine
    container_name: zeropay-redis
    restart: unless-stopped
    ports:
      - "6379:6379"
    networks:
      - zeropay-network

volumes:
  dbdata:
    driver: local

networks:
  zeropay-network:
    driver: bridge
```

## ⚡ **أوامر التشغيل**
```bash
# بناء وتشغيل الحاويات
docker-compose up -d --build

# تنفيذ الأوامر داخل الحاوية
docker-compose exec app php artisan migrate
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan config:cache

# مراقبة السجلات
docker-compose logs -f app

# إيقاف الحاويات
docker-compose down
```

⚔️ **بيئة Docker محسنة وجاهزة** ⚔️