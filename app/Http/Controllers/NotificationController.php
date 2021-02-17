<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\NotificationPermission;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->activeProfile->uuid;
        $profile = Profile::where('uuid', $uuid)->first();
        if(null == $profile){
            return sendError('Invalid or Expired information providesd', []);
        }

        $result = NotificationPermission::updateSetting($request, $profile->id);
        if(!$result['status']){
            sendError('Something went wrong while updating Notification Permission', []);
        }
        $model = $result['data'];

        $data['notification_permissions'] = $model;
        return sendSuccess('Success', $data);
    }
}
