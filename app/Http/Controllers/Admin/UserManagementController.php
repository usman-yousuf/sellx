<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use File;

class UserManagementController extends Controller
{
	public function index() {
		$users = Profile::where('profile_type', 'buyer')->get();

		return view('admin.usermanagement.index',compact('users',$users));
	}

	public function view(Request $request, $uuid){

		$user = Profile::where('uuid', $uuid)->with('user')->with('addresses')->with('LocalisationSetting')->with('notificationpermissions')->first();

		return view('admin.usermanagement.view',compact('user',$user));
	}

	public function delete(Request $request, $uuid){
		$profile = Profile::where('uuid', $uuid)->first();
		
		$user = User::where('id', $profile->user_id)->first();
		// \DB::enableQueryLog();

		// $user = User::where('id', 2)->first();	
		// $queries = \DB::getQueryLog();
		// dd($queries,'test');
		// $user = \DB::select("select * from users where id = 2");
		// dd($user);
		if($user->delete() && $profile->delete()){
			return redirect()->route('admin.users');
		}

	}

	public function ajaxsubscribe(){

		return view('index');
	}


    // admin users
    public function indexAdmin() {
		$users = User::where('role', 'admin')->with('profiles')->get();
		// dd($users);
		// $users = User::with('profiles')->get();
		// $users = User::all();
		// $users =  \DB::('users')->get();
		// dd($users);
		// dd($users[10]->profiles->first_name);
		$allUser = [];
		$allProfile = [];
		foreach($users as $user){
			$allUser[] = $user;
			foreach($user->profiles as $profile){
				$allProfile[] = $profile;
			}
		}
		// dd($allProfile,$allUser);
		return view('admin.adminusermanagement.index', compact('users', $users));
	}

    public function viewAdmin($uuid,Request $request ){

		$users = User::where('uuid', $uuid)->where('role', 'admin')->with('profiles')->first();
		
		$user_profile = $users->profiles[0];

		return view('admin.adminusermanagement.view',['users'=>$users, 'user_profile'=>$user_profile]);
	}

	
	public function updateAdminUsersView($uuid, Request $request){

		$user = User::where('uuid', $uuid)->where('role', 'admin')->first();
		$profile = Profile::where('user_id', $user->id)->first();

		return view('admin.adminusermanagement.update', ['user'=>$user, 'profile'=>$profile]);
	}
    
	
	public function updateAdminUsersForm(Request $request, $uuid){
		
		$user = User::where('uuid', $uuid)->where('role', 'admin')->first();
		$profile = Profile::where('user_id', $user->id)->first();
		// dd($user);
		if(isset($request->first_name))
			$profile->first_name = $request->first_name;
		
		if(isset($request->last_name))
			$profile->last_name = $request->last_name;

		if(isset($request->dob))
			$profile->dob = $request->dob;

		if($request->hasFile('image'))
		{
			// dd($request->all());
			$file = $request->file('image');
			$extention = $file->getClientOriginalExtension();
			$filename = time(). '.' .$extention;
			$file->move('public/assets/images/', $filename);
			$profile->profile_image = $filename;
			
		}

		$profile->save();

		if(isset($request->name))
			$user->name = $request->name;

		if(isset($request->email))
			$user->email = $request->email;
			
		if(isset($request->password))
			$user->password = $request->password;

		$user->save();

		return redirect()->route('admin.adminusers');

	}

	public function addAdminView(){
		return view('admin.adminusermanagement.add');
	}


	public function addAdminUsersForm(Request $request){
		$request->validate([
			'name'          => 'required',
			'email'         => 'required|unique:users,email',
			'password'      => 'required|min:6',
			'dob'          => 'required|date',
			'first_name'    => 'required',
			'last_name'     => 'required',
			'role'          => 'required',
		]);

		$role = \Auth::user()->role;

		$super_admin = User:: where('role', $role);
	
		if($super_admin) {
			
			$admin_user = new User();

			$admin_user->uuid = \Str::uuid();
			$admin_user->name = $request->name;
			$admin_user->email = $request->email;
			$admin_user->password = $request->password;
			$admin_user->role = 'admin';
			
			$admin_user->save();

			$admin = new Profile();
			$admin->uuid = \Str::uuid();
			$admin->user_id = $admin_user->id;
			$admin->first_name = $request->first_name;
			$admin->last_name = $request->last_name;
			$admin->dob = $request->dob;
			if($request->hasFile('image'))
			{
				// dd($request->all());
				$file = $request->file('image');
				$extention = $file->getClientOriginalExtension();
				$filename = time(). '.' .$extention;
				$file->move('public/assets/images/', $filename);
				// dd($file_route);
				$admin->profile_image = $filename;
				
			}
			$admin->save();
		}
		
			return redirect()->route('admin.adminusers');
	}
    
	public function deleteAdmin($uuid, Request $request){

		
		$user = User::where('uuid', $uuid)->where('role', 'admin')->first();
		$profile = Profile::where('user_id', $user->id)->first();

		$path = public_path()."/assets/images/".$profile->profile_image;
		unlink($path);

		if($user->delete() && $profile->delete()){
			return redirect()->route('admin.adminusers');
		}

	}


}
