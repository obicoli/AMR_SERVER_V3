<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/15/19
 * Time: 10:54 PM
 */

namespace App\Repositories\Doctor;


use App\Models\Users\User;

interface AvailabilityRepositoryInterface
{

    public function find($id);
    public function store(User $user, array $arr);
    public function update(array $arr, $uuid);
    public function destroy($uuid);
    public function all();

    public function getByUserId($user_id);
    public function get_by_user_id_and_day($week_day, $user_id);
    public function is_weekday_exist(User $user, $week_day);

}
