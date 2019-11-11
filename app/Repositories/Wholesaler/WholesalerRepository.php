<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 2/19/19
 * Time: 12:46 PM
 */

namespace App\Repositories\Wholesaler;


use App\Models\Wholesaler\Wholesaler;

class WholesalerRepository implements WholesalerRepositoryInterface
{

    protected $wholesaler;

    public function __construct(Wholesaler $wholesaler)
    {
        $this->wholesaler = $wholesaler;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
    }

    public function store(array $arr)
    {
        // TODO: Implement store() method.
    }

    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
    }

    public function destroy($uuid)
    {
        // TODO: Implement destroy() method.
    }


}
