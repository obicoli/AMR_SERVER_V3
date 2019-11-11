<?php

namespace App\Models\Doctor;

use App\Contracts\AccountableInterface;
use App\Models\Practice\Inventory\PracticeAccountHolder;
use App\Models\Practice\Practice;
use App\Models\Product\Order\Order;
use App\Models\Specialist\Specialist;
use App\Models\Users\User;
use App\Traits\AccountableTrait;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Account\Account;

class Doctor extends Model implements AccountableInterface
{
    use SoftDeletes, Accountable, UuidTrait, AccountableTrait;

    const USER_TYPE = 'Doctor';
    const FIRST_NAME = 'first_name';
    const OTHER_NAME = 'other_name';
    const MOBILE = 'mobile';
    const EMAIL = 'email';
    const GENDER = 'gender';
    const DOB = 'date_of_birth';
    const DEFAULT_AVATAR = "/assets/images/profile/avatar.jpg";

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'doctors';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    protected $account_type = Account::AC_DOCTOR;

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'admin_verified',
        'user_id',
        'first_name',
        'last_name',
        'other_name',
        'email',
        'mobile',
        //'registration_number',
        'uuid',
        'postcode',
        'title',
        'address',
        'gender',
        'date_of_birth',
        'bio',
        'city',
        'country',
        'latitude',
        'longitude',
    ];

    /**
     * A profile belongs to a user.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function practice_account_holder(){ return $this->morphMany(PracticeAccountHolder::class, 'owner','owner_type','owner_id'); }

    public function availability(){
        return $this->hasMany(Availability::class,'doctor_id');
    }

    public function medical_registration(){
        return $this->hasMany(MedicalRegistration::class,'doctor_id');
    }

    public function education(){
        return $this->hasMany(Education::class,'doctor_id');
    }

    public function specialization(){
        return $this->belongsToMany(Specialist::class,'doctor_specialization','doctor_id','specialization_id');
    }

    public function consultation(){
        return $this->hasMany('App\Models\Consultation\Consultation','doctor_id');
    }

    public function orders(){
        return $this->morphMany(Order::class,'orderable','owner_type','owner_id','id');
    }

    //public function practice(){ return $this->morphToMany(Practice::class,'practiceable');}
    public function practices(){return $this->morphMany(Practice::class,'owner','owner_type','owner_id');}

    public function getAccountId()
    {
        // TODO: Implement getAccountId() method.
        return $this->id;
    }

    public function getAccountName()
    {
        // TODO: Implement getAccountName() method.
        return $this->phone;
    }

    public function getAccountType()
    {
        // TODO: Implement getAccountType() method.
        return $this->account_type;
    }


}
