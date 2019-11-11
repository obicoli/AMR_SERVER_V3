<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activations';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'token',
        'ip_address',
    ];

    public function activationable(){
        return $this->morphTo();
    }
}
