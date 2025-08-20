#!/usr/bin/env php
<?php

/**
 * سكريبت إنشاء مشروع Laravel جديد - نمط الأسطورة ⚔️
 * 
 * @author ناصر العنزي - Nasser Alanazi
 * @version 3.0.0
 */

echo "🚀 مرحباً بك في منشئ المشاريع - نمط الأسطورة ⚔️\n\n";

// التحقق من المعاملات
if ($argc < 2) {
    echo "❌ خطأ: يجب تحديد اسم المشروع\n";
    echo "الاستخدام: php create-project.php <project-name> [template]\n";
    echo "القوالب المتاحة: basic, ecommerce, dashboard\n";
    exit(1);
}

$projectName = $argv[1];
$template = $argv[2] ?? 'basic';

// التحقق من صحة اسم المشروع
if (!preg_match('/^[a-zA-Z0-9_-]+$/', $projectName)) {
    echo "❌ خطأ: اسم المشروع يجب أن يحتوي على أحرف وأرقام و _ و - فقط\n";
    exit(1);
}

// التحقق من وجود المشروع
$projectPath = __DIR__ . '/../active/' . $projectName;
if (file_exists($projectPath)) {
    echo "❌ خطأ: المشروع '$projectName' موجود بالفعل\n";
    exit(1);
}

echo "📋 إعدادات المشروع:\n";
echo "   الاسم: $projectName\n";
echo "   القالب: $template\n";
echo "   المسار: $projectPath\n\n";

// تأكيد الإنشاء
echo "هل تريد المتابعة؟ (y/n): ";
$handle = fopen("php://stdin", "r");
$confirm = trim(fgets($handle));
fclose($handle);

if (strtolower($confirm) !== 'y' && strtolower($confirm) !== 'yes') {
    echo "❌ تم إلغاء العملية\n";
    exit(0);
}

echo "\n🔥 بدء إنشاء المشروع...\n";

try {
    // إنشاء مجلد المشروع
    createProjectStructure($projectName, $template);
    
    // نسخ الملفات الأساسية
    copyProjectFiles($projectName, $template);
    
    // إعداد قاعدة البيانات
    setupDatabase($projectName);
    
    // تطبيق التحسينات
    optimizeProject($projectName);
    
    echo "\n✅ تم إنشاء المشروع بنجاح! 🎉\n";
    echo "📁 مسار المشروع: $projectPath\n";
    echo "🚀 لتشغيل المشروع: php scripts/serve-project.php $projectName\n\n";
    
} catch (Exception $e) {
    echo "\n❌ خطأ في إنشاء المشروع: " . $e->getMessage() . "\n";
    
    // تنظيف الملفات في حالة الفشل
    if (file_exists($projectPath)) {
        exec("rm -rf " . escapeshellarg($projectPath));
        echo "🧹 تم تنظيف الملفات المؤقتة\n";
    }
    
    exit(1);
}

/**
 * إنشاء هيكل المشروع
 */
function createProjectStructure($projectName, $template)
{
    $projectPath = __DIR__ . '/../active/' . $projectName;
    
    echo "📁 إنشاء هيكل المشروع...\n";
    
    $directories = [
        'app/Http/Controllers',
        'app/Http/Livewire',
        'app/Models',
        'app/Services',
        'bootstrap/cache',
        'config',
        'database/migrations',
        'database/seeders',
        'public/assets/css',
        'public/assets/js',
        'public/assets/images',
        'resources/views/layouts',
        'resources/views/livewire',
        'resources/views/components',
        'routes',
        'storage/app/public',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/logs',
        'tests/Feature',
        'tests/Unit'
    ];
    
    foreach ($directories as $dir) {
        $fullPath = $projectPath . '/' . $dir;
        if (!mkdir($fullPath, 0755, true)) {
            throw new Exception("فشل في إنشاء المجلد: $dir");
        }
    }
    
    echo "✅ تم إنشاء هيكل المشروع\n";
}

/**
 * نسخ الملفات الأساسية
 */
function copyProjectFiles($projectName, $template)
{
    $projectPath = __DIR__ . '/../active/' . $projectName;
    $corePath = __DIR__ . '/../core';
    $sharedPath = __DIR__ . '/../shared';
    $templatePath = __DIR__ . '/../templates/' . $template;
    
    echo "📄 نسخ الملفات الأساسية...\n";
    
    // نسخ ملفات Core
    if (file_exists($corePath . '/composer.json')) {
        copy($corePath . '/composer.json', $projectPath . '/composer.json');
    }
    
    if (file_exists($corePath . '/.env.example')) {
        copy($corePath . '/.env.example', $projectPath . '/.env.example');
        copy($corePath . '/.env.example', $projectPath . '/.env');
    }
    
    // نسخ Layout المشترك
    if (file_exists($sharedPath . '/layouts/app.blade.php')) {
        copy($sharedPath . '/layouts/app.blade.php', $projectPath . '/resources/views/layouts/app.blade.php');
    }
    
    // نسخ ملفات القالب
    if (file_exists($templatePath)) {
        copyDirectory($templatePath, $projectPath);
    }
    
    // إنشاء ملفات أساسية
    createBasicFiles($projectPath, $projectName);
    
    echo "✅ تم نسخ الملفات الأساسية\n";
}

/**
 * إعداد قاعدة البيانات
 */
function setupDatabase($projectName)
{
    $projectPath = __DIR__ . '/../active/' . $projectName;
    $databasePath = $projectPath . '/database/database.sqlite';
    
    echo "🗄️ إعداد قاعدة البيانات...\n";
    
    // إنشاء ملف SQLite
    if (!touch($databasePath)) {
        throw new Exception("فشل في إنشاء ملف قاعدة البيانات");
    }
    
    // تعديل مسار قاعدة البيانات في .env
    $envPath = $projectPath . '/.env';
    if (file_exists($envPath)) {
        $envContent = file_get_contents($envPath);
        $envContent = str_replace(
            'DB_DATABASE=/absolute/path/to/database.sqlite',
            'DB_DATABASE=' . $databasePath,
            $envContent
        );
        $envContent = str_replace(
            'APP_NAME="Auto Smart"',
            'APP_NAME="' . ucfirst($projectName) . '"',
            $envContent
        );
        file_put_contents($envPath, $envContent);
    }
    
    echo "✅ تم إعداد قاعدة البيانات\n";
}

/**
 * تطبيق التحسينات
 */
function optimizeProject($projectName)
{
    $projectPath = __DIR__ . '/../active/' . $projectName;
    
    echo "⚡ تطبيق التحسينات...\n";
    
    // تثبيت التبعيات
    $currentDir = getcwd();
    chdir($projectPath);
    
    echo "   - تثبيت Composer...\n";
    exec('composer install --optimize-autoloader 2>&1', $output, $returnCode);
    
    if ($returnCode !== 0) {
        chdir($currentDir);
        throw new Exception("فشل في تثبيت Composer: " . implode("\n", $output));
    }
    
    // إنشاء مفتاح التطبيق
    echo "   - إنشاء مفتاح التطبيق...\n";
    exec('php artisan key:generate 2>&1', $output, $returnCode);
    
    // إنشاء رابط التخزين
    echo "   - إنشاء رابط التخزين...\n";
    exec('php artisan storage:link 2>&1');
    
    // تطبيق migrations
    echo "   - تطبيق migrations...\n";
    exec('php artisan migrate --force 2>&1');
    
    chdir($currentDir);
    
    echo "✅ تم تطبيق التحسينات\n";
}

/**
 * نسخ مجلد بالكامل
 */
function copyDirectory($source, $destination)
{
    if (!is_dir($source)) {
        return false;
    }
    
    if (!is_dir($destination)) {
        mkdir($destination, 0755, true);
    }
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $item) {
        $target = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
        
        if ($item->isDir()) {
            mkdir($target, 0755, true);
        } else {
            copy($item, $target);
        }
    }
    
    return true;
}

/**
 * إنشاء ملفات أساسية
 */
function createBasicFiles($projectPath, $projectName)
{
    // إنشاء web.php
    $webRoutes = <<<PHP
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

PHP;
    
    file_put_contents($projectPath . '/routes/web.php', $webRoutes);
    
    // إنشاء welcome.blade.php
    $welcomeView = <<<HTML
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            مرحباً بك في $projectName
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        مرحباً بك في تطبيق $projectName!
                    </div>
                    
                    <div class="mt-6 text-gray-500">
                        تم إنشاء هذا المشروع باستخدام نمط الأسطورة ⚔️
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
HTML;
    
    file_put_contents($projectPath . '/resources/views/welcome.blade.php', $welcomeView);
    
    // إنشاء README.md للمشروع
    $readme = <<<MD
# $projectName

مشروع Laravel تم إنشاؤه باستخدام Auto Smart Monorepo

## التشغيل

\`\`\`bash
php artisan serve
\`\`\`

## المميزات

- Laravel 11
- Livewire 3
- SQLite
- Bootstrap 5
- نمط الأسطورة ⚔️

MD;
    
    file_put_contents($projectPath . '/README.md', $readme);
}

echo "⚔️ تم الانتهاء من إنشاء المشروع بنمط الأسطورة ⚔️\n";