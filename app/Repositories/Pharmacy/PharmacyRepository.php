<?php


namespace App\Repositories\Pharmacy;


use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Practice;
use App\Models\Users\User;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PharmacyRepository implements PharmacyRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->model->find($id);
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->model->all()->where('uuid',$uuid)->first();
    }

    public function findByUserId($user_id)
    {
        // TODO: Implement findByUserId() method.
        return $this->model->all()->where('user_id',$user_id)->first();
    }


    public function store(array $arr)
    {
        // TODO: Implement store() method.
        return $this->model->create($arr);
    }

    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
    }

    public function destroy($uuid)
    {
        // TODO: Implement destroy() method.
    }

    public function transform(Pharmacy $pharmacy)
    {
        // TODO: Implement transform() method.
        $practRepo = new PracticeRepository(new Practice());
        $userRepo = new UserRepository(new User());
        $main_practice_store = $pharmacy->practices()->get()->where('category','Main')->first();
        //Log::info($main_practice_store);
        $user = $pharmacy->user()->get()->first();
        return [
            'practice_id' => $main_practice_store->uuid,
            'practice_email' => $main_practice_store->email,
            'practice_address' => $main_practice_store->address,
            'practice_name' => $main_practice_store->name,
            'practice_logo' => $this->getAvatar($pharmacy),
            'practice_mobile' => $main_practice_store->mobile,
            'practice_category' => $main_practice_store->category,
            'approval_status' => $main_practice_store->approval_status,
            'permissions' => $userRepo->getPermissions($user),
        ];
    }

    public function getPractices(Pharmacy $pharmacy)
    {
        // TODO: Implement getPractices() method.
        return $pharmacy->practices()->get()->sortByDesc('created_at')->where('category','Branch');
    }

    public function getAvatar(Pharmacy $pharmacy)
    {
        // TODO: Implement getAvatar() method.
        if ($pharmacy->logo == null || $pharmacy->logo == ""){
            return Pharmacy::DEFAULT_AVATAR;
        }else{
            return $pharmacy->logo;
        }
    }


}