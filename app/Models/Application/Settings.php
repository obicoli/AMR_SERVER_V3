<?php

namespace App\Models\Application;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    const SERVER_DOMAIN = "http://127.0.0.1:10000";
    const DOCTOR_SERVER_DOMAIN = "";
    const PATIENT_SERVER_DOMAIN = "";
    const PHARMACY_SERVER_DOMAIN = "";
    const MAKE_MASTER_ADMIN = "Account Privileges Granted";
    const MASTER_FACILITY_ADMIN = "Master Facility Administrator";

    protected $table = 'settings';

    protected $fillable = [
        'enable_trial_account',
        'server_domain',
        'patient_domain',
        'doctor_domain',
        'supplier_domain',
        'pharmacy_domain',
    ];
}
