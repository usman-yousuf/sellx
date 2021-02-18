<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\NotificationPermission;
use App\Models\Notification;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Update Notification Setting
     *
     * @param Request $request
     * @return void
     */
    public function updateNotificationSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required',
            'enable_email_notifications' => 'required|in:1,0',
            'enable_push_notifications' => 'required|in:1,0',
            'enable_sms_notifications' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
        $uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->uuid;
        $profile = Profile::where('uuid', $uuid)->first();
        if(null == $profile){
            return sendError('Invalid or Expired information provided', []);
        }

        $result = NotificationPermission::updateSetting($request, $profile->id);
        if(!$result['status']){
            sendError('Something went wrong while updating Notification Permission', []);
        }
        $model = $result['data'];

        $data['notification_permissions'] = $model;
        return sendSuccess('Success', $data);
    }

    public function getNotifications(Request $request){
        $profile_id = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->id;
        $limit = null;
        if($request->limit){
            $limit = $request->limit;
        }

        if($limit){
            $notifications = Notification::where('receiver_id', $profile_id)->with('sender')->latest()->take($limit)->get();
        }else{
            $notifications = Notification::where('receiver_id', $profile_id)->with('sender')->latest()->get();
        }
        
        $notifications = $notifications->sortByDesc('created_at');
        
        $read_notiffications = Notification::where('receiver_id', $profile_id)->where('is_read', '0')->update(['is_read' => '1']);

        $data['notifications'] = $notifications;

        return sendSuccess("User Notifications", $data);
    }

    // Needs to Update According to Sellx
    public function addNotification($sender_id, $receiver_id, $type_id, $noti_type, $noti_text, $is_send_noti){

        $check = Notification::where('sender_id', $sender_id)->where('type_id', $type_id)->where('noti_type', $noti_type)->where('receiver_id', $receiver_id)->latest()->first();

        if($check != null){
            if($sender_id == $receiver_id){
                return false;
            }
        }

        $noti = new Notification;
        $noti->sender_id = $sender_id;
        $noti->receiver_id = $receiver_id;
        $noti->type_id = $type_id;
        $noti->noti_type = $noti_type;
        $noti->noti_text = $noti_text;
        $noti->save();

        $sender_profile = Profile::where('id', $sender_id)->first();

        $noti = Notification::find($noti->id);
        if($is_send_noti){
            $this->sendPushNotification([$receiver_id], $sender_profile->name.' '.$noti_text, $noti->toJson());
        }
        return $noti;
    }

    // Needs to Update According to Sellx
    public function sendPushNotification($ids, $text, $data){
        $filters = [];
        foreach ($ids as $i => $id){
            if($i > 0)
                array_push($filters, ["operator" => "OR"]);
            array_push($filters, ["field" => "tag", "key" => "user_id", "relation" => "=", "value" => $id]);
        }

        Log::info($filters);

        $content = array(
            "en" => $text
        );

        $att1 = str_replace(':','=>', $data);

        $fields = array(
            'app_id' => config('onesignal.app_id'),
            //'included_segments' => array('Active Users'),
            'filters' => $filters,
            'data' => array("data" => array($att1)),
            'contents' => $content
        );

        $fields = json_encode($fields);

        Log::info($fields);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.config('onesignal.rest_api_key')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        Log::info('NotificationsController => function sendPushNotification');
        Log::info($response);

        return $response;
    }

    public function getNotificationsPermission(Request $request){
        $profile_id = (isset($request->profile_id) && ($request->profile_id != ''))? $request->profile_id : $request->user()->profile->id;

        $notificationPermissions = NotificationPermission::where('profile_id' ,$profile_id)->first();

        $data['notification_permissions'] = $notificationPermissions;

        return sendSuccess("User Notifications Permissions", $data);
    }

    public function getUnreadNotificationsCount(Request $request){
        $profile_id = (isset($request->profile_id) && ($request->profile_id != ''))? $request->profile_id : $request->user()->profile->id;
        
        $unreadCount = Notification::whereRaw("id IN (SELECT id FROM notifications WHERE is_read = 0 and receiver_id = {$profile_id})")->count();

        $data['unreadCount'] = $unreadCount;
        
        return sendSuccess("Notification Unread Counts.", $data);
    }


}
