<?php

/**
 * تكوين التطبيق المحسن - نمط الأسطورة ⚔️
 * ملف config/app.php محسن
 */

return [
    /*
    |--------------------------------------------------------------------------
    | إعدادات التطبيق الأساسية
    |--------------------------------------------------------------------------
    */
    'name' => env('APP_NAME', 'ZeroPay'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'asset_url' => env('ASSET_URL'),
    'timezone' => 'Asia/Riyadh',
    'locale' => 'ar',
    'fallback_locale' => 'en',
    'faker_locale' => 'ar_SA',
    
    /*
    |--------------------------------------------------------------------------
    | مفاتيح التشفير المتقدمة
    |--------------------------------------------------------------------------
    */
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-GCM', // تشفير متقدم
    
    /*
    |--------------------------------------------------------------------------
    | إعدادات الأداء المتقدمة
    |--------------------------------------------------------------------------
    */
    'performance' => [
        'opcache_enabled' => true,
        'memory_limit' => '512M',
        'max_execution_time' => 300,
        'upload_max_filesize' => '100M',
        'post_max_size' => '100M',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | إعدادات الأمان المتقدمة
    |--------------------------------------------------------------------------
    */
    'security' => [
        'csrf_protection' => true,
        'xss_protection' => true,
        'content_type_nosniff' => true,
        'frame_options' => 'DENY',
        'hsts_max_age' => 31536000,
        'referrer_policy' => 'strict-origin-when-cross-origin',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | مقدمي الخدمة المحسنين
    |--------------------------------------------------------------------------
    */
    'providers' => [
        // Laravel Framework Service Providers...
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        
        // Package Service Providers...
        Livewire\LivewireServiceProvider::class,
        Spatie\Permission\PermissionServiceProvider::class,
        Spatie\Activitylog\ActivitylogServiceProvider::class,
        
        // Application Service Providers...
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        
        // خدمات نمط الأسطورة
        App\Providers\GovernmentServiceProvider::class,
        App\Providers\SecurityServiceProvider::class,
        App\Providers\PerformanceServiceProvider::class,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | الأسماء المستعارة للفئات
    |--------------------------------------------------------------------------
    */
    'aliases' => [
        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'Date' => Illuminate\Support\Facades\Date::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Js' => Illuminate\Support\Js::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'RateLimiter' => Illuminate\Support\Facades\RateLimiter::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        
        // أسماء مستعارة مخصصة
        'Government' => App\Facades\GovernmentFacade::class,
        'Security' => App\Facades\SecurityFacade::class,
        'Performance' => App\Facades\PerformanceFacade::class,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | إعدادات نمط الأسطورة
    |--------------------------------------------------------------------------
    */
    'legend_mode' => [
        'enabled' => env('LEGEND_MODE_ENABLED', true),
        'swarm_units' => env('SWARM_UNITS', 100),
        'parallel_processing' => env('PARALLEL_PROCESSING', true),
        'performance_monitoring' => env('PERFORMANCE_MONITORING', true),
        'security_level' => env('SECURITY_LEVEL', 'maximum'),
    ],
];
