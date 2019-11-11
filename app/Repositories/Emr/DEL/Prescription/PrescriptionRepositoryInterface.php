<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/12/19
 * Time: 10:27 AM
 */

namespace App\Repositories\Emr\Prescription;

use App\Models\Records\Prescription\Prescription;

interface PrescriptionRepositoryInterface
{

    public function all();
    public function store(array $arr);
    public function update(array $arr, $id);
    public function destroy($id);
    public function find($id);
    public function findByUuid($uuid);

    public function store_assets(Prescription $prescription, array $arr = []);

}