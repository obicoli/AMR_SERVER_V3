<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/18/18
 * Time: 10:00 AM
 */

namespace App\Repositories\Consultation;


interface PatientSymptomRepositoryInterface
{

    public function store(array $arr); //create a single record

    public function insert(array $arr); //insert multiple records

    public function destroyByConsultId($consult_id);

}
