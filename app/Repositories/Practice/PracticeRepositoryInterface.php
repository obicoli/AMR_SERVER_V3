<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/13/19
 * Time: 6:25 PM
 */

namespace App\Repositories\Practice;


use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Department;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Practice\PracticeProductItemStock;
use App\Models\Practice\PracticeUser;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Models\Practice\PracticeRole;

interface PracticeRepositoryInterface
{

    public function find($id);
    public function findByUserIdPracticeId($user_id,$practice_id,$email);
    public function findOwner(Practice $practice);
    public function findParent(Practice $practice);
    public function findByUser(User $user);
    public function findByUuid($uuid);
    public function delete($uuid);
    public function findByMobile($mobile);
    public function getByEmail($email);
    public function save(Practice $practice);
    public function create(array $arr);
    public function all();
    public function getByUser(User $user);
    public function getByUserID($user_id);
    public function update(array $arr, $uuid);
    //public function getUsers(Practice $practice, $all_facilities = null);
    public function getRoles(PracticeUser $practiceUser,$source_type=null);
    public function findMasterAdmin(Practice $practice);
    public function getPermissions(PracticeUser $practiceUser);
    public function create_asset(Practice $practice, array $arr);
    public function create_activation(Practice $practice, array $arr);
    public function verify_mobile(Practice $practice);
    public function verify_email(Practice $practice);
    //public function verify_otp(Practice $practice, $otp);
    public function getDepartment(Practice $practice = null, Pharmacy $pharmacy = null);
    public function getDepartmentServices(Department $department);
    public function setDepartment(Practice $practice, $inputs);
    public function setStore(Request $request);
    public function getStores(Practice $practice);
    public function transform_collection($collections);
    public function transform_(Practice $practice);
    //public function deleteDepartment($id);
    //Product
    public function getProductType(Practice $practice);
    public function setProductCategory(Practice $practice, array $array);
    public function setBrand(Model $model, array $array);
    public function setProductType(Model $model, array $array);
    public function setCategory(Model $model, array $array);
    public function setProduct(Model $model, array $array);
    public function setTax(Model $model, array $array);
    public function setGeneric(Model $model, array $array);
    public function setBrandSector(Model $model, array $array);
    public function setUnits(Model $model, array $array);
    public function setCurrency(Practice $practice, array $array);
    public function setChartAccount(Practice $practice, array $array);
    public function setAccountHolder(Practice $practice, array $array);
    public function setPaymentMethod(Practice $practice, array $array);
    public function setProductRoute(Practice $practice, array $array);
    public function setVendor(Model $model, array $array);
    //Roles
    //public function setRole(array $arr);
    public function getRole($role_id);
    //public function getPracticeRoles(Practice $practice);
    public function transform_role(PracticeRole $practiceRole,Practice $company);
    //Practice User
    public function setUser(Practice $practice, array $arr);
    public function getUser(Practice $practice);
    public function transform_user(PracticeUser $practiceUser, $source_type, Practice $company=null);
    public function setPermission(Role $role,$permissions);
    public function setWorkPlace(PracticeUser $practiceUser,array $arr);
    public function getWorkPlace(PracticeUser $practiceUser);
    public function getAccounts(User $user);
    public function attachRole(PracticeUser $practiceUser, PracticeRole $practiceRole);
    public function detachRole(PracticeUser $practiceUser, PracticeRole $practiceRole);
    //product items
//    public function setProductItem(array $arr);
//    public function getProductItem(Practice $practice);
//    public function add_consume_Stock(Practice $practice, PracticeProductItemStock $practiceProductItemStock,
//                                $move_direction,$bn, $description,$quantity,$unit_cost,$total_cost);
//    public function getStock(PracticeProductItem $practiceProductItem,$type = null);
    public function getResource(Practice $practice, $type);
}
