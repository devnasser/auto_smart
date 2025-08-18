# 🚀 دليل إعداد Laravel - نمط الأسطورة ⚔️

## 🎯 **مقدمة**
دليل شامل لإعداد وتكوين Laravel في بيئة Auto Smart Monorepo

---

## 📋 **المتطلبات الأساسية**

### 🔧 **متطلبات النظام:**
```bash
PHP 8.4+ مع Extensions:
├── php-sqlite3      # دعم SQLite
├── php-pdo          # قاعدة البيانات
├── php-mbstring     # معالجة النصوص
├── php-xml          # معالجة XML
├── php-curl         # طلبات HTTP
├── php-zip          # ضغط الملفات
├── php-gd           # معالجة الصور
├── php-intl         # الدولية
├── php-bcmath       # العمليات الرياضية
└── php-opcache      # تحسين الأداء
```

### 📦 **أدوات التطوير:**
```bash
Composer 2.8+        # مدير حزم PHP
SQLite 3.46+         # قاعدة البيانات
Git 2.40+           # إدارة الإصدارات (اختياري)
```

---

## 🏗️ **إعداد Laravel في Monorepo**

### 1️⃣ **إنشاء Laravel Core:**
```bash
# الانتقال لمجلد projects
cd projects/core

# إنشاء Laravel جديد
composer create-project laravel/laravel . --prefer-dist

# تثبيت Livewire
composer require livewire/livewire

# تثبيت حزم إضافية
composer require spatie/laravel-permission
composer require intervention/image
```

### 2️⃣ **تكوين قاعدة البيانات:**
```php
// config/database.php
'default' => env('DB_CONNECTION', 'sqlite'),

'connections' => [
    'sqlite' => [
        'driver' => 'sqlite',
        'url' => env('DATABASE_URL'),
        'database' => database_path('database.sqlite'),
        'prefix' => '',
        'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
    ],
],
```

### 3️⃣ **إعداد متغيرات البيئة:**
```env
# .env
APP_NAME="Auto Smart"
APP_ENV=local
APP_KEY=base64:your-app-key-here
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
```

---

## ⚡ **تحسينات الأداء**

### 🔧 **تحسينات Composer:**
```bash
# تحسين autoloader
composer dump-autoload --optimize --classmap-authoritative

# إزالة dev dependencies في الإنتاج
composer install --no-dev --optimize-autoloader
```

### 🚀 **تحسينات Laravel:**
```bash
# تخزين التكوينات مؤقتاً
php artisan config:cache

# تخزين المسارات مؤقتاً
php artisan route:cache

# تخزين العروض مؤقتاً
php artisan view:cache

# تخزين الأحداث مؤقتاً
php artisan event:cache
```

### 📊 **تحسين OPcache:**
```ini
; php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.validate_timestamps=0
opcache.save_comments=1
opcache.fast_shutdown=1
```

---

## 🔐 **إعدادات الأمان**

### 🛡️ **تأمين التطبيق:**
```php
// config/app.php
'debug' => env('APP_DEBUG', false),
'env' => env('APP_ENV', 'production'),

// إخفاء معلومات الخادم
'cipher' => 'AES-256-GCM',
```

### 🔒 **تأمين قاعدة البيانات:**
```php
// config/database.php
'sqlite' => [
    'driver' => 'sqlite',
    'database' => database_path('database.sqlite'),
    'foreign_key_constraints' => true,
    'options' => [
        PDO::ATTR_TIMEOUT => 30,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ],
],
```

---

## 🧪 **الاختبار والتحقق**

### ✅ **فحص التثبيت:**
```bash
# فحص إصدار PHP
php -v

# فحص extensions
php -m | grep -E "(sqlite|pdo|mbstring)"

# فحص Composer
composer --version

# فحص Laravel
php artisan --version
```

### 🔍 **اختبار التطبيق:**
```bash
# إنشاء قاعدة البيانات
touch database/database.sqlite

# تشغيل migrations
php artisan migrate

# تشغيل الخادم
php artisan serve

# اختبار في المتصفح
curl http://localhost:8000
```

---

## 🔧 **إعدادات متقدمة**

### 📱 **Livewire Configuration:**
```php
// config/livewire.php
return [
    'class_namespace' => 'App\\Http\\Livewire',
    'view_path' => resource_path('views/livewire'),
    'layout' => 'layouts.app',
    'asset_url' => null,
    'app_url' => null,
    'middleware_group' => 'web',
    'temporary_file_upload' => [
        'disk' => null,
        'rules' => null,
        'directory' => null,
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5,
    ],
];
```

### 🗄️ **SQLite Optimization:**
```php
// في ServiceProvider
public function boot()
{
    if (DB::connection() instanceof SQLiteConnection) {
        DB::statement('PRAGMA journal_mode=WAL');
        DB::statement('PRAGMA synchronous=NORMAL');
        DB::statement('PRAGMA cache_size=10000');
        DB::statement('PRAGMA temp_store=MEMORY');
    }
}
```

---

## 🚨 **استكشاف الأخطاء**

### ❌ **مشاكل شائعة وحلولها:**

#### **مشكلة: SQLite database locked**
```bash
# الحل
sudo chown -R www-data:www-data storage/
sudo chmod -R 775 storage/
sudo chmod 664 database/database.sqlite
```

#### **مشكلة: Class not found**
```bash
# الحل
composer dump-autoload
php artisan clear-compiled
php artisan config:clear
```

#### **مشكلة: Permission denied**
```bash
# الحل
sudo chown -R $USER:$USER .
chmod -R 755 storage bootstrap/cache
```

---

## 📚 **موارد إضافية**

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://laravel-livewire.com/docs)
- [SQLite Documentation](https://sqlite.org/docs.html)
- [PHP Manual](https://www.php.net/manual/)

---

⚔️ **دليل Laravel مكتمل - جاهز للاستخدام بنمط الأسطورة** ⚔️