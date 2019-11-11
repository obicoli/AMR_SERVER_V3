<?php

namespace App\Models\Patient;

use App\Contracts\AccountableInterface;
use App\Models\Account\Account;
use App\Models\Addresses\DeliveryAddress;
use App\Models\Consultation\Consultation;
use App\Models\Dependant\Dependant;
use App\Models\Emr\Health\Allergies;
use App\Models\Emr\Health\HealthCondition;
use App\Models\Emr\Health\Medication;
use App\Models\Emr\Health\Surgery;
use App\Models\Practice\Inventory\PracticeAccountHolder;
use App\Models\Practice\Practice;
use App\Models\Product\Order\Order;
use App\Models\Emr\Prescription\Prescription;
use App\Models\Users\User;
use App\Traits\AccountableTrait;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model implements AccountableInterface
{
    use SoftDeletes,UuidTrait,Accountable, AccountableTrait;

    const USER_TYPE = 'Patient';
    const DEFAULT_AVATAR = "/assets/images/profile/avatar.jpg";
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patients';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    protected $account_type = Account::AC_PATIENT;

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'other_name',
        'email',
        'mobile',
        'uuid',
        'mobile',
        'postcode',
        'time_zone',
        'address',
        'gender',
        'date_of_birth',
        'blood_group',
        'country',
        'patient_number',
        'city',
    ];

    //health profile
    public function health_profile(){return $this->hasOne(HealthProfile::class,'patient_id');}
    public function dependant(){return $this->morphMany(Dependant::class, 'dependable','dependable_type','dependable_id');}
    public function conditions(){ return $this->belongsToMany( HealthCondition::class,'patient_health_condition','patient_id','health_condition_id'); }
    public function medications(){ return $this->belongsToMany( Medication::class,'patient_medication','patient_id','medication_id'); }
    public function allergies(){ return $this->belongsToMany( Allergies::class,'patient_allergies','patient_id','allergy_id'); }
    public function surgeries(){ return $this->belongsToMany( Surgery::class,'patient_surgery','patient_id','surgery_id'); }
    //prefered pharmacy
    public function pharmacy(){return $this->belongsToMany(Practice::class,'patient_pharmacy','patient_id','practice_id');}
    public function practice_account_holder(){ return $this->morphMany(PracticeAccountHolder::class, 'owner','owner_type','owner_id'); }
    /**
     * A profile belongs to a user.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prescription(){
        return $this->morphMany(Prescription::class,'owner');
    }

    public function practice(){
        return $this->morphToMany(Practice::class,'practices_user','practices_users');
    }

    public function consultation(){
        return $this->hasMany(Consultation::class,'patient_id');
    }

    public function orders(){
        return $this->morphMany(Order::class,'orderable','owner_type','owner_id','id');
    }

    public function delivery_address()
    {
        return $this->morphMany(DeliveryAddress::class, 'owner','owner_type','owner_id');
    }

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
