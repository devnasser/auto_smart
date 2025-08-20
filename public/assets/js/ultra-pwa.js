/**
 * Ultra Progressive Web App - نمط الأسطورة ⚔️
 * Advanced PWA Implementation with cutting-edge features
 * 
 * @author ناصر العنزي - Nasser Alanazi
 * @version 4.0.0 - Legend Mode Ultimate
 */

class UltraPWA {
    constructor() {
        this.isOnline = navigator.onLine;
        this.installPrompt = null;
        this.notificationPermission = 'default';
        this.serviceWorkerRegistration = null;
        
        this.initialize();
    }
    
    /**
     * تهيئة PWA المتقدم
     */
    async initialize() {
        console.log('🚀 تهيئة Ultra PWA - نمط الأسطورة ⚔️');
        
        await this.registerServiceWorker();
        await this.setupInstallPrompt();
        await this.initializeNotifications();
        await this.setupOfflineSupport();
        await this.enableAdvancedFeatures();
        
        this.setupEventListeners();
        this.startPerformanceMonitoring();
        
        console.log('✅ تم تهيئة Ultra PWA بنجاح!');
    }
    
    /**
     * تسجيل Service Worker متقدم
     */
    async registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            try {
                this.serviceWorkerRegistration = await navigator.serviceWorker.register('/ultra-sw.js', {
                    scope: '/',
                    updateViaCache: 'none'
                });
                
                console.log('✅ Service Worker مسجل بنجاح');
                
                // تحديث تلقائي للـ Service Worker
                this.serviceWorkerRegistration.addEventListener('updatefound', () => {
                    const newWorker = this.serviceWorkerRegistration.installing;
                    newWorker.addEventListener('statechange', () => {
                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            this.showUpdateNotification();
                        }
                    });
                });
                
            } catch (error) {
                console.error('❌ فشل تسجيل Service Worker:', error);
            }
        }
    }
    
    /**
     * إعداد مطالبة التثبيت
     */
    async setupInstallPrompt() {
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            this.installPrompt = e;
            this.showInstallButton();
        });
        
        window.addEventListener('appinstalled', () => {
            console.log('🎉 تم تثبيت التطبيق بنجاح!');
            this.hideInstallButton();
            this.trackInstallation();
        });
    }
    
    /**
     * تهيئة النوتيفيكيشن المتقدمة
     */
    async initializeNotifications() {
        if ('Notification' in window) {
            this.notificationPermission = await Notification.requestPermission();
            
            if (this.notificationPermission === 'granted') {
                console.log('✅ تم منح صلاحية الإشعارات');
                await this.setupPushNotifications();
            }
        }
    }
    
    /**
     * إعداد Push Notifications
     */
    async setupPushNotifications() {
        if (this.serviceWorkerRegistration) {
            try {
                const subscription = await this.serviceWorkerRegistration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: this.urlBase64ToUint8Array('YOUR_VAPID_PUBLIC_KEY')
                });
                
                // إرسال subscription للخادم
                await this.sendSubscriptionToServer(subscription);
                console.log('✅ تم إعداد Push Notifications');
                
            } catch (error) {
                console.error('❌ فشل إعداد Push Notifications:', error);
            }
        }
    }
    
    /**
     * إعداد الدعم في وضع عدم الاتصال
     */
    async setupOfflineSupport() {
        // مراقبة حالة الاتصال
        window.addEventListener('online', () => {
            this.isOnline = true;
            this.showConnectionStatus('متصل', 'success');
            this.syncOfflineData();
        });
        
        window.addEventListener('offline', () => {
            this.isOnline = false;
            this.showConnectionStatus('غير متصل', 'warning');
            this.enableOfflineMode();
        });
        
        // إعداد قاعدة بيانات محلية للوضع غير المتصل
        await this.initializeOfflineDatabase();
    }
    
    /**
     * تفعيل المميزات المتقدمة
     */
    async enableAdvancedFeatures() {
        // Web Share API
        if (navigator.share) {
            this.enableWebShare();
        }
        
        // Contact Picker API
        if ('contacts' in navigator) {
            this.enableContactPicker();
        }
        
        // File System Access API
        if ('showOpenFilePicker' in window) {
            this.enableFileSystemAccess();
        }
        
        // Web Bluetooth API
        if (navigator.bluetooth) {
            this.enableBluetoothIntegration();
        }
        
        // Geolocation API Enhanced
        if (navigator.geolocation) {
            this.enableAdvancedGeolocation();
        }
        
        // Payment Request API
        if (window.PaymentRequest) {
            this.enableWebPayments();
        }
        
        // Web Authentication API (WebAuthn)
        if (window.PublicKeyCredential) {
            this.enableWebAuthn();
        }
    }
    
    /**
     * إظهار زر التثبيت
     */
    showInstallButton() {
        const installButton = document.createElement('button');
        installButton.innerHTML = '📱 تثبيت التطبيق';
        installButton.className = 'btn btn-primary install-btn';
        installButton.addEventListener('click', () => this.installApp());
        
        document.body.appendChild(installButton);
    }
    
    /**
     * تثبيت التطبيق
     */
    async installApp() {
        if (this.installPrompt) {
            const result = await this.installPrompt.prompt();
            console.log('نتيجة التثبيت:', result.outcome);
            this.installPrompt = null;
        }
    }
    
    /**
     * إظهار حالة الاتصال
     */
    showConnectionStatus(status, type) {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-bg-${type} border-0`;
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    🌐 حالة الاتصال: ${status}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        document.querySelector('.toast-container').appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }
    
    /**
     * مزامنة البيانات غير المتصلة
     */
    async syncOfflineData() {
        const offlineData = await this.getOfflineData();
        
        for (const data of offlineData) {
            try {
                await this.sendToServer(data);
                await this.removeFromOfflineStorage(data.id);
            } catch (error) {
                console.error('فشل مزامنة البيانات:', error);
            }
        }
    }
    
    /**
     * تهيئة قاعدة البيانات المحلية
     */
    async initializeOfflineDatabase() {
        if ('indexedDB' in window) {
            const dbRequest = indexedDB.open('AutoSmartDB', 1);
            
            dbRequest.onupgradeneeded = (event) => {
                const db = event.target.result;
                
                // إنشاء stores للبيانات المختلفة
                const stores = ['projects', 'users', 'settings', 'cache', 'queue'];
                
                stores.forEach(storeName => {
                    if (!db.objectStoreNames.contains(storeName)) {
                        const store = db.createObjectStore(storeName, { keyPath: 'id', autoIncrement: true });
                        store.createIndex('timestamp', 'timestamp', { unique: false });
                    }
                });
            };
            
            dbRequest.onsuccess = () => {
                console.log('✅ تم تهيئة قاعدة البيانات المحلية');
            };
        }
    }
    
    /**
     * تفعيل Web Share API
     */
    enableWebShare() {
        window.shareContent = async (title, text, url) => {
            try {
                await navigator.share({ title, text, url });
                console.log('✅ تم مشاركة المحتوى');
            } catch (error) {
                console.error('فشل المشاركة:', error);
                this.fallbackShare(title, text, url);
            }
        };
    }
    
    /**
     * تفعيل Contact Picker API
     */
    enableContactPicker() {
        window.pickContact = async () => {
            try {
                const contacts = await navigator.contacts.select(['name', 'email', 'tel']);
                return contacts;
            } catch (error) {
                console.error('فشل اختيار جهة الاتصال:', error);
                return null;
            }
        };
    }
    
    /**
     * تفعيل File System Access API
     */
    enableFileSystemAccess() {
        window.openFile = async () => {
            try {
                const [fileHandle] = await window.showOpenFilePicker({
                    types: [
                        {
                            description: 'Text files',
                            accept: { 'text/plain': ['.txt', '.md'] }
                        },
                        {
                            description: 'Images',
                            accept: { 'image/*': ['.png', '.jpg', '.jpeg', '.gif'] }
                        }
                    ]
                });
                
                const file = await fileHandle.getFile();
                return file;
            } catch (error) {
                console.error('فشل فتح الملف:', error);
                return null;
            }
        };
        
        window.saveFile = async (content, filename) => {
            try {
                const fileHandle = await window.showSaveFilePicker({
                    suggestedName: filename,
                    types: [
                        {
                            description: 'Text files',
                            accept: { 'text/plain': ['.txt'] }
                        }
                    ]
                });
                
                const writable = await fileHandle.createWritable();
                await writable.write(content);
                await writable.close();
                
                console.log('✅ تم حفظ الملف');
            } catch (error) {
                console.error('فشل حفظ الملف:', error);
            }
        };
    }
    
    /**
     * تفعيل WebAuthn للمصادقة المتقدمة
     */
    enableWebAuthn() {
        window.registerWebAuthn = async () => {
            try {
                const credential = await navigator.credentials.create({
                    publicKey: {
                        challenge: new Uint8Array(32),
                        rp: { name: "Auto Smart" },
                        user: {
                            id: new Uint8Array(16),
                            name: "user@example.com",
                            displayName: "User Name"
                        },
                        pubKeyCredParams: [{ alg: -7, type: "public-key" }],
                        authenticatorSelection: {
                            authenticatorAttachment: "platform",
                            userVerification: "required"
                        }
                    }
                });
                
                console.log('✅ تم تسجيل WebAuthn');
                return credential;
            } catch (error) {
                console.error('فشل WebAuthn:', error);
                return null;
            }
        };
    }
    
    /**
     * بدء مراقبة الأداء
     */
    startPerformanceMonitoring() {
        // Web Vitals monitoring
        if ('web-vitals' in window) {
            import('https://unpkg.com/web-vitals@3/dist/web-vitals.js').then(({ getCLS, getFID, getFCP, getLCP, getTTFB }) => {
                getCLS(this.sendToAnalytics);
                getFID(this.sendToAnalytics);
                getFCP(this.sendToAnalytics);
                getLCP(this.sendToAnalytics);
                getTTFB(this.sendToAnalytics);
            });
        }
        
        // Performance Observer
        if ('PerformanceObserver' in window) {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    this.analyzePerformanceEntry(entry);
                }
            });
            
            observer.observe({ entryTypes: ['navigation', 'resource', 'paint', 'layout-shift'] });
        }
    }
    
    /**
     * إرسال البيانات للتحليلات
     */
    sendToAnalytics(metric) {
        console.log('📊 Performance Metric:', metric);
        
        // إرسال للخادم (مع دعم offline)
        if (this.isOnline) {
            fetch('/api/analytics/performance', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(metric)
            }).catch(error => {
                // حفظ في قاعدة البيانات المحلية للمزامنة لاحقاً
                this.saveToOfflineQueue('analytics', metric);
            });
        } else {
            this.saveToOfflineQueue('analytics', metric);
        }
    }
    
    /**
     * تحليل إدخالات الأداء
     */
    analyzePerformanceEntry(entry) {
        const analysis = {
            name: entry.name,
            type: entry.entryType,
            startTime: entry.startTime,
            duration: entry.duration,
            timestamp: Date.now()
        };
        
        // تحليل متقدم حسب نوع الإدخال
        switch (entry.entryType) {
            case 'navigation':
                analysis.loadTime = entry.loadEventEnd - entry.fetchStart;
                analysis.domContentLoaded = entry.domContentLoadedEventEnd - entry.fetchStart;
                break;
                
            case 'resource':
                analysis.resourceSize = entry.transferSize;
                analysis.compressionRatio = entry.encodedBodySize / entry.decodedBodySize;
                break;
                
            case 'paint':
                analysis.paintMetric = entry.name;
                break;
        }
        
        this.sendToAnalytics(analysis);
    }
    
    /**
     * حفظ في طابور الوضع غير المتصل
     */
    async saveToOfflineQueue(type, data) {
        if ('indexedDB' in window) {
            const dbRequest = indexedDB.open('AutoSmartDB', 1);
            
            dbRequest.onsuccess = () => {
                const db = dbRequest.result;
                const transaction = db.transaction(['queue'], 'readwrite');
                const store = transaction.objectStore('queue');
                
                store.add({
                    type: type,
                    data: data,
                    timestamp: Date.now(),
                    synced: false
                });
            };
        }
    }
    
    /**
     * إظهار إشعار التحديث
     */
    showUpdateNotification() {
        const notification = document.createElement('div');
        notification.className = 'alert alert-info alert-dismissible fade show position-fixed';
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 300px;';
        notification.innerHTML = `
            <strong>🔄 تحديث متاح!</strong><br>
            إصدار جديد من التطبيق متوفر.
            <button type="button" class="btn btn-sm btn-primary mt-2" onclick="location.reload()">
                تحديث الآن
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // إزالة تلقائية بعد 10 ثوان
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 10000);
    }
    
    /**
     * تحويل VAPID key
     */
    urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/-/g, '+')
            .replace(/_/g, '/');
        
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }
    
    /**
     * إعداد مستمعي الأحداث
     */
    setupEventListeners() {
        // مراقبة تغييرات الشبكة
        if ('connection' in navigator) {
            navigator.connection.addEventListener('change', () => {
                this.handleConnectionChange();
            });
        }
        
        // مراقبة تغييرات البطارية
        if ('getBattery' in navigator) {
            navigator.getBattery().then(battery => {
                battery.addEventListener('levelchange', () => {
                    this.handleBatteryChange(battery.level);
                });
            });
        }
        
        // مراقبة تغييرات الذاكرة
        if ('memory' in performance) {
            setInterval(() => {
                this.monitorMemoryUsage();
            }, 30000); // كل 30 ثانية
        }
    }
    
    /**
     * معالجة تغيير الاتصال
     */
    handleConnectionChange() {
        const connection = navigator.connection;
        
        if (connection.effectiveType === 'slow-2g' || connection.effectiveType === '2g') {
            this.enableLowBandwidthMode();
        } else {
            this.disableLowBandwidthMode();
        }
        
        console.log(`📶 نوع الاتصال: ${connection.effectiveType}, السرعة: ${connection.downlink}Mbps`);
    }
    
    /**
     * تفعيل وضع النطاق الترددي المنخفض
     */
    enableLowBandwidthMode() {
        console.log('📶 تفعيل وضع النطاق الترددي المنخفض');
        
        // تقليل جودة الصور
        document.querySelectorAll('img').forEach(img => {
            if (img.dataset.lowBandwidth) {
                img.src = img.dataset.lowBandwidth;
            }
        });
        
        // تأخير تحميل المحتوى غير الضروري
        document.querySelectorAll('[data-lazy]').forEach(element => {
            element.style.display = 'none';
        });
        
        // إظهار إشعار
        this.showConnectionStatus('وضع النطاق المنخفض مُفعل', 'warning');
    }
    
    /**
     * مراقبة استخدام الذاكرة
     */
    monitorMemoryUsage() {
        if ('memory' in performance) {
            const memory = performance.memory;
            const usage = {
                used: Math.round(memory.usedJSHeapSize / 1024 / 1024),
                total: Math.round(memory.totalJSHeapSize / 1024 / 1024),
                limit: Math.round(memory.jsHeapSizeLimit / 1024 / 1024)
            };
            
            // تحذير إذا تجاوز الاستخدام 80%
            if (usage.used / usage.limit > 0.8) {
                console.warn('⚠️ استخدام ذاكرة عالي:', usage);
                this.optimizeMemoryUsage();
            }
        }
    }
    
    /**
     * تحسين استخدام الذاكرة
     */
    optimizeMemoryUsage() {
        // تنظيف الكاش القديم
        if ('caches' in window) {
            caches.keys().then(cacheNames => {
                cacheNames.forEach(cacheName => {
                    if (cacheName.includes('old') || cacheName.includes('v1')) {
                        caches.delete(cacheName);
                    }
                });
            });
        }
        
        // تنظيف DOM elements غير المستخدمة
        document.querySelectorAll('[data-cleanup]').forEach(element => {
            element.remove();
        });
        
        // تشغيل garbage collection إذا كان متاحاً
        if (window.gc) {
            window.gc();
        }
    }
    
    // Helper methods (تنفيذ مبسط)
    hideInstallButton() { document.querySelector('.install-btn')?.remove(); }
    trackInstallation() { console.log('📊 تتبع التثبيت'); }
    enableOfflineMode() { console.log('📱 وضع عدم الاتصال مُفعل'); }
    getOfflineData() { return Promise.resolve([]); }
    sendToServer(data) { return fetch('/api/sync', { method: 'POST', body: JSON.stringify(data) }); }
    removeFromOfflineStorage(id) { return Promise.resolve(); }
    sendSubscriptionToServer(sub) { return Promise.resolve(); }
    fallbackShare(title, text, url) { console.log('مشاركة تقليدية:', { title, text, url }); }
    disableLowBandwidthMode() { console.log('📶 إلغاء وضع النطاق المنخفض'); }
}

// تهيئة PWA عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', () => {
    window.ultraPWA = new UltraPWA();
});

// تصدير للاستخدام العام
window.UltraPWA = UltraPWA;