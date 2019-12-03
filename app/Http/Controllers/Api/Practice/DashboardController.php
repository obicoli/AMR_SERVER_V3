<?php

namespace App\Http\Controllers\Api\Practice;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Settings\DashboardSetting;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\helpers\HelperFunctions;


class DashboardController extends Controller
{
    protected $response_type;
    protected $helper;
    protected $practices;

    public function __construct(){
        $this->helper = new HelperFunctions();
        $this->response_type = Config::get('response.http');
        $this->practices = new PracticeRepository( new Practice() );
        //$this->customers = new CustomerRepository( new Customer() );
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $user = $request->user();
        $results = array();
        $company = $this->practices->find($user->company_id);
        if( $request->has('report_type') ){
            $report_type = $request->report_type;
            switch ($report_type) {
                case 'value':
                    # code...
                    break;
                default:
                    $widgets = DashboardSetting::all()->sortBy('type')->groupBy('type');
                    // $widgets = $company->dashboard_widgets()->groupBy('type')->get();
                    foreach ($widgets as $index => $widget){
                        //Log::info($index);
                        $temp_data['type'] = $index;
                        $looped_data = array();
                        foreach($widget as $widge){
                            $company_widget = DB::connection(Module::MYSQL_DB_CONN)
                                ->table('company_widgets')
                                ->where('practice_id',$company->id)
                                ->where('widget_id',$widge->id)
                                ->get()->first();
                                $temp_d['id'] = $company_widget->id;
                                $temp_d['name'] = $widge->name;
                                $temp_d['type'] = $widge->type;
                                $temp_d['display'] = $widge->display;
                                $temp_d['description'] = $widge->description;
                                $temp_d['status'] = $company_widget->status;
                                array_push($looped_data,$temp_d);
                        }
                        $temp_data['type'] = $index;
                        $temp_data['data'] = $looped_data;
                        array_push($results,$temp_data);
                    }
                    break;
            }
        }else{
            $widgets = DashboardSetting::all()->groupBy('type');
            // $widgets = $company->dashboard_widgets()->groupBy('type')->get();//->sortBy('type')
            foreach ($widgets as $index => $widget){
                //Log::info($index);
                $temp_data['type'] = $index;
                $looped_data = array();
                foreach($widget as $widge){
                    $company_widget = DB::connection(Module::MYSQL_DB_CONN)
                        ->table('company_widgets')
                        ->where('practice_id',$company->id)
                        ->where('widget_id',$widge->id)
                        ->get()->first();
                        $temp_d['id'] = $company_widget->id;
                        $temp_d['name'] = $widge->name;
                        $temp_d['type'] = $widge->type;
                        $temp_d['display'] = $widge->display;
                        $temp_d['description'] = $widge->description;
                        $temp_d['status'] = $company_widget->status;
                        array_push($looped_data,$temp_d);
                }
                $temp_data['type'] = $index;
                $temp_data['data'] = $looped_data;
                array_push($results,$temp_data);
            }
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

    public function create(Request $request){

        $http_resp = $this->response_type['200'];
        Log::info($request);
        $rules = [
            //'widgets'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $widgets = $request->widgets;
        if ( !is_array($widgets) ){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Widgets must be an array!'];
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            $user = $request->user();
            $company = $this->practices->find($user->company_id);
            $inputs = ['status'=>0];
            $company_widget = DB::connection(Module::MYSQL_DB_CONN)
                ->table('company_widgets')->where('practice_id',$company->id)
                ->update($inputs);

            $company_widgets = DB::connection(Module::MYSQL_DB_CONN)
                ->table('company_widgets')->where('practice_id',$company->id)
                ->get();

            for ( $i=0; $i < \sizeof($widgets); $i++ ) { 
                
                foreach ($company_widgets as $company_widget) {
                    
                    if( $company_widget->id == $widgets[$i] ){

                        $company_widget = DB::connection(Module::MYSQL_DB_CONN)
                        ->table('company_widgets')->where('id',$company_widget->id)
                        ->update(['status'=>true]);

                    }

                }

            }

        }catch(\Exception $e){
            Log::info($e);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);

    }

    public function update(Request $request, $id){

        $http_resp = $this->response_type['200'];
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            $inputs = ['status'=>$request->status];
            $company_widget = DB::connection(Module::MYSQL_DB_CONN)
                ->table('company_widgets')->where('id',$id)
                ->update($inputs);

        }catch(\Exception $e){
            Log::info($e);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

}
