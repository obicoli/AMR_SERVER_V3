<?php

namespace App\Models\Specialist;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domains extends Model
{

    use SoftDeletes;

    protected $table = 'domains';

    public function specialist(){
        return $this->hasMany('App\Models\Specialist\Specialist','domain_id');
    }

    public function consultation(){
        return $this->hasMany('App\Models\Consultation\Consultation','domain_id','id');
    }

}
