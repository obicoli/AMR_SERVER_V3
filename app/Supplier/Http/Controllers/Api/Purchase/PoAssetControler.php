<?php

namespace App\Supplier\Http\Controllers\Api\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Product;
use App\Repositories\Product\ProductReposity;
use App\Supplier\Models\PurchaseOrder;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Supplier\Models\SupplierAsset;

class PoAssetControler extends Controller
{
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $supplierAsset;
    protected $purchaseOrders;
    protected $company_users;

    public function __construct( SupplierAsset $supplierAsset )
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->supplierAsset = new SupplierRepository( $supplierAsset );
        $this->purchaseOrders = new ProductReposity( new PurchaseOrder() );
        $this->company_users = new PracticeRepository(new PracticeUser());
    }

    public function create( Request $request ){

        //Log::info($request);
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
            //$supplier = $this->suppliers->findByUuid($request->supplier_id);
            $company_user = $this->company_users->find($request->user()->company_id); //Get current user
            $purchase_order = $this->purchaseOrders->findByUuid($request->attachable_id);

            $doc_tmp_name = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];

            $doc_type = Product::DOC_PO;
            $root_directory_array = $this->helper->create_upload_directory($company->uuid,$doc_type,$purchase_order->trans_number);
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
                $asset = $purchase_order->assets()->create($inputs);
                $status['status'] = Product::STATUS_ATTACHED;
                $status['notes'] = "File attached to ".$doc_type;
                $status['type'] = "action";
                $po_status = $company_user->po_status()->create($status);
                $po_status = $purchase_order->po_status()->save($po_status);
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
