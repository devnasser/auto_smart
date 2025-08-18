#!/usr/bin/env php
<?php

/**
 * سكريبت تشغيل المشروع - نمط الأسطورة ⚔️
 * 
 * @author ناصر العنزي - Nasser Alanazi
 * @version 3.0.0
 */

echo "🚀 خادم المشاريع - نمط الأسطورة ⚔️\n\n";

// التحقق من المعاملات
if ($argc < 2) {
    echo "❌ خطأ: يجب تحديد اسم المشروع\n";
    echo "الاستخدام: php serve-project.php <project-name> [port]\n";
    echo "المثال: php serve-project.php my-project 8000\n\n";
    
    // عرض المشاريع المتاحة
    showAvailableProjects();
    exit(1);
}

$projectName = $argv[1];
$port = $argv[2] ?? 8000;

// التحقق من وجود المشروع
$projectPath = __DIR__ . '/../active/' . $projectName;
if (!file_exists($projectPath)) {
    echo "❌ خطأ: المشروع '$projectName' غير موجود\n\n";
    showAvailableProjects();
    exit(1);
}

// التحقق من صحة المنفذ
if (!is_numeric($port) || $port < 1000 || $port > 65535) {
    echo "❌ خطأ: رقم المنفذ يجب أن يكون بين 1000 و 65535\n";
    exit(1);
}

// التحقق من توفر المنفذ
if (isPortInUse($port)) {
    echo "⚠️ تحذير: المنفذ $port مستخدم بالفعل\n";
    $port = findAvailablePort($port);
    echo "🔄 سيتم استخدام المنفذ $port بدلاً من ذلك\n\n";
}

echo "📋 معلومات المشروع:\n";
echo "   الاسم: $projectName\n";
echo "   المسار: $projectPath\n";
echo "   المنفذ: $port\n";
echo "   الرابط: http://localhost:$port\n\n";

try {
    // التحقق من متطلبات المشروع
    checkProjectRequirements($projectPath);
    
    // تشغيل المشروع
    runProject($projectPath, $port);
    
} catch (Exception $e) {
    echo "\n❌ خطأ في تشغيل المشروع: " . $e->getMessage() . "\n";
    exit(1);
}

/**
 * عرض المشاريع المتاحة
 */
function showAvailableProjects()
{
    $activeDir = __DIR__ . '/../active';
    
    if (!is_dir($activeDir)) {
        echo "📁 لا توجد مشاريع نشطة حالياً\n";
        return;
    }
    
    $projects = array_diff(scandir($activeDir), ['.', '..']);
    
    if (empty($projects)) {
        echo "📁 لا توجد مشاريع نشطة حالياً\n";
        echo "💡 لإنشاء مشروع جديد: php scripts/create-project.php <project-name>\n";
        return;
    }
    
    echo "📁 المشاريع المتاحة:\n";
    foreach ($projects as $project) {
        if (is_dir($activeDir . '/' . $project)) {
            $status = getProjectStatus($activeDir . '/' . $project);
            echo "   - $project $status\n";
        }
    }
    echo "\n";
}

/**
 * التحقق من حالة المشروع
 */
function getProjectStatus($projectPath)
{
    $indicators = [];
    
    // التحقق من وجود .env
    if (file_exists($projectPath . '/.env')) {
        $indicators[] = '✅ .env';
    } else {
        $indicators[] = '❌ .env';
    }
    
    // التحقق من وجود vendor
    if (is_dir($projectPath . '/vendor')) {
        $indicators[] = '✅ vendor';
    } else {
        $indicators[] = '❌ vendor';
    }
    
    // التحقق من وجود قاعدة البيانات
    if (file_exists($projectPath . '/database/database.sqlite')) {
        $indicators[] = '✅ db';
    } else {
        $indicators[] = '❌ db';
    }
    
    return '(' . implode(' ', $indicators) . ')';
}

/**
 * التحقق من متطلبات المشروع
 */
function checkProjectRequirements($projectPath)
{
    echo "🔍 فحص متطلبات المشروع...\n";
    
    // التحقق من وجود composer.json
    if (!file_exists($projectPath . '/composer.json')) {
        throw new Exception("ملف composer.json غير موجود");
    }
    
    // التحقق من وجود .env
    if (!file_exists($projectPath . '/.env')) {
        echo "⚠️ ملف .env غير موجود، سيتم إنشاؤه من .env.example\n";
        if (file_exists($projectPath . '/.env.example')) {
            copy($projectPath . '/.env.example', $projectPath . '/.env');
        }
    }
    
    // التحقق من وجود vendor
    if (!is_dir($projectPath . '/vendor')) {
        echo "📦 تثبيت التبعيات...\n";
        $currentDir = getcwd();
        chdir($projectPath);
        
        exec('composer install --optimize-autoloader 2>&1', $output, $returnCode);
        
        if ($returnCode !== 0) {
            chdir($currentDir);
            throw new Exception("فشل في تثبيت التبعيات: " . implode("\n", $output));
        }
        
        chdir($currentDir);
    }
    
    // التحقق من مفتاح التطبيق
    $envContent = file_get_contents($projectPath . '/.env');
    if (strpos($envContent, 'APP_KEY=') === false || strpos($envContent, 'APP_KEY=base64:') === false) {
        echo "🔑 إنشاء مفتاح التطبيق...\n";
        $currentDir = getcwd();
        chdir($projectPath);
        
        exec('php artisan key:generate --force 2>&1', $output, $returnCode);
        
        chdir($currentDir);
    }
    
    // التحقق من قاعدة البيانات
    $dbPath = $projectPath . '/database/database.sqlite';
    if (!file_exists($dbPath)) {
        echo "🗄️ إنشاء قاعدة البيانات...\n";
        touch($dbPath);
        
        // تشغيل migrations
        $currentDir = getcwd();
        chdir($projectPath);
        
        exec('php artisan migrate --force 2>&1', $output, $returnCode);
        
        chdir($currentDir);
    }
    
    echo "✅ جميع المتطلبات متوفرة\n\n";
}

/**
 * تشغيل المشروع
 */
function runProject($projectPath, $port)
{
    echo "🚀 بدء تشغيل المشروع...\n";
    echo "🌐 المشروع يعمل على: http://localhost:$port\n";
    echo "⏹️  لإيقاف الخادم: اضغط Ctrl+C\n\n";
    echo "📊 سجل الخادم:\n";
    echo str_repeat("=", 50) . "\n";
    
    // تغيير المجلد الحالي
    chdir($projectPath);
    
    // تشغيل خادم Laravel
    $command = "php artisan serve --host=127.0.0.1 --port=$port";
    
    // إضافة معالج الإشارات لإيقاف الخادم بشكل نظيف
    if (function_exists('pcntl_signal')) {
        pcntl_signal(SIGINT, function() {
            echo "\n\n🛑 تم إيقاف الخادم بواسطة المستخدم\n";
            echo "⚔️ نمط الأسطورة - مهمة مكتملة ⚔️\n";
            exit(0);
        });
    }
    
    // تشغيل الأمر
    $descriptorspec = [
        0 => ["pipe", "r"],
        1 => ["pipe", "w"],
        2 => ["pipe", "w"]
    ];
    
    $process = proc_open($command, $descriptorspec, $pipes);
    
    if (is_resource($process)) {
        // قراءة المخرجات في الوقت الفعلي
        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);
        
        while (proc_get_status($process)['running']) {
            $output = fread($pipes[1], 1024);
            $error = fread($pipes[2], 1024);
            
            if ($output) {
                echo $output;
            }
            
            if ($error) {
                echo $error;
            }
            
            // معالجة الإشارات
            if (function_exists('pcntl_signal_dispatch')) {
                pcntl_signal_dispatch();
            }
            
            usleep(100000); // 0.1 ثانية
        }
        
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        
        $returnValue = proc_close($process);
        
        if ($returnValue !== 0) {
            throw new Exception("فشل في تشغيل الخادم");
        }
    } else {
        throw new Exception("فشل في تشغيل عملية الخادم");
    }
}

/**
 * التحقق من استخدام المنفذ
 */
function isPortInUse($port)
{
    $connection = @fsockopen('127.0.0.1', $port, $errno, $errstr, 1);
    
    if (is_resource($connection)) {
        fclose($connection);
        return true;
    }
    
    return false;
}

/**
 * البحث عن منفذ متاح
 */
function findAvailablePort($startPort)
{
    for ($port = $startPort; $port <= $startPort + 100; $port++) {
        if (!isPortInUse($port)) {
            return $port;
        }
    }
    
    // إذا لم يتم العثور على منفذ متاح، استخدم منفذ عشوائي
    return rand(8000, 9000);
}

echo "\n⚔️ تم إنهاء خدمة المشروع بنمط الأسطورة ⚔️\n";