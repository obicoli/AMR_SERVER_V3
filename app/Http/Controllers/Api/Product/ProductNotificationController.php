<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\ProductOrderCategory;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailbox;
use App\Models\NotificationCenter\Inventory\NotificationInventorySms;
use App\Models\NotificationCenter\MailBox;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductNotificationController extends Controller
{

    protected $notificationInventoryMailbox;
    protected $http_response;
    protected $helper;
    protected $practice;
    protected $productItems;

    public function __construct(NotificationInventoryMailbox $notificationInventoryMailbox)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->notificationInventoryMailbox = new ProductReposity($notificationInventoryMailbox);
        $this->practice = new PracticeRepository(new Practice());
        $this->productItems = new ProductReposity(new PracticeProductItem());
    }

    public function index($practice_uuid, $type){
        $http_resp = $this->http_response['200'];
        //product_email_notifications
        $results = array();
        $practice = $this->practice->findByUuid($practice_uuid);
        $practiceParent = $this->practice->findParent($practice);
        switch($type){
            case "emails":
                $mailboxes = $practice->product_email_notifications()->orderByDesc('created_at')->paginate(15);
                $paged_data = $this->helper->paginator($mailboxes);
                foreach($mailboxes as $mailboxe){
                    array_push($results,$this->transform_mails($mailboxe));
                }
                $paged_data['data'] = $results;
                $http_resp['results'] = $paged_data;
                break;
            case "sms":
                $mailboxes = $practice->product_sms_notifications()->orderByDesc('created_at')->paginate(15);
                $paged_data = $this->helper->paginator($mailboxes);
                foreach($mailboxes as $mailboxe){
                    array_push($results,$this->transform_mails($mailboxe,"SMS"));
                }
                $paged_data['data'] = $results;
                $http_resp['results'] = $paged_data;
                break;
            case "alerts":
                $mailboxes = $practice->product_notifications()->orderByDesc('created_at')->paginate(15);
                $paged_data = $this->helper->paginator($mailboxes);
                foreach($mailboxes as $mailboxe){
                    array_push($results,$this->transform_mails($mailboxe,"alerts"));
                }
                $paged_data['data'] = $results;
                $http_resp['results'] = $paged_data;
                break;
        }
        return response()->json($http_resp);
    }

    public function create(Request $request){
        $http_resp = $this->http_response['200'];

        $rule1 = [
            'products' => 'required',
            'stores' => 'required',
            'frequency' => 'required',
            'name' => 'required',
            'email_enabled' => 'required',
            'sms_enabled' => 'required',
            'practice_id' => 'required',
            // 'email' => 'required',
            // 'mobile' => 'required',
        ];

        $validation = Validator::make($request->all(),$rule1, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{
            $practice = $this->practice->findByUuid($request->practice_id);
            $parent_practice = $this->practice->findParent($practice);
            $alert_notification = $practice->product_notifications()->create($request->all());
            $http_resp['description'] = "Successful saved!";
        }catch(\Exception $e){
            DB::rollBack();
            $http_resp = $this->http_response['500'];
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function transform_mails(Model $model,$type_=null){
        if($type_){
            switch($type_){
                case "SMS":
                    $result = [
                        'id' => $model->uuid,
                        'mobile' => $model->mobile,
                        'date_sent' => $this->helper->format_mysql_date($model->created_at),
                        'message' => $model->message,
                        'status' => $model->status
                    ];
                break;
                case "alerts":
                    $result = [
                        'id' => $model->uuid,
                        'name' => $model->name,
                        'email' => $model->email,
                        'mobile' => $model->mobile,
                        'date_sent' => $this->helper->format_mysql_date($model->created_at),
                        'message' => $model->message,
                        'status' => $model->status,
                        'frequency' => '',
                    ];
                break;
            }
            
        }else{
            $result = [
                'id' => $model->uuid,
                'recipient' => $model->email,
                'date_sent' => $this->helper->format_mysql_date($model->created_at),
                'subject' => $model->subject,
                'message' => $model->msg,
                'status' => $model->status,
                'attachments' => $this->transform_attachments($model->attatchments()->get())
            ];
        }
        return $result;
    }

    public function transform_attachments($collections){
        $results = array();
        foreach($collections as $collection){
            $temp_data['id'] = $collection->uuid;
            $temp_data['type'] = $collection->attachment_type;
            switch($collection->attachment_type){
                case MailBox::PO_SUBJECT:
                    $place_order = $collection->attachable()->get()->first();
                    $temp_po = $this->helper->format_purchase_order($place_order);
                    $temp_po['attachment_type'] = $collection->attachment_type;
                    array_push($results,$temp_po);
                break;
                case MailBox::GRN_SUBJECT:
                    $grn_note = $collection->attachable()->get()->first();
                    $temp_po = $this->helper->transform_goods_received_note($grn_note);
                    $temp_po['attachment_type'] = $collection->attachment_type;
                    array_push($results,$temp_po);
                break;
            }
        }
        return $results;
    }
    
}
