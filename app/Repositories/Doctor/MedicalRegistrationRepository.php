<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/12/19
 * Time: 5:24 PM
 */

namespace App\Repositories\Doctor;


use App\Models\Doctor\MedicalRegistration;
use App\Models\Users\User;

class MedicalRegistrationRepository implements MedicalRegistrationRepositoryInterface
{

    protected $medicalRegistration;

    public function __construct(MedicalRegistration $medicalRegistration)
    {
        $this->medicalRegistration = $medicalRegistration;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }


    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->medicalRegistration->get(['id','uuid','registration_year','registration_council','registration_number','user_id'])->first();
    }

    public function findByUser(User $user)
    {
        // TODO: Implement findByUser() method.
        return $user->medical_registration()->get(['id','uuid','registration_year','registration_council','registration_number','user_id'])->first();
    }

    public function findByUserId($user_id)
    {
        // TODO: Implement findByUserId() method.
        return $this->medicalRegistration->all()->where('user_id',$user_id)->first();
    }

    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
        //return $medicalRegistration->update($arr);
        return $this->medicalRegistration->where('uuid',$uuid)->update($arr);
    }

    public function getAssets(MedicalRegistration $medicalRegistration)
    {
        // TODO: Implement getAssets() method.
        $results = array();
        $assets = $medicalRegistration->assets()->get()->first();
        if ($assets){
            $results['id'] = $assets->uuid;
            $results['file_path'] = $assets->file_path;
            $results['file_mime'] = $assets->file_mime;
            $results['file_name'] = $assets->file_name;
            $results['file_size'] = $assets->file_size;
        }
        return $results;
    }

}
