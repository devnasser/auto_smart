# 📋 قالب Laravel الأساسي - نمط الأسطورة ⚔️

## 🎯 **نظرة عامة**
قالب Laravel أساسي يحتوي على المكونات الأساسية لبدء مشروع جديد

---

## ✨ **المميزات المتضمنة**

### 🔧 **التقنيات الأساسية:**
- ✅ Laravel 11
- ✅ Livewire 3  
- ✅ SQLite
- ✅ Bootstrap 5
- ✅ FontAwesome Icons

### 🏗️ **المكونات الجاهزة:**
- ✅ نظام مصادقة بسيط
- ✅ لوحة تحكم أساسية
- ✅ إدارة المستخدمين
- ✅ نظام الصلاحيات
- ✅ سجل الأنشطة

### 🎨 **واجهة المستخدم:**
- ✅ تصميم متجاوب
- ✅ دعم RTL للعربية
- ✅ ألوان وثيم موحد
- ✅ مكونات Bootstrap محسنة

---

## 📁 **هيكل القالب**

```
basic/
├── 📄 app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   └── UserController.php
│   │   └── Livewire/
│   │       ├── Auth/
│   │       │   ├── Login.php
│   │       │   └── Register.php
│   │       ├── Dashboard/
│   │       │   ├── Stats.php
│   │       │   └── RecentActivity.php
│   │       └── Users/
│   │           ├── UserList.php
│   │           └── UserForm.php
│   └── Models/
│       ├── User.php
│       └── Activity.php
│
├── 📄 resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── livewire/
│       │   ├── auth/
│       │   ├── dashboard/
│       │   └── users/
│       ├── dashboard.blade.php
│       └── welcome.blade.php
│
├── 📄 database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_roles_permissions_tables.php
│   │   └── create_activities_table.php
│   └── seeders/
│       ├── UserSeeder.php
│       └── RolePermissionSeeder.php
│
└── 📄 routes/
    └── web.php
```

---

## 🚀 **كيفية الاستخدام**

### 1️⃣ **إنشاء مشروع جديد:**
```bash
php projects/scripts/create-project.php my-project basic
```

### 2️⃣ **تشغيل المشروع:**
```bash
php projects/scripts/serve-project.php my-project
```

### 3️⃣ **الوصول للتطبيق:**
- الرئيسية: `http://localhost:8000`
- لوحة التحكم: `http://localhost:8000/dashboard`
- تسجيل الدخول: `http://localhost:8000/login`

---

## 👤 **المستخدمين الافتراضيين**

### 🔑 **المدير العام:**
- البريد: `admin@example.com`
- كلمة المرور: `password`
- الصلاحيات: جميع الصلاحيات

### 👤 **مستخدم عادي:**
- البريد: `user@example.com`
- كلمة المرور: `password`
- الصلاحيات: القراءة فقط

---

## 🎨 **التخصيص**

### 🎨 **تغيير الألوان:**
```css
/* في resources/css/app.css */
:root {
    --primary-color: #your-color;
    --secondary-color: #your-color;
}
```

### 🏠 **تخصيص لوحة التحكم:**
```php
// في app/Http/Livewire/Dashboard/Stats.php
public function getStats()
{
    return [
        'users' => User::count(),
        'activities' => Activity::count(),
        // إضافة إحصائيات جديدة
    ];
}
```

### 🔧 **إضافة صفحات جديدة:**
```bash
php artisan make:livewire Pages/MyPage
```

---

## 📋 **المهام المتاحة**

### ⚡ **أوامر Artisan:**
```bash
# تحسين الأداء
php artisan optimize

# تنظيف الكاش
php artisan cache:clear

# إنشاء مستخدم جديد
php artisan make:user

# عرض الإحصائيات
php artisan stats:show
```

### 🧪 **الاختبارات:**
```bash
# تشغيل جميع الاختبارات
php artisan test

# اختبار مكون معين
php artisan test --filter=UserTest
```

---

## 🔐 **الأمان**

### ✅ **التطبيقات المفعلة:**
- ✅ CSRF Protection
- ✅ XSS Protection  
- ✅ SQL Injection Prevention
- ✅ Rate Limiting
- ✅ Password Hashing
- ✅ Session Security
- ✅ File Upload Security
- ✅ Input Validation

### 🛡️ **الصلاحيات:**
- `view-dashboard` - عرض لوحة التحكم
- `manage-users` - إدارة المستخدمين
- `view-reports` - عرض التقارير
- `system-settings` - إعدادات النظام

---

## 📈 **الأداء**

### ⚡ **التحسينات المطبقة:**
- ✅ OPcache enabled
- ✅ Query optimization
- ✅ Asset minification
- ✅ Lazy loading
- ✅ Caching strategies
- ✅ Database indexing

### 📊 **المقاييس المتوقعة:**
- **وقت التحميل:** < 200ms
- **استهلاك الذاكرة:** < 50MB
- **حجم الصفحة:** < 500KB
- **نقاط الأداء:** 90+/100

---

## 🆘 **الدعم والمساعدة**

### 📚 **الوثائق:**
- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://laravel-livewire.com)
- [Bootstrap Documentation](https://getbootstrap.com)

### 🐛 **الإبلاغ عن الأخطاء:**
- إنشاء Issue في المستودع
- إرسال بريد إلكتروني: dev.na@outlook.com

---

⚔️ **قالب أساسي محسن - جاهز للاستخدام الفوري** ⚔️