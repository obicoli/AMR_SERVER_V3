<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/28/19
 * Time: 8:09 PM
 */

namespace App\Repositories\Consultation;

use App\Models\Consultation\Consultation;
use Illuminate\Http\Request;

interface ConsultRepositoryInterface
{

    public function all($_PAGINATE = 0, $_SORT_ORDER = null);
    public function get($doctor_id = null, $patient_id = null);
    public function store(array $arr);
    public function update(array $arr, $id);
    public function destroy($id);
    public function find($id);
    public function findByUuid($uuid);
    public function transform_collection($collections);
    public function transform(Consultation $consultation, Request $request);
    //Chat group for online consults
    public function setChatGroup(Consultation $consultation, array $arr);
    public function getChatGroup(Consultation $consultation);

}