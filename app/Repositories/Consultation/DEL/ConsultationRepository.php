<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/17/18
 * Time: 5:06 PM
 */

namespace App\Repositories\Consultation;


use App\helpers\HelperFunctions;
use App\Models\Consultation\Consultation;
use App\Models\Conversation\OnlineTrack;
use App\Models\Symptom\Symptom;
use App\Models\Users\Doctor;
use App\Models\Users\Patient;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConsultationRepository implements ConsultationRepositoryInterface
{

    protected $consultation;

    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }

    public function setNotes(Consultation $consultation, array $arr)
    {
        // TODO: Implement setNotes() method.
        $consultation->notes()->create($arr);
    }

    public function getNotes(Consultation $consultation)
    {
        // TODO: Implement getNotes() method.
        return $consultation->notes()->get();
    }


    public function setSignature(Consultation $consultation, $signature_path)
    {
        // TODO: Implement setSignature() method.
        $consultation->doctor_signature = $signature_path;
        $consultation->save();
    }

    public function getSignature(Consultation $consultation)
    {
        // TODO: Implement getSignature() method.
    }


    public function setTestOrder(Consultation $consultation, array $arr)
    {
        // TODO: Implement setTestOrder() method.
        return $consultation->testorder()->create($arr);
    }

    public function getTestOrder(Consultation $consultation)
    {
        // TODO: Implement getTestOrder() method.
        return $consultation->testorder()->get();
    }


    public function setSicknote(Consultation $consultation, array $arr)
    {
        // TODO: Implement setSicknote() method.
        return $consultation->sicknote()->create($arr);
    }

    public function getSicknote(Consultation $consultation)
    {
        // TODO: Implement getSicknote() method.
        return $consultation->sicknote()->get();
    }


    public function setReferral(Consultation $consultation, array $arr)
    {
        // TODO: Implement setReferral() method.
        return $consultation->referral()->create($arr);
    }

    public function getReferral(Consultation $consultation)
    {
        // TODO: Implement getReferral() method.
        return $consultation->referral()->get();
    }


    public function setPrescription(Consultation $consultation, array $arr)
    {
        // TODO: Implement setPrescription() method.
        return $consultation->prescription()->create($arr);
    }

    public function getPrescription(Consultation $consultation)
    {
        // TODO: Implement getPrescription() method.
        return $consultation->prescription()->get()->sortBy('id');
    }


    public function getVisit(Consultation $consultation)
    {
        // TODO: Implement getVisit() method.
        $vists = $consultation->symptoms()->get();
        $resu = array();
        foreach ($vists as $vist){
            array_push($resu, $vist->name);
        }
        return implode(", ", $resu);
    }


    public function setSymptoms(Consultation $consultation, Symptom $symptom)
    {
        // TODO: Implement setSymptoms() method.
        return $consultation->symptoms()->save($symptom);
    }

    public function getSymptoms(Consultation $consultation)
    {
        // TODO: Implement getSymptoms() method.
        return $consultation->symptoms()->get(['name']);
    }


    public function getByDoctor(Doctor $doctor)
    {
        // TODO: Implement getByDoctor() method.
        return $doctor->consultation()->orderBy('created_at', 'desc')->paginate(4);
    }

    public function getByPatient(Patient $patient)
    {
        // TODO: Implement getByPatient() method.
        return $patient->consultation()->orderBy('created_at', 'desc')->paginate(3);
    }


    public function setChatGroup(Consultation $consultation, array $arr)
    {
        // TODO: Implement setChatGroup() method.
        return $group = $consultation->groups()->create($arr);
    }

    public function getChatGroup(Consultation $consultation)
    {
        // TODO: Implement getChatGroup() method.
    }


    public function setConversation(Consultation $consultation, array $arr)
    {
        // TODO: Implement setConversation() method.
        return $consultation->conversation()->create($arr);
    }

    public function getConversation(Consultation $consultation)
    {
        // TODO: Implement getConversation() method.
        return $consultation->conversation()->get();
    }


    public function checkIfUserIsOnline(Consultation $consultation,$user_id, $resource_id)
    {
        // TODO: Implement checkIfUserIsOnline() method.
        $tracker = $consultation->onlinetrack()->where('user_id',$user_id)->get()->first();
        if ( $tracker ){
            return $tracker;
        }else{
            return false;
        }
    }


    public function setOnlineStatus(Consultation $consultation, array $arr)
    {
        // TODO: Implement setOnlineStatus() method.
        return $consultation->onlinetrack()->create($arr);
    }

    public function getOnlineStatus(Consultation $consultation)
    {
        // TODO: Implement getOnlineStatus() method.
    }

    public function getAllOnlinePartiesInConsultationRoom(Consultation $consultation)
    {
        // TODO: Implement getAllOnlinePartiesInConsultationRoom() method.
        return $consultation->onlinetrack()->get();
    }

    public function setTime(Consultation $consultation, array $arr)
    {
        // TODO: Implement setTime() method.
        $helper = new HelperFunctions();
        if ( $consultation->time_bound ){
            $dur = $consultation->time_bound.' hours';
            $format = 'Y-m-d H:i:s';
            $time = $helper->getNextDate($dur,$format,$consultation->time_zone);
            $consultation->consult_date_time = $time;
            $consultation->save();
        }

    }

    public function getTime(Consultation $consultation)
    {
        // TODO: Implement getTime() method.
        $helper = new HelperFunctions();
        $results = "";
        if ($consultation->consult_date_time == null){
            $results = "Time slot to be confirmed within ".$consultation->time_bound." hours";
        }else{
            $results = 'Before '.$helper->format_mysql_date($consultation->consult_date_time);
        }
        return $results;
    }

    public function setProvide(Consultation $consultation, array $arr)
    {
        // TODO: Implement setProvide() method.
    }

    public function getProvider(Consultation $consultation)
    {
        // TODO: Implement getProvider() method.
        $provider = "";
        if ($consultation->doctor_id == 0 || $consultation->doctor_id == null){
            //$provider = $consultation->doctordomain()->get()->first()->name." (".$consultation->specialist()->get()->first()->name.")";
        }else{
            $docy = $consultation->doctor()->get()->first();
            $provider = $docy->salute.". ".$docy->first_name." ".$docy->last_name." (".$consultation->specialist()->get()->first()->name.")";
        }
        return $provider;
    }

    public function setUid(Consultation $consultation, $consultation_uid)
    {
        // TODO: Implement setUid() method.
        $consultation->consultation_uid = $consultation_uid;
        $consultation->save();
    }

    public function getUid(Consultation $consultation)
    {
        // TODO: Implement getUid() method.
    }

    public function setPatient(Consultation $consultation, Patient $patient)
    {
        // TODO: Implement setPatient() method.
        $consultation->patient_id = $patient->id;
        $consultation->save();
    }

    public function getPatient(Consultation $consultation)
    {
        // TODO: Implement getPatient() method.
        $patient = $consultation->patient()->get([
            'id',
            'first_name',
            'last_name',
            'gender',
            'user_id',
            'dob',
        ])->first();
        if ($patient){
            return $patient->toArray();
        }
        return [];
    }

    public function setDoctor(Consultation $consultation, Doctor $doctor)
    {
        // TODO: Implement setDoctor() method.
        $consultation->doctor_id = $doctor->id;
        $consultation->save();
    }

    public function getDoctor(Consultation $consultation)
    {
        // TODO: Implement getDoctor() method.
        $doc = $consultation->doctor()->get([
            'id',
            'first_name',
            'last_name',
            'gender',
            'user_id',
            'registration_number',
            'salute'
        ])->first();
        if ($doc){
            return $doc->toArray();
        }
        return [];
    }

    public function setStatus(Consultation $consultation, $status)
    {
        // TODO: Implement setStatus() method.
    }

    public function getStatus(Consultation $consultation)
    {
        // TODO: Implement getStatus() method.
    }

    public function setPayment(Consultation $consultation, array $arr)
    {
        // TODO: Implement setPayment() method.
        $consultation->payments()->create($arr);
    }

    public function getPayment(Consultation $consultation)
    {
        // TODO: Implement getPayment() method.
        return $consultation->payments()->get();
    }

    public function confirmPayment(Consultation $consultation, Request $request)
    {
        // TODO: Implement confirmPayment() method.
        $consult = $consultation->payments()
            ->where('user_id',$request->user()->id)
            ->where('mobile_number_paid',$request->mobile_paid)
            ->where('txn_id',$request->transaction_code)
            ->where('gateway',$request->gateway)
            ->where('status','processing')
            ->get()
            ->first();
        if ($consult){
            $consult->status = 'confirmed';
            $consult->save();
            $consultation->status = 'Confirmed';
            $consultation->save();
            return $consult;
        }else{
            return false;
        }
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->consultation->orderBy('id','desc')->pagenate(25);
    }

    public function store(array $arr)
    {
        // TODO: Implement store() method.
        return $this->consultation->create($arr);
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->consultation->find($id);
    }

    public function update(array $arr, $consultation_uid)
    {
        // TODO: Implement update() method.
        return $this->consultation->where('uuid',$consultation_uid)->update($arr);
    }

    public function findByUid($uuid)
    {
        // TODO: Implement findByUid() method.
        return $this->consultation->all()->where('uuid',$uuid)->first();
    }


}
