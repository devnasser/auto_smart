# ⚡ دليل Livewire الشامل - نمط الأسطورة ⚔️

## 🎯 **مقدمة**
دليل شامل لاستخدام Livewire 3 في بيئة Auto Smart

---

## 🚀 **ما هو Livewire؟**

Livewire هو framework للـ Laravel يتيح لك بناء واجهات تفاعلية باستخدام PHP فقط، بدون JavaScript معقد.

### ✨ **المميزات:**
- 🔥 **تفاعل في الوقت الفعلي** بدون JavaScript
- ⚡ **تحديث جزئي** للصفحة
- 🛡️ **أمان مدمج** مع Laravel
- 🎨 **تكامل مثالي** مع Bootstrap

---

## 📦 **التثبيت والإعداد**

### 1️⃣ **التثبيت:**
```bash
composer require livewire/livewire
```

### 2️⃣ **النشر:**
```bash
php artisan livewire:publish --config
php artisan livewire:publish --assets
```

### 3️⃣ **إعداد Layout:**
```html
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @livewireStyles
</head>
<body>
    <div class="container-fluid">
        {{ $slot }}
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @livewireScripts
</body>
</html>
```

---

## 🔧 **إنشاء Components**

### ⚡ **Component أساسي:**
```bash
# إنشاء component
php artisan make:livewire Counter

# إنشاء component في مجلد
php artisan make:livewire Dashboard/Stats
```

### 📝 **مثال: Counter Component:**
```php
<?php
// app/Http/Livewire/Counter.php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;
    
    public function increment()
    {
        $this->count++;
    }
    
    public function decrement()
    {
        $this->count--;
    }
    
    public function render()
    {
        return view('livewire.counter');
    }
}
```

```html
<!-- resources/views/livewire/counter.blade.php -->
<div class="card">
    <div class="card-header">
        <h5>العداد التفاعلي</h5>
    </div>
    <div class="card-body text-center">
        <h2 class="display-4 text-primary">{{ $count }}</h2>
        
        <div class="btn-group mt-3">
            <button wire:click="decrement" class="btn btn-danger">
                <i class="fas fa-minus"></i> تقليل
            </button>
            <button wire:click="increment" class="btn btn-success">
                <i class="fas fa-plus"></i> زيادة
            </button>
        </div>
    </div>
</div>
```

---

## 📊 **أمثلة متقدمة**

### 1️⃣ **جدول البيانات التفاعلي:**
```php
<?php
// app/Http/Livewire/ProductTable.php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    
    protected $paginationTheme = 'bootstrap';
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
    }
    
    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        return view('livewire.product-table', compact('products'));
    }
}
```

```html
<!-- resources/views/livewire/product-table.blade.php -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>جدول المنتجات</h5>
        <div class="d-flex gap-2">
            <input wire:model.debounce.300ms="search" 
                   type="text" 
                   class="form-control" 
                   placeholder="البحث...">
            <select wire:model="perPage" class="form-select">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th wire:click="sortBy('name')" style="cursor: pointer">
                            اسم المنتج
                            @if($sortField === 'name')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('price')" style="cursor: pointer">
                            السعر
                            @if($sortField === 'price')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->price, 2) }} ريال</td>
                            <td>
                                <button class="btn btn-sm btn-primary">تعديل</button>
                                <button class="btn btn-sm btn-danger">حذف</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">لا توجد منتجات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $products->links() }}
    </div>
</div>
```

### 2️⃣ **نموذج تفاعلي:**
```php
<?php
// app/Http/Livewire/ProductForm.php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;
    
    public $name = '';
    public $description = '';
    public $price = '';
    public $image;
    public $showSuccessMessage = false;
    
    protected $rules = [
        'name' => 'required|min:3|max:255',
        'description' => 'required|min:10',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:1024', // 1MB Max
    ];
    
    protected $messages = [
        'name.required' => 'اسم المنتج مطلوب',
        'name.min' => 'اسم المنتج يجب أن يكون 3 أحرف على الأقل',
        'description.required' => 'وصف المنتج مطلوب',
        'price.required' => 'سعر المنتج مطلوب',
        'price.numeric' => 'السعر يجب أن يكون رقم',
        'image.image' => 'يجب أن يكون الملف صورة',
        'image.max' => 'حجم الصورة يجب أن يكون أقل من 1 ميجابايت',
    ];
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function save()
    {
        $this->validate();
        
        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
        }
        
        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image_path' => $imagePath,
        ]);
        
        $this->reset(['name', 'description', 'price', 'image']);
        $this->showSuccessMessage = true;
        
        $this->emit('productAdded');
    }
    
    public function render()
    {
        return view('livewire.product-form');
    }
}
```

```html
<!-- resources/views/livewire/product-form.blade.php -->
<div class="card">
    <div class="card-header">
        <h5>إضافة منتج جديد</h5>
    </div>
    
    <div class="card-body">
        @if($showSuccessMessage)
            <div class="alert alert-success alert-dismissible fade show">
                تم إضافة المنتج بنجاح!
                <button type="button" class="btn-close" wire:click="$set('showSuccessMessage', false)"></button>
            </div>
        @endif
        
        <form wire:submit.prevent="save">
            <div class="mb-3">
                <label class="form-label">اسم المنتج</label>
                <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror">
                @error('name') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">الوصف</label>
                <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" rows="3"></textarea>
                @error('description') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">السعر (ريال)</label>
                <input wire:model="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror">
                @error('price') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">صورة المنتج</label>
                <input wire:model="image" type="file" class="form-control @error('image') is-invalid @enderror">
                @error('image') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                @if($image)
                    <div class="mt-2">
                        <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" style="max-width: 200px">
                    </div>
                @endif
            </div>
            
            <button type="submit" class="btn btn-primary">
                <span wire:loading.remove wire:target="save">حفظ المنتج</span>
                <span wire:loading wire:target="save">
                    <span class="spinner-border spinner-border-sm me-2"></span>
                    جاري الحفظ...
                </span>
            </button>
        </form>
    </div>
</div>
```

---

## 🎯 **تقنيات متقدمة**

### 1️⃣ **Real-time Updates:**
```php
// في Component
public function getListeners()
{
    return [
        'productAdded' => 'refreshList',
        'echo:products,ProductUpdated' => 'refreshList',
    ];
}

public function refreshList()
{
    // تحديث القائمة
}
```

### 2️⃣ **Polling (التحديث الدوري):**
```html
<div wire:poll.5s="refreshData">
    <!-- المحتوى يتحدث كل 5 ثوان -->
</div>
```

### 3️⃣ **Loading States:**
```html
<button wire:click="save" class="btn btn-primary">
    <span wire:loading.remove wire:target="save">حفظ</span>
    <span wire:loading wire:target="save">
        <span class="spinner-border spinner-border-sm"></span>
        جاري الحفظ...
    </span>
</button>
```

---

## ⚡ **تحسين الأداء**

### 🚀 **Lazy Loading:**
```php
// تحميل البيانات عند الحاجة فقط
public function loadPosts()
{
    $this->readyToLoad = true;
}

public function render()
{
    return view('livewire.posts', [
        'posts' => $this->readyToLoad ? Post::all() : []
    ]);
}
```

### 🔧 **Defer Updates:**
```html
<!-- تأخير التحديث حتى submit -->
<input wire:model.defer="name" type="text">

<!-- تأخير التحديث بوقت معين -->
<input wire:model.debounce.500ms="search" type="text">
```

---

## 🛡️ **الأمان**

### 🔐 **تأمين Properties:**
```php
class SecureComponent extends Component
{
    public $publicProperty = 'visible';
    protected $protectedProperty = 'hidden';
    
    // منع تعديل property من الخارج
    protected $rules = [
        'publicProperty' => 'required|string|max:100'
    ];
}
```

### 🛡️ **تأمين Actions:**
```php
public function deleteProduct($productId)
{
    // التحقق من الصلاحية
    $this->authorize('delete', Product::find($productId));
    
    Product::find($productId)->delete();
}
```

---

## 📚 **موارد إضافية**

- [Livewire Documentation](https://laravel-livewire.com/docs)
- [Livewire Screencasts](https://laravel-livewire.com/screencasts)
- [Alpine.js Documentation](https://alpinejs.dev/)

---

⚔️ **دليل Livewire مكتمل - تفاعل ديناميكي بنمط الأسطورة** ⚔️