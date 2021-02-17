<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    // /**
    //  * Get Profile Addresses
    //  *
    //  * @param Request $request
    //  * @return void
    //  */
    // public function getProfileAddresses(Request $request)
    // {
    //     $uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile : $request->user()->activeProfile->uuid;
    //     $profile = Profile::where('uuid', $uuid)->with('user')->first();
    //     if(null == $profile){
    //         return sendError('Invalid or Expired information provided', []);
    //     }
    //     $data['addresses'] = $profile->addresses;
    //     return sendSuccess('Success', $data);
    // }

}
