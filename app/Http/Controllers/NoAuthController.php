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

class NoAuthController extends Controller
{
	public function getConstants(Request $request){
		$constants = Constant::get();

		if($constants){
			$data['constants'] = $constants;
 			return sendSuccess('success.', $data);
		}
		return sendError('No Record Found !', null);
	}

	public function getCategories(Request $request){
		$categories = Category::get();

		if($categories){
			$data['categories'] = $categories;
 			return sendSuccess('success.', $data);
		}
		return sendError('No Record Found !', null);
	}

	public function getLanguages(Request $request){
		$languages = Language::get();

		if($languages){
			$data['languages'] = $languages;
 			return sendSuccess('success.', $data);
		}
		return sendError('No Record Found !', null);
	}

	public function getCountries(Request $request){
		$countries = Country::get();

		if($countries){
			$data['countries'] = $countries;
 			return sendSuccess('success.', $data);
		}
		return sendError('No Record Found !', null);
	}

	public function getCities(Request $request){
		$cities = City::get();

		if($cities){
			$data['cities'] = $cities;
 			return sendSuccess('success.', $data);
		}
		return sendError('No Record Found !', null);
	}

	public function getCurrencies(Request $request){
		$currencies = Currency::get();

		if($currencies){
			$data['currencies'] = $currencies;
 			return sendSuccess('success.', $data);
		}
		return sendError('No Record Found !', null);
	}
}