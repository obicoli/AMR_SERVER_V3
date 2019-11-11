<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/15/18
 * Time: 4:57 PM
 */

namespace App\Repositories\Doctor;


use App\Models\Doctor\Doctor;
use App\Models\Users\User;

interface DoctorRepositoryInterface
{

//    public function createDoctor(array $arr);
//    public function update(Doctor $doctor, array $arr);
//    public function updateDoctor(array $arr, $id);
    public function find($id);
//    public function findByUuid($uuid);
    public function findByUserId($user_id);
//    public function getDoctors();
//    public function findByKmpddb($kmpdb);
//    public function destroyDoctor($id);
//    public function attachRole(User $user);

    //doctor profile management
    public function getUuid(User $user);
    public function getBasicDetails(Doctor $doctor);
    public function getMedicalRegistration(Doctor $doctor);
    public function getEducation(Doctor $doctor);
    public function getPractices(Doctor $doctor);
    public function getTimings(Doctor $doctor);
    public function getFees(Doctor $doctor);
    public function getAvatar(Doctor $doctor);
    public function getPractice(Doctor $doctor);
    //ACCOUNT
    public function getAccount(Doctor $doctor);
    //transformational functions
    public function transform_collection($doctors);
}
