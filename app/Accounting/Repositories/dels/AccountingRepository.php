<?php

namespace App\Accounting\Repositories;

use App\Accounting\Models\Banks\AccountMasterBank;
use App\Accounting\Models\Banks\AccountMasterBankBranch;
use App\Accounting\Models\Banks\AccountsBank;
use Illuminate\Database\Eloquent\Model;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\COA\AccountsNature;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Models\Practice\Practice;
use App\Supplier\Models\Supplier;

class AccountingRepository implements AccountingRepositoryInterface
{
    protected $model;
    protected $helpers;
    protected $customerRepository;
    //protected $supplierRepository;

    public function __construct( Model $model )
    {
        $this->model = $model;
        $this->helpers = new HelperFunctions();
        //$this->customerRepository = new CustomerRepository(new Customer());
        //$this->supplierRepository = new SupplierRepository( new Supplier() );
    }

    public function all(){
        return $this->model->all()->sortBy('name');
    }
    public function find($id){
        return $this->model->find($id);
    }
    public function findByUuid($uuid){
        return $this->model->all()->where('uuid',$uuid)->first();
    }
    public function findByCode($code){
        return $this->model->all()->where('code',$code)->first();
    }
    public function findByName($name){
        return $this->model->all()->where('name',$name)->first();
    }
    public function findByDefaultCode($code){
        return $this->model->all()->where('default_code',$code)->first();
    }
    public function create($inputs = []){
        return $this->model->create($inputs);
    }
}