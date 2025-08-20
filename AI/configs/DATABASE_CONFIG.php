<?php

/**
 * تكوين قاعدة البيانات المحسن - نمط الأسطورة ⚔️
 * ملف config/database.php محسن
 */

return [
    /*
    |--------------------------------------------------------------------------
    | اتصال قاعدة البيانات الافتراضي
    |--------------------------------------------------------------------------
    */
    'default' => env('DB_CONNECTION', 'mysql'),
    
    /*
    |--------------------------------------------------------------------------
    | اتصالات قواعد البيانات المحسنة
    |--------------------------------------------------------------------------
    */
    'connections' => [
        
        /*
        | SQLite محسن للتطوير المحلي
        */
        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            // تحسينات SQLite
            'options' => [
                PDO::ATTR_TIMEOUT => 30,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        ],
        
        /*
        | MySQL محسن للإنتاج
        */
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'zeropay'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => 'InnoDB',
            // تحسينات MySQL متقدمة
            'options' => [
                PDO::ATTR_TIMEOUT => 30,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => false,
                // SSL Configuration for production
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => env('MYSQL_SSL_VERIFY', false),
            ],
            // Connection Pool Settings
            'pool' => [
                'min_connections' => 5,
                'max_connections' => 20,
                'max_idle_time' => 300,
            ],
        ],
        
        /*
        | MySQL قراءة منفصلة (للأداء العالي)
        */
        'mysql_read' => [
            'driver' => 'mysql',
            'read' => [
                'host' => env('DB_READ_HOST', env('DB_HOST', '127.0.0.1')),
                'port' => env('DB_READ_PORT', env('DB_PORT', '3306')),
                'username' => env('DB_READ_USERNAME', env('DB_USERNAME', 'root')),
                'password' => env('DB_READ_PASSWORD', env('DB_PASSWORD', '')),
            ],
            'write' => [
                'host' => env('DB_WRITE_HOST', env('DB_HOST', '127.0.0.1')),
                'port' => env('DB_WRITE_PORT', env('DB_PORT', '3306')),
                'username' => env('DB_WRITE_USERNAME', env('DB_USERNAME', 'root')),
                'password' => env('DB_WRITE_PASSWORD', env('DB_PASSWORD', '')),
            ],
            'database' => env('DB_DATABASE', 'zeropay'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],
        
        /*
        | PostgreSQL محسن (اختياري)
        */
        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'zeropay'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
            // PostgreSQL optimizations
            'options' => [
                PDO::ATTR_TIMEOUT => 30,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ],
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | جدول الهجرات
    |--------------------------------------------------------------------------
    */
    'migrations' => 'migrations',
    
    /*
    |--------------------------------------------------------------------------
    | إعدادات Redis المحسنة
    |--------------------------------------------------------------------------
    */
    'redis' => [
        
        'client' => env('REDIS_CLIENT', 'phpredis'),
        
        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
            // تحسينات الأداء
            'serializer' => 'igbinary', // تسريع التسلسل
            'compression' => 'lz4', // ضغط البيانات
        ],
        
        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
            // Connection pool settings
            'pool' => [
                'min_connections' => 1,
                'max_connections' => 10,
                'connect_timeout' => 10,
                'wait_timeout' => 3,
                'heartbeat' => -1,
                'max_idle_time' => 60,
            ],
        ],
        
        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],
        
        'session' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_SESSION_DB', '2'),
        ],
        
        // Redis Cluster Configuration
        'cluster' => [
            'default' => [
                [
                    'host' => env('REDIS_CLUSTER_NODE1_HOST', '127.0.0.1'),
                    'port' => env('REDIS_CLUSTER_NODE1_PORT', 7000),
                ],
                [
                    'host' => env('REDIS_CLUSTER_NODE2_HOST', '127.0.0.1'),
                    'port' => env('REDIS_CLUSTER_NODE2_PORT', 7001),
                ],
                [
                    'host' => env('REDIS_CLUSTER_NODE3_HOST', '127.0.0.1'),
                    'port' => env('REDIS_CLUSTER_NODE3_PORT', 7002),
                ],
            ],
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | إعدادات الأداء المتقدمة
    |--------------------------------------------------------------------------
    */
    'performance' => [
        'query_cache_enabled' => env('DB_QUERY_CACHE', true),
        'query_cache_ttl' => env('DB_QUERY_CACHE_TTL', 3600),
        'connection_pooling' => env('DB_CONNECTION_POOLING', true),
        'slow_query_log' => env('DB_SLOW_QUERY_LOG', true),
        'slow_query_time' => env('DB_SLOW_QUERY_TIME', 2.0),
    ],
];
