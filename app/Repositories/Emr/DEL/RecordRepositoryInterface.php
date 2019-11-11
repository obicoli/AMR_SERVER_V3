<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/27/19
 * Time: 1:00 PM
 */

namespace App\Repositories\Emr;


interface RecordRepositoryInterface
{

    public function all();
    public function store(array $arr);
    public function update(array $arr, $id);
    public function destroy($id);
    public function find($id);
    public function findByUuid($uuid);

}