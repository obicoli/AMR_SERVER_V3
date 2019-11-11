<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/15/18
 * Time: 4:57 PM
 */

namespace App\Repositories\Doctor;


use App\Models\Application\Settings;
use App\Models\Doctor\Doctor;
use App\Models\Doctor\Education;
use App\Models\Doctor\MedicalRegistration;
use App\Models\Users\User;
use Illuminate\Support\Facades\Config;
use jeremykenedy\LaravelRoles\Models\Role;

class DoctorRepository implements DoctorRepositoryInterface
{

    protected $doctor;

    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

//    public function createDoctor(array $arr)
//    {
//        // TODO: Implement createDoctor() method.
//    }
//
//    public function update(Doctor $doctor, array $arr)
//    {
//        // TODO: Implement update() method.
//        return $doctor->update($arr);
//    }
//
//
//    public function updateDoctor(array $arr, $id)
//    {
//        // TODO: Implement updateDoctor() method.
//    }

    public function find($id)
    {
        // TODO: Implement findDoctor() method.
        return $this->doctor->find($id);
    }


    public function findByUserId($user_id)
    {
        // TODO: Implement findByUserId() method.
        return $this->doctor->all()->where('user_id',$user_id)->first();
    }

//
//
//    public function findByUuid($uuid)
//    {
//        // TODO: Implement findByUuid() method.
//        return $this->doctor->all()->where('uuid',$uuid)->first();
//    }
//
//
//    public function getDoctors()
//    {
//        // TODO: Implement getDoctors() method.
//        return $this->doctor->get(['id','uuid','address','first_name','last_name','salute','gender','registration_number','time_zone','postcode','country_code','lat','lng'])->sortByDesc('id')->toArray();
//    }
//
//    public function findByKmpddb($kmpdb)
//    {
//        // TODO: Implement findByKmpddb() method.
//    }
//
//    public function destroyDoctor($id)
//    {
//        // TODO: Implement destroyDoctor() method.
//    }
//
//    public function attachRole(User $user)
//    {
//        // TODO: Implement attachRole() method.
//        $role = Role::all()->where('slug','doctor')->first();
//        $user->attachRole($role);
//    }


    public function getUuid(User $user)
    {
        // TODO: Implement getUuid() method.
        return $user->doctor()->get()->first()->uuid;
    }


    ///////////////////////////////////////////////////////////////////////////

    public function getBasicDetails(Doctor $doctor)
    {
        // TODO: Implement getBasicDetails() method.
        $results = array();
        if ($doctor){
            $specialization = $doctor->specialization()->get()->first();
            $results['specialization'] = '';
            if ($specialization){
                $results['specialization'] = $specialization->name;
            }
            $results['title'] = $doctor->title;
            $results['first_name'] = $doctor->first_name;
            $results['other_name'] = $doctor->other_name;
            $results['gender'] = $doctor->gender;
            $results['country'] = $doctor->country;
            $results['city'] = $doctor->city;
            $results['bio'] = $doctor->bio;
        }
        return $results;
    }

    public function getMedicalRegistration(Doctor $doctor)
    {
        // TODO: Implement getMedicalRegistration() method.
        $results = array();

        $results['registration_number'] = '';
        $results['registration_council'] = '';
        $results['registration_year'] = '';
        $results['registration_certificate'] = [];
        $registration = $doctor->medical_registration()->get()->first();
        if ($registration){
            $regRepo = new MedicalRegistrationRepository(new MedicalRegistration());
            $results['registration_number'] = $registration->registration_number;
            $results['registration_council'] = $registration->registration_council;
            $results['registration_year'] = $registration->registration_year;
            $results['approval'] = $registration->approval_status;
            $results['registration_certificate'] = $regRepo->getAssets($registration);
        }
        return $results;
    }

    public function getEducation(Doctor $doctor)
    {
        // TODO: Implement getEducation() method.
        $results = array();

        $results['degree'] = '';
        $results['institution'] = '';
        $results['completion_year'] = '';
        $results['year_of_experience'] = '';
        $results['verification_certificate'] = [];

        $education = $doctor->education()->get()->first();
        if ($education){
            $eduRepo = new EducationRepository(new Education());
            $results['degree'] = $education->degree;
            $results['institution'] = $education->institution;
            $results['completion_year'] = $education->year_of_completion;
            $results['approval'] = $education->approval_status;
            $results['year_of_experience'] = $education->year_of_experience;
            $results['verification_certificate'] = $eduRepo->getAssets($education);
        }

        return $results;
    }

    public function getPractices(Doctor $doctor)
    {
        // TODO: Implement getPractices() method.
        $results = array();
        $practices = $doctor->practice()->get()->sortByDesc('created_at')->where('category','Branch');
        foreach ($practices as $practice){
            $temp_practice['id'] = $practice->uuid;
            $temp_practice['name'] = $practice->name;
            $temp_practice['type'] = $practice->type;
            $temp_practice['mobile'] = $practice->mobile;
            $temp_practice['email'] = $practice->email;
            $temp_practice['approval'] = $practice->approval_status;
            $temp_practice['address'] = $practice->address;
            $temp_practice['registration_number'] = $practice->registration_number;
            $temp_practice['country'] = $practice->country;
            $temp_practice['city'] = $practice->city;
            $temp_practice['website'] = $practice->website;
            array_push($results,$temp_practice);
        }
        return $results;
    }

    public function getTimings(Doctor $doctor)
    {
        // TODO: Implement getTimings() method.
        $results = array();
        $availabilities = $doctor->availability()->get();
        foreach ($availabilities as $availability){
            $temp_data['id'] = $availability->uuid;
            $temp_data['week_day'] = $availability->week_day;
            $temp_data['opening_time'] = $availability->opening_time;
            $temp_data['closing_time'] = $availability->closing_time;
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function getFees(Doctor $doctor)
    {
        // TODO: Implement getFees() method.
        $results = array();
        return $results;
    }

    public function getAccount(Doctor $doctor)
    {
        // TODO: Implement getAccount() method.
        $account = $doctor->account()->get()->first();
        $results = array();
        $results['id'] = $account->uuid;
        $results['balance'] = $account->balance;
        $results['main'] = $account->main;
        $results['bonus'] = $account->bonus;
        return $results;
    }

    public function getAvatar(Doctor $doctor)
    {
        // TODO: Implement getAvatar() method.
        return Doctor::DEFAULT_AVATAR;
    }

    public function getPractice(Doctor $doctor)
    {
        // TODO: Implement getPractice() method.
        return $doctor->practices()->get();
    }


    //transformational functions
    public function transform_collection($doctors)
    {
        // TODO: Implement transform_collection() method.
        $results = array();

        foreach ($doctors as $doctor){
            $temp_data['id'] = $doctor->uuid;
            $temp_data['first_name'] = $doctor->first_name;
            $temp_data['other_name'] = $doctor->other_name;
            $temp_data['mobile'] = $doctor->mobile;
            $temp_data['email'] = $doctor->email;
            $temp_data['dob'] = $doctor->date_of_birth;
            $temp_data['gender'] = $doctor->gender;
            $temp_data['title'] = $doctor->title;
            $temp_data['country'] = $doctor->country;
            $temp_data['city'] = $doctor->city;
            $temp_data['address'] = $doctor->address;
            $temp_data['speciality'] = 'General Practice';
            $temp_data['avatar'] = "/assets/images/doctor/user.png";
            array_push($results,$temp_data);
        }

        return $results;
    }

    public function transform_(Doctor $doctor){
        $results = array();
        $results['id'] = $doctor->uuid;
        $results['basic_details'] = $this->getBasicDetails($doctor);
        $results['medical'] = $this->getMedicalRegistration($doctor);
        $results['education'] = $this->getEducation($doctor);
        $results['practices'] = $this->getPractices($doctor);
        $results['timings'] = $this->getTimings($doctor);
        $results['fees'] = $this->getFees($doctor);
        $results['account'] = $this->getAccount($doctor);
        return $results;
    }


}
