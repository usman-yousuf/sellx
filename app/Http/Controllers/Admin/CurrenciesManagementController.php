<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CurrenciesManagementController extends Controller
{
	public function index() {
		$data = Currency::get();
		return view('admin.currencymanagement.index',compact('data',$data));
	}

	public function view(Request $request, $id){
		
		$data = Currency::where('id', $id)->first();
		return view('admin.currencymanagement.view',compact('data',$data));
	}

	public function createForm(Request $request){
		
		return view('admin.currencymanagement.create_form');
	}

	public function editForm(Request $request, $id){
		
		$data = Currency::where('id', $id)->first();
		return view('admin.currencymanagement.edit_form',compact('data',$data));
	}

	public function update(Request $request){

		try{
            $data = new Currency();


            if(isset($request['id'])){
                $data->where('id',$request['id'])
                    ->update([
                    	'code' => $request['code'],
                        'name' => $request['name'],
                        'symbol' => $request['symbol'],
                        'created_at' =>Carbon::now(),
                        'updated_at' =>Carbon::now()
                    ]);
                    return redirect()->route('admin.currencies');
            }else{
                $data->code = $request['code'];
                $data->name = $request['name'];
                $data->symbol = $request['symbol'];
                $data->save();

                if($data){
                	return redirect()->route('admin.currencies');
                }
                return redirect()->route('admin.currencies');
            }

        }catch (\Exception $e) {

            return $e->getMessage();
        }
		
		if($data){
			return redirect()->route('admin.currencies');
		}
		return redirect()->route('admin.currencies');
		
	}

	public function delete(Request $request, $id){
		
		$data = Currency::where('id', $id)->first();
		
		if($data->delete()){
			return redirect()->route('admin.currencies');
		}
		
	}

}