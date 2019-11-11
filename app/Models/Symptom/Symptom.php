<?php

namespace App\Models\Symptom;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Symptom extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'symptoms';

    protected $fillable = [
        'name',
        'description',
        'category_id'
    ];

    public function category(){
        return $this->belongsTo('App\Models\Symptom\SymptomCategory','category_id');
    }

    public function consultation(){
        return $this->belongsToMany('App\Models\Consultation\Consultation','consult_symptoms','symptom_id','consultation_id');
    }
}
