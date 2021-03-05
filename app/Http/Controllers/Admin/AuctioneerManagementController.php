<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuctioneerManagementController extends Controller
{
	public function index() {
		$users = Profile::where('profile_type', 'auctioneer')->where('is_approved', 1)->get();
		return view('admin.auctioneermanagement.index',compact('users',$users));
	}

	public function view(Request $request, $uuid){
		
		$user = Profile::where('uuid', $uuid)->with('user')->with('addresses')->with('LocalisationSetting')->with('notificationpermissions')->first();
		return view('admin.auctioneermanagement.view',compact('user',$user));
	}

	public function delete(Request $request, $uuid){
		
		$profile = Profile::where('uuid', $uuid)->first();
		$user = User::where('id', $profile->user_id)->first();
		
		if($user->delete() && $profile->delete()){
			return redirect()->route('admin.auctioneer');
		}
		
	}

	public function approvalRequests() {
		$users = Profile::where('profile_type', 'auctioneer')->where('is_approved', 0)->get();
		return view('admin.auctioneermanagement.approval_request',compact('users',$users));
	}

	public function approvalRequestForm(Request $request, $uuid){
		
		$user = Profile::where('profile_type', 'auctioneer')->where('is_approved', 0)->first();
		return view('admin.auctioneermanagement.approval_request_form',compact('user',$user));
		
	}

	public function updateApprovalRequests(Request $request, $uuid){
		
		$auctioneer_profile = new Profile();
		
		$auctioneer_profile = Profile::where('uuid', $uuid)->update([
                'is_approved' => $request['is_approved'],
                'updated_at' =>Carbon::now()
            ]);
		
		if($auctioneer_profile){
			return redirect()->route('admin.auctioneer.view_approval_request');
		}
		return redirect()->route('admin.auctioneer.view_approval_request');
		
	}

	public function deleteApprovalRequests(Request $request, $uuid){
		
		$profile = Profile::where('uuid', $uuid)->first();
		
		if($profile->delete()){
			return redirect()->route('admin.auctioneer.view_approval_request');
		}
		return redirect()->route('admin.auctioneer.view_approval_request');
	}
}