<?php

namespace App\Http\Controllers\Api\Doctor;

use App\helpers\HelperFunctions;
use App\Models\Doctor\Availability;
use App\Models\Users\User;
use App\Repositories\Doctor\AvailabilityRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AvailabilityController extends Controller
{
    protected $availability;
    protected $user;
    protected $helpers;
    protected $response_type;

    public function __construct(Availability $availability)
    {
        $this->availability = new AvailabilityRepository($availability);
        $this->user = new UserRepository(new User());
        $this->response_type = Config::get('response.http');
        $this->helpers = new HelperFunctions();
    }

    public function index(){

    }

    public function create(Request $request){

        $http_resp = $this->response_type['200'];

        $rule = [
            'week_day' => 'required',
            'opening_time' => 'required',
            'closing_time' => 'required',
        ];

        $validation = Validator::make($request->all(), $rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp, 422);
        }

        $user = $this->user->findRecord($request->user()->id);
        if ($this->availability->is_weekday_exist($user, $request->week_day)){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Week day already taken'];
            return response()->json($http_resp, 422);
        }

        if ( $this->helpers->compare_two_dates($request->opening_time, $request->closing_time) ){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Opening hours is greater than closing hour'];
            return response()->json($http_resp, 422);
        }

        $saved = $this->availability->store($user, $request->all());
        return response()->json($http_resp);

    }

    public function get_by_user(Request $request, $uuid){

        $http_resp = $this->response_type['200'];

        $user_id = $request->user()->id;

        $availabilities = $this->availability->getByUserId($user_id);

        $week_days = array();
        $data = array();

        $results = array();

        for ($ii = 0; $ii < 7; $ii++ ){
            $week_days[$ii] = $this->helpers->get_next_week_day(($ii + 1).' days');
        }

        $results['week_days'] = $week_days;


//        foreach ($availabilities as $availability){
//
//            for ($i = 0; $i < 7; $i++ ){
//
//                $wk_day = $this->helpers->get_next_week_day(($i + 1).' days');
//                $wk_date = $this->helpers->get_next_date(($i + 1).' days');
//                $temp_date['week_day'] = $wk_day;
//                $temp_date['week_date'] = $wk_date;
//                $temp_date['work_hours'] = $this->process_working_hours($availability->opening_time, $availability->closing_time, $wk_day, $user_id);
//                array_push($data, $temp_date);
//            }
//
//        }

        for ($i = 0; $i < 7; $i++ ){

            $wk_day = $this->helpers->get_next_week_day(($i).' days');
            $wk_date = $this->helpers->get_next_date(($i).' days');
            foreach ($availabilities as $availability){
                if ($availability->week_day == $wk_day){
                    $temp_date['week_day'] = $wk_day;
                    $temp_date['week_date'] = $wk_date;
                    $temp_date['work_hours'] = $this->process_working_hours($availability->opening_time, $availability->closing_time, $wk_day, $user_id);
                    array_push($data, $temp_date);
                }
            }

        }

        $results['data'] = $data;
        $results['date_ranges'] = $availabilities;

        $http_resp['results'] = $results;

        return response()->json($http_resp);

    }

    protected function process_working_hours($open_hr, $close_hr, $week_day, $user_id){

        $hours_array = [
            '07:00',
            '07:30',
            '08:00',
            '08:30',
            '09:00',
            '09:30',
            '10:00',
            '10:30',
            '11:00',
            '11:30',
            '12:00',
            '12:30',
            '13:00',
            '13:30',
            '14:00',
            '14:30',
            '15:00',
            '15:30',
            '16:00',
            '16:30',
            '17:00',
            '17:30',
            '18:00',
            '18:30',
            '19:00',
            '19:30',
            '20:00',
            '20:30',
            '21:00',
            '21:30',
            '22:00',
            '22:30',
            '23:00',
            '23:30',
        ];

        $work_hours = array();

        $day_availability = $this->availability->get_by_user_id_and_day($week_day,$user_id);

        if ($day_availability){

            for ( $i = 0; $i < sizeof($hours_array); $i++ ){
                if ( (strtotime($hours_array[$i]) >= strtotime($open_hr)) && (strtotime($hours_array[$i]) <= strtotime($close_hr)) ){
                    $work_hours_temp['w_hrs'] = $hours_array[$i];
                    $work_hours_temp['is_available'] = true;
                }else{
                    $work_hours_temp['w_hrs'] = $hours_array[$i];
                    $work_hours_temp['is_available'] = false;
                }
                array_push($work_hours,$work_hours_temp);
            }

        }else{

            for ( $i = 0; $i < sizeof($hours_array); $i++ ){
                $work_hours_temp['w_hrs'] = $hours_array[$i];
                $work_hours_temp['is_available'] = false;
                array_push($work_hours,$work_hours_temp);
            }

        }

        return $work_hours;

    }

}
