<?php

/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/28/19
 * Time: 9:27 PM
 */

namespace App\Repositories\His;
use App\Models\Practice\Department;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Store\ProductStore;
use Illuminate\Database\Eloquent\Model;

class HisRepository implements HisRepositoryInterface{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($_PAGINATE = 0, $_SORT_ORDER = null){}
    public function store(array $arr){}
    public function update(array $arr, $uuid){}
    public function destroy($uuid){}
    public function find($id){}
    public function findByUuid($uuid){}
    public function getOrCreate(Model $owner, Model $owning,ProductStore $productStore,Department $department,ProductStore $substore, PracticeUser $practiceUser, $inputs){

        //$ona = $owner->his_rtc_tracks();
        $user_track = $practiceUser->his_rtc_tracks()->get()->first();
        if($user_track){
            $user_track = $user_track->update($inputs);
        }else{
            $user_track = $owner->his_rtc_tracks()->create($inputs);
            $user_track = $owning->his_rtc_tracks()->save($user_track);
            $user_track = $productStore->his_rtc_tracks_store()->save($user_track);
            $user_track = $department->his_rtc_tracks()->save($user_track);
            $user_track = $substore->his_rtc_tracks_sub_store()->save($user_track);
            $user_track = $practiceUser->his_rtc_tracks()->save($user_track);
        }
        return $user_track;
    }

}