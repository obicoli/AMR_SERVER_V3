<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/13/19
 * Time: 6:25 PM
 */

namespace App\Repositories\Practice;


use App\helpers\HelperFunctions;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Department;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Practice\PracticeStore;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Accounts\ProductAccountDetailType;
use App\Models\Product\Accounts\ProductAccountNature;
use App\Models\Product\Accounts\ProductAccountType;
use App\Models\Product\Accounts\ProductChartAccount;
use App\Models\Product\Product;
use App\Models\Product\ProductAdministrationRoute;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductGeneric;
use App\Models\Product\ProductPracticeCategory;
use App\Models\Product\ProductType;
use App\Models\Product\ProductUnit;
use App\Models\Users\User;
use App\Repositories\ModelRepository;
use App\Repositories\Product\ProductReposity;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Models\Practice\PracticeDepartment;
use App\Models\Practice\PracticeVendor;
use App\Models\Practice\PracticeRole;
use App\Models\Product\Store\ProductStore;
use App\Models\Practice\PracticeFinanceSetting;

class PracticeRepository implements PracticeRepositoryInterface
{

    protected $practice;
    protected $helper;

    public function __construct(Model $practice)
    {
        $this->practice = $practice;
        $this->helper = new HelperFunctions();
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->practice->find($id);
    }

    public function findByUserIdPracticeId($user_id, $practice_id,$email)
    {
        // TODO: Implement findByUserIdPracticeId() method.
        return $this->practice->all()
            ->where('user_id',$user_id)
            ->where('practice_id',$practice_id)
            ->where('email',$email)
            ->first();
    }


    public function findOwner(Practice $practice)
    {
        // TODO: Implement findOwner() method.
        //This method return the HeadQuarter(Main Branch)
        if ($practice->category == 'Main'){
            return $practice;
        }
        $owner = $practice->owner()->get()->first();
        return $owner->practices()->where('category','Main')->get()->first();
    }

    public function findParent(Practice $practice)
    {
        // TODO: Implement findParent() method.
        return $owner = $practice->owner()->get()->first();
    }

    public function findByUser(User $user)
    {
        // TODO: Implement findByUser() method.
        return $user->practices()->get()->first();
    }

    public function findByUserAndCompany(User $user,Practice $practice){
        return $this->practice->all()->where('user_id',$user->id)->where('practice_id',$practice->id)->first();
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->practice->all()->where('uuid',$uuid)->first();
    }

    public function delete($uuid)
    {
        // TODO: Implement delete() method.
        return $this->practice->all()->where('uuid',$uuid)->first()->delete();
    }

    public function findByMobile($mobile)
    {
        // TODO: Implement findByMobile() method.
        return $this->practice->all()->where('mobile',$mobile)->first();
    }

    public function getByEmail($email)
    {
        // TODO: Implement findByEmail() method.
        return $this->practice->all()->where('email',$email);
    }


    public function save(Practice $practice)
    {
        // TODO: Implement save() method.
        return $this->practice->save();
    }

    public function create(array $arr)
    {
        // TODO: Implement create() method.
        return $this->practice->create($arr);
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->practice->all()->where('is_verified',true)->sortBy('name');
    }

    public function getByUser(User $user)
    {
        // TODO: Implement getByUser() method.
        //return $user->practices()->get(['uuid','address','name','mobile','email','type','website','activated','is_verified','registration_number'])->sortByDesc('created_at');
        return $user->practices()->get()->sortByDesc('created_at');
    }

    public function getByUserID($user_id)
    {
        // TODO: Implement getByUserID() method.
        return $this->practice->all()->where('user_id',$user_id);
    }


    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
        return $this->practice->where('uuid',$uuid)->get()->first()->update($arr);
    }

    // public function getUsers(Practice $practice, $all_facilities = null)
    // {
    //     // TODO: Implement getUsers() method.
    //     $results = array();
    //     $main_practice = $this->findOwner($practice);
    //     $userss = $practice->users()->get();
    //     foreach ($userss as $users){
    //         $temp_data['id'] = $users->uuid;
    //         $temp_data['first_name'] = $users->first_name;
    //         $temp_data['other_name'] = $users->other_name;
    //         $temp_data['email'] = $users->email;
    //         $temp_data['mobile'] = $users->mobile;
    //         $temp_data['billable'] = $users->billable;
    //         $temp_data['gender'] = $users->gender;
    //         $temp_data['status'] = $users->status;
    //         $temp_data['address'] = $users->address;
    //         $temp_data['avatar'] = PracticeUser::DEFAULT_AVATAR;
    //         $temp_data['work_place'] = $this->getWorkPlace($users);
    //         $temp_data['roles'] = $this->getRoles($users);
    //         array_push($results, $temp_data);
    //     }
    //     return $results;
    // }

    public function transform_user(PracticeUser $practiceUser, $source_type=null, Practice $company=null)
    {
        // TODO: Implement transform_user() method.
        //$results = array();
        $temp_data['id'] = $practiceUser->uuid;
        $temp_data['first_name'] = $practiceUser->first_name;
        $temp_data['other_name'] = $practiceUser->other_name;
        $temp_data['email'] = $practiceUser->email;
        $temp_data['mobile'] = $practiceUser->mobile;
        $temp_data['status'] = $practiceUser->status;
        $temp_data['specific_facility'] = $practiceUser->facility;
        if($company){
            $temp_data['created_at'] = $this->helper->format_mysql_date($practiceUser->created_at,$company->date_format);
            $temp_data['updated_at'] = $this->helper->format_mysql_date($practiceUser->updated_at,$company->date_format);
            $parentPract = $this->findParent($company);
            $practice_main = $parentPract->practices()->where('category','Main')->get()->first();
            $app_data['id'] = $parentPract->uuid;
            $app_data['name'] = $parentPract->name;
            $app_data['address'] = $parentPract->address;
            $app_data['logo'] = "/assets/img/amref-white.png";
            $app_data['email'] = $parentPract->email;
            $app_data['mobile'] = $parentPract->mobile;

            $main_branch['id'] = $practice_main->uuid;
            $main_branch['name'] = $practice_main->name;
            $main_branch['address'] = $practice_main->address;
            $main_branch['logo'] = "/assets/img/amref-white.png";
            $main_branch['email'] = $practice_main->email;
            $main_branch['mobile'] = $practice_main->mobile;
            $main_branch['lat'] = $practice_main->latitude;
            $main_branch['lgt'] = $practice_main->longitude;
            $main_branch['category'] = $practice_main->category;

            $main_branch['app_data'] = $app_data;

        }else{
            $temp_data['created_at'] = $this->helper->format_mysql_date($practiceUser->created_at);
            $temp_data['updated_at'] = $this->helper->format_mysql_date($practiceUser->updated_at);
        }
        $temp_data['role'] = $this->getRoles($practiceUser, $source_type);
        //$temp_data['work_station'] = $this->getWorkPlace($practiceUser);
        // $temp_data['billable'] = $practiceUser->billable;
        // $temp_data['gender'] = $practiceUser->gender;
        // $temp_data['status'] = $practiceUser->status;
        // $temp_data['address'] = $practiceUser->address;
        // $temp_data['avatar'] = PracticeUser::DEFAULT_AVATAR;
        //$temp_data['roles'] = $this->getRoles($practiceUser);
        //$temp_data['permissions'] = $this->getPermissions($practiceUser);
        //$practice = $this->find($practiceUser->practice_id);

        // $main_branch['id'] = $practice_main->uuid;
        // $main_branch['name'] = $practice_main->name;
        // $main_branch['address'] = $practice_main->address;
        // $main_branch['logo'] = "/assets/front/images/amref-logo.png";
        // $main_branch['email'] = $practice_main->email;
        // $main_branch['mobile'] = $practice_main->mobile;
        // $main_branch['lat'] = $practice_main->latitude;
        // $main_branch['lgt'] = $practice_main->longitude;
        // $main_branch['branch'] = $this->getWorkPlace($practiceUser);
        // $temp_data['facility'] = $main_branch;




        

        if($source_type=="app"){ //For app Login: User who can access facilities
            if( sizeof($temp_data['role'])>0 && $temp_data['role']['access_level'] == "facility_manager" ){//User at Main Branch Level
                $branches = $parentPract->practices()->get();
                $brancha = array();
                foreach($branches as $branch){
                    $temp_bra = $this->transform_($branch,'Purchase Orders & Category');
                    array_push($brancha,$temp_bra);
                }
                $main_branch['branches'] = $brancha;
                $temp_data['facility'] = $main_branch;
            }else{ //User at Branch Level: Login via APP
                //$temp_data['facility'] = $this->getWorkPlace($practiceUser);
                //$temp_data['facility'] = $this->transform_($practice,'Purchase Orders & Category');
            }
        }elseif($source_type=="web"){//For web login
            if( sizeof($temp_data['role'])>0 && $temp_data['role']['access_level'] == "facility_manager"){ //general manager
                $temp_data['facility'] = $main_branch;
            }else{ //user at branch level
                $placo = $this->getWorkPlace($practiceUser);
                $placo['app_data'] = $app_data;
                $temp_data['facility'] = $placo;
            }
        }else{
            return $temp_data;
        }
        // $main_branch['branch'] = $this->getWorkPlace($practiceUser);
        // $temp_data['facility'] = $main_branch;
        //$temp_data['facility'] = $this->getWorkPlace($practiceUser);
        //array_push($results, $temp_data);
        return $temp_data;
    }

    public function transform_finance_settings(PracticeFinanceSetting $practiceFinanceSetting){

        return [
            'id' => $practiceFinanceSetting->uuid,
            'so_prefix' => $practiceFinanceSetting->so_prefix,
            'so_title' => $practiceFinanceSetting->so_title,
            'so_summary' => $practiceFinanceSetting->so_summary,
            'so_terms' => $practiceFinanceSetting->so_terms,
            'so_notes' => $practiceFinanceSetting->so_notes,
            'so_mail_subject' => $practiceFinanceSetting->so_mail_subject,
            'so_text_below_phone' => $practiceFinanceSetting->so_text_below_phone,
            'so_due_term' => $practiceFinanceSetting->so_due_term,
            'so_bank_details' => $practiceFinanceSetting->so_bank_details,
            'so_show_shipping' => $practiceFinanceSetting->so_show_shipping,

            'inv_prefix' => $practiceFinanceSetting->inv_prefix,
            'inv_title' => $practiceFinanceSetting->inv_title,
            'inv_summary' => $practiceFinanceSetting->inv_summary,
            'inv_terms' => $practiceFinanceSetting->inv_terms,
            'inv_notes' => $practiceFinanceSetting->inv_notes,
            'inv_mail_subject' => $practiceFinanceSetting->inv_mail_subject,
            'inv_text_below_phone' => $practiceFinanceSetting->inv_text_below_phone,
            'inv_due_term' => $practiceFinanceSetting->inv_due_term,
            'inv_bank_details' => $practiceFinanceSetting->inv_bank_details,
            'inv_show_shipping' => $practiceFinanceSetting->inv_show_shipping,

            'po_prefix' => $practiceFinanceSetting->po_prefix,
            'po_title' => $practiceFinanceSetting->po_title,
            'po_summary' => $practiceFinanceSetting->po_summary,
            'po_terms' => $practiceFinanceSetting->po_terms,
            'po_notes' => $practiceFinanceSetting->po_notes,
            'po_mail_subject' => $practiceFinanceSetting->po_mail_subject,
            'po_text_below_phone' => $practiceFinanceSetting->po_text_below_phone,
            'po_due_term' => $practiceFinanceSetting->po_due_term,
            'po_bank_details' => $practiceFinanceSetting->po_bank_details,
            'po_show_shipping' => $practiceFinanceSetting->po_show_shipping,

            'bill_prefix' => $practiceFinanceSetting->bill_prefix,
            'bill_title' => $practiceFinanceSetting->bill_title,
            'bill_summary' => $practiceFinanceSetting->bill_summary,
            'bill_terms' => $practiceFinanceSetting->bill_terms,
            'bill_notes' => $practiceFinanceSetting->bill_notes,
            'bill_mail_subject' => $practiceFinanceSetting->bill_mail_subject,
            'bill_text_below_phone' => $practiceFinanceSetting->bill_text_below_phone,
            'bill_due_term' => $practiceFinanceSetting->bill_due_term,
            'bill_bank_details' => $practiceFinanceSetting->bill_bank_details,
            'bill_show_shipping' => $practiceFinanceSetting->bill_show_shipping,

            'est_prefix' => $practiceFinanceSetting->est_prefix,
            'est_title' => $practiceFinanceSetting->est_title,
            'est_summary' => $practiceFinanceSetting->est_summary,
            'est_terms' => $practiceFinanceSetting->est_terms,
            'est_notes' => $practiceFinanceSetting->est_notes,
            'est_mail_subject' => $practiceFinanceSetting->est_mail_subject,
            'est_text_below_phone' => $practiceFinanceSetting->est_text_below_phone,
            'est_due_term' => $practiceFinanceSetting->est_due_term,
            'est_bank_details' => $practiceFinanceSetting->est_bank_details,
            'est_show_shipping' => $practiceFinanceSetting->est_show_shipping,

            'cn_prefix' => $practiceFinanceSetting->cn_prefix,
            'cn_title' => $practiceFinanceSetting->cn_title,
            'cn_summary' => $practiceFinanceSetting->cn_summary,
            'cn_terms' => $practiceFinanceSetting->cn_terms,
            'cn_notes' => $practiceFinanceSetting->cn_notes,
            'cn_mail_subject' => $practiceFinanceSetting->cn_mail_subject,
            'cn_text_below_phone' => $practiceFinanceSetting->cn_text_below_phone,
            'cn_due_term' => $practiceFinanceSetting->cn_due_term,
            'cn_bank_details' => $practiceFinanceSetting->cn_bank_details,
            'cn_show_shipping' => $practiceFinanceSetting->cn_show_shipping,

            'dn_prefix' => $practiceFinanceSetting->dn_prefix,
            'dn_title' => $practiceFinanceSetting->dn_title,
            'dn_summary' => $practiceFinanceSetting->dn_summary,
            'dn_terms' => $practiceFinanceSetting->dn_terms,
            'dn_notes' => $practiceFinanceSetting->dn_notes,
            'dn_mail_subject' => $practiceFinanceSetting->dn_mail_subject,
            'dn_text_below_phone' => $practiceFinanceSetting->dn_text_below_phone,
            'dn_due_term' => $practiceFinanceSetting->dn_due_term,
            'dn_bank_details' => $practiceFinanceSetting->dn_bank_details,
            'dn_show_shipping' => $practiceFinanceSetting->dn_show_shipping,

            'return_prefix' => $practiceFinanceSetting->return_prefix,
            'return_title' => $practiceFinanceSetting->return_title,
            'return_summary' => $practiceFinanceSetting->return_summary,
            'return_terms' => $practiceFinanceSetting->return_terms,
            'return_notes' => $practiceFinanceSetting->return_notes,
            'return_mail_subject' => $practiceFinanceSetting->return_mail_subject,
            'return_text_below_phone' => $practiceFinanceSetting->return_text_below_phone,
            'return_due_term' => $practiceFinanceSetting->return_due_term,
            'return_bank_details' => $practiceFinanceSetting->return_bank_details,
            'return_show_shipping' => $practiceFinanceSetting->return_show_shipping,


        ];
        
    }

    public function setPermission(Role $role, $permissions)
    {
        // TODO: Implement setPermission() method.
        // $practiceUser->detachAllPermissions();
        // if ( is_array($permissions) ){
        //     for ($k=0; $k < sizeof($permissions); $k++){
        //         $permission = Permission::find($permissions[$k]);
        //         $practiceUser->attachPermission($permission);
        //     }
        // }
    }

    public function setWorkPlace(PracticeUser $practiceUser, array $arr)
    {
        // TODO: Implement setWorkPlace() method.
        $work_place = $practiceUser->work_place()->get()->first();
        if ($work_place){
            $work_place->ended_at = date('Y-m-d H:i:s');
            $work_place->status = false;
            $work_place->save();
        }
        return $practiceUser->work_place()->create($arr);
    }

    public function getWorkPlace(PracticeUser $practiceUser)
    {
        // TODO: Implement getWorkPlace() method.
        $results = array();
        $work_place = $practiceUser->work_place()->get()->where('status',true)->first();
        $branchRepo = new ModelRepository(new Practice());
        $deptRepo = new ModelRepository(new Department());
        //$practDeptRepo = new ModelRepository(new PracticeDepartment());
        if ($work_place){
            $pract = Practice::find($work_place->practice_id);
            //$pract_department = $practDeptRepo->find($work_place->practice_department_id);
            $dept = Department::find($work_place->department_id);
            $store = ProductStore::find($work_place->store_id);
            $sub_store = ProductStore::find($work_place->sub_store_id);
            $results['id'] = $pract->uuid;
            $results['name'] = $pract->name;
            $results['category'] = $pract->category;
            $results['email'] = $pract->email;
            $results['mobile'] = $pract->mobile;
            $results['lat'] = $pract->latitude;
            $results['lgt'] = $pract->longitude;
            $results['department'] = [];
            $results['store'] = [];
            $results['sub_store'] = [];

            if($dept){
                $depo['id'] = $dept->uuid;
                $depo['name'] = $dept->name;
                $results['department'] = $depo;
            }
            $results['store'] = [];
            if($store){
                $sto['id'] = $store->uuid;
                $sto['name'] = $store->name;
                $results['store'] = $sto;
            }
            $results['sub_store'] = [];
            if($sub_store){
                $stos['id'] = $sub_store->uuid;
                $stos['name'] = $sub_store->name;
                $results['sub_store'] = $stos;
            }
        }else{
            $pract = Practice::find($practiceUser->practice_id);
            $results['id'] = $pract->uuid;
            $results['name'] = $pract->name;
            $results['category'] = $pract->category;
            $results['email'] = $pract->email;
            $results['mobile'] = $pract->mobile;
            $results['address'] = $pract->address;
            $results['lat'] = $pract->latitude;
            $results['lgt'] = $pract->longitude;
            // $results['department'] = [];
        }
        return $results;
    }

    public function getAccounts(User $user)
    {
        // TODO: Implement getAccounts() method.
        $practiceUserAccounts = PracticeUser::all()->where('user_id',$user->id);
        $accounts = array();
        foreach ($practiceUserAccounts as $practiceUserAccount){
            $practice = Practice::find($practiceUserAccount->practice_id);
            $owner = $practice->owner()->get()->first();
            $main_practice = $owner->practices()->where('category','Main')->get()->first();
            // $acc['id'] = $main_practice->uuid;
            // $acc['name'] = $main_practice->name;
            // $acc['logo'] = $owner->logo;
            // $acc['email'] = $main_practice->email;
            // $acc['address'] = $main_practice->address;
            // $acc['mobile'] = $main_practice->mobile;
            // $acc['category'] = $main_practice->category;
            $acc['practice_user'] = $this->transform_user($practiceUserAccount);
            array_push($accounts, $acc);
        }
        return $accounts;
    }

    public function attachRole(PracticeUser $practiceUser, PracticeRole $practiceRole)
    {
        // TODO: Implement attachRole() method.
        $practiceUser->detachRole($practiceRole);
        $practiceUser->attachRole($practiceRole);
    }

    public function detachRole(PracticeUser $practiceUser, PracticeRole $practiceRole)
    {
        // TODO: Implement detachRole() method.
        $practiceUser->detachRole($practiceRole);
    }


    public function getRoles(PracticeUser $practiceUser, $source_type=null)
    {
        // TODO: Implement getRoles() method.
        $roles = PracticeRole::all();//->where('practice_id',$practiceUser->practice_id);
        $roler = array();
        foreach ($roles as $role){
            if( DB::table('practice_user_role')->where('practice_user_id',$practiceUser->id)->where('role_id',$role->id)->get()->first() ){
                $temp_role['id'] = $role->id;
                $temp_role['name'] = $role->name;
                $temp_role['slug'] = $role->slug;
                $temp_role['access_level'] = "branch_manager";
                $temp_perms = array();

                if($source_type && $source_type=="web" || $source_type=="app"){
                    $perms = DB::table('permission_practice_role')->where('practice_role_id',$role->id)->get();
                    foreach( $perms as $perm ){
                        $permission = Permission::find($perm->permission_id);
                        $temp_arr['id'] = $permission->id;
                        $temp_arr['slug'] = $permission->slug;
                        $temp_arr['name'] = $permission->name;
                        $temp_arr['description'] = $permission->description;
                        $temp_arr['descriptions'] = $permission->descriptions;
                        if( !$practiceUser->facility){
                            $temp_role['access_level'] = "facility_manager";
                        }
                        array_push($temp_perms, $temp_arr);
                    }
                    if($source_type=="web"){
                        $temp_role['permissions'] = $temp_perms;
                        array_push($roler, $temp_role);
                    }
                }
                return $temp_role;
                array_push($roler, $temp_role);
                
            }
        }
        return $roler;
    }

    public function findMasterAdmin(Practice $practice)
    {
        $users = $practice->users()->get();
        foreach ($users as $user){
            if ($user->hasRole('master.admin')){
                return $user;
            }
        }
        return false;
        // TODO: Implement findMasterAdmin() method.
    }


    public function getPermissions(PracticeUser $practiceUser)
    {
        // TODO: Implement getPermissions() method.
        $res = array();
        $permissions = Permission::all()->groupBy('description');
        foreach ($permissions as $index => $permission){
            $temp_arr = array();
            $temp_data['category'] = $index;
            $temp_data['has_category'] = false;
            foreach ($permission as $perms){
                $temp_arr1['id'] = $perms->id;
                $temp_arr1['name'] = $perms->name;
                $temp_arr1['slug'] = $perms->slug;
                $temp_arr1['description'] = $perms->description;
                $checker = DB::table('permission_practice_user')->get()->where('permission_id',$perms->id)->where('practice_user_id',$practiceUser->id)->first();
                if ( $checker ){
                    $temp_arr1['has_perm'] = true;
                    $temp_data['has_category'] = true;
                }else{
                    $temp_arr1['has_perm'] = false;
                }
                array_push($temp_arr, $temp_arr1);
            }
            $temp_data['data'] = $temp_arr;
            array_push($res,$temp_data);

        }
        return $res;
    }


    public function create_asset(Practice $practice, array $arr)
    {
        // TODO: Implement create_asset() method.
        return $practice->assets()->create($arr);
    }

    public function create_activation(Practice $practice, array $arr)
    {
        // TODO: Implement create_activation() method.
        $act = $practice->activation()->get()->first();
        if ($act){
            $act->delete();
            //return $practice->activation()->save($act);
            return $practice->activation()->create($arr);
        }
        return $practice->activation()->create($arr);
    }

    public function verify_mobile(Practice $practice)
    {
        // TODO: Implement verify_mobile() method.
        $practice->phone_verified = true;
        return $practice->save();
    }

    public function verify_email(Practice $practice)
    {
        // TODO: Implement verify_email() method.
        $practice->mail_verified = true;
        return $practice->save();
    }

    public function getDepartment(Practice $practice = null, Pharmacy $pharmacy = null)
    {
        // TODO: Implement getDepartment() method.
        $results = array();
        if ($practice){
            $practice_departments = DB::table('practice_departments')
                ->join('practices','practice_departments.practice_id','=','practices.id')
                ->join('departments','practice_departments.department_id','=','departments.id')
                ->select('departments.name as depart_name','practice_departments.*','practices.name as branch_name')
                ->where('practice_departments.practice_id','=', $practice->id)
                ->whereNull('practice_departments.deleted_at')
                ->get();
            foreach ($practice_departments as $practice_department){
                $temp_data['id'] = $practice_department->uuid;
                $temp_data['status'] = $practice_department->status;
                $temp_data['description'] = $practice_department->description;
                $depart = Department::find($practice_department->department_id);
                $temp_data['name'] = $practice_department->depart_name;
                $temp_data['branch'] = $practice_department->branch_name;
                array_push($results, $temp_data);
            }
        }elseif ($pharmacy){

            $practices = $pharmacy->practices()->get();
            foreach ($practices as $practi){

                $practice_departments = DB::table('practice_departments')
                    ->join('practices','practice_departments.practice_id','=','practices.id')
                    ->join('departments','practice_departments.department_id','=','departments.id')
                    ->select('departments.name as depart_name','practice_departments.*','practices.name as branch_name')
                    ->where('practice_departments.practice_id','=', $practi->id)
                    ->whereNull('practice_departments.deleted_at')
                    //->where('practice_departments.deleted_at','!=', '')
                    ->get();
                //Log::info($practice_departments);
                foreach ($practice_departments as $practice_department){
                    $temp_data['id'] = $practice_department->uuid;
                    $temp_data['status'] = $practice_department->status;
                    $temp_data['description'] = $practice_department->description;
                    $depart = Department::find($practice_department->department_id);
                    $temp_data['name'] = $practice_department->depart_name;
                    $temp_data['branch'] = $practice_department->branch_name;
                    $temp_data['services'] = '';
                    array_push($results, $temp_data);
                }

            }
        }
        return $results;
    }

    public function getDepartmentServices(Department $department)
    {
        // TODO: Implement getDepartmentServices() method.
    }


    public function setDepartment(Practice $practice, $inputs)
    {
        // TODO: Implement setDepartment() method.
        $department = Department::all()
            ->where('name',$inputs['name'])
            ->where('practice_id',$practice->id)
            ->first();
        if (!$department){
            $department = new Department();
            $department->name = $inputs['name'];
            $department->practice_id = $practice->id;
            $department->save();
        }

        //check if branch already exist
        $branch = Practice::all()->where('uuid',$inputs['branch_id'])->first();
        $check = PracticeDepartment::all()
            ->where('practice_id',$branch->id)
            ->where('department_id',$department->id)
            ->first();
        if ($check){
            return false;
        }
        $inputs['practice_id'] = $branch->id;
        $inputs['department_id'] = $department->id;
        //return $branch->department()->create($inputs);
        return PracticeDepartment::create($inputs);
    }

    public function setStore(Request $request)
    {
        // TODO: Implement setStore() method.
        $arr = $request->all();
        $msg = "";
        //Log::info($request);

        if ( is_array($arr['branch_id']) ){

            for ( $i=0; $i < sizeof($arr['branch_id']); $i++ ){

                $branch = Practice::all()->where('uuid',$arr['branch_id'][$i])->first();
                $store = PracticeStore::all()
                    ->where('name',$arr['name'])
                    ->where('branch_id',$branch->id)
                    ->first();
                if (!$store){
                    $arr2 = $request->except(['branch_id']);
                    $arr2['practice_id'] = $branch->id;
                    $arr2['created_by_user_id'] = $request->user()->id;
                    $store = PracticeStore::create($arr2);
                    $msg .= $branch->name.", ";
                }
            }

        }else{
            $branch = Practice::all()->where('uuid',$request->branch_id)->first();
            //Log::info($branch);
            //check if this branch already exist
            $store = PracticeStore::all()
                ->where('name',$arr['name'])
                ->where('practice_id',$branch->id)
                ->first();
            if (!$store){
                //Log::info('--------');
                $arr2 = $request->except(['branch_id']);
                $arr2['practice_id'] = $branch->id;
                $arr2['created_by_user_id'] = $request->user()->id;
                $store = PracticeStore::create($arr2);
                $msg .= $branch->name.", ";
            }
        }
        //return $msg;
        if ($msg != ""){
            return "Store successful added to branch: ".$msg;
        }else{
            return $msg;
        }
    }


    public function getStores(Practice $practice)
    {
        // TODO: Implement getStores() method.
        $results = array();
        $stores = $practice->stores()->get()->sortByDesc('created_at');
        foreach ($stores as $stor){
            $temp_data['id'] = $stor->uuid;
            $temp_data['name'] = $stor->name;
            $temp_data['status'] = $stor->status;
            $temp_data['description'] = $stor->description;
            array_push($results,$temp_data);
        }
        return $results;
    }


    public function transform_collection($collections)
    {
        // TODO: Implement transaform_collection() method.
        $results = array();
        foreach ($collections as $collection){
            array_push($results, $this->transform_($collection,null));
        }
        return $results;

    }

    public function transform_(Practice $practice, $resource_type = null)
    {
        // TODO: Implement transform_() method.
        $branch_data['id'] = $practice->uuid;
        $branch_data['name'] = $practice->name;
        $branch_data['country'] = $practice->country;
        $branch_data['city'] = $practice->city;
        $branch_data['mobile'] = $practice->mobile;
        $branch_data['phone'] = $practice->mobile;
        $branch_data['email'] = $practice->email;
        $branch_data['mail_verified'] = $practice->mail_verified;
        $branch_data['phone_verified'] = $practice->phone_verified;
        $branch_data['type'] = $practice->type;
        $branch_data['address'] = $practice->address;
        $branch_data['registration_number'] = $practice->registration_number;
        $branch_data['description'] = $practice->description;
        $branch_data['website'] = $practice->website;
        $branch_data['approval_status'] = $practice->approval_status;
        $branch_data['status'] = $practice->status;
        $branch_data['support_email'] = $practice->support_email;
        $branch_data['category'] = $practice->category;
        $branch_data['postal_code'] = $practice->postal_code;
        $branch_data['region'] = $practice->region;
        $branch_data['fax'] = $practice->fax;
        $branch_data['logo'] = $practice->logo;
        if(!$practice->logo){
            $branch_data['logo'] = "/assets/img/logos/amref-white.png";
        }

        $branch_data['propriator_title'] = $practice->propriator_title;
        $branch_data['propriator_name'] = $practice->propriator_name;
        $branch_data['business_type'] = $practice->business_type;
        $branch_data['industry'] = $practice->industry;
        $branch_data['display_assigned_user'] = $practice->display_assigned_user;
        $branch_data['inventory_increase'] = $practice->inventory_increase;
        $branch_data['inventory_descrease'] = $practice->inventory_descrease;
        $branch_data['warehouse_config'] = $practice->warehouse_config;
        $branch_data['batch_tracking'] = $practice->batch_tracking;
        $branch_data['date_format'] = $practice->date_format;

        if ($resource_type){
            switch ($resource_type){

                case "Purchase Orders & Category":
                    $purchase_orders = $practice->purchase_orders()->get()->sortByDesc('created_at');
                    $pos = array();
                    $cate = array();
                    $helper = new HelperFunctions();
                    foreach($purchase_orders as $purchase_order){
                        array_push($pos, $helper->format_purchase_order($purchase_order));
                    }
                    $branch_data['purchase_orders'] = $pos;
                    $categories = ProductCategory::all();
                    foreach($categories as $category){
                        $temp_dat['id'] = $category->uuid;
                        $temp_dat['name'] = $category->name;
                        $cate_prod = array();
                        $practice_product_items = $category->product_items()->get();
                        foreach($practice_product_items as $practice_product_item){
                            $prod = $helper->create_product_attribute($practice_product_item);
                            $prod['stock_total'] = 0;
                            array_push($cate_prod, $prod);
                        }
                        $temp_dat['products'] = $cate_prod;
                        array_push($cate, $temp_dat);
                    }
                    $branch_data['product_category'] = $cate;
                    break;
                case "Human Resource":
                    //Log::info($this->getUsers($practice));
                    $branch_data['resources'] = $this->getUsers($practice);
                    break;
                case "Practices":
                    $branch_data['resources'] = $this->getResource($practice, $resource_type);
                    break;
                case "Product Items":
                    //$branch_data['product_items'] = $this->getProductItem($practice);
                    break;
                case "Medicine Category":
                case "Product Type":
                case "Product Category":
                case "Manufacturers":
                case "Departments":
                    $depars = $practice->departments()->get();
                    $res = array();
                    foreach($depars as $depar){
                        $temps['id'] = $depar->uuid;
                        $temps['name'] = $depar->name;
                        array_push($res,$temps);
                    }
                    $branch_data['departments'] = $res;
                    break;
                case "Brands":
                case "Units":
                case "Accounts":
                case "Currency":
                case "Branches":
                case "Account Nature":
                case "Account Type":
                case "Brand Sector":
                case "Taxes":
                case "Suppliers":
                case "Payment Methods":
                    $branch_data['resources'] = $this->getResource($practice, $resource_type);
                    break;
                // case "Items Page Initialization":
                //     $intialized['units'] = $this->getResource($practice, "Units");
                //     $intialized['brand_sector'] = $this->getResource($practice, "Brand Sector");
                //     $intialized['brands'] = $this->getResource($practice, "Brands");
                //     $intialized['product_category'] = $this->getResource($practice, "Product Category");
                //     $intialized['taxes'] = $this->getResource($practice, "Taxes");
                //     $intialized['currency'] = $this->getResource($practice, "Currency");//product_types
                //     $intialized['product_types'] = $this->getResource($practice, "Product Type");
                //     $intialized['manufacturers'] = $this->getResource($practice, "Manufacturers");
                //     $intialized['generics'] = $this->getResource($practice, "Generics");
                //     $intialized['products'] = $this->getResource($practice, "Products");
                //     $proRepo = new ProductReposity(new PracticeProductItem());
                //     $intialized['product_items'] = $proRepo->getProductItem($practice);
                //     $branch_data['resources'] = $intialized;
                //     //Log::info($branch_data);
                //     break;
            }
        }
        return $branch_data;
    }

    public function getResource(Practice $practice, $type)
    {
        // TODO: Implement getResource() method.
        $results = array();
        $user_repo = new UserRepository(new User());
        $parent_main = $this->findParent($practice);
        switch ($type){
            case "Practices":
                $practice_main = $this->findOwner($practice);
                $owner = $practice_main->owner()->get()->first();
                $practice_lists = $owner->practices()->get();
                foreach($practice_lists as $practice_list){
                    $temp_data['id'] = $practice_list->uuid;
                    $temp_data['name'] = $practice_list->name;
                    $temp_data['email'] = $practice_list->email;
                    $temp_data['mobile'] = $practice_list->mobile;
                    $temp_data['address'] = $practice_list->address;
                    $temp_data['category'] = $practice_list->category;
                    $temp_data['city'] = $practice_list->city;
                    $temp_data['registration_number'] = $practice_list->registration_number;
                    $temp_data['longitude'] = $practice_list->longitude;
                    $temp_data['latitude'] = $practice_list->latitude;
                    array_push($results, $temp_data);
                }
                break;
            case "Suppliers":
                $vendor_lists = PracticeVendor::all()->where('vendor_type','Supplier')->where('practice_id',$practice->id)->sortByDesc('created_at');
                foreach( $vendor_lists as $vendor_list){
                    $temp_data['id'] = $vendor_list->uuid;
                    $temp_data['first_name'] = $vendor_list->first_name;
                    $temp_data['last_name'] = $vendor_list->last_name;
                    $temp_data['middle_name'] = $vendor_list->middle_name;
                    $temp_data['email'] = $vendor_list->email;
                    $temp_data['mobile'] = $vendor_list->mobile;
                    $temp_data['address'] = "Mara road";
                    $temp_data['company'] = $vendor_list->company;
                    array_push($results, $temp_data);
                }
                break;
            case "Generics": //
                $payment_methods = $parent_main->generics()->get()->sortBy('name');
                foreach ($payment_methods as $payment_method){
                    $temp_data['id'] = $payment_method->uuid;
                    $temp_data['name'] = $payment_method->name;
                    $temp_data['status'] = $payment_method->status;
                    $temp_data['description'] = $payment_method->description;
                    array_push($results, $temp_data);
                }
                break;
            case "Products":
                $payment_methods = $parent_main->products()->get()->sortBy('name');
                foreach ($payment_methods as $payment_method){
                    $temp_data['id'] = $payment_method->uuid;
                    $temp_data['name'] = $payment_method->name;
                    $temp_data['status'] = $payment_method->status;
                    $temp_data['description'] = $payment_method->description;
                    array_push($results, $temp_data);
                }
                break;
            case "Payment Methods":
                $payment_methods = $practice->payment_methods()->get()->sortBy('name');
                foreach ($payment_methods as $payment_method){
                    $temp_data['id'] = $payment_method->uuid;
                    $temp_data['name'] = $payment_method->name;
                    $temp_data['vendor_fee'] = $payment_method->vendor_fee;
                    $temp_data['status'] = $payment_method->status;
                    $temp_data['payment_type'] = $payment_method->payment_type_id;
                    $temp_data['description'] = $payment_method->description;
                    array_push($results, $temp_data);
                }
                break;
            case "Medicine Category":
                $categories = $parent_main->product_category()->get()->sortByDesc('created_at');
                foreach ($categories as $category){
                    $user = User::find($category->created_by_user_id);
                    $temp_data['id'] = $category->uuid;
                    $temp_data['status'] = $category->status;
                    $temp_data['description'] = $category->description;
                    $temp_data['name'] = $category->name;
                    $temp_data['created_by'] = $user_repo->getCreatedBy($user);
                    $temp_data['created_at'] = date('Y-m-d', strtotime($category->created_at));
                    array_push($results, $temp_data);
                }
                break;
            case "Product Category":
                $categories = $parent_main->product_category()->get()->sortByDesc('created_at');
                foreach ($categories as $category){
                    $user = User::find($category->created_by_user_id);
                    $temp_data['id'] = $category->uuid;
                    $temp_data['status'] = $category->status;
                    $temp_data['description'] = $category->description;
                    $temp_data['name'] = $category->name;
                    //$temp_data['created_by'] = $user_repo->getCreatedBy($user);
                    //$temp_data['created_at'] = date('Y-m-d', strtotime($category->created_at));
                    array_push($results, $temp_data);
                }
                break;
            case "Product Type":
                $categories = $parent_main->product_type()->get()->sortByDesc('created_at');
                foreach ($categories as $category){
                    $user = User::find($category->created_by_user_id);
                    $temp_data['id'] = $category->uuid;
                    $temp_data['status'] = $category->status;
                    $temp_data['description'] = $category->description;
                    $temp_data['name'] = $category->name;
                    //$temp_data['created_by'] = $user_repo->getCreatedBy($user);
                    //$temp_data['created_at'] = date('Y-m-d', strtotime($category->created_at));
                    array_push($results, $temp_data);
                }
                break;
            case "Brands":
                $brands = $parent_main->product_brands()->get()->sortByDesc('created_at');
                //Log::info($manufacturers);
                foreach ($brands as $brand){
                    $manu = Manufacturer::find($brand->company_id);
                    $temp_data['id'] = $brand->uuid;
                    $temp_data['name'] = $brand->name;
                    //$temp_data['company_name'] = $manu->name;
                    $temp_data['status'] = $brand->status;
                    //$temp_data['company_id'] = $manu->uuid;
                    $temp_data['created_at'] = date('Y-m-d',strtotime($brand->created_at));
                    //$temp_data['created_by'] = $user_repo->getCreatedBy($user_repo->findRecord($brand->created_by_user_id));
                    array_push($results, $temp_data);
                }
                break;
            case "Brand Sector":
                $brand_sectors = $parent_main->product_brand_sector()->get()->sortBy('name');

                foreach ($brand_sectors as $brand_sector){

                    $user = $user_repo->findRecord($brand_sector->created_by_user_id);

                    $temp_data['id'] = $brand_sector->uuid;
                    $temp_data['name'] = $brand_sector->name;
                    $temp_data['status'] = $brand_sector->status;
                    $temp_data['created_at'] = date('Y-m-d',strtotime($brand_sector->created_at));
                    if ($user){
                        $temp_data['created_by'] = $user_repo->getCreatedBy($user);
                    }else{
                        $temp_data['created_by'] = "";
                    }
                    array_push($results, $temp_data);
                }
                break;
            case "Currency":
                $product_currencys = $parent_main->product_currency()->get()->sortBy('name');
                foreach ($product_currencys as $product_currency){
                    $user = $user_repo->findRecord($product_currency->created_by_user_id);
                    $temp_data['id'] = $product_currency->uuid;
                    $temp_data['name'] = $product_currency->name;
                    $temp_data['status'] = $product_currency->status;
                    $temp_data['slug'] = $product_currency->slug;
                    $temp_data['created_at'] = date('Y-m-d',strtotime($product_currency->created_at));
                    if ($user){
                        $temp_data['created_by'] = $user_repo->getCreatedBy($user);
                    }else{
                        $temp_data['created_by'] = "";
                    }
                    array_push($results, $temp_data);
                }
                break;
            case "Branches":
                if ( $practice->category == "Main" ){
                    $owner = $practice->owner()->get()->first();
                    $branches = $owner->practices()->get()->sortBy('name');
                    foreach ($branches as $branch){
                        $user = $user_repo->findRecord($branch->created_by_user_id);
                        $temp_data['id'] = $branch->uuid;
                        $temp_data['name'] = $branch->name;
                        $temp_data['registration_number'] = $branch->registration_number;
                        $temp_data['status'] = $branch->status;
                        $temp_data['type'] = $branch->type;
                        $temp_data['email'] = $branch->email;
                        $temp_data['mobile'] = $branch->mobile;
                        $temp_data['country'] = $branch->country;
                        $temp_data['city'] = $branch->city;
                        $temp_data['description'] = $branch->description;
                        $temp_data['category'] = $branch->category;
                        $temp_data['phone_verified'] = $branch->phone_verified;
                        $temp_data['mail_verified'] = $branch->mail_verified;
                        $temp_data['website'] = $branch->website;
                        $temp_data['address'] = $branch->address;
                        $temp_data['approval_status'] = $branch->approval_status;
                        $temp_data['longitude'] = $branch->longitude;
                        $temp_data['latitude'] = $branch->latitude;
                        $temp_data['created_at'] = date('Y-m-d',strtotime($branch->created_at));
                        if ($user){
                            $temp_data['created_by'] = $user_repo->getCreatedBy($user);
                        }else{
                            $temp_data['created_by'] = "";
                        }
                        array_push($results, $temp_data);
                    }
                }
                break;
            case "Units":
                $product_units = $parent_main->product_units()->get()->sortBy('name');
                foreach ($product_units as $product_unit){
                    $user = $user_repo->findRecord($product_unit->created_by_user_id);
                    $temp_data['id'] = $product_unit->uuid;
                    $temp_data['name'] = $product_unit->name;
                    $temp_data['status'] = $product_unit->status;
                    $temp_data['slug'] = $product_unit->slug;
                    $temp_data['created_at'] = date('Y-m-d',strtotime($product_unit->created_at));
                    if ($user){
                        $temp_data['created_by'] = $user_repo->getCreatedBy($user);
                    }else{
                        $temp_data['created_by'] = "";
                    }
                    array_push($results, $temp_data);
                }
                break;
            case "Departments":
                $departments = PracticeDepartment::all()->where('practice_id',$practice->id)->sortByDesc('created_at');
                foreach ($departments as $department){
                    $deprt = Department::find($department->department_id);
                    $pract = Practice::find($department->practice_id);
                    $temp_data['id'] = $department->uuid;
                    $temp_data['name'] = $deprt->name;
                    $temp_data['branch'] = $pract->name;
                    $temp_data['status'] = $department->status;
                    $temp_data['description'] = $department->description;
                    array_push($results, $temp_data);
                }
                break;
            case "Accounts":
                $prodRepo = new ProductReposity(new Product());
                $practice_accounts = $practice->chart_accounts()->get()->sortByDesc('created_at');
                foreach ($practice_accounts as $practice_account){

                    $ac_type = array();
                    $ac_type_details = array();
                    $user = $user_repo->findRecord($practice_account->created_by_user_id);
                    $ac_type_obj = ProductAccountType::find($practice_account->account_type_id);
                    $ac_type['id'] = $ac_type_obj->uuid;
                    $ac_type['name'] = $ac_type_obj->name;
                    $ac_type_detail_obj = ProductAccountDetailType::find($practice_account->account_detail_type_id);
                    $ac_type_details['id'] = $ac_type_detail_obj->uuid;
                    $ac_type_details['name'] = $ac_type_detail_obj->name;
                    $temp_data['id'] = $practice_account->uuid;
                    $temp_data['name'] = $practice_account->name;
                    $temp_data['balance'] = $prodRepo->getBalance($practice_account);;
                    $temp_data['description'] = $practice_account->description;
                    $temp_data['account_type'] = $ac_type;
                    $temp_data['account_type_details'] = $ac_type_details;
                    $temp_data['created_at'] = date('Y-m-d',strtotime($practice_account->created_at));
                    if ($user){
                        $temp_data['created_by'] = $user_repo->getCreatedBy($user);
                    }else{
                        $temp_data['created_by'] = "";
                    }
                    array_push($results, $temp_data);

                }
                break;
            case "Account Nature":
                $account_nature = ProductAccountNature::all();
                foreach ($account_nature as $account_natur){
                    $temp_data['id'] = $account_natur->uuid;
                    $temp_data['name'] = $account_natur->name;
                    array_push($results, $temp_data);
                }
                break;
            case "Taxes":
                $taxes = $practice->sales_charge()->get();
                foreach ($taxes as $tax){
                    $temp_data['id'] = $tax->uuid;
                    $temp_data['name'] = $tax->name;
                    $temp_data['status'] = $tax->status;
                    $temp_data['amount'] = $tax->amount;
                    $temp_data['description'] = $tax->description;
                    $temp_data['agent_name'] = $tax->agent_name;
                    $temp_data['registration_number'] = $tax->registration_number;
                    $temp_data['start_period'] = $tax->start_period;
                    $temp_data['filling_frequency'] = $tax->filling_frequency;
                    $temp_data['reporting_method'] = $tax->reporting_method;
                    $temp_data['collected_on_sales'] = $tax->collected_on_sales;
                    $temp_data['sales_rate'] = $tax->sales_rate;
                    $temp_data['purchase_rate'] = $tax->purchase_rate;
                    $temp_data['collected_on_purchase'] = $tax->collected_on_purchase;
                    array_push($results, $temp_data);
                }
                break;
            case "Account Type":
                $account_types = ProductAccountType::all();
                foreach ($account_types as $account_type){
                    $temp_data['id'] = $account_type->uuid;
                    $temp_data['name'] = $account_type->name;
                    array_push($results, $temp_data);
                }
                break;
        }
        return $results;
    }

    //Product
    public function getProductType(Practice $practice)
    {
        // TODO: Implement getProductType() method.
        $results = array();
        $parentPractice = $this->findParent($practice);
        $product_types = $parentPractice->product_type()->get()->sortBy('name');
        foreach ($product_types as $product_type){
            $temp_data['id'] = $product_type->uuid;
            $temp_data['name'] = $product_type->name;
            $temp_data['description'] = $product_type->description;
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function setProductCategory(Practice $practice, array $array)
    {
        // TODO: Implement setProductCategory() method.
        $category = $practice->product_category()->get()->where('name',$array['name'])->first();
        if ($category){
            return false;
        }else{
            return $practice->product_category()->create($array);
        }
    }

    public function setBrand(Model $model, array $array)
    {
        // TODO: Implement setBrand() method.
        $pract = $model->product_brands()->get()->where('name',$array['name'])->first();
        if ( $pract ){
            return $pract;
        }
        return $model->product_brands()->create($array);
    }

    public function setProductType(Model $model, array $array){
        $pract = $model->product_type()->get()->where('name',$array['name'])->first();
        if ( $pract ){
            return $pract;
        }
        return $model->product_type()->create($array);
    }

    public function setCategory(Model $model, array $array){
        
        $pract = $model->product_category()->get()->where('name',$array['name'])->first();
        if ( $pract ){
            return $pract;
        }
        return $model->product_category()->create($array);
    }

    public function setProduct(Model $model, array $array){
        $product = $model->products()->get()->where('name',$array['name'])->first();
        if($product){
            return $product;
        }else{
            return $model->products()->create($array);
        }
    }

    //
    public function setTax(Model $model, array $array){
        $product = $model->sales_charge()->get()->where('name',$array['name'])->first();
        if($product){
            return $product;
        }else{
            return $model->sales_charge()->create($array);
        }
    }

    public function setGeneric(Model $model, array $array){
        if($array['name']){
            $pract = $model->generics()->get()->where('name',$array['name'])->first();
            if ( $pract ){
                return $pract;
            }
            return $model->generics()->create($array);
        }else{
            return null;
        }
    }

    public function setBrandSector(Model $model, array $array)
    {
        // TODO: Implement setBrandSector() method.
        $brandsect = $model->product_brand_sector()->get()->where('name',$array['name'])->first();
        if ($brandsect){
            return $brandsect;
        }else{
            return $model->product_brand_sector()->create($array);
        }
    }

    public function setUnits(Model $model, array $array)
    {
        // TODO: Implement setUnits() method.
        $brandsect = $model->product_units()->get()->where('name',$array['name'])->first();
        if ($brandsect){
            return $brandsect;
        }else{
            return $model->product_units()->create($array);
        }
    }

    public function setCurrency(Practice $practice, array $array)
    {
        // TODO: Implement setCurrency() method.
        $brandsect = $practice->product_currency()->get()->where('name',$array['name'])->first();
        if ($brandsect){
            return false;
        }else{
            return $practice->product_currency()->create($array);
        }
    }

    public function setProductRoute(Practice $practice, array $array){
        $brandsect = $practice->product_route()->get()->where('name',$array['name'])->first();
        if ($brandsect){
            return false;
        }else{
            return $practice->product_route()->create($array);
        }
    }

    public function setVendor(Model $model, array $array){
        return $model->suppliers()->create($array);
    }

    public function setChartAccount(Practice $practice, array $array)
    {
        // TODO: Implement setChartAccount() method.
        $check = ProductChartAccount::all()
            ->where('name',$array['name'])
            ->where('practice_id',$array['practice_id'])->first();
        if ($check){
            return false;
        }
        return $practice->chart_accounts()->create($array);
    }

    public function setAccountHolder(Practice $practice, array $array)
    {
        // TODO: Implement setAccountHolder() method.
        return $practice->practice_account_holder()->create($array);
    }

    public function setPaymentMethod(Practice $practice, array $array)
    {
        // TODO: Implement setPaymentMethod() method.
        return $practice->payment_methods()->create($array);
    }
    
    // public function deleteDepartment($uuid)
    // {
    //     // TODO: Implement deleteDepartment() method.
    //     return PracticeDepartment::all()->where('uuid',$uuid)->first()->delete();
    // }

    // public function setRole(array $arr)
    // {
    //     // TODO: Implement setRole() method.
    //     $role = $this->practice->all()->where('name',$arr['name'])->first();
    //     if ($role){
    //         return $role;
    //     }
    //     return $this->practice->create($arr);
    // }

    public function getRole($role_id)
    {
        // TODO: Implement getRole() method.
        $temp_datas = array();
        //$practice_roles = $practice->roles()->get()->sortBy('name');
        $practice_role = PracticeRole::find($role_id);
        $permissions = Permission::all()->sortBy('name');
        if($practice_role){

            $temp_datas['id'] = $practice_role->id;
            $temp_datas['name'] = $practice_role->name;
            $temp_datas['slug'] = $practice_role->slug;
            $temp_datas['description'] = $practice_role->description;
            $perms = array();
            foreach( $permissions as $permission ){
                if( $practice_role->hasPermission($permission->slug)  ){
                    $temp_data['slug'] = $permission->slug;
                    $temp_data['id'] = $permission->id;
                    $temp_data['name'] = $permission->name;
                    $temp_data['description'] = $permission->description;
                    array_push($perms,$temp_data);
                }
            }
            $temp_datas['permissions'] = $perms;

        }
        
        // foreach( $practice_roles as $practice_role ){
        //     $temp_datas['id'] = $practice_role->id;
        //     $temp_datas['name'] = $practice_role->name;
        //     $temp_datas['slug'] = $practice_role->slug;
        //     $temp_datas['description'] = $practice_role->description;
        //     $perms = array();
        //     foreach( $permissions as $permission ){
        //         if( $practice_role->hasPermission($permission->slug)  ){
        //             $temp_data['slug'] = $permission->slug;
        //             $temp_data['id'] = $permission->id;
        //             $temp_data['name'] = $permission->name;
        //             $temp_data['description'] = $permission->description;
        //             array_push($perms,$temp_data);
        //         }
        //     }
        //     $temp_datas['permissions'] = $perms;
        //     array_push($results,$temp_datas);
        // }
        return $temp_datas;
    }

    // public function getPracticeRoles(Practice $practice){
    //     $results = array();
    //     $practice_roles = $practice->roles()->get()->sortBy('name');
    //     $permissions = Permission::all()->sortBy('name');
    //     foreach( $practice_roles as $practice_role ){
    //         $temp_datas['id'] = $practice_role->id;
    //         $temp_datas['name'] = $practice_role->name;
    //         $temp_datas['slug'] = $practice_role->slug;
    //         $temp_datas['description'] = $practice_role->description;
    //         $perms = array();
    //         foreach( $permissions as $permission ){
    //             if( $practice_role->hasPermission($permission->slug)  ){
    //                 $temp_data['slug'] = $permission->slug;
    //                 $temp_data['id'] = $permission->id;
    //                 $temp_data['name'] = $permission->name;
    //                 $temp_data['description'] = $permission->description;
    //                 array_push($perms,$temp_data);
    //             }
    //         }
    //         $temp_datas['permissions'] = $perms;
    //         array_push($results,$temp_datas);
    //     }
    //     return $results;
    // }
    public function transform_role(PracticeRole $practiceRole, Practice $company){
        $permissions = Permission::all()->sortBy('name');
        $temp_datas['id'] = $practiceRole->id;
        $temp_datas['name'] = $practiceRole->name;
        $temp_datas['slug'] = $practiceRole->slug;
        $temp_datas['created_at'] = $this->helper->format_mysql_date($practiceRole->created_at,$company->date_format);
        $temp_datas['updated_at'] = $this->helper->format_mysql_date($practiceRole->updated_at,$company->date_format);
        $temp_datas['description'] = $practiceRole->description;
        $perms = array();
        foreach( $permissions as $permission ){
            if( $practiceRole->hasPermission($permission->slug)  ){
                $temp_data['slug'] = $permission->slug;
                $temp_data['id'] = $permission->id;
                $temp_data['name'] = $permission->name;
                $temp_data['description'] = $permission->description;
                array_push($perms,$temp_data);
            }
        }
        $temp_datas['permissions'] = $perms;
        return $temp_datas;
    }

    public function setUser(Practice $practice, array $arr)
    {
        // TODO: Implement setUser() method.

        $helper = new HelperFunctions();
        $msg = $helper->msg();
        if ( $practice->users()->where('mobile',$arr['mobile'])->get()->first() ){
            // $msg['status'] = false;
            // $msg['message'] = "Mobile number already in use";
            // return $msg;
        }
        if ( $practice->users()->where('email',$arr['email'])->get()->first() ){
            // $msg['status'] = false;
            // $msg['message'] = "Email address already in use";
            // return $msg;
        }
        //return $this->practice->create($arr);
        // $msg['status'] = true;
        // $msg['message'] = $practice->users()->create($arr);
        return $practice->users()->create($arr);
        
    }

    public function getUser(Practice $practice)
    {
        // TODO: Implement getUser() method.
    }

    public function setProductItem(array $arr)
    {
        // TODO: Implement setProductItem() method.
        return $this->practice->create($arr);
    }

    public function getProductItem(Practice $practice)
    {
        // TODO: Implement getProductItem() method.
        $results = array();

        $prodRepo = new ProductReposity(new Product());
        $geneRepo = new ProductReposity(new ProductGeneric());
        $manuRepo = new ProductReposity(new Manufacturer());
        $typeRepo = new ProductReposity(new ProductType());
        $cateRepo = new ProductReposity(new ProductCategory());
        $routeRepo = new ProductReposity(new ProductAdministrationRoute());
        $brandRepo = new ProductReposity(new ProductBrand());
        $unitRepo = new ProductReposity(new ProductUnit());
        $product_items = $practice->product_items()->get()->sortByDesc('created_at');
        foreach ($product_items as $product_item){
            $temp_data['id'] = $product_item->uuid;
            $temp_data['item_name'] = $prodRepo->getName($product_item->product_id);
            $temp_data['generic_name'] = $geneRepo->getName($product_item->generic_id);
            $temp_data['manufacturer'] = $manuRepo->getName($product_item->manufacturer_id);
            $temp_data['product_type'] = $typeRepo->getName($product_item->product_type_id);
            $temp_data['product_category'] = $cateRepo->getName($product_item->product_category_id);
            $temp_data['product_route'] = $routeRepo->getName($product_item->product_route_id);
            $temp_data['product_brand'] = $brandRepo->getName($product_item->product_brand_id);
            $temp_data['product_unit'] = $unitRepo->getName($product_item->product_unit_id);
            $temp_data['product_unit_slug'] = $unitRepo->getName($product_item->product_unit_id, 'slug');
            $temp_data['available_stock'] = $this->getStock($product_item);
            $temp_data['retail_price'] = $product_item->retail_price;
            $temp_data['tax_charges'] = 'Tax@0.50%';
            $temp_data['units_per_pack'] = $product_item->units_per_pack;
            $temp_data['alert_indicator_level'] = $product_item->alert_indicator_level;
            $temp_data['net_weight'] = $product_item->net_weight;
            $temp_data['item_code'] = $product_item->item_code;
            $temp_data['barcode'] = $product_item->barcode;
            $temp_data['item_note'] = $product_item->item_note;
            $temp_data['unit_storage_location'] = $product_item->unit_storage_location;
            $temp_data['single_unit_weight'] = $product_item->single_unit_weight;
            $temp_data['stocks'] = [];
            array_push($results, $temp_data);
        }
        return $results;
    }


}
