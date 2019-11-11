<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/26/18
 * Time: 10:28 AM
 */

namespace App\Transformers\User;


use App\Models\Doctor\Doctor;
use App\Repositories\Doctor\DoctorRepository;

class DoctorTransformer
{

    public function transform(Doctor $doctor){
        $results = array();
        $doctorRepo = new DoctorRepository(new Doctor());
        $results['id'] = $doctor->uuid;
        $results['basic_details'] = $doctorRepo->getBasicDetails($doctor);
        $results['medical'] = $doctorRepo->getMedicalRegistration($doctor);
        $results['education'] = $doctorRepo->getEducation($doctor);
        $results['practices'] = $doctorRepo->getPractices($doctor);
        $results['timings'] = $doctorRepo->getTimings($doctor);
        $results['fees'] = $doctorRepo->getFees($doctor);
        $results['account'] = $doctorRepo->getAccount($doctor);
        return $results;
    }

    public function signupRule(){
        return [
            'first_name' => 'required',
            'other_name' => 'required',
            'email' => 'required|unique:users|email',
            //'username' => 'required|unique:users',
            'mobile' => 'required|unique:users',
            'password' => 'required|confirmed|min:8',
        ];
    }

}
