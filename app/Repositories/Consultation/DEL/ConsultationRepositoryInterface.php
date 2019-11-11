<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/17/18
 * Time: 5:06 PM
 */

namespace App\Repositories\Consultation;


use App\Models\Consultation\Consultation;
use App\Models\Symptom\Symptom;
use App\Models\Users\Patient;
use App\Models\Users\Doctor;
use Illuminate\Http\Request;

interface ConsultationRepositoryInterface
{

    public function setNotes(Consultation $consultation, array $arr);

    public function getNotes(Consultation $consultation);

    public function setSignature(Consultation $consultation, $signature_path);

    public function getSignature(Consultation $consultation);

    public function setTestOrder(Consultation $consultation, array $arr);

    public function getTestOrder(Consultation $consultation);

    public function setSicknote(Consultation $consultation, array $arr);

    public function getSicknote(Consultation $consultation);

    public function setReferral(Consultation $consultation, array $arr);

    public function getReferral(Consultation $consultation);

    public function setPrescription(Consultation $consultation, array $arr);

    public function getPrescription(Consultation $consultation);

    public function getVisit(Consultation $consultation);

    public function setSymptoms(Consultation $consultation, Symptom $symptom);

    public function getSymptoms(Consultation $consultation);

    public function getByDoctor(Doctor $doctor);

    public function getByPatient(Patient $patient);

    public function setChatGroup(Consultation $consultation, array $arr);

    public function getChatGroup(Consultation $consultation);

    public function setConversation(Consultation $consultation, array $arr);

    public function getConversation(Consultation $consultation);

    public function checkIfUserIsOnline(Consultation $consultation, $user_id, $resource_id);

    public function setOnlineStatus(Consultation $consultation, array $arr);

    public function getOnlineStatus(Consultation $consultation);

    public function getAllOnlinePartiesInConsultationRoom(Consultation $consultation);

    public function setTime(Consultation $consultation, array $arr);

    public function getTime(Consultation $consultation);

    public function setProvide(Consultation $consultation, array $arr);

    public function getProvider(Consultation $consultation);

    public function setUid(Consultation $consultation, $consultation_uid);

    public function getUid(Consultation $consultation);

    public function setPatient(Consultation $consultation, Patient $patient);

    public function getPatient(Consultation $consultation);

    public function setDoctor(Consultation $consultation, Doctor $doctor);

    public function getDoctor(Consultation $consultation);

    public function setStatus(Consultation $consultation, $status);

    public function getStatus(Consultation $consultation);

    public function setPayment(Consultation $consultation, array $arr);

    public function getPayment(Consultation $consultation);

    public function confirmPayment(Consultation $consultation, Request $request);

    public function all();

    public function store(array $arr);

    public function find($id);

    public function update(array $arr, $consultation_uid);

    public function findByUid($consultation_uid);

}
