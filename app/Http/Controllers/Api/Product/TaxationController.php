<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\Product\ProductTaxation;
use Illuminate\Http\Request;
use App\helpers\HelperFunctions;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use Illuminate\Support\Facades\Config;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use App\Models\Practice\Practice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TaxationController extends Controller
{

    protected $productTaxation;
    protected $practices;
    protected $helper;

    public function __construct(ProductTaxation $productTaxation)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productTaxation = new ProductReposity($productTaxation);
        $this->practices = new PracticeRepository(new Practice());
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $companyParent = $this->practices->findParent($company);
        
        if($request->has('input_tax')){
            $taxes = $companyParent->product_taxations()
                ->where('collected_on_purchase',true)
                ->orderByDesc('created_at')
                ->paginate(20);
        }elseif($request->has('output_tax')){
            $taxes = $companyParent->product_taxations()
                ->where('collected_on_sales',true)
                ->orderByDesc('created_at')
                ->paginate(20);
        }else{
            $taxes = $companyParent->product_taxations()->orderByDesc('created_at')->paginate(20);
        }

        $paged_data = $this->helper->paginator($taxes);
        foreach($taxes as $taxe){
            $temp_data['id'] = $taxe->uuid;
            $temp_data['collected_on_purchase'] = $taxe->collected_on_purchase;
            $temp_data['collected_on_sales'] = $taxe->collected_on_sales;
            $temp_data['agent_name'] = $taxe->agent_name;
            $temp_data['name'] = $taxe->name;
            $temp_data['registration_number'] = $taxe->registration_number;
            $temp_data['description'] = $taxe->description;
            $temp_data['start_period'] = $taxe->start_period;
            $temp_data['filling_frequency'] = $taxe->filling_frequency;
            $temp_data['reporting_method'] = $taxe->reporting_method;
            $temp_data['purchase_rate'] = $taxe->purchase_rate;
            $temp_data['sales_rate'] = $taxe->sales_rate;
            $temp_data['amount'] = $taxe->amount;
            $temp_data['status'] = $taxe->status;
            $temp_data['display_as'] = $taxe->name.' '.$taxe->category.'('.number_format($taxe->sales_rate,1).'%)';
            array_push($results,$temp_data);
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];
        $rule1 = [
            'collected_on_purchase' => 'required',
            'collected_on_sales' => 'required',
            'agent_name' => 'required',
            'name' => 'required',
            'registration_number' => 'required',
            'description' => 'required',
            'start_period' => 'required',
            'filling_frequency' => 'required',
            'reporting_method' => 'required',
            'purchase_rate' => 'required',
            'sales_rate' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ];
        $validation = Validator::make($request->all(),$rule1, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        
        $company = $this->practices->find($request->user()->company_id);
        $companyParent = $this->practices->findParent($company);

        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            $tax = $companyParent->product_taxations()->create($request->all());
            $http_resp['description'] = "Tax successful created!";
        }catch(\Exception $e){
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            Log::info($e);
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){
        $http_resp = $this->http_response['200'];
        $rule1 = [
            'collected_on_purchase' => 'required',
            'collected_on_sales' => 'required',
            'agent_name' => 'required',
            'name' => 'required',
            'registration_number' => 'required',
            'description' => 'required',
            'start_period' => 'required',
            'filling_frequency' => 'required',
            'reporting_method' => 'required',
            'purchase_rate' => 'required',
            'sales_rate' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ];
        $validation = Validator::make($request->all(),$rule1, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        
        $company = $this->practices->find($request->user()->company_id);
        $companyParent = $this->practices->findParent($company);

        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            //$tax = $companyParent->product_taxations()->create($request->all());
            $tax = $this->productTaxation->findByUuid($uuid);
            $this->productTaxation->update($request->all(),$tax->id);
            $http_resp['description'] = "Tax successful updated!";
            
        }catch(\Exception $e){
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            Log::info($e);
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function show($uuid){}

    public function destroy($uuid){

        $http_resp = $this->http_response['200'];
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        try{
            $tax = $this->productTaxation->findByUuid($uuid);
            $tax->delete();
        }catch(\Exception $e){
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            Log::info($e);
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        return response()->json($http_resp);

    }
}
