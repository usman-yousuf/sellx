<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class LanguagesManagementController extends Controller
{
	public function index() {
		$data = Language::get();
		return view('admin.languagemanagement.index',compact('data',$data));
	}

	public function view(Request $request, $id){
		
		$data = Language::where('id', $id)->first();
		return view('admin.languagemanagement.view',compact('data',$data));
	}

	public function createForm(Request $request){
		
		return view('admin.languagemanagement.create_form');
	}

	public function editForm(Request $request, $id){
		
		$data = Language::where('id', $id)->first();
		return view('admin.languagemanagement.edit_form',compact('data',$data));
	}

	public function update(Request $request){

		try{
            $data = new Language();


            if(isset($request['id'])){
                $data->where('id',$request['id'])
                    ->update([
                    	'code' => $request['code'],
                        'name' => $request['name'],
                        'nativeName' => $request['nativeName'],
                        'created_at' =>Carbon::now(),
                        'updated_at' =>Carbon::now()
                    ]);
                    return redirect()->route('admin.languages');
            }else{
                $data->code = $request['code'];
                $data->name = $request['name'];
                $data->nativeName = $request['nativeName'];
                $data->save();

                if($data){
                	return redirect()->route('admin.languages');
                }
                return redirect()->route('admin.languages');
            }

        }catch (\Exception $e) {

            return $e->getMessage();
        }
		
		if($data){
			return redirect()->route('admin.languages');
		}
		return redirect()->route('admin.languages');
		
	}

	public function delete(Request $request, $id){
		
		$data = Language::where('id', $id)->first();
		
		if($data->delete()){
			return redirect()->route('admin.currencies');
		}
		
	}

}