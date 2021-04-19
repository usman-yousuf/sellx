<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;
use App\Models\Constant;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\City;

class CMSController extends Controller
{
	public function tos_page(Request $request)
    {
        return view('cms_pages.tos', []);
		// $data['view'] =  view('cms_pages.tos', [])->render();
        // return sendSuccess('Success', $data);
	}

    public function privacy_page(Request $request)
    {
        return view('cms_pages.privacy', []);

        // $data['view'] =  view('cms_pages.privacy', [])->render();
        // return sendSuccess('Success', $data);
    }
}
