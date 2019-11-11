<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/28/19
 * Time: 8:08 PM
 */

namespace App\Repositories\Consultation;


use App\Models\Consultation\Consultation;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use App\Models\Users\User;
use App\Repositories\Consultation\ConsultRepositoryInterface;
use App\Repositories\Doctor\DoctorRepository;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ConsultRepository implements ConsultRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($_PAGINATE = 0, $_SORT_ORDER = null)
    {
        // TODO: Implement all() method.
    }

    public function get($doctor_id = null, $patient_id = null)
    {
        // TODO: Implement get() method.
        if ($patient_id){
            return $this->model->all()->where('patient_id',$patient_id)->sortByDesc('created_at');
        }elseif($doctor_id){
            return $this->model->all()->where('doctor_id',$patient_id);
        }
    }


    public function store(array $arr)
    {
        // TODO: Implement store() method.
        return $this->model->create($arr);
    }

    public function update(array $arr, $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->model->all()->where('uuid',$uuid)->first();
    }

    public function transform_collection($collections)
    {
        // TODO: Implement transform_collection() method.
        $results = array();
        foreach ($collections as $collection){
            $temp_data['id'] = $collection->uuid;
            $temp_data['status'] = $collection->status;
            $temp_data['visit_type'] = $collection->visit_type;
            $temp_data['who_is_patient'] = $collection->who_is_patient;
            $temp_data['created_at'] = date('Y-m-d H:i:s', strtotime($collection->created_at));
            $temp_data['records'] = ['oooo'];
            if ( $collection->visit_type == Consultation::VISIT_TYPE_ONLINE ){
                $temp_data['chat_group'] = $this->getChatGroup($collection);
            }
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function transform(Consultation $consultation, Request $request)
    {
        // TODO: Implement transform() method.
        $results = array();
        $userRepo = new UserRepository(new User());
        $user = $request->user();
        $results['id'] = $consultation->uuid;
        $results['visit_type'] = $consultation->visit_type;
        if ($consultation->visit_type == Consultation::VISIT_TYPE_ONLINE){
            $results['room_id'] = $consultation->groups()->first()->id;
            $results['service_type'] = Consultation::CHAT_SERVICE_NAME;
            $results['group_id'] = $consultation->groups()->first()->id;
            $results['room_wait_message'] = "Your doctor will enter when your consult starts at 8:40AM on Fri Aug 10.";
        }

        $patientRepo = new PatientRepository(new Patient());
        $doctorRepo = new DoctorRepository(new Doctor());
        switch ($userRepo->getUserType($user)){
            case Patient::USER_TYPE:
                $patient = $patientRepo->findPatientByUserId($user->id);
                $results['patient_id'] = $patient->uuid;
                if ($consultation->doctor_id){
                    $doctor = $doctorRepo->find($consultation->doctor_id);
                    $results['doctor_id'] = $doctor->uuid;
                }
                break;
            case Doctor::USER_TYPE:
                $doctor = $doctorRepo->findByUserId($user->id);
                $patient_ = $patientRepo->find($consultation->patient_id);
                $results['doctor_id'] = $doctor->uuid;
                $results['patient_id'] = $patient_->uuid;
                break;
        }
        return $results;
    }


    public function setChatGroup(Consultation $consultation, array $arr)
    {
        // TODO: Implement setChatGroup() method.
        return $consultation->groups()->create($arr);
    }

    public function getChatGroup(Consultation $consultation)
    {
        // TODO: Implement getChatGroup() method.
        $res = array();
        $groups = $consultation->groups()->get();
        foreach ($groups as $group){
            $temp_data['id'] = $group->id;
            $temp_data['name'] = $group->name;
            $temp_data['status'] = $group->status;
            $temp_data['group_users'] = [];
            array_push($res, $temp_data);
        }
        return $res;
    }


}