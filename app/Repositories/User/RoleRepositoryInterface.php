<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/30/18
 * Time: 1:51 AM
 */

namespace App\Repositories\User;


interface RoleRepositoryInterface
{

    public function all();
    public function formatPermissions();
    public function find($id);
    public function findBySlug($slug);
    public function getByDesc($desc);
    public function update(array $arr, $id);
    public function destroy($id);
    public function transform_collection($collections);
    public function createRole(array $arr);

}
