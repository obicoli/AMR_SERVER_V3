<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 2/9/19
 * Time: 1:59 PM
 */

namespace App\Repositories\Consultation;


use App\Models\Consultation\MedicalAsset;
use App\Models\Users\User;

interface MedicalAssetsRepositoryInterface
{

    public function create(User $user, array $arr);
    public function save(User $user, MedicalAsset $medicalAsset);
    public function find($id);
    public function findByUuid($uuid);
    public function update(array $arr, $uuid);
    public function destroy($uuid);
    public function getByUser(User $user);
    public function create_notification_sms(MedicalAsset $medicalAsset, array $arr);

}
