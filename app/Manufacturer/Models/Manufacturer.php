<?php

namespace App\Manufacturer\Models;

use App\Models\Module\Module;
use App\Models\Practice\Inventory\PracticeAccountHolder;
use App\Models\Practice\Practice;
use App\Models\Product\Product;
use App\Traits\AccountableTrait;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Account\Account;

class Manufacturer extends Model
{
    use SoftDeletes, UuidTrait, AccountableTrait, Accountable;

    protected $connection = Module::MYSQL_MANUFACTURER_DB_CONN;
    protected $id_column = "id";
    protected $table = "manufacturers";
    protected $guarded = [];
    protected $account_type = Account::AC_MANUFACTURES;
    protected $fillable = [
        'name',
        'slug',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating( function ($model){
            $model->slug = str_slug($model->name);
        });
    }

    public function profile(){ return $this->hasOne(ManufacturerProfile::class,'manufacturer_id'); }

    public function getAccountId()
    {
        return $this->id;
    }

    public function getAccountType()
    {
        return $this->account_type;
    }

    public function getAccountName()
    {
        return $this->name;
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, "manufacturer_id", "id");
    }

    public function practices(){ return $this->belongsToMany(Practice::class,'practice_manufacturers','manufacturer_id','practice_id'); }
    public function practice_account_holder(){ return $this->morphMany(PracticeAccountHolder::class, 'owner','owner_type','owner_id'); }

    public static function getOrCreate($id, array $data)
    {
        $manuf = self::query()->where("id", $id)->firstOrFail();

        if (!$manuf) {
            $manuf = self::query()->create($data);

            return $manuf;
        }

        return $manuf;
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'product_manufacturer','manufacturer_id','product_id');
    }

}
