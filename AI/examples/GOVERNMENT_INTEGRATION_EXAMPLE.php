<?php

/**
 * مثال عملي لاستخدام GovernmentIntegrationService
 * نمط الأسطورة ⚔️
 */

namespace App\Http\Controllers;

use App\Services\GovernmentIntegrationService;
use Illuminate\Http\Request;

class GovernmentController extends Controller
{
    private $governmentService;
    
    public function __construct(GovernmentIntegrationService $governmentService)
    {
        $this->governmentService = $governmentService;
    }
    
    /**
     * فحص مطابقة منتج لنظام SABER
     */
    public function checkSaberCompliance(Request $request)
    {
        $productData = [
            'id' => $request->product_id,
            'name' => $request->product_name,
            'category' => $request->category,
            'specifications' => $request->specifications
        ];
        
        try {
            $result = $this->governmentService->checkSaberCompliance($productData);
            
            return response()->json([
                'success' => true,
                'message' => 'تم فحص المطابقة بنجاح',
                'data' => $result
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في فحص المطابقة: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * تسجيل متجر في نظام نافس
     */
    public function registerInNafes(Request $request)
    {
        $shopData = [
            'id' => auth()->id(),
            'name' => $request->shop_name,
            'city' => $request->city,
            'region' => $request->region,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'working_hours' => $request->working_hours
        ];
        
        try {
            $result = $this->governmentService->integrateWithNafes($shopData);
            
            return response()->json([
                'success' => true,
                'message' => 'تم التسجيل في نافس بنجاح',
                'data' => $result
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في التسجيل: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * إرسال فاتورة إلكترونية إلى ZATCA
     */
    public function sendEInvoice(Request $request)
    {
        $invoiceData = [
            'seller_name' => $request->seller_name,
            'seller_vat_number' => $request->seller_vat_number,
            'seller_address' => $request->seller_address,
            'buyer_name' => $request->buyer_name,
            'buyer_address' => $request->buyer_address,
            'items' => $request->items,
            'subtotal' => $request->subtotal,
            'vat_amount' => $request->vat_amount,
            'total_amount' => $request->total_amount,
            'payment_method' => $request->payment_method
        ];
        
        try {
            $result = $this->governmentService->sendEInvoiceToZATCA($invoiceData);
            
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال الفاتورة بنجاح',
                'data' => $result
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في إرسال الفاتورة: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * التحقق من الهوية الوطنية
     */
    public function verifyNationalID(Request $request)
    {
        $request->validate([
            'id_number' => 'required|string|size:10',
            'full_name' => 'required|string|max:255'
        ]);
        
        try {
            $result = $this->governmentService->verifyNationalID(
                $request->id_number,
                $request->full_name
            );
            
            return response()->json([
                'success' => true,
                'message' => 'تم التحقق من الهوية بنجاح',
                'data' => $result
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في التحقق: ' . $e->getMessage()
            ], 500);
        }
    }
}

/**
 * مثال على استخدام الخدمة في Livewire
 */
use Livewire\Component;

class GovernmentIntegration extends Component
{
    public $productId;
    public $complianceResult;
    
    protected $governmentService;
    
    public function boot(GovernmentIntegrationService $governmentService)
    {
        $this->governmentService = $governmentService;
    }
    
    public function checkCompliance()
    {
        $productData = [
            'id' => $this->productId,
            'name' => 'Sample Product',
            'category' => 'Electronics',
            'specifications' => ['voltage' => '220V', 'frequency' => '50Hz']
        ];
        
        $this->complianceResult = $this->governmentService->checkSaberCompliance($productData);
        
        session()->flash('message', 'تم فحص المطابقة بنجاح!');
    }
    
    public function render()
    {
        return view('livewire.government-integration');
    }
}
