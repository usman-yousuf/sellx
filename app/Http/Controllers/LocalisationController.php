<?php

namespace App\Http\Controllers;

use App\Models\LocalisationSetting;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocalisationController extends Controller
{
    /**
     * Update Notification Setting
     *
     * @param Request $request
     * @return void
     */
    public function updateLocalisationSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
        $uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->uuid;
        $profile = Profile::where('uuid', $uuid)->first();
        if(null == $profile){
            return sendError('Invalid or Expired information providesd', []);
        }


        $result = LocalisationSetting::updateSetting($request, $profile->id);
        if(!$result['status']){
            sendError('Something went wrong while updating Notification Permission', []);
        }
        $model = $result['data'];

        $data['localisation_settings'] = $model;
        return sendSuccess('Success', $data);
    }

    public function getLocalisationSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $profile_uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->uuid;
        $profile = Profile::where('uuid', $profile_uuid)->with('LocalisationSetting')->first();

        if($profile){
            $data['profile'] = $profile;
            return sendSuccess('Success', $data);
        }
        return sendError('Profile not found.', null);
        
    }
}
