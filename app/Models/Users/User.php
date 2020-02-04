<?php

namespace App\Models\Users;

use App\Models\Addresses\DeliveryAddress;
use App\Models\Conversation\Groups;
use App\Models\Conversation\GroupUser;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Order\Order;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Laravel\Passport\HasApiTokens;
// use App\Models\Supplier\Supplier;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, HasRoleAndPermission,UuidTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile',
        'email',
        'status',
        'password',
        //'uuid',
        'activated',
        'company_id',
        'department_id',
        'store_id',
        'sub_store_id',
        'company_user_id',
        'email_verified_at',
        'signup_ip_address',
        'signup_confirmation_ip_address',
        'signup_sm_ip_address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activated',
        'token',
    ];

    protected $dates = [
        'deleted_at',
    ];

    protected $id_column = "id";

    //columns based function
    public function getCompanyId(){ return $this->company_id; }
    public function getDepartmentId(){ return $this->department_id; }
    public function getStoreId(){ return $this->store_id; }
    public function getSubstoreId(){ return $this->sub_store_id; }

    //public function group_user(){ return $this->hasMany(GroupUser::class,'user_id'); }
    public function groups(){ return $this->belongsToMany(Groups::class,'group_users','user_id','group_id'); }

    public function delivery_address()
    {
        return $this->morphMany(DeliveryAddress::class, 'owner','owner_type','owner_id');
    }

    public function availability(){
        return $this->hasMany('App\Models\Doctor\Availability','user_id');
    }

    //Module based Account
    public function doctor(){return $this->hasOne(Doctor::class,'user_id');}
    public function patient(){return $this->hasOne(Patient::class,'user_id');}
    public function pharmacy(){return $this->hasOne(Pharmacy::class,'user_id');}
    //public function supplier(){return $this->hasOne(Supplier::class,'user_id');}

    public function assets(){
        return $this->morphMany(Assets::class, 'assetable');
    }

    public function dependant(){
        return $this->hasMany('App\Models\Users\Dependant','parent_id');
    }

    public function medical_registration(){
        return $this->hasMany('App\Models\Doctor\MedicalRegistration','user_id');
    }

    public function education(){
        return $this->hasMany('App\Models\Doctor\Education','user_id');
    }

    public function practices(){
        return $this->belongsToMany(Practice::class,'practices_users','user_id','practice_id');
    }

    public function practiceUsers(){
        return $this->hasMany(PracticeUser::class,'user_id','id');
    }

    public function medical_assets(){
        return $this->belongsToMany('App\Models\Consultation\MedicalAsset','medical_assets_users','user_id','medical_assets_id');
    }

    public function orders(){
        return $this->morphMany(Order::class,'orderable','owner_type','owner_id','id');
    }

    public function activation()
    {
        return $this->morphMany(Activation::class, 'activationable','owner_type','owner_id');
    }

}
