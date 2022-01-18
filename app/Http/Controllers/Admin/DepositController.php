<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProfileCategory;

class DepositController extends Controller
{

	// All auctions deposits view
    public function depositView(){
        
        $deposits = Profile::where('deposit', '!=','0')->get();
        return view('admin.deposit.index', ['deposits'=> $deposits]);
	}


    // All auctions edit deposits view
    public function editDepositView($uuid, Request $request){

        $deposits = Profile::where('uuid', $uuid)->where('deposit', '!=','0')->first();
        // dd($deposits);
        return view('admin.deposit.edit_deposit', ['deposits'=> $deposits]);
	}

    // All auctions edit deposits
    public function editDeposit($uuid, Request $request){

        $deposits = Profile::where('uuid', $uuid)->where('deposit', '!=','0')->first();
        
        if(isset($request->username))
            $deposits->username = $request->username;
        
        if(isset($request->amount))
            $deposits->deposit = $request->amount;

        if(isset($request->date))
            $deposits->created_at = $request->date;

        $deposits->save();

        return redirect()->route('admin.deposit');
	}

    public function deleteDeposit($uuid, Request $request){

        $deposits = Profile::where('uuid', $uuid)->where('deposit', '!=','0')->first();
        if($deposits->delete()){
            return redirect()->route('admin.deposit');
        }
    }

    // All auctions transactions view
    public function transactionsView(){

		return view('admin.transactions.index');
	}
	
}
