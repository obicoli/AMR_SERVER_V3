<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/17/18
 * Time: 5:24 PM
 */

namespace App\Transformers\Consultation;


use App\helpers\HelperFunctions;
use App\Models\Consultation\Consultation;
use App\Models\Service\Service;
use App\Models\Users\Doctor;
use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Repositories\Consultation\ConsultationRepository;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ConsultationTransformer
{

    public function transform(Consultation $consultation){

        return [
            'id' => $consultation->id,
            'uuid' => $consultation->uuid,
            'time_zone' => $consultation->time_zone,
            'consultation_duration' => $consultation->consult_duration.' Minutes',
            'service_type' => $consultation->service()->get()->first()->name,
            'fees' => $consultation->service()->get()->first()->currency.' '.$consultation->service()->get()->first()->fees,
            'service_provider' => '',
            'date_time' => '',
            'created_at' => (string)$consultation->created_at,
            'is_patient' => false,
            'is_doctor' => false,
            'doctor_id' => $consultation->doctor_id,
            'patient_id' => $consultation->patient_id,
            'group_id' => $consultation->groups()->get()->first()->id,
        ];
    }

    public function transformCollection($consultations){

        $results = array();

        $consult_repo = new ConsultationRepository(new Consultation());

        foreach ($consultations as $consultation){

            $temp_data['uuid'] = $consultation->uuid;
            $temp_data['patient'] = $this->getPatient($consultation->patient_id);
            if ($consultation->doctor_id){
                $temp_data['doctor_assigned'] = true;
                $temp_data['doctor'] = $this->getDoctor($consultation->doctor_id);
            }else{
                $temp_data['doctor_assigned'] = false;
            }
            $temp_data['status'] = $consultation->status;
            $temp_data['time_zone'] = $consultation->time_zone;
            $temp_data['service_provider'] = $consult_repo->getProvider($consultation);
            $temp_data['date_time'] = $consult_repo->getTime($consultation);
            $temp_data['visit'] = $consult_repo->getVisit($consultation);
            array_push($results, $temp_data);

        }

        return $results;

    }

    protected function getPatient($id){
        if ($id){
            $patient = Patient::find($id);
            $user = User::find($patient->user_id);
            $user_repo = new UserRepository( new User());
            return $user_repo->getProfile($user);
        }
        return [];
    }
    protected function getDoctor($id){
        if ($id){
            $dock = Doctor::find($id);
            $user = User::find($dock->user_id);
            $user_repo = new UserRepository( new User());
            return $user_repo->getProfile($user);
        }
    }

    public function createConsultationSymptoms(Request $request, Consultation $consultation, Patient $patient){
        $results = array();
        for ($i = 0; $i < sizeof($request->patient_symptoms); $i++ ){
            $temp_data['consult_id'] = $consultation->id;
            $temp_data['symptom_id'] = $request->patient_symptoms[$i];
            $temp_data['patient_id'] = $patient->id;
            $temp_data['created_by_user_id'] = $request->user()->id;
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function createPayment(Request $request, Consultation $consultation, Service $service){

        $helper = new HelperFunctions();
        $results = $request->all();
        $results['account_number'] = $helper->getAccountNumber();
        $results['user_id'] = $request->user()->id;
        $results['fees'] = $service->fees;
        $results['status'] = 'pending';
        return $results;
    }

    public function paymentInstructions(Consultation $consultation){
        $gateways = Config::get('payments.gateways');
        $results = array();
        for ( $i=0; $i < sizeof($gateways); $i++ ){

            $gateways[$i]['instructions'] = $this->createHtmlStringInstructions($gateways[$i], $consultation);
        }
        return $results;
    }

    public function createHtmlStringInstructions(array $arr, Consultation $consultation){

        $html_string = "";
        switch ($arr['service_name']){
            case 'MPESA':
                $html_string = "<p>Send <strong>".$arr['service_name']."</strong> <strong></strong></p>";
                break;
            default:
                $html_string = "<p>Sorry, ".$arr['service_name']." instruction not yet available for online payments.</p>";
                $html_string .= "<ol>";
                $html_string .= "<li>Sorry, instructions not yet available for online payments.</li>";
                $html_string .= "</ol>";
                break;
        }
        return $html_string;

    }

}
