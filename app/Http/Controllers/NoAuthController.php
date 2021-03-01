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
	public function getInitialData(){
		$lan = array('en','ar'); 
		$country = array('bahrain','kuwait', 'oman', 'qatar', 'saudi Arabia', 'united arab emirates'); 
		$currency = array('bhd','awd', 'omr', 'qar', 'sar', 'aed', 'usd'); 
		
		$constants = Constant::get();
		$categories = Category::get();
		$languages = Language::whereIn('code', $lan)->get();
		$countries = Country::whereIn('name', $country)->get();
	 	$currencies = Currency::whereIn('code', $currency)->get();
		$cities = City::get();

		$data['constants'] = $constants;
		$data['categories'] = $categories;
		$data['languages'] = $languages;
		$data['countries'] = $countries;
		$data['currencies'] = $currencies;
		$data['cities'] = $cities;

		return sendSuccess('success.', $data);
	}

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
		$lan = array('en','ar'); 
		
		$languages = Language::whereIn('code', $lan)->get();

		if($languages){
			$data['languages'] = $languages;
 			return sendSuccess('success.', $data);
		}
		return sendError('No Record Found !', null);
	}

	public function getCountries(Request $request){
		$country = array('bahrain','kuwait', 'oman', 'qatar', 'saudi Arabia', 'united arab emirates'); 
		$countries = Country::whereIn('name', $country)->get();

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
		$currency = array('bhd','awd', 'omr', 'qar', 'sar', 'aed', 'usd'); 
		$currencies = Currency::whereIn('code', $currency)->get();

		if($currencies){
			$data['currencies'] = $currencies;
 			return sendSuccess('success.', $data);
		}
		return sendError('No Record Found !', null);
	}
}