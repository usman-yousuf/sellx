<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CategoriesManagementController extends Controller
{
	public function index() {
		$data = Category::get();
		return view('admin.categoriesmanagement.index',compact('data',$data));
	}

	public function view(Request $request, $uuid){
		
		$data = Category::where('uuid', $uuid)->first();
		return view('admin.categoriesmanagement.view',compact('data',$data));
	}

	public function createForm(Request $request){
		
		return view('admin.categoriesmanagement.create_form');
	}

	public function editForm(Request $request, $uuid){
		
		$data = Category::where('uuid', $uuid)->first();
		return view('admin.categoriesmanagement.edit_form',compact('data',$data));
	}

	public function update(Request $request){

		try{
            $data = new Category();


            if(isset($request['uuid'])){
                $data->where('uuid',$request['uuid'])
                    ->update([
                        'name' => $request['name'],
                        'slug' => $request['slug'],
                        'status' => $request['status'],
                        'created_at' =>Carbon::now(),
                        'updated_at' =>Carbon::now()
                    ]);
                    return redirect()->route('admin.categories');
            }else{
                $data->uuid = \Str::uuid();
                $data->name = $request['name'];
                $data->slug = $request['slug'];
                $data->status = $request['status'];
                $data->save();

                if($data){
                	return redirect()->route('admin.categories');
                }
                return redirect()->route('admin.categories');
            }

        }catch (\Exception $e) {

            return $e->getMessage();
        }
		
		if($data){
			return redirect()->route('admin.categories');
		}
		return redirect()->route('admin.categories');
		
	}

	public function delete(Request $request, $uuid){
		
		$data = Category::where('uuid', $uuid)->first();
		
		if($data->delete()){
			return redirect()->route('admin.categories');
		}
		
	}

}