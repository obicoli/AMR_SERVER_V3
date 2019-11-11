<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/16/18
 * Time: 8:02 PM
 */

namespace App\Repositories\Specialist;


use App\Models\Specialist\Domains;

class DomainRepository implements DomainRepositoryInterface
{
    protected $domain;

    public function __construct(Domains $domain)
    {
        $this->domain = $domain;
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->domain->all()->sortBy('name');
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


}
