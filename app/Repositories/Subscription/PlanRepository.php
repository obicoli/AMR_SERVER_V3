<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 2/20/19
 * Time: 7:48 AM
 */

namespace App\Repositories\Subscription;

use App\Models\Subscription\Plan;

class PlanRepository implements PlanRepositoryInterface
{
    protected $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
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