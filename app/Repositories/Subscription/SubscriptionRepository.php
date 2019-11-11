<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 2/20/19
 * Time: 8:00 AM
 */

namespace App\Repositories\Subscription;


use App\Models\Subscription\Subscription;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    protected $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
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