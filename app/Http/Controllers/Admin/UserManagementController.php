<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UserManagementController extends Controller
{
	public function index() {
		$users = Profile::where('profile_type', 'buyer')->get();
		
		return view('admin.usermanagement.index',compact('users',$users));
	}

	public function view(Request $request, $uuid){
		
		$user = Profile::where('uuid', $uuid)->with('user')->with('LocalisationSetting')->get();

		return view('admin.usermanagement.view',compact('user',$user));
	}
}