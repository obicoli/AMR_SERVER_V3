<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 2/19/19
 * Time: 12:46 PM
 */

namespace App\Repositories\Wholesaler;


interface WholesalerRepositoryInterface
{

    public function all();
    public function find($id);
    public function findByUuid($uuid);
    public function store(array $arr);
    public function update(array $arr, $uuid);
    public function destroy($uuid);

}
