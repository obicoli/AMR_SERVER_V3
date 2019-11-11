<?php

namespace App\Http\Controllers\Websocket;

use App\helpers\HelperFunctions;
use App\Models\His\Rtc\HisRtcUserTrack;
use App\Models\Product\Inventory\ProductRequistion;
use App\Models\Practice\Department;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Store\ProductStore;
use App\Repositories\His\HisRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class HisSocketController implements MessageComponentInterface 
{
    protected $clients;
    private $subscriptions;
    private $users;
    private $userresources;
    //database integration
    protected $practice;
    protected $stores;
    protected $departments;
    protected $subStores;
    protected $practiceUser;
    protected $hisRtcUserTracks;
    protected $helper;
    //Product
    protected $productRequisitions;
    protected $productItems;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
        $this->users = [];
        $this->userresources = [];
        //database
        $this->practice = new PracticeRepository( new Practice() );
        $this->practiceUser = new PracticeRepository( new PracticeUser() );
        $this->stores = new ProductReposity( new ProductStore() );
        $this->departments = new PracticeRepository( new Department() );
        $this->subStores = new ProductReposity( new ProductStore() );
        $this->hisRtcUserTracks = new HisRepository( new HisRtcUserTrack() );
        //Product
        $this->productRequisitions = new ProductReposity( new ProductRequistion() );
        $this->productItems = new ProductReposity( new PracticeProductItem() );
        $this->helper = new HelperFunctions();
    }

        /**
     * [onOpen description]
     * @method onOpen
     * @param  ConnectionInterface $conn [description]
     * @return [JSON]                    [description]
     * @example connection               var conn = new WebSocket('ws://localhost:8090');
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $this->users[$conn->resourceId] = $conn;
        echo "New connection! ({$conn->resourceId})".PHP_EOL;
        //$this->debug("New anonim connection! ({$conn->resourceId}) in room ({$conn->resourceId})");
    }
    /**
     * [onMessage description]
     * @method onMessage
     * @param  ConnectionInterface $conn [description]
     * @param  [JSON.stringify]              $msg  [description]
     * @return [JSON]                    [description]
     * @example subscribe                conn.send(JSON.stringify({command: "subscribe", channel: "global"}));
     * @example groupchat                conn.send(JSON.stringify({command: "groupchat", message: "hello glob", channel: "global"}));
     * @example message                  conn.send(JSON.stringify({command: "message", to: "1", from: "9", message: "it needs xss protection"}));
     * @example register                 conn.send(JSON.stringify({command: "register", userId: 9}));
     */
    public function onMessage(ConnectionInterface $conn, $msg){

        echo "----------New Incoming Message from Client(".$conn->resourceId.")----------".PHP_EOL;
        $data = json_decode($msg);
        //Log::info($msg);
        echo "--->TYPE: ".$data->type.PHP_EOL;
        $service_ = $this->onDataRead($data,HisRtcUserTrack::RTC_SERVICE); //$data->text->service_data->service_type;
        $service_action = $this->onDataRead($data,HisRtcUserTrack::RTC_SERVICE_ACTION);//$data->text->service_data->service_action;
        echo "--->SERVICE: ".$service_.PHP_EOL;
        echo "--->ACTION: ".$service_action.PHP_EOL;
        echo "--->DESCRIPTION: ".$data->text->service_data->service_type." ".$data->text->service_data->service_action.PHP_EOL;
        //practice user id
        $p_user_id = $data->text->staff_address->staff_id;
        $practice_user = $this->practiceUser->findByUuid($p_user_id);
        $role = $data->text->staff_address->role;
        //Practice uuid
        $prac_uuid = $data->text->staff_address->facility_id;
        $practice = $this->practice->findByUuid($prac_uuid);
        $practiceParent = $this->practice->findParent($practice);
        $practiceMain = $this->practice->findOwner($practice);
        //Store uuid
        $store_uuid = $data->text->staff_address->store_id;
        $store = $this->stores->findByUuid($store_uuid);
        //sub store uuid
        $sub_store_uuid = $data->text->staff_address->sub_store_id;
        $substore = $this->stores->findByUuid($sub_store_uuid);
        //Department uuid
        $department_uuid = $data->text->staff_address->department_id;
        $department = $this->departments->findByUuid($department_uuid);
        echo "----------------------------------------------".PHP_EOL;
        echo "BRANCH: ".$practice->name.PHP_EOL;
        echo "STORE: ".$store->name.PHP_EOL;
        echo "DEPARTMENT: ".$department->name.PHP_EOL;
        echo "SUBSTORE: ".$substore->name.PHP_EOL;
        echo "STAFF: ".$practice_user->first_name." ".$practice_user->other_name."(".$role.")".PHP_EOL;
        echo "----------------------------------------------".PHP_EOL;

        if (isset($data->type)){
            switch($data->type){
                case "login": //client send his login request
                    $inputs['service_action'] = $service_;
                    $inputs['service_type'] = $service_action;
                    $inputs['first_name'] = $practice_user->first_name;
                    $inputs['last_name'] = $practice_user->other_name;
                    $inputs['resource_id'] = $conn->resourceId;
                    $his_user_track = $this->hisRtcUserTracks->getOrCreate($practiceParent,$practice,$store,$department,$substore,$practice_user,$inputs);
                    $data->type = "success_auth";
                    switch($service_){
                        case "Requisition": //Service level
                            $data = $this->onRequisitions($conn,$practiceParent,$practice,$store,$department,$substore,$practice_user,$data);
                            break;
                    }
                    $this->sendToClient($conn, $data);
                    break; //Logins Ends here
                case "inventory": //Inventory Activities
                    switch($service_){
                        case "Requisition"://
                            $data = $this->onRequisitions($conn,$practiceParent,$practice,$store,$department,$substore,$practice_user,$data);
                            break;
                    }
                    break;
            }
        }

    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn){
        $disconnectedId = $conn->resourceId;
        unset($this->connections[$disconnectedId]);
        foreach($this->connections as &$connection)
            $connection['conn']->send(json_encode([
                'offline_user' => $disconnectedId,
                'from_user_id' => 'server control',
                'from_resource_id' => null
            ]));
    }
    
     /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e){
        // $userId = $this->connections[$conn->resourceId]['user_id'];
        // echo "An error has occurred with user $userId: {$e->getMessage()}\n";
        // unset($this->connections[$conn->resourceId]);
        // $conn->close();
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    protected function onRequisitions(ConnectionInterface $conn, Model $parent=null, Practice $practice=null,ProductStore $store=null,Department $department=null,ProductStore $substore=null,PracticeUser $practiceUser, $data){
        //action requested
        $action = $this->onDataRead($data,HisRtcUserTrack::RTC_SERVICE_ACTION);
        switch($action){
            case "Listing"://
                $data->results = $this->onRequisitionList($practice);
                break;
            case "Create":
                echo "-----Extracting requisition destination...".PHP_EOL;
                $posted_data = $this->onDataRead($data,HisRtcUserTrack::RTC_SERVICE_POSTED_DATA);
                //$posted_by = $this->onDataRead($data,HisRtcUserTrack::RTC_SERVICE_POSTED_BY);
                //get destination branch
                $dest_branch = $this->practice->findByUuid($posted_data->branch_id);
                $dest_store = $this->stores->findByUuid($posted_data->store_id);
                $dest_department = $this->departments->findByUuid($posted_data->department_id);
                $dest_sub_store = $this->stores->findByUuid($posted_data->sub_store_id);
                echo "-----Saving requisition...".PHP_EOL;
                DB::beginTransaction();

                //=================================================
                $temp_inputs['note'] = $posted_data->note;
                $temp_inputs['user_id'] = $practiceUser->user_id;
                //create requistion
                $requistion = $parent->product_requisitions()->create($temp_inputs); //Enterprise
                $requistion = $practice->product_requisitions_src()->save($requistion); //Facility Requistion From
                $requistion = $dest_branch->product_requisitions_dest()->save($requistion); //Facility Requistion To
                $requistion = $department->product_requisitions_src()->save($requistion);//Department From
                $requistion = $dest_department->product_requisitions_dest()->save($requistion);//Department To
                $requistion = $store->product_requisition_src()->save($requistion); //Store from
                $requistion = $dest_store->product_requisition_dest()->save($requistion);//Store To
                $requistion = $practiceUser->product_requisitions()->save($requistion);//who requested
                if($substore){
                    $requistion = $substore->product_requisition_substore_src()->save($requistion);//Sub Store From
                }
                if($dest_sub_store){
                    $requistion = $dest_sub_store->product_requisition_substore_dest()->save($requistion);//Sub Store To
                }
                //Create Status into Reqquisition Movement Status
                $temp_inputs['status'] = "Pending";
                $temp_inputs['note'] = "Initial status when request is placed";
                $requistion_status = $requistion->product_requisition_movements()->create($temp_inputs);
                //Create Requistion Items
                $items = $posted_data->items;
                for( $i=0; $i < sizeof($items); $i++ ){
                    $temp_inputs['amount'] = $items[$i]->qty;
                    $product_item = $this->productItems->findByUuid($items[$i]->id);
                    $product_price = $product_item->price_record()->where('status',true)->get()->last();
                    $requistion_item = $requistion->product_requisition_items()->create($temp_inputs);//new item
                    $requistion_item = $product_item->product_requisitions()->save($requistion_item);//product item
                    $requistion_item = $product_price->product_requisition_items()->save($requistion_item); //prices item
                }
                echo "-----DB Commit...".PHP_EOL;
                DB::commit();
                echo "----------Saving completed successful...".PHP_EOL;
                echo "-----Searching for destination online status...".PHP_EOL;
                $target_party = $this->onTarget($conn,$parent,$dest_branch,$dest_store,$dest_department,$dest_sub_store);
                if( $target_party ){
                    //Target found Online
                    echo "----------Destination is online...".PHP_EOL;
                    echo "-----Sending destination alert...".PHP_EOL;
                    $this->sendToParty($conn,$target_party->re,$data);
                    echo "----------Alert Send...".PHP_EOL;
                }else{
                    echo "----------Destination is offline...".PHP_EOL;
                }
                //===================================================
                try{
                    // $temp_inputs['note'] = $posted_data->note;
                    // $temp_inputs['user_id'] = $practiceUser->user_id;
                    // //create requistion
                    // $requistion = $parent->product_requisitions()->create($temp_inputs); //Enterprise
                    // $requistion = $practice->product_requisitions_src()->save($requistion); //Facility Requistion From
                    // $requistion = $dest_branch->product_requisitions_dest()->save($requistion); //Facility Requistion To
                    // $requistion = $department->product_requisitions_src()->save($requistion);//Department From
                    // $requistion = $dest_department->product_requisitions_dest()->save($requistion);//Department To
                    // $requistion = $store->product_requisition_src()->save($requistion); //Store from
                    // $requistion = $dest_store->product_requisition_dest()->save($requistion);//Store To
                    // $requistion = $practiceUser->product_requisitions()->save($requistion);//who requested
                    // if($substore){
                    //     $requistion = $substore->product_requisition_substore_src()->save($requistion);//Sub Store From
                    // }
                    // if($dest_sub_store){
                    //     $requistion = $dest_sub_store->product_requisition_substore_dest()->save($requistion);//Sub Store To
                    // }
                    // //Create Status into Reqquisition Movement Status
                    // $temp_inputs['status'] = "Pending";
                    // $temp_inputs['note'] = "Initial status when request is placed";
                    // $requistion_status = $requistion->product_requisition_movements()->create($temp_inputs);
                    // //Create Requistion Items
                    // $items = $posted_data->items;
                    // for( $i=0; $i < sizeof($items); $i++ ){
                    //     $temp_inputs['amount'] = $items[$i]->qty;
                    //     $product_item = $this->productItems->findByUuid($items[$i]->id);
                    //     $product_price = $product_item->price_record()->where('status',true)->get()->last();
                    //     $requistion_item = $requistion->product_requisition_items()->create($temp_inputs);//new item
                    //     $requistion_item = $product_item->product_requisitions()->save($requistion_item);//product item
                    //     $requistion_item = $product_price->product_requisition_items()->save($requistion_item); //prices item
                    // }
                    // echo "-----DB Commit...".PHP_EOL;
                    // DB::commit();
                    // echo "----------Saving completed successful...".PHP_EOL;
                    // echo "-----Searching for destination online status...".PHP_EOL;
                    // $target_party = $this->onTarget($conn,$parent,$dest_branch,$dest_store,$dest_department,$dest_sub_store);
                    // if( $target_party ){
                    //     //Target found Online
                    //     echo "----------Destination is online...".PHP_EOL;
                    //     echo "-----Sending destination alert...".PHP_EOL;
                    //     $this->sendToParty($conn,$target_party->re,$data);
                    //     echo "----------Alert Send...".PHP_EOL;
                    // }else{
                    //     echo "----------Destination is offline...".PHP_EOL;
                    // }
                }catch(\Exception $e){
                    Log::info($e);
                    DB::rollBack();
                }
                break;
        }
        return $data;
    }

    protected function onRequisitionList(Practice $practice){
        $results = array();
        echo "-----Fetching Internal Requisitions...".PHP_EOL;
        $internal_requisitions = $practice->product_requisitions_src()->get()->sortByDesc('created_at');
        echo "----------".$internal_requisitions->count()." found...".PHP_EOL;
        echo "-----Fetching External Requisitions...".PHP_EOL;
        $external_requisitions = $practice->product_requisitions_dest()->get()->sortByDesc('created_at');
        echo "----------".$external_requisitions->count()." found...".PHP_EOL;
        echo "-----Transforming Results".PHP_EOL;
        foreach($internal_requisitions as $internal_requisition){
            array_push($results,$this->helper->transform_requisiton($internal_requisition));
        }
        foreach($external_requisitions as $external_requisition){
            array_push($results,$this->helper->transform_requisiton($external_requisition));
        }
        return $results;
    }

    protected function onDataRead($data,$type_){
        $result = null;
        switch($type_){
            case HisRtcUserTrack::RTC_SERVICE:
                $result = $data->text->service_data->service_type;
                break;
            case HisRtcUserTrack::RTC_SERVICE_ACTION:
                $result = $data->text->service_data->service_action;
                break;
            case HisRtcUserTrack::RTC_SERVICE_POSTED_DATA:
                $result = $data->text->service_data->posted_data;
                break;
            case HisRtcUserTrack::RTC_SERVICE_POSTED_DATA:
                $result = $this->practiceUser->findByUuid($data->text->staff_address->staff_id);
                break;
        }
        return $result;
    }

    protected function onTarget(ConnectionInterface $conn, Model $parent=null, Practice $practice=null,ProductStore $store=null,Department $department=null,ProductStore $substore=null){
        $target_party = $practice->his_rtc_tracks()->where('department_id',$department->id)->where('store_id',$store->id)->get()->first();
        if($substore){
            $target_party = $practice->his_rtc_tracks()->where('department_id',$department->id)->where('store_id',$store->id)->where('sub_store_id',$substore->id)->get()->first();
        }
        return $target_party;
    }

    protected function sendToClient($client, $msg){
        $msg = json_encode($msg);
        $client->send($msg);
    }

    protected function sendToParties(ConnectionInterface $conn, $data){
        //$data = json_decode($msg);
        echo "-->SEND_TO_PARTIES: ".$data->service_type.PHP_EOL;
        $group = $this->groups->find($data->room_id);
        $tracker = $this->onlinetrack->findByRecourceId($conn->resourceId); //requesting user
        //get all users in this group
        $groupusers = $this->groups->groupMembers($group);
        $total_grp_user = $groupusers->count();
        if ( $total_grp_user > 1){
            foreach ($groupusers as $groupuser){
                $traced_user = $this->onlinetrack->findByUserId($groupuser->user_id); //in group but requesting user
                if ( $traced_user ){ //check if user is online
                    foreach ($this->clients as $client){ //loop through all connections
                        if ($conn != $client){
                            if ( $client->resourceId == $traced_user->resource_id ){
                                echo "-->SUBMIT_TO_PARTIES: Client(".$client->resourceId.") ".$traced_user->first_name." ".$traced_user->last_name.PHP_EOL;
                                $this->sendToClient($client, $data);
                            }
                        }
                    }
                }
            }
        }
    }

    protected function sendToParty(ConnectionInterface $conn, $party_rid, $data){
        foreach ($this->clients as $client){ //loop through all connections
            if ($conn != $client){
                if ( $client->resourceId == $party_rid ){
                    $this->sendToClient($client, $data);
                }
            }
        }
    }

}
