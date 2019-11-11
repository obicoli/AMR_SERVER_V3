<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/16/18
 * Time: 8:10 PM
 */

namespace App\Repositories\Specialist;


use App\Models\Specialist\Specialist;

class SpecialistRepository implements SpecialistRepositoryInterface
{

    protected $specialist;

    public function __construct(Specialist $specialist)
    {
        $this->specialist = $specialist;
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->specialist->all()->sortBy('name');
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function store(array $arr)
    {
        // TODO: Implement store() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function getSpecialistByDomain($domain_id)
    {
        // TODO: Implement getSpecialistByDomain() method.
        return $this->specialist->all()->where('domain_id',$domain_id)->sortBy('name');
    }

    public function select()
    {
        // TODO: Implement select() method.
        return $this->specialist->get(['id','name','domain_id'])->sortBy('domain_id');
    }


}
