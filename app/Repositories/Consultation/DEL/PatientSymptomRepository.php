<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/18/18
 * Time: 9:59 AM
 */

namespace App\Repositories\Consultation;


use App\Models\Consultation\PatientSymptom;

class PatientSymptomRepository implements PatientSymptomRepositoryInterface
{

    protected $patientSymptom;

    public function __construct(PatientSymptom $patientSymptom)
    {
        $this->patientSymptom = $patientSymptom;
    }

    public function store(array $arr)
    {
        // TODO: Implement store() method.
        //inserts a single record
        return $this->patientSymptom->create($arr);
    }

    public function insert(array $arr)
    {
        // TODO: Implement insert() method.
        //inserts multiple records
        $this->patientSymptom->insert($arr);
    }

    public function destroyByConsultId($consult_id)
    {
        // TODO: Implement destroyByConsultId() method.
    }


}
