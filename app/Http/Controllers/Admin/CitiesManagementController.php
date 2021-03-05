<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CitiesManagementController extends Controller
{
	public function index() {
		$data = City::get();
		return view('admin.citymanagement.index',compact('data',$data));
	}

	public function view(Request $request, $id){
		
		$data = City::where('id', $id)->first();
		return view('admin.citymanagement.view',compact('data',$data));
	}

	public function createForm(Request $request){
		
		return view('admin.citymanagement.create_form');
	}

	public function editForm(Request $request, $id){
		
		$data = City::where('id', $id)->first();
		return view('admin.citymanagement.edit_form',compact('data',$data));
	}

	public function update(Request $request){

		try{
            $data = new City();


            if(isset($request['id'])){
                $data->where('id',$request['id'])
                    ->update([
                        'name' => $request['name'],
                        'country_code' => $request['country_code'],
                        'district' => $request['district'],
                        'population' => $request['population'],
                        'updated_at' =>Carbon::now()
                    ]);
                    return redirect()->route('admin.cities');
            }else{
            	$data->name = $request['name'];
                $data->country_code = $request['country_code'];
                $data->district = $request['district'];
                $data->population = $request['population'];
                $data->save();

                if($data){
                	return redirect()->route('admin.cities');
                }
                return redirect()->route('admin.cities');
            }

        }catch (\Exception $e) {

            return $e->getMessage();
        }
		
		if($data){
			return redirect()->route('admin.cities');
		}
		return redirect()->route('admin.cities');
		
	}

	public function delete(Request $request, $id){
		
		$data = City::where('id', $id)->first();
		
		if($data->delete()){
			return redirect()->route('admin.cities');
		}
		
	}

}