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
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\DB;
use jeremykenedy\LaravelRoles\Models\Role;

class PatientRepository implements PatientRepositoryInterface
{

    protected $patient;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function createPatient(array $arr)
    {
        // TODO: Implement createPatient() method.
    }

    public function update(Patient $patient, array $arr)
    {
        // TODO: Implement update() method.
        $patient->update($arr);
    }


    public function find($id)
    {
        // TODO: Implement findPatient() method.
        return $this->patient->find($id);
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->patient->all()->where('uuid', $uuid)->first();
    }


    public function findPatientByUserId($user_id)
    {
        // TODO: Implement findPatientByUserId() method.
        return $this->patient->all()->where('user_id',$user_id)->first();
    }

    public function attachRole(User $user)
    {
        // TODO: Implement attachRole() method.
        $role = Role::all()->where('slug','patient')->first();
        $user->attachRole($role);
    }

    public function getUuid(User $user)
    {
        // TODO: Implement getUuid() method.
        return $user->patient()->get()->first()->uuid;
    }

    public function createDependant(Patient $patient, array $arr)
    {
        // TODO: Implement createDependant() method.
        return $patient->dependant()->create($arr);
    }

    public function getDependant(Patient $patient)
    {
        // TODO: Implement getDependant() method.
        return $patient->dependant()->get()->sortByDesc('created_at');
    }

    public function setPrescription(Patient $patient, array $arr)
    {
        // TODO: Implement setPrescription() method.
        return $patient->prescription()->create($arr);
    }

    public function setPreferredPharmacy(Patient $patient, Practice $practice)
    {
        // TODO: Implement setPreferredPharmacy() method.
        //delete any existing
        $check = DB::table('patient_pharmacy')->where('patient_id',$patient->id)->where('practice_id',$practice->id)->get()->first();
        if ($check){
            DB::table('patient_pharmacy')->delete($check->id);
        }
        DB::table('patient_pharmacy')->delete();
        return $patient->pharmacy()->save($practice);
    }

    public function getAvatar(Patient $patient)
    {
        // TODO: Implement getAvatar() method.
        return "/assets/images/profile/avatar.jpg";
    }


    ///////////////////////////////////////////////////////


    public function getPreferredPharmacy(Patient $patient)
    {
        // TODO: Implement getPreferredPharmacy() method.
        $results = array();
        $pharmacies = $patient->pharmacy()->get()->where('activated',true)->sortBy('name');
        foreach ($pharmacies as $pharmacy){
            $temp_data['id'] = $pharmacy->uuid;
            $temp_data['name'] = $pharmacy->name;
            $temp_data['country'] = $pharmacy->country;
            $temp_data['email'] = $pharmacy->email;
            $temp_data['mobile'] = $pharmacy->mobile;
            $temp_data['address'] = $pharmacy->address;
            $temp_data['reg_no'] = $pharmacy->registration_number;
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function getHealthProfile(Patient $patient)
    {
        // TODO: Implement getHealthProfile() method.
        $healths = $patient->health_profile()->get()->first();
        if ($healths){
            return [
                'id' => $healths->id,
                'current_height_ft' => $healths->current_height_ft,
                'current_height_inch' => $healths->current_height_inch,
                'weight' => $healths->current_weight,
                'updated_at' => date("Y-m-d H:i:s", strtotime($healths->updated_at)),
                'conditions' => $this->getConditions($patient),
                'medications' => $this->getMedications($patient),
                'surgeries' => $this->getSurgery($patient),
                'allergies' => $this->getAllergy($patient),
            ];
        }

        return [];

    }

    public function getConditions(Patient $patient)
    {
        // TODO: Implement getConditions() method.
        $conditions = $patient->conditions()->get()->sortBy('created_at');
        $results = array();
        foreach ($conditions as $condition){
            $temp_data['id'] = $condition->uuid;
            $temp_data['name'] = $condition->name;
            if ($condition->created_by_user_id == $patient->user_id){
                $temp_data['reported_by'] = 'Self Reported';
            }else{
                $temp_data['reported_by'] = 'Self Reported';
            }
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function setConditions(Patient $patient, HealthCondition $healthCondition, array $arr = [])
    {
        // TODO: Implement setConditions() method.
        //$patient->conditions()->attach($healthCondition->id);
        $check = DB::table('patient_health_condition')
            ->where('patient_id',$patient->id)
            ->where('health_condition_id',$healthCondition->id)->get()->first();
        if (!$check){
            DB::table('patient_health_condition')->insert([
                'patient_id' => $patient->id,
                'health_condition_id' => $healthCondition->id,
                'created_by_user_id' => $patient->user_id,
            ]);
            return true;
        }
        return false;
    }

    public function deleteConditions(Patient $patient, HealthCondition $healthCondition)
    {
        // TODO: Implement deleteConditions() method.
        DB::table('patient_health_condition')
            ->where('patient_id', $patient->id)
            ->where('health_condition_id',$healthCondition->id)->delete();
    }

    public function setMedications(Patient $patient, Medication $medication, array $arr = [])
    {
        // TODO: Implement setMedications() method.
        $check = DB::table('patient_medication')
            ->where('patient_id',$patient->id)
            ->where('medication_id',$medication->id)->get()->first();
        if (!$check){
            DB::table('patient_medication')->insert([
                'patient_id' => $patient->id,
                'medication_id' => $medication->id,
                'created_by_user_id' => $patient->user_id,
                'dosage' => $arr['dosage'],
            ]);
            return true;
        }
        return false;
    }


    public function getMedications(Patient $patient)
    {
        // TODO: Implement getMedications() method.
        $medications = $patient->medications()->get()->sortBy('created_at');
        $results = array();
        foreach ($medications as $medication){
            $temp_data['id'] = $medication->uuid;
            $temp_data['name'] = $medication->name;

            $patie_medic = DB::table('patient_medication')->get()->where('patient_id',$patient->id)->where('medication_id',$medication->id)->first();
            $temp_data['dosage'] = $patie_medic->dosage;
            $temp_data['status'] = $patie_medic->status;
            if ($patie_medic->created_by_user_id == $patient->user_id){
                $temp_data['reported_by'] = 'Self Reported';
            }else{
                $temp_data['reported_by'] = User::find($patie_medic->created_by_user_id)->email;
            }
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function deleteMedication(Patient $patient, Medication $medication)
    {
        // TODO: Implement deleteMedication() method.
        DB::table('patient_medication')
            ->where('patient_id', $patient->id)
            ->where('medication_id',$medication->id)->delete();
    }


    public function getSurgery(Patient $patient)
    {
        // TODO: Implement getSurgery() method.
        $surgeries = $patient->surgeries()->get()->sortBy('created_at');
        $results = array();
        foreach ($surgeries as $surgery){
            $temp_data['id'] = $surgery->uuid;
            $temp_data['name'] = $surgery->name;
            $patie_medic = DB::table('patient_surgery')->get()->where('patient_id',$patient->id)->where('surgery_id',$surgery->id)->first();
            $temp_data['year_'] = $patie_medic->year_of_operation;
            if ($patie_medic->created_by_user_id == $patient->user_id){
                $temp_data['reported_by'] = 'Self Reported';
            }else{
                $temp_data['reported_by'] = User::find($patie_medic->created_by_user_id)->email;
            }
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function setSurgery(Patient $patient, Surgery $surgery, array $arr = [])
    {
        // TODO: Implement setSurgery() method.
        $check = DB::table('patient_surgery')
            ->where('patient_id',$patient->id)
            ->where('surgery_id',$surgery->id)->get()->first();
        if (!$check){
            DB::table('patient_surgery')->insert([
                'patient_id' => $patient->id,
                'surgery_id' => $surgery->id,
                'created_by_user_id' => $patient->user_id,
                'year_of_operation' => $arr['year'],
            ]);
            return true;
        }
        return false;
    }

    public function deleteSurgery(Patient $patient, Surgery $surgery)
    {
        // TODO: Implement deleteSurgery() method.
        DB::table('patient_surgery')
            ->where('patient_id', $patient->id)
            ->where('surgery_id',$surgery->id)->delete();
    }


    public function setAllergy(Patient $patient, Allergies $allergies, array $arr = [])
    {
        // TODO: Implement setAllergy() method.
        $check = DB::table('patient_allergies')
            ->where('patient_id',$patient->id)
            ->where('allergy_id',$allergies->id)->get()->first();
        if (!$check){
            DB::table('patient_allergies')->insert([
                'patient_id' => $patient->id,
                'allergy_id' => $allergies->id,
                'severity' => $arr['severity'],
                'reaction' => $arr['reaction'],
                'created_by_user_id' => $patient->user_id,
            ]);
            return true;
        }
        return false;
    }

    public function getAllergy(Patient $patient)
    {
        // TODO: Implement getAllergy() method.
        $allergies = $patient->allergies()->get()->sortBy('created_at');
        $results = array();
        foreach ($allergies as $allergy){
            $temp_data['id'] = $allergy->uuid;
            $temp_data['name'] = $allergy->name;
            $patie_medic = DB::table('patient_allergies')->get()->where('patient_id',$patient->id)->where('allergy_id',$allergy->id)->first();
            $temp_data['severity'] = $patie_medic->severity;
            $temp_data['reaction'] = $patie_medic->reaction;
            if ($patie_medic->created_by_user_id == $patient->user_id){
                $temp_data['reported_by'] = 'Self Reported';
            }else{
                $temp_data['reported_by'] = User::find($patie_medic->created_by_user_id)->email;
            }
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function deleteAllergies(Patient $patient, Allergies $allergies)
    {
        // TODO: Implement deleteAllergies() method.
        DB::table('patient_allergies')
            ->where('patient_id', $patient->id)
            ->where('allergy_id',$allergies->id)->delete();
    }


    public function check_preference($patient_id, $practice_id)
    {
        // TODO: Implement check_preference() method.
        return $check = DB::table('patient_pharmacy')->where('patient_id',$patient_id)->where('practice_id',$practice_id)->get()->first();
    }

    public function transform_profile(Patient $patient, $get_basic = null)
    {
        // TODO: Implement getProfile() method.
        $results = array();
        $results['id'] = $patient->uuid;
        $results['first_name'] = $patient->first_name;
        $results['other_name'] = $patient->other_name;
        $results['user_id'] = $patient->user_id;
        $results['gender'] = $patient->gender;
        $results['mobile'] = $patient->mobile;
        $results['dob'] = $patient->date_of_birth;
        $results['postcode'] = $patient->postcode;
        $results['country'] = $patient->country;
        $results['city'] = $patient->city;
        $results['blood_group'] = $patient->blood_group;
        $results['patient_number'] = $patient->patient_number;
        $results['longitude'] = $patient->longitude;
        $results['latitude'] = $patient->latitude;
        $results['address'] = $patient->address;
        $results['avatar'] = "/assets/images/profile/avatar.jpg";
        if (!$get_basic){
            $results['account_balance'] = $this->getBalance($patient);
            $results['pharmacies'] = $this->getPreferredPharmacy($patient);
            $results['health_profile'] = $this->getHealthProfile($patient);
        }



        return $results;
    }

    public function getBalance(Patient $patient)
    {
        // TODO: Implement getBalance() method.
        $account = $patient->account()->get()->first();
        $temp_data['bonus'] = $account->bonus;
        $temp_data['main'] = $account->main;
        $temp_data['balance'] = $account->balance;
        return $temp_data;
    }


}
