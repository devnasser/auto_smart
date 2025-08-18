# 🧩 مكونات Livewire المشتركة - نمط الأسطورة ⚔️

## 🎯 **نظرة عامة**
مجموعة من مكونات Livewire القابلة لإعادة الاستخدام في جميع مشاريع Monorepo

---

## 📁 **هيكل المكونات**

```
shared/components/
├── 📊 DataTable/           # جداول البيانات التفاعلية
├── 📝 Forms/               # نماذج متقدمة
├── 🔔 Notifications/       # نظام الإشعارات
├── 🔍 Search/              # مكونات البحث
├── 📈 Charts/              # الرسوم البيانية
├── 🖼️  Media/              # إدارة الوسائط
├── 👤 User/                # مكونات المستخدمين
└── 🛠️  Utilities/          # أدوات مساعدة
```

---

## 🚀 **المكونات المتاحة**

### 📊 **DataTable Components**
- `DataTable.php` - جدول بيانات تفاعلي كامل
- `SimpleTable.php` - جدول بسيط
- `PaginatedTable.php` - جدول مع ترقيم الصفحات

### 📝 **Form Components**
- `DynamicForm.php` - نموذج ديناميكي
- `FileUpload.php` - رفع الملفات المتقدم
- `MultiSelect.php` - اختيار متعدد
- `DatePicker.php` - اختيار التاريخ

### 🔔 **Notification Components**
- `Toast.php` - إشعارات منبثقة
- `Alert.php` - تنبيهات
- `NotificationCenter.php` - مركز الإشعارات

### 🔍 **Search Components**
- `LiveSearch.php` - بحث مباشر
- `AdvancedSearch.php` - بحث متقدم
- `FilterPanel.php` - لوحة التصفية

---

## 📋 **كيفية الاستخدام**

### 1️⃣ **نسخ المكونات:**
```bash
# نسخ مكون معين
cp projects/shared/components/DataTable/DataTable.php app/Http/Livewire/

# نسخ مجموعة مكونات
cp -r projects/shared/components/Forms/* app/Http/Livewire/Forms/
```

### 2️⃣ **تضمين المكون:**
```php
// في Controller أو View
use App\Http\Livewire\DataTable;

// في Blade
@livewire('data-table', ['model' => 'App\Models\Product'])
```

### 3️⃣ **تخصيص المكون:**
```php
// وراثة المكون وتخصيصه
class ProductTable extends DataTable
{
    protected $model = Product::class;
    
    public function configure()
    {
        $this->setColumns([
            'name' => 'اسم المنتج',
            'price' => 'السعر',
            'created_at' => 'تاريخ الإنشاء'
        ]);
    }
}
```

---

## 🎨 **التصميم الموحد**

جميع المكونات تستخدم Bootstrap 5 مع:
- **ألوان موحدة** حسب العلامة التجارية
- **أيقونات FontAwesome** أو Bootstrap Icons
- **تصميم متجاوب** لجميع الأجهزة
- **دعم RTL** للغة العربية

---

## 🔧 **إرشادات التطوير**

### ✅ **قواعد المكونات المشتركة:**
1. **القابلية لإعادة الاستخدام** - يجب أن تعمل في أي مشروع
2. **التخصيص السهل** - parameters واضحة
3. **الأداء المحسن** - lazy loading عند الحاجة
4. **التوثيق الشامل** - تعليقات وأمثلة
5. **الاختبار** - unit tests لكل مكون

### 📝 **مثال على مكون مشترك:**
```php
<?php
// shared/components/DataTable/DataTable.php

namespace App\Http\Livewire\Shared;

use Livewire\Component;
use Livewire\WithPagination;

class DataTable extends Component
{
    use WithPagination;
    
    // خصائص قابلة للتخصيص
    public $model;
    public $columns = [];
    public $searchable = true;
    public $sortable = true;
    public $paginated = true;
    public $perPage = 10;
    
    // خصائص داخلية
    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    
    protected $paginationTheme = 'bootstrap';
    
    public function mount($model, $columns = [])
    {
        $this->model = $model;
        $this->columns = $columns;
    }
    
    public function render()
    {
        $query = $this->model::query();
        
        // تطبيق البحث
        if ($this->search && $this->searchable) {
            $query->where(function($q) {
                foreach ($this->columns as $field => $label) {
                    $q->orWhere($field, 'like', '%' . $this->search . '%');
                }
            });
        }
        
        // تطبيق الترتيب
        if ($this->sortable) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }
        
        // تطبيق الترقيم
        $data = $this->paginated 
            ? $query->paginate($this->perPage)
            : $query->get();
        
        return view('livewire.shared.data-table', compact('data'));
    }
}
```

---

## 🔄 **التحديث والصيانة**

### 📅 **جدولة التحديثات:**
- **مراجعة شهرية** للمكونات
- **تحديث التبعيات** بانتظام
- **إضافة مكونات جديدة** حسب الحاجة
- **إزالة المكونات غير المستخدمة**

### 🧪 **الاختبار:**
```bash
# اختبار جميع المكونات
php artisan test --filter=SharedComponents

# اختبار مكون معين
php artisan test --filter=DataTableTest
```

---

⚔️ **مكونات مشتركة محسنة - جاهزة للاستخدام في جميع المشاريع** ⚔️