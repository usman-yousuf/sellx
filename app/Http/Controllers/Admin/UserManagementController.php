<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UserManagementController extends Controller
{
	public function index() {
		$users = User::get();
		
		return view('admin.usermanagement.index',compact('users',$users));
	}
}