<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CountriesManagementController extends Controller
{
	public function index() {
		$data = Country::get();
		return view('admin.countrymanagement.index',compact('data',$data));
	}

	public function view(Request $request, $id){
		
		$data = Country::where('id', $id)->first();
		return view('admin.countrymanagement.view',compact('data',$data));
	}

	public function createForm(Request $request){
		
		return view('admin.countrymanagement.create_form');
	}

	public function editForm(Request $request, $id){
		
		$data = Country::where('id', $id)->first();
		return view('admin.countrymanagement.edit_form',compact('data',$data));
	}

	public function update(Request $request){

		try{
            $data = new Country();


            if(isset($request['id'])){
                $data->where('id',$request['id'])
                    ->update([
                    	'iso' => $request['iso'],
                        'name' => $request['name'],
                        'nicename' => $request['name'],
                        'iso3' => $request['iso3'],
                        'numcode' => $request['numcode'],
                        'phonecode' => $request['phonecode'],
                        'created_at' =>Carbon::now(),
                        'updated_at' =>Carbon::now()
                    ]);
                    return redirect()->route('admin.countries');
            }else{
                $data->iso = $request['iso'];
                $data->name = $request['name'];
                $data->nicename = $request['nicename'];
                $data->iso3 = $request['iso3'];
                $data->numcode = $request['numcode'];
                $data->phonecode = $request['phonecode'];
                $data->save();

                if($data){
                	return redirect()->route('admin.countries');
                }
                return redirect()->route('admin.countries');
            }

        }catch (\Exception $e) {

            return $e->getMessage();
        }
		
		if($data){
			return redirect()->route('admin.countries');
		}
		return redirect()->route('admin.countries');
		
	}

	public function delete(Request $request, $id){
		
		$data = Country::where('id', $id)->first();
		
		if($data->delete()){
			return redirect()->route('admin.countries');
		}
		
	}

}