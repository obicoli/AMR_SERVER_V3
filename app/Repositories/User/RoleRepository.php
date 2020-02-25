<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/30/18
 * Time: 1:49 AM
 */

namespace App\Repositories\User;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{

    protected $role;

    public function __construct(Model $role)
    {
        $this->role = $role;
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->role->get(['id','name','slug'])
            ->where('slug','!=','admin')
            ->where('slug','!=','superadmin')
            ->where('slug','!=','practice')
            ->toArray();
    }

    public function formatPermissions()
    {
        // TODO: Implement formatPermissions() method.
        $res = array();
        // $permissions = Permission::all()->groupBy('description');
        // $permissions = Permission::all()->sortBy('description')->groupBy('description');
        $permissions = Permission::all()->groupBy('description');
        foreach ($permissions as $index => $permission){
            $temp_arr = array();
            $temp_data['category'] = $index;
            //$temp_data['has_category'] = false;
            //$permission_categorys = Permission::all()->where('description',$index)->sortBy('descriptions')->groupBy('descriptions');
            $permission_categorys = Permission::all()->where('description',$index)->groupBy('descriptions');
            foreach ( $permission_categorys as $index2 => $permission_category){
                //$temp_data['sub_category'] = $index2;
                $temp_arr1['sub_category'] = $index2;
                $looped_data = array();
                foreach ($permission_category as $permission_categ){
                    $temp1['id'] = $permission_categ->id;
                    $temp1['name'] = $permission_categ->name;
                    $temp1['slug'] = $permission_categ->slug;
                    $temp1['descriptions'] = $permission_categ->description_1;
                    $temp1['description'] = $permission_categ->description;
                    array_push($looped_data,$temp1);
                }
                $temp_arr1['sub_category_data'] = $looped_data;
                array_push($temp_arr, $temp_arr1);
            }
            $temp_data['data'] = $temp_arr;
            array_push($res,$temp_data);
        }
        return $res;
    }


    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->role->find($id);
    }

    public function findBySlug($slug)
    {
        // TODO: Implement findBySlug() method.
        return $this->role->all()->where('slug',$slug)->first();
    }

    public function getByDesc($desc)
    {
        // TODO: Implement findByDesc() method.
        return $this->role->where('description',$desc)->get()->sortBy('name');
    }


    public function update(array $arr, $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function transform_collection($collections)
    {
        // TODO: Implement transform_collection() method.
        $results = array();
        foreach ($collections as $collection){
            $temp_data['id'] = $collection->id;
            $temp_data['name'] = $collection->name;
            $temp_data['description'] = $collection->description;
            $temp_data['slug'] = $collection->slug;
            $temp_data['url_slug'] = strtolower(str_replace(" ","_",$collection->name));
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function createRole(array $arr)
    {
        // TODO: Implement createRole() method.
        $role = $this->role->all()->where('name',$arr['name'])->first();
        if ($role){
            return $role;
        }
        return $this->role->create($arr);
    }


}
