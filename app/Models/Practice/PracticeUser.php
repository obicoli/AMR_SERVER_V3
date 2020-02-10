<?php
namespace App\Models\Practice;

use App\Customer\Models\Credits\CustomerCreditNoteStatus;
use App\Customer\Models\Invoice\CustomerInvoiceStatus;
use App\Customer\Models\Invoice\CustomerRetainerInvoice;
use App\Customer\Models\Invoice\CustomerRetainerInvoiceStatus;
use App\Customer\Models\Orders\CustomerSalesOrderStatus;
use App\Customer\Models\Quote\EstimateStatus;
use App\Customer\Models\Sales\CustomerSalesReceiptStatus;
use App\Finance\Models\Banks\ReconciledTransactionState;
use App\Models\His\Rtc\HisRtcUserTrack;
use App\Models\Module\Module;
use App\Models\Product\Inventory\ProductRequisitionMovement;
use App\Models\Product\Inventory\ProductRequisitionShipment;
use App\Models\Product\Inventory\ProductRequistion;
use App\Models\Product\Purchase\GrnNote;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use App\Models\Product\Purchase\ProductPo;
use App\Models\Product\Store\ProductStore;
use App\Models\Product\Supply\ProductSupplySignatory;
use App\Models\Product\Supply\ProductSupplyState;
use Laravel\Passport\HasApiTokens;
use App\Supplier\Models\PurchaseOrderStatus;
use App\Supplier\Models\SupplierBillStatus;
use App\Supplier\Models\SupplierCreditStatus;
use App\Supplier\Models\SupplierPaymentStatus;
use App\Supplier\Models\SupplierReturnStatus;

class PracticeUser extends Model
{
    use SoftDeletes, Accountable, UuidTrait, HasRoleAndPermission, HasApiTokens;

    const DEFAULT_AVATAR = "/assets/images/profile/avatar.jpg";

    const USER_TYPE = "Facility Staff";

    protected $connection = Module::MYSQL_DB_CONN;

    protected $table = 'practices_users';

    protected $fillable = [
        'practice_id',
        'store_id',
        'department_id',
        'sub_store_id',
        'user_id',
        'first_name',
        'other_name',
        'can_access_company',
        'email',
        'mobile',
        'gender',
        'password',
        'status',
        'address',
        'billable',
    ];

    public function getCompanyId(){ return $this->practice_id; }
    public function getCanAccessCompany(){ return $this->can_access_company; }

    public function product_po(){ return $this->morphMany(ProductPo::class, 'received','received_type','received_id'); }
    public function practice(){ return $this->belongsTo(Practice::class,'practice_id'); }
    public function profile(){ return $this->hasOne(Profile::class,'practice_user_id'); }
    public function work_place(){ return $this->hasMany(PracticeUserWorkPlace::class,'practice_user_id'); }
    public function purchase_orders_approvals(){ return $this->morphMany(ProductPo::class, 'approvable','approvable_type','approvable_id'); }
    public function his_rtc_tracks(){ return $this->hasMany(HisRtcUserTrack::class,'practice_user_id'); }
    public function product_requisitions(){ return $this->morphMany(ProductRequistion::class,'requested','requested_type','requested_id'); }
    public function requisition_approval(){ return $this->morphMany(ProductRequisitionShipment::class,'approving','approving_type','approving_id'); }
    public function requisition_shipping(){ return $this->morphMany(ProductRequisitionShipment::class,'shipping','shipping_type','shipping_id'); }
    public function requisition_receiving(){ return $this->morphMany(ProductRequisitionShipment::class,'receiving','receiving_type','receiving_id'); }
    //Goods Received Note
    public function grn_checkedby(){ return $this->morphMany(GrnNote::class,'checkedby','checkedby_type','checkedby_id'); }
    public function grn_receivedby(){ return $this->morphMany(GrnNote::class,'receivedby','receivedby_type','receivedby_id'); }
    //Supply Signatories
    // public function supply_requested(){ return $this->morphMany(ProductSupplySignatory::class,'requested','requested_type','requested_id'); }
    // public function supply_approval(){ return $this->morphMany(ProductSupplySignatory::class,'approving','approving_type','approving_id'); }
    // public function supply_shipping(){ return $this->morphMany(ProductSupplySignatory::class,'shipping','shipping_type','shipping_id'); }
    // public function supply_receiving(){ return $this->morphMany(ProductSupplySignatory::class,'receiving','receiving_type','receiving_id'); }
    //Supply Statuses
    public function supply_status_responsible(){ return $this->morphMany(ProductSupplyState::class,'responsible','responsible_type','responsible_id'); }
    public function requisition_status_responsible(){ return $this->morphMany(ProductRequisitionMovement::class,'responsible','responsible_type','responsible_id'); }
    //Estimates
    public function estimate_status(){ return $this->morphMany(EstimateStatus::class,'responsible','responsible_type','responsible_id'); }
    public function salesorder_status(){ return $this->morphMany(CustomerSalesOrderStatus::class,'responsible','responsible_type','responsible_id'); }
    public function customer_invoice_status(){ return $this->morphMany(CustomerInvoiceStatus::class,'responsible','responsible_type','responsible_id'); }
    public function retainer_invoice_status(){ return $this->morphMany(CustomerRetainerInvoiceStatus::class,'responsible','responsible_type','responsible_id'); }
    public function sales_receipt_status(){ return $this->morphMany(CustomerSalesReceiptStatus::class,'responsible','responsible_type','responsible_id'); }
    public function credit_note_status(){ return $this->morphMany(CustomerCreditNoteStatus::class,'responsible','responsible_type','responsible_id'); }
    //
    //PO
    public function po_status(){ return $this->morphMany(PurchaseOrderStatus::class,'responsible','responsible_type','responsible_id'); }
    public function bill_status(){ return $this->morphMany(SupplierBillStatus::class,'responsible','responsible_type','responsible_id'); }
    public function payment_status(){ return $this->morphMany(SupplierPaymentStatus::class,'responsible','responsible_type','responsible_id'); }
    public function return_status(){ return $this->morphMany(SupplierReturnStatus::class,'responsible','responsible_type','responsible_id'); }
    public function supplier_credit_status(){ return $this->morphMany(SupplierCreditStatus::class,'responsible','responsible_type','responsible_id'); }
    //Banking/Finance Integration
    public function reconciled_transaction_state(){ return $this->morphMany(ReconciledTransactionState::class,'responsible','responsible_type','responsible_id'); }


}
