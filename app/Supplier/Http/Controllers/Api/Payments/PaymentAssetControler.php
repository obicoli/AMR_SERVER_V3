<?php

namespace App\Supplier\Http\Controllers\Api\Payments;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankTransaction;
use App\Finance\Repositories\FinanceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supplier\Models\SupplierPayment;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Supplier\Models\Supplier;
use App\Supplier\Models\SupplierBill;
use App\Supplier\Repositories\SupplierRepository;
use App\Accounting\Repositories\AccountingRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Practice\PracticeUser;
use App\Supplier\Models\SupplierAsset;
use App\Models\Product\Product;

class PaymentAssetControler extends Controller
{
    protected $supplierPayment;
    protected $supplierAsset;
    protected $http_response;
    protected $practices;
    protected $helper;
    // protected $bills;
    // protected $suppliers;
    // protected $bankAccounts;
    // protected $chartAccounts;
    protected $company_users;
    // protected $bankTransactions;
    // protected $accountDoubleEntries;

    public function __construct(SupplierAsset $supplierAsset){
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->supplierAsset = new SupplierRepository($supplierAsset);
        $this->supplierPayment = new SupplierRepository( new SupplierPayment() );
        // $this->suppliers = new SupplierRepository( new Supplier() );
        // $this->bankAccounts = new FinanceRepository( new AccountsBank() );
        // $this->chartAccounts = new FinanceRepository( new AccountChartAccount() );
        $this->company_users = new PracticeRepository(new PracticeUser());
        // $this->bankTransactions = new FinanceRepository( new BankTransaction() );
        // $this->accountDoubleEntries = new AccountingRepository( new AccountsVoucher() );
    }

    public function create( Request $request ){
        Log::info($request);
        $http_resp = $this->http_response['200'];
        $rule = [
            'attachable_id'=>'required',
            'file'=>'required|file|max:2000',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        try{
            $company = $this->practices->find($request->user()->company_id);
            $practiceParent = $this->practices->findParent($company);
            $company_user = $this->company_users->find($request->user()->company_id); //Get current user
            $payment = $this->supplierPayment->findByUuid($request->attachable_id);
            $doc_tmp_name = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];

            $doc_type = Product::DOC_SUPPLIER_PAYMENT;
            $root_directory_array = $this->helper->create_upload_directory($company->uuid,$doc_type,$payment->trans_number);
            $newFilePath = $root_directory_array['file_server_root'].'/'.$_FILES['file']['name'];
            $file_path = $root_directory_array['file_public_access'].'/'.$_FILES['file']['name'];
            if( $this->helper->is_file_exist($newFilePath) ){
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['File already exists!'];
                return response()->json($http_resp,422);
            }elseif(move_uploaded_file($doc_tmp_name, $newFilePath)){
                $inputs['file_name'] = $file_name;
                $inputs['file_path'] = $file_path;
                $inputs['file_mime'] = $file_type;
                $inputs['file_size'] = round(($file_size/1000000),2).'MB';
                $asset = $payment->assets()->create($inputs);
                $status['status'] = Product::STATUS_ATTACHED;
                $status['notes'] = "File attached to ".$doc_type;
                $status['type'] = "action";
                $po_status = $company_user->payment_status()->create($status);
                $po_status = $payment->payment_status()->save($po_status);
            }
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function delete($uuid){
        $http_resp = $this->http_response['200'];
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        try{
            $asset = $this->supplierAsset->findByUuid($uuid);
            Log::info($asset->file_path);
            if( $this->helper->delete_file($_SERVER['DOCUMENT_ROOT'].''.$asset->file_path) ){
                $asset->forceDelete();
                $http_resp['description'] = "File successful deleted!";
            }else{
                $http_resp = $this->http_response['422'];
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                $http_resp['errors'] = ['Unable to locate the file'];
                return response()->json($http_resp,422);
            }
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        return response()->json($http_resp);
    }
}
