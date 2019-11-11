<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/15/19
 * Time: 10:53 PM
 */

namespace App\Repositories\Doctor;


use App\Models\Doctor\Availability;
use App\Models\Users\User;

class AvailabilityRepository implements AvailabilityRepositoryInterface
{
    protected $availability;

    public function __construct(Availability $availability)
    {
        $this->availability = $availability;
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function store(User $user, array $arr)
    {
        // TODO: Implement store() method.
        return $user->availability()->create($arr);
    }

    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
    }

    public function destroy($uuid)
    {
        // TODO: Implement destroy() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function getByUserId($user_id)
    {
        // TODO: Implement getByUserId() method.
        return $this->availability->all()->where('user_id',$user_id);
    }

    public function get_by_user_id_and_day($week_day, $user_id)
    {
        // TODO: Implement get_by_user_id_and_day() method.
        if ( $this->availability->all()->where('user_id',$user_id)->where('week_day',$week_day)->first() ){
            return true;
        }else{
            return false;
        }
    }


    public function is_weekday_exist(User $user, $week_day)
    {
        // TODO: Implement is_weekday_exist() method.
        if ($user->availability()->get()->where('week_day',$week_day)->first()){
            return true;
        }
        return false;
    }


}
