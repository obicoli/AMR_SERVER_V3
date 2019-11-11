<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/18/18
 * Time: 1:47 PM
 */

namespace App\Traits;


use Illuminate\Support\Str;

trait UuidTrait
{
    /**
     * Find Model By uuid
     *
     * @param $query
     * @param $uuid
     * @return mixed
     */
    public function scopeByUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    /**
     * Boot the uuid scope trait for the model
     *
     * @return void
     */
    protected static function bootUuidTrait()
    {
        static::creating(function($model) {
            //dd($model);
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
