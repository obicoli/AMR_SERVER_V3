<?php

namespace App\Http\Controllers\Websocket;

use App\helpers\HelperFunctions;
use App\Models\Consultation\Consultation;
use App\Models\Conversation\Conversation;
use App\Models\Conversation\Groups;
use App\Models\Conversation\GroupUser;
use App\Models\Conversation\OnlineTrack;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use App\Models\Users\User;
use App\Repositories\Consultation\ConsultationRepository;
use App\Repositories\Conversation\ConversationRepository;
use App\Repositories\Conversation\GroupRepository;
use App\Repositories\Conversation\OnlineTrackRepository;
use App\Repositories\Doctor\DoctorRepository;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketController implements MessageComponentInterface
{
    //
    protected $clients;
    private $subscriptions;
    private $users;
    private $userresources;

    protected $onlinetrack;
    protected $consultation;
    protected $conversation;
    protected $user;
    protected $groups;
    protected $patient;
    protected $doctor;
    protected $helper;


    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
        $this->users = [];
        $this->userresources = [];

        $this->onlinetrack = new OnlineTrackRepository(new OnlineTrack());
        $this->consultation = new ConsultationRepository(new Consultation());
        $this->conversation = new ConversationRepository(new Conversation());
        $this->user = new UserRepository(new User());
        $this->groups = new GroupRepository(new Groups());
        $this->patient = new PatientRepository(new Patient());
        $this->doctor = new DoctorRepository(new Doctor());
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
    public function onMessage(ConnectionInterface $conn, $msg)
    {
        //echo $msg.PHP_EOL;
        echo "----------New Incoming Message from Client(".$conn->resourceId.")----------".PHP_EOL;
        $data = json_decode($msg);
        echo "--->ID: ".$data->id.PHP_EOL;
        echo "--->TYPE: ".$data->type.PHP_EOL;
        echo "--->TEXT: ".$data->text.PHP_EOL;
        echo "--->ROOM_ID: ".$data->room_id.PHP_EOL;
        echo "--->DATE: ".$data->date.PHP_EOL;

//        $numRecv = count($this->clients) - 1;
//        echo sprintf('Client %d sending message "%s" to %d other clients %s' .PHP_EOL
//            , $conn->resourceId, $data->text, $numRecv, $numRecv == 1 ? '' : 's');

        if (isset($data->type)) {

            switch ($data->type) {

                case "online": //logging user
                    //Check if already subscribed
                    if ( !$this->onlinetrack->checkIfUserAlreadyLoggedIn($data->user_id,$conn->resourceId) ){

                        $trace_data = $this->onTraceable($conn, $data);//this method creates data to be store to indicate this use is online
                        $this->onlinetrack->createNewOnlineUser($trace_data);
                        //retrieve user data based on room id and chat on type(Consultation,Appointment)
                        echo "--->ONLINE_STATUS_INFORM: From Client(".$conn->resourceId."#".$data->user_id.") ".$data->first_name." ".$data->last_name.PHP_EOL;
                        $served_members = array();
                        $user = $this->user->findRecord($data->user_id);
                        $this->groups->setUserLastSeen($user->id);
                        $groups = $this->groups->getUserGroups($user);
                        echo "--->GROUPS: Client(".$conn->resourceId.") belongs to ".$groups->count()." group(s)".PHP_EOL;
                        foreach ($groups as $group){
                            //get group members
                            $members = $this->groups->groupMembers($group);
                            echo "--->GROUP MEMBERS: Group(".$group->name.") total members(".$members->count()." group(s)".PHP_EOL;
                            foreach ($members as $member){
                                //check if this group member is online
                                $member_tracker = $this->onlinetrack->findByUserId($member->user_id);
                                if ($member_tracker){
                                    echo "--->GROUP MEMBERS IS ONLINE: Member(".$conn->resourceId."#".$member->user_id.") ".$member_tracker->first_name." ". $member_tracker->last_name." is online".PHP_EOL;
                                    foreach ($this->clients as $client){

                                        if ($conn != $client){

                                            if ($member_tracker->resource_id == $client->resourceId){

                                                if ( !in_array($member->user_id, $served_members) ){
                                                    //sent
                                                    $this->sendToClient($client, json_encode($data));
                                                    //update served members array
                                                    array_push($served_members, $member->user_id);
                                                    echo "--->SEND IS ONLINE: To Member(".$client->resourceId."#".$member->user_id.") ".$member_tracker->first_name." ".$member_tracker->last_name.PHP_EOL;
                                                }

                                            }else{
                                                echo "--->SEND IS ONLINE: Skipping(".$client->resourceId."#".$member->user_id.") ".$member_tracker->first_name." ".$member_tracker->last_name.PHP_EOL;
                                            }

                                        }

                                    }
                                }
                            }
                        }
                        echo "--->TOTAL SEND ONLINE ALERTS: ".sizeof($served_members)."".PHP_EOL;

                    }else{
                        //tell user he has subscribed on another device/browser
                        echo "--->ONLINE TRACE ISSUE".PHP_EOL;
                        $data3 = json_decode($msg);
                        $data3->type = 'subscribe_rejected';
                        $data3->text = 'You already subscribed on another device/browser';
                        $this->sendToClient($conn, json_encode($data3));
                    }
                    break;
                case "conversations": //this is a part requesting its partners conversation
                    echo "--->CONVERSATION_REQUEST: From Client(".$conn->resourceId.")".PHP_EOL;
                    //$user = $this->user->findRecord($tracker->user_id);
                    $data->conversations = $this->createChatList($conn,null,$data);
                    $data->type = "chats";
                    echo "--->ANSWER_CONVERSATION_REQUEST: From Client(".$conn->resourceId.")".PHP_EOL;
                    $this->sendToSelf($conn, $data);
                    break;
                case "message": //users are chatting
                    echo "-->SERVICE_TYPE:".PHP_EOL;
                    echo "-->SAVE_CHAT: Conversation saved".PHP_EOL;
                    $this->conversation->store($this->onChat($conn, $data));
                    $this->sendToParties($conn,$data);
                    break;
                case 'typing':
                    $this->onTyping($conn, $msg);
                    break;
                case 'video-offer': //video call invitation

                    switch ($data->service_type){
                        case 'consultation': //chatting on a given consultation
                            echo "-->VIDEO_CALL_INVITE: From ".$data->first_name.PHP_EOL;
                            echo "-->SERVICE_TYPE: Consultation".PHP_EOL;
                            $consult = $this->consultation->findByUid($data->service_id);
                            $allonlineparties = $this->consultation->getAllOnlinePartiesInConsultationRoom($consult);
                            echo "-->LOG_INCOMING_CALL: saved".PHP_EOL;
                            //$this->log_consultation_calls($consult,$conn,$msg,'Calling');
                            foreach ($allonlineparties as $party){

                                foreach ($this->clients as $client){

                                    if ( $conn !== $client ){

                                        if ( ($client->resourceId == $party->resource_id) && ($data->room_id == $party->room_id) ){
                                            $this->sendToClient($client, $msg);
                                            echo "-->CALL_INVITE_SEND: To ".$party->first_name.PHP_EOL;
                                        }

                                    }

                                }

                            }
                            break;
                    }//switch service type
                    break;
                case 'call_busy': //
                    switch ($data->service_type){
                        case 'consultation': //chatting on a given consultation
                            echo "-->VIDEO_CALL_INVITE_DENIED: From ".$data->first_name.PHP_EOL;
                            echo "-->SERVICE_TYPE: Consultation".PHP_EOL;
                            $consult = $this->consultation->findByUid($data->service_id);
                            $allonlineparties = $this->consultation->getAllOnlinePartiesInConsultationRoom($consult);
                            //echo "-->SAVE_CHAT: Conversation saved".PHP_EOL;
                            foreach ($allonlineparties as $party){

                                foreach ($this->clients as $client){

                                    if ( $conn !== $client ){
                                        if ( ($client->resourceId == $party->resource_id) && ($data->room_id == $party->room_id) ){
                                            $this->sendToClient($client, $msg);
                                            echo "-->CALL_INVITE_DENIAL_SEND: To ".$party->first_name.PHP_EOL;
                                        }
                                    }

                                }

                            }
                            break;
                    }//switch service type
                    break;
                case 'new-ice-candidate':
                    switch ($data->service_type){
                        case 'consultation': //chatting on a given consultation
                            echo "-->NEW_ICE_CANDIDATE: From ".$data->first_name.PHP_EOL;
                            echo "-->SERVICE_TYPE: Consultation".PHP_EOL;
                            $consult = $this->consultation->findByUid($data->service_id);
                            $allonlineparties = $this->consultation->getAllOnlinePartiesInConsultationRoom($consult);
                            //echo "-->SAVE_CHAT: Conversation saved".PHP_EOL;
                            foreach ($allonlineparties as $party){

                                foreach ($this->clients as $client){

                                    if ( $conn !== $client ){

                                        if ( ($client->resourceId == $party->resource_id) && ($data->room_id == $party->room_id) ){
                                            $this->sendToClient($client, $msg);
                                            echo "-->CALL_INVITE_DENIAL_SEND: To ".$party->first_name.PHP_EOL;
                                        }

                                    }

                                }

                            }
                            break;
                    }//switch service type
                    break;
                case 'video-answer':
                    switch ($data->service_type){
                        case 'consultation': //chatting on a given consultation
                            echo "-->NEW_ICE_CANDIDATE: From ".$data->first_name.PHP_EOL;
                            echo "-->SERVICE_TYPE: Consultation".PHP_EOL;
                            $consult = $this->consultation->findByUid($data->service_id);
                            $allonlineparties = $this->consultation->getAllOnlinePartiesInConsultationRoom($consult);
                            //echo "-->SAVE_CHAT: Conversation saved".PHP_EOL;
                            foreach ($allonlineparties as $party){

                                foreach ($this->clients as $client){

                                    if ( $conn !== $client ){

                                        if ( ($client->resourceId == $party->resource_id) && ($data->room_id == $party->room_id) ){
                                            $this->sendToClient($client, $msg);
                                            echo "-->CALL_INVITE_DENIAL_SEND: To ".$party->first_name.PHP_EOL;
                                        }

                                    }

                                }

                            }
                            break;
                    }//switch service type
                    break;
                case 'call_drop':
                    switch ($data->service_type){
                        case 'consultation': //chatting on a given consultation
                            echo "-->NEW_ICE_CANDIDATE: From ".$data->first_name.PHP_EOL;
                            echo "-->SERVICE_TYPE: Consultation".PHP_EOL;
                            $consult = $this->consultation->findByUid($data->service_id);
                            $allonlineparties = $this->consultation->getAllOnlinePartiesInConsultationRoom($consult);
                            echo "-->LOG_MISSED_CALL: ".PHP_EOL;
                            $this->log_consultation_calls($consult,$conn,$msg,'Missed');
                            foreach ($allonlineparties as $party){

                                foreach ($this->clients as $client){

                                    if ( $conn !== $client ){

                                        if ( ($client->resourceId == $party->resource_id) && ($data->room_id == $party->room_id) ){
                                            $this->sendToClient($client, $msg);
                                            echo "-->CALL_INVITE_DENIAL_SEND: To ".$party->first_name.PHP_EOL;
                                        }

                                    }

                                }

                            }
                            break;
                    }//switch service type
                    break;
                case 'hang-up': //party ended the call
                    switch ($data->service_type){
                        case 'consultation': //chatting on a given consultation
                            echo "-->HANG_CALL: From ".$data->first_name.PHP_EOL;
                            echo "-->SERVICE_TYPE: Consultation".PHP_EOL;
                            $consult = $this->consultation->findByUid($data->service_id);
                            $allonlineparties = $this->consultation->getAllOnlinePartiesInConsultationRoom($consult);
                            echo "-->LOG_HANG_CALL: ".PHP_EOL;
                            //update call end time
                            //$this->log_consultation_calls($consult,$conn,$msg,'Missed');
                            foreach ($allonlineparties as $party){

                                foreach ($this->clients as $client){

                                    if ( $conn !== $client ){

                                        if ( ($client->resourceId == $party->resource_id) && ($data->room_id == $party->room_id) ){
                                            $this->sendToClient($client, $msg);
                                            echo "-->CALL_INVITE_DENIAL_SEND: To ".$party->first_name.PHP_EOL;
                                        }

                                    }

                                }

                            }
                            break;
                    }//switch service type
                    break;
                case 'call_history':
                    echo "--->CALL_HISTORY_REQUEST: User( ".$data->first_name." ".$data->last_name.", ID #".$data->user_id." )".PHP_EOL;
                    $user = $this->user->findRecord($data->user_id);
                    $contacts = $this->getCallHistory_ContactList($user);
                    foreach ($this->clients as $client){
                        if ( $conn == $client ){
                            $data->users = $contacts;
                            echo "--->CALL_HISTORY_REQUEST_ANSWERED: User( ".$data->first_name." ".$data->last_name.", ID #".$data->user_id."-".$client->resourceId." )".PHP_EOL;
                            $this->sendToClient($client, json_encode($data));
                        }
                    }
                    break;
                default: //user is typing
                    echo "-->UNKNOWN ERROR: ".PHP_EOL;
                    //call on typing function to alert the parties
                    //$this->onTyping($conn, $msg);
                    break;
            }
        }
    }

    protected function getCallHistory_ContactList(User $user){

        $history = array();

        $groups = $user->groups()->get();

        foreach ($groups as $grp){

            //get all users in this group
            $groupusers = DB::table('group_users')->where('group_id', $grp->id)->get();
            $total_grp_user = $groupusers->count();
            if ( $total_grp_user > 1){

                foreach ($groupusers as $groupuser){

                    if ( ($this->groups->is_generated($grp)) && ($total_grp_user==2) ){ //this is just one contact

                        if ( $user->id != $groupuser->user_id ){

                            $temp_user = $this->user->findRecord($groupuser->user_id);
                            $profile = null;
                            $title = "";
                            $avatar = "";
                            switch ($this->user->getUserType($temp_user)){
                                case Patient::USER_TYPE:
                                    $profile = $this->patient->findPatientByUserId($temp_user->id);
                                    $avatar = $this->patient->getAvatar($profile);
                                    break;
                                case Doctor::USER_TYPE:
                                    $profile = $this->doctor->findByUserId($temp_user->id);
                                    $title = $profile->title;
                                    $avatar = $this->doctor->getAvatar($profile);
                                    break;
                            }
                            $temp_data['type'] = "contact";
                            $temp_data['id'] = $groupuser->id;
                            $temp_data['date_seen'] = $this->helper->lastSeen($groupuser->last_seen);
                            $temp_data['first_name'] = $profile->first_name;
                            $temp_data['last_name'] = $profile->other_name;
                            $temp_data['uuid'] = $profile->uuid;
                            $temp_data['group_id'] = $grp->id;
                            $temp_data['room_id'] = $grp->id;
                            $temp_data['user_id'] = $temp_user->id;
                            $temp_data['avatar'] = $avatar;
                            $temp_data['salute'] = $title;
                            $temp_data['status'] = $this->onlinetrack->trace_status($temp_user->id);

                            array_push($history,$temp_data);
                        }

                    }else{ //this is a group
                        $temp_data['name'] = $grp->name;
                        $temp_data['status'] = $grp->status;
                        $temp_data['type'] = "group";
                        $temp_data['group_id'] = $grp->id;
                        $temp_data['room_id'] = $grp->id;
                        $temp_data['avatar'] = $this->groups->getAvatar($grp);
                    }

                }

            }

        }

//        foreach ($groups as $group){
//
//            if ( ($this->groups->is_generated($group)) && ($this->groups->getUsers($group)->count() > 1 ) ){
//                $temp_data['type'] = "contact";
//            }else{
//                $temp_data['name'] = $group->name;
//                $temp_data['status'] = $group->status;
//                $temp_data['type'] = "group";
//                $temp_data['group_id'] = $group->id;
//                $temp_data['room_id'] = $group->id;
//                $temp_data['avatar'] = $this->groups->getAvatar($group);
//            }
//
//            $temp_group_user = array();
//            $groupusers = DB::table('group_users')->where('group_id', $group->id)->get();
//            foreach ($groupusers as $groupuser){
//
//                if ( $groupuser->user_id != $user->id ){
//
//                    $temp_user = $this->user->findRecord($groupuser->user_id);
//                    $profile = null;
//                    $title = "";
//                    $avatar = "";
//                    switch ($this->user->getUserType($temp_user)){
//                        case Patient::USER_TYPE:
//                            $profile = $this->patient->findPatientByUserId($temp_user->id);
//                            $avatar = $this->patient->getAvatar($profile);
//                            break;
//                        case Doctor::USER_TYPE:
//                            $profile = $this->doctor->findByUserId($temp_user->id);
//                            $title = $profile->title;
//                            $avatar = $this->doctor->getAvatar($profile);
//                            break;
//                    }
//
//                    if ( ($this->groups->is_generated($group)) && ($this->groups->getUsers($group)->count() > 1 ) ){ //contact user
//                        $temp_data['id'] = $groupuser->id;
//                        $temp_data['date_seen'] = $groupuser->last_seen;
//                        $temp_data['first_name'] = $profile->first_name;
//                        $temp_data['last_name'] = $profile->other_name;
//                        $temp_data['uuid'] = $profile->uuid;
//                        $temp_data['group_id'] = $group->id;
//                        $temp_data['room_id'] = $group->id;
//                        $temp_data['user_id'] = $temp_user->id;
//                        $temp_data['avatar'] = $avatar;
//                        $temp_data['salute'] = $title;
//                        $temp_data['status'] = $this->onlinetrack->trace_status($temp_user->id);
//                    }else{
//                        $temp_data1['id'] = $groupuser->id;
//                        $temp_data1['salute'] = $title;
//                        $temp_data1['avatar'] = $avatar;
//                        $temp_data1['date_seen'] = $groupuser->last_seen;
//                        $temp_data1['first_name'] = $profile->first_name;
//                        $temp_data1['last_name'] = $profile->other_name;
//                        $temp_data1['uuid'] = $profile->uuid;
//                        $temp_data1['user_id'] = $temp_user->id;
//                        $temp_data1['status'] = $this->onlinetrack->trace_status($temp_user->id);
//                        array_push($temp_group_user, $temp_data1);
//                        $temp_data['group_users'] = $temp_group_user;
//                    }
//                }
//            }
//            array_push($history, $temp_data);
//        }

        return $history;
    }

    protected function log_consultation_calls(Consultation $consultation,ConnectionInterface $conn, $msg, $status){
        $data = json_decode($msg);
        switch ($status){
            case 'Calling':
                $call = [
                    'started_at' => date('Y-m-d H:i:s'),
                    'status' => $status,
                    'group_id' => $data->group_id,
                    'user_id' => $data->user_id,
                ];
                $consultation->calls()->create($call);
                break;
            case 'Missed':
                $call = [
                    'started_at' => date('Y-m-d H:i:s'),
                    'status' => $status,
                    'group_id' => $data->group_id,
                    'user_id' => $data->user_id,
                ];
                $consultation->calls()->create($call);
                break;
            default:
                echo "UNKNOWN_ERROR: ".PHP_EOL;
                break;
        }
    }

    protected function getLatestUsersList($allonlineparties, $client_id){

        $user_list = array();
        // The sender is not the receiver, send to each client connected
        foreach ($allonlineparties as $part){
            if ( $part->id != $client_id ){
                $temp_user['id'] = $part->uuid;
                $temp_user['first_name'] = $part->first_name;
                $temp_user['last_name'] = $part->last_name;
                $temp_user['avatar'] = $part->avatar;
                $temp_user['salute'] = $part->salute;
                $temp_user['group_id'] = $part->group_id;
                $temp_user['room_id'] = $part->room_id;
                $temp_user['date_seen'] = $part->date_seen;
                $temp_user['status'] = $part->status;
                $temp_user['user_id'] = $part->user_id;
                array_push($user_list, $temp_user);
            }
        }
        return $user_list;
    }

    protected function onTyping(ConnectionInterface $conn, $msg){
        echo "-->TYPING_ALERT: ".PHP_EOL;
        $this->sendToParties($conn,json_decode($msg));
    }

    protected function sendToSelf(ConnectionInterface $conn, $data){

        $tracker = $this->onlinetrack->findByRecourceId($conn->resourceId);
        foreach ($this->clients as $client){
            if ( $conn == $client ){
                if ( ($client->resourceId == $tracker->resource_id) ){
                    echo "--->ANSWER_CONVERSATION_REQUEST: From Client(".$conn->resourceId.")".PHP_EOL;
                    $data->conversations = $this->createChatList($conn,$client,$data);
                    $data->type = "chats";
                    $this->sendToClient($client, json_encode($data));
                }
            }
        }
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
                                $this->sendToClient($client, json_encode($data));
                            }
                        }
                    }
                }
            }
        }
    }

    protected function onChat(ConnectionInterface $conn, $chat){
        return [
            'message' => $chat->text,
            'user_id' => $chat->user_id,
            'group_id' => $chat->group_id,
            'room_id' => $chat->room_id,
        ];
    }


    protected function onConsultConversation(ConnectionInterface $conn, Consultation $consultation, $client, $msg){

        $data = json_decode($msg);
        $data->type = 'chats';
        $data->conversations = $this->createConversation($conn, $consultation, $client, $msg);
        $this->sendToClient($client, json_encode($data));
    }

    protected function createChatList(ConnectionInterface $conn, $client, $data){

        $conversations = array();
        //$data = json_decode($msg);
        $converses = $this->conversation->getByGroupId($data->group_id);
        foreach ( $converses as $convers){
            if ($data->user_id == $convers->user_id){
                $temp_data['me'] = true;
            }else{
                $temp_data['me'] = false;
            }
            //user who posted this conversation
            $user = $this->user->findRecord($convers->user_id);
            $temp_data['text'] = $convers->message;
            $temp_data['id'] = $convers->uuid;
            $temp_data['group_id'] = $convers->group_id;
            $temp_data['avatar'] = $this->getUserAttributes($user,'avatar');
            $temp_data['first_name'] = $this->getUserAttributes($user,'first_name');
            $temp_data['last_name'] = $this->getUserAttributes($user,'last_name');
            $temp_data['salute'] = $this->getUserAttributes($user,'salute');
            $temp_data['date'] = $this->helper->postedOn($convers->created_at);
            array_push($conversations, $temp_data);
        }
        return $conversations;

    }

    protected function createConversation(ConnectionInterface $conn, Consultation $consultation, $client, $msg){

        $conversations = array();
        $data = json_decode($msg);
        $converses = $consultation->conversation()->paginate(15);
        foreach ( $converses as $convers){
            if ($data->user_id == $convers->user_id){
                $temp_data['me'] = true;
            }else{
                $temp_data['me'] = false;
            }
            //user who posted this conversation
            $user = $this->user->findRecord($convers->user_id);
            $temp_data['text'] = $convers->message;
            $temp_data['id'] = $convers->uuid;
            $temp_data['group_id'] = $convers->group_id;
            $temp_data['avatar'] = $this->getUserAttributes($user,'avatar');
            $temp_data['first_name'] = $this->getUserAttributes($user,'first_name');
            $temp_data['last_name'] = $this->getUserAttributes($user,'last_name');
            $temp_data['salute'] = $this->getUserAttributes($user,'salute');
            $temp_data['date'] = date('Y-m-d H:i', strtotime($convers->created_at));
            array_push($conversations, $temp_data);
        }
        return $conversations;
    }

    protected function getUserAttributes(User $user, $attr_type){

        $profile = null;

        $userRepo = new UserRepository(new User());
        switch ( $userRepo->getUserType($user) ){
            case Patient::USER_TYPE:
                $patientRepo = new PatientRepository(new Patient());
                $profile = $patientRepo->findPatientByUserId($user->id);
                break;
            case Doctor::USER_TYPE:
                $doctorRepo = new DoctorRepository(new Doctor());
                $profile = $doctorRepo->findByUserId($user->id);
                break;
        }

        switch ($attr_type){
            case 'first_name':
                    return $profile->first_name;
                break;
            case 'last_name':
                    return $profile->other_name;
                break;
            case 'salute':
                    if ( $this->user->getUserType($user) == Doctor::USER_TYPE){
                        return $profile->title;
                    }else{
                        return "";
                    }
                break;
            default: //avatar
                //return $user->assets()->get()->first()->file_path;
                return "/assets/images/profile/avatar.jpg";
                break;
        }

    }

    protected function onConsultUserList(ConnectionInterface $conn, Consultation $consultation){

        $user_list = array();
        $allonlineparties = $this->consultation->getAllOnlinePartiesInConsultationRoom($consultation);
        foreach ($this->clients as $client) {
            if ( $conn != $client ) {
                // The sender is not the receiver, send to each client connected
                foreach ($allonlineparties as $party){
                    if ( $party->resource_id != $conn->resourceId ){
                        $temp_user['id'] = $party->uuid;
                        $temp_user['first_name'] = $party->first_name;
                        $temp_user['last_name'] = $party->last_name;
                        $temp_user['avatar'] = $party->avatar;
                        $temp_user['salute'] = $party->salute;
                        $temp_user['group_id'] = $party->group_id;
                        $temp_user['room_id'] = $party->room_id;
                        $temp_user['date_seen'] = $party->date_seen;
                        $temp_user['user_id'] = $party->user_id;
                        array_push($user_list, $temp_user);
                    }
                }
            }
        }
        return $user_list;
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->onClosure($conn);
        $this->onlinetrack->destroyByResourceId($conn->resourceId);
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected".PHP_EOL;
        unset($this->users[$conn->resourceId]);
        unset($this->subscriptions[$conn->resourceId]);
        foreach ($this->userresources as &$userId) {
            foreach ($userId as $key => $resourceId) {
                if ($resourceId==$conn->resourceId) {
                    unset( $userId[ $key ] );
                }
            }
        }

    }

    protected function onClosure(ConnectionInterface $conn){

        //track the room this party/client belongs to
        $track_record = $this->onlinetrack->findByRecourceId($conn->resourceId);
        //track this room discussion topic: e.g can be a Consultation
        //$trackable = $this->onlinetrack->findTrackable($track_record);
        //echo "------------OFFLINE_ALERT: Client(".$conn->resourceId.") is leaving Party(".$track_record->traceable_type." Tracing error) alerted!".PHP_EOL;
        //echo "------------OFFLINE_ALERT: Client(".$conn->resourceId.") is leaving Party("."gg".") alerted!".PHP_EOL;
        //echo "------------OFFLINE_ALERT: Client(".$conn->resourceId.") is leaving Party(".$trackable->traceable_type.") alerted!".PHP_EOL;
        echo "------------DISCONNECTING: Client(".$conn->resourceId.") ".$track_record->first_name." ".$track_record->last_name.PHP_EOL;
        $user = $this->user->findRecord($track_record->user_id);
        $groups = $user->groups()->get();
        echo "--->TOPIC: Consultation".PHP_EOL;
        foreach ($groups as $grp){

            //get all users in this group
            $groupusers = DB::table('group_users')->where('group_id', $grp->id)->get();
            $total_grp_user = $groupusers->count();
            if ( $total_grp_user > 1){

                foreach ($groupusers as $groupuser){

                    $traced_user = $this->onlinetrack->findByUserId($groupuser->user_id);

                    if ( $traced_user ){

                        foreach ($this->clients as $client){ //loop through all connections

                            if ( $client->resourceId == $traced_user->resource_id ){ //the leaving connected party/client not yet reached/found

                                $data = [
                                    'type'=>'offline',
                                    'text'=> $track_record->salute.' '.$track_record->first_name.' '.$track_record->last_name.' is offline',
                                ];
                                $this->sendToClient($client, json_encode($data));
                                echo "------------OFFLINE_ALERT: Client(".$conn->resourceId.") is leaving Party(".$client->resourceId.") alerted!".PHP_EOL;

                            }

                        }

                    }

                }

            }

        }

    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    public function debug($obj){
        if(!isset ($this->config['debug']) || !$this->config['debug']){
            return;
        }
        if(is_scalar($obj)){
            echo "$obj\n";
        }
        else{
            print_r($obj);
        }
    }

    protected function sendToClient($client, $msg){
        if(is_array($msg)){
            $msg = json_encode($msg);
        }
        $client->send($msg);
    }

    protected function onTraceable(ConnectionInterface $conn, $data){
        return [
            'user_id' => $data->user_id,
            'salute' => $data->salute,
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'room_id' => $data->room_id,
            'group_id' => $data->group_id,
            'resource_id' => $conn->resourceId,
            'avatar' => $data->avatar,
        ];
    }

    protected function createConversations(Model $model, $user_id, $first_name){
        $conversations = $model->conversation()->get();
        $results = array();
        foreach ($conversations as $conversation){
            $temp_data['id'] = $conversation->uuid;
            $temp_data['msg'] = $conversation->message;
            $temp_data['first_name'] = $first_name;
            $temp_data['created_at'] = date('Y-m-d H:i', strtotime($conversation->created_at));
            array_push($results, $temp_data);
        }
        return $results;
    }

}
