<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/16/18
 * Time: 8:10 PM
 */

namespace App\Repositories\Specialist;


interface SpecialistRepositoryInterface
{

    public function all();

    public function find($id);

    public function store(array $arr);

    public function destroy($id);

    public function getSpecialistByDomain($domain_id);

    public function select();

}
