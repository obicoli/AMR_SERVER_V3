<?php

namespace App\Models\Symptom;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SymptomCategory extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'symptom_categories';

    protected $fillable = [
        'name',
        'description'
    ];

    public function symptom(){
        return $this->hasMany(Symptom::class,'category_id');
    }
}
