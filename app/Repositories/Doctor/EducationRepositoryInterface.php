<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/13/19
 * Time: 2:52 PM
 */

namespace App\Repositories\Doctor;


use App\Models\Doctor\Education;
use App\Models\Users\User;

interface EducationRepositoryInterface
{
    public function all();
    public function findByUuid($uuid);
    public function update(array $arr, $uuid);
    public function getAssets(Education $education);
}
