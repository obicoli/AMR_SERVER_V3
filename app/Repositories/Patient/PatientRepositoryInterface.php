<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/15/18
 * Time: 8:20 PM
 */

namespace App\Repositories\Patient;


use App\Models\Emr\Health\Allergies;
use App\Models\Emr\Health\HealthCondition;
use App\Models\Emr\Health\Medication;
use App\Models\Emr\Health\Surgery;
use App\Models\Patient\Patient;
use App\Models\Practice\Practice;
use App\Models\Users\User;

interface PatientRepositoryInterface
{
    //getters and setters
    public function createPatient(array $arr);
    public function update(Patient $patient, array $arr);
    public function find($id);
    public function findByUuid($uuid);
    public function findPatientByUserId($user_id);
    public function attachRole(User $user);
    public function getUuid(User $user);
    public function createDependant(Patient $patient, array $arr);
    public function getDependant(Patient $patient);
    public function setPrescription(Patient $patient, array $arr);
    public function setPreferredPharmacy(Patient $patient, Practice $practice);
    public function getPreferredPharmacy(Patient $patient);
    public function getAvatar(Patient $patient);
    //Patient Health profile
    public function getHealthProfile(Patient $patient);
    public function getConditions(Patient $patient);
    public function setConditions(Patient $patient, HealthCondition $healthCondition, array $arr = []);
    public function deleteConditions(Patient $patient, HealthCondition $healthCondition);
    public function setMedications(Patient $patient, Medication $medication, array $arr = []);
    public function getMedications(Patient $patient);
    public function deleteMedication(Patient $patient, Medication $medication);
    //
    public function getSurgery(Patient $patient);
    public function setSurgery(Patient $patient, Surgery $surgery, array $arr = []);
    public function deleteSurgery(Patient $patient, Surgery $surgery);
    //allergies
    public function getAllergy(Patient $patient);
    public function setAllergy(Patient $patient, Allergies $allergies, array $arr = []);
    public function deleteAllergies(Patient $patient, Allergies $allergies);
    public function check_preference($patient_id, $practice_id);
    public function transform_profile(Patient $patient, $get_basic = null);
    //account details
    public function getBalance(Patient $patient);

}
