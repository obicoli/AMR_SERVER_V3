<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/12/19
 * Time: 5:25 PM
 */

namespace App\Repositories\Doctor;


use App\Models\Doctor\MedicalRegistration;
use App\Models\Users\User;

interface MedicalRegistrationRepositoryInterface
{
    public function all();
    public function findByUuid($uuid);
    public function findByUserId($user_id);
    public function findByUser(User $user);
    public function update(array $arr, $uuid);
    public function getAssets(MedicalRegistration $medicalRegistration);
}
