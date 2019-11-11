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

class EducationRepository implements EducationRepositoryInterface
{
    protected $education;

    public function __construct(Education $education)
    {
        $this->education = $education;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->education->get(['degree','uuid','year_of_experience','institution','year_of_completion','user_id'])->first();
    }

    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
        return $this->education->where('uuid', $uuid)->update($arr);
    }

    public function getAssets(Education $education)
    {
        // TODO: Implement getAssets() method.
        $results = array();
        $assets = $education->assets()->get()->first();
        if ($assets){
            $results['id'] = $assets->uuid;
            $results['file_path'] = $assets->file_path;
            $results['file_mime'] = $assets->file_mime;
            $results['file_name'] = $assets->file_name;
            $results['file_size'] = $assets->file_size;
        }
        return $results;
    }


}
