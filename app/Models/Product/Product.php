<?php

namespace App\Models\Product;

use App\Models\Manufacturer\Manufacturer;
use App\Models\Module\Module;
use App\Models\Supplier\Supplier;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    protected $table = 'products';

    const STOCK_ADDED = "added";
    const STATUS_APPROVED = "Approved";
    const STATUS_DRAFT = "Draft";
    const STATUS_DELIVERED = "Delivered";
    const STATUS_PENDING = "Pending";
    const STATUS_SUBMITTED = "Submitted";
    const STATUS_PARTIAL_DELIVERED = "Partial Delivered";
    const STATUS_EXCESS_DELIVERED = "Excess Delivered";
    const STATUS_LESS_DELIVERED = "Less Delivered";
    const STATUS_PARTIAL_PAYMENT = "Partial Paid";
    const STATUS_PARTIAL = "Partial";
    const STATUS_DECLINED = "Declined";
    const STATUS_PRINTED = "Printed";
    const STATUS_PICKED = "Picked";
    const STATUS_PACKED = "Packed";
    const STATUS_SHIPPED = "Shipped";
    const STATUS_SENT = "Sent";
    const STATUS_OPEN = "Open";
    const STATUS_CLOSED = "Closed";
    const STATUS_RECEIVED = "Received";

    const STOCK_SOURCE_OPENING_STOCK = "Opening Stock";
    const STOCK_SOLD = "sold";
    const STOCK_QTY = "qty";
    const PURCHASE_ADDED = "added";
    const PURCHASE_APPROVED = "approved";
    const PURCHASE_QTY = "qty";
    const DEBIT = "Debit";
    const CREDIT = "Credit";

    const BILLING_ADDRESS = "Billing Address";
    const SHIPPING_ADDRESS = "Shipping Address";

    const ACTIONS_SAVE_DRAFT = "Save As Draft";
    const ACTIONS_SAVE_SEND = "Save & Send";
    const ACTIONS_SAVE_OPEN = "Open";

    const SHIP_TO_ORGANIZATION = "Organization";
    const SHIP_TO_CUSTOMER = "Customer";

    protected $fillable = [
        'name',
        'owner_type',
        'owner_id'
    ];

    public function product_items(){ return $this->hasMany(ProductItem::class,'product_id'); }

    public function owner(){ return $this->morphTo();}

    public function features(){
        return $this->belongsToMany(Feature::class, 'products_features','product_id','feature_id');
    }

    public function disclaimer(){
        return $this->belongsToMany(Disclaimer::class, 'products_disclaimers','product_id','disclaimer_id');
    }

    public function precaution(){
        return $this->belongsToMany(Precaution::class,'product_precaution','product_id','precaution_id');
    }

    public function dosage(){
        return $this->belongsToMany(Dosage::class, 'product_dosage','product_id','dosage_id');
    }

//    public function price(){
//        return $this->hasMany(ProductPrice::class,'product_id','id');
//    }

    public function manufacturer(){
        //return $this->belongsTo(Manufacturer::class,'manufacturer_id');
        return $this->belongsToMany(Manufacturer::class, 'product_manufacturer','product_id','manufacturer_id');
    }

    public function supplier(){
        return $this->belongsToMany(Supplier::class,'product_supplier','product_id','supplier_id');
    }

}
