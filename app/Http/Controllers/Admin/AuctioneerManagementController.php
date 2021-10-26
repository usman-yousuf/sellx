<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Profile;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuctioneerManagementController extends Controller
{
	public function index() {
		$users = Profile::where('profile_type', 'auctioneer')->where('is_approved', 1)->get();
		return view('admin.auctioneermanagement.index',compact('users',$users));
	}

	public function view(Request $request, $uuid){

		$user = Profile::where('uuid', $uuid)->with('user')->with('addresses')->with('LocalisationSetting')->with('notificationpermissions')->first();
		return view('admin.auctioneermanagement.view',compact('user',$user));
	}

    // user details
    public function viewDetails(Request $request, $uuid){

		$user = Profile::where('uuid', $uuid)->with('user')->with('addresses')->with('LocalisationSetting')->with('notificationpermissions')->first();
		return view('admin.auctioneermanagement.auctioneer_details',compact('user',$user));
	}

    // auction view
    public function auctionView(Request $request, $uuid = null){

		$auction = Auction::get();
		return view('admin.auctions.index',compact('auction',$auction));
	}

    // auction products detail view
    public function auctionProductsDetail(){

		return view('admin.auctions.auction_products_detail');
	}

    // All auctions products view
    public function allAuctionsProducts(){

		return view('admin.auctions.products_of_auctions');
	}

    // All auctions deposits view
    public function depositView(){

		return view('admin.deposit.index');
	}


    // All auctions edit deposits view
    public function editDeposit(){

		return view('admin.deposit.edit_deposit');
	}

     // All auctions transactions view
    public function transactionsView(){

		return view('admin.transactions.index');
	}


    // All auctions edit view
    public function editAuction(){

		return view('admin.auctions.edit_auction');
	}

     // All auctions house account view
    public function auctionHouseAccountsView(){

		return view('admin.accounts.auction_house_accounts.index');
	}

    // All auctions house account view
    public function auctionHouseAccountsDetail(){

		return view('admin.accounts.auction_house_accounts.account_detail_view');
	}

    // All auctions house account view
    public function AccountsSummaryReport(){

		return view('admin.accounts.accounts_summary_reports.index');
	}


	public function delete(Request $request, $uuid){

		$profile = Profile::where('uuid', $uuid)->first();
		$user = User::where('id', $profile->user_id)->first();

		if($user->delete() && $profile->delete()){
			return redirect()->route('admin.auctioneer');
		}

	}

	public function approvalRequests() {
		$users = Profile::where('profile_type', 'auctioneer')->where('is_approved', 0)->get();
		return view('admin.auctioneermanagement.approval_request',compact('users',$users));
	}

	public function approvalRequestForm(Request $request, $uuid){

		$user = Profile::where('profile_type', 'auctioneer')->where('is_approved', 0)->first();
		return view('admin.auctioneermanagement.approval_request_form',compact('user',$user));

	}
    // use this function for user status update
    public function updateUsersForm(Request $request, $uuid){

		$users = Profile::where('profile_type', 'auctioneer')->where('is_approved', 0)->first();
		return view('admin.usermanagement.update',compact('users',$users));

	}

    // use this function for user status update
    public function updateAuctioneerForm(Request $request, $uuid){

		$users = Profile::where('profile_type', 'auctioneer')->where('is_approved', 0)->first();
		return view('admin.auctioneermanagement.auctioneers_status',compact('users',$users));

	}

	public function updateApprovalRequests(Request $request, $uuid){

		$auctioneer_profile = new Profile();

		$auctioneer_profile = Profile::where('uuid', $uuid)->update([
                'is_approved' => $request['is_approved'],
                'updated_at' =>Carbon::now()
            ]);

		if($auctioneer_profile){
			return redirect()->route('admin.auctioneer.view_approval_request');
		}
		return redirect()->route('admin.auctioneer.view_approval_request');

	}

	public function deleteApprovalRequests(Request $request, $uuid){

		$profile = Profile::where('uuid', $uuid)->first();

		if($profile->delete()){
			return redirect()->route('admin.auctioneer.view_approval_request');
		}
		return redirect()->route('admin.auctioneer.view_approval_request');
	}
}
