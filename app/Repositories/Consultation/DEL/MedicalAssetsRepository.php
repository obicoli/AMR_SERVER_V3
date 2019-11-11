<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 2/9/19
 * Time: 1:58 PM
 */

namespace App\Repositories\Consultation;


use App\Models\Consultation\MedicalAsset;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;

class MedicalAssetsRepository implements MedicalAssetsRepositoryInterface
{
    protected $medicalAsset;

    public function __construct(MedicalAsset $medicalAsset)
    {
        $this->medicalAsset = $medicalAsset;
    }

    public function create(User $user, array $arr)
    {
        // TODO: Implement create() method.
        return $user->medical_assets()->create($arr);
    }

    public function save(User $user, MedicalAsset $medicalAsset)
    {
        // TODO: Implement share() method.
        $checker = DB::table('medical_assets_users')->where('medical_assets_id',$medicalAsset->id)->where('user_id',$user->id)->get()->first();
        if (!$checker){
            return $user->medical_assets()->save($medicalAsset);
        }
    }


    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->medicalAsset->all()->where('uuid',$uuid)->first();
    }

    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
    }

    public function destroy($uuid)
    {
        // TODO: Implement destroy() method.
        return $this->medicalAsset->where('uuid',$uuid)->delete();
        //return $asset_record->delete();
    }

    public function getByUser(User $user)
    {
        // TODO: Implement getByUser() method.
        return $user->medical_assets()->orderByDesc('created_at')->paginate(10);
    }

    public function create_notification_sms(MedicalAsset $medicalAsset, array $arr)
    {
        // TODO: Implement create_notification() method.
        return $medicalAsset->sms_notifications()->create($arr);
    }


}
