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
    // auction house index
    public function auctionHouseIndex() {
		$users = Profile::where('profile_type', 'auctioneer')->where('is_approved', 1)->get();
		return view('admin.auctioneermanagement.auction_house_index',compact('users',$users));
	}
    
    // All auction house profile view
    public function auctionHouseProfile($uuid, Request $request){
		$profile = Profile::where('uuid', $uuid)->where('profile_type', 'auctioneer')->first();
		$user = User::where('id', $profile->user_id)->first();

		return view('admin.auctioneermanagement.auction_house_profile', ['profile'=>$profile, 'user'=>$user]);
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

    // All Won lists
    public function wonList(){

		return view('admin.auctions.wonlist');
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
    // All transfer amount view
    public function transferAmountView(){

		return view('admin.accounts.transferred_amounts.index');
	}
    // All transfer amount add & edit
    public function transferAmountEdit(){

		return view('admin.accounts.transferred_amounts.edit_transfer_amount');
	}

    // All returns View
    public function returnView(){

		return view('admin.refund_cancelation.return.index');
	}

    // All returns Edit
    public function returnEdit(){

		return view('admin.refund_cancelation.return.edit_return');
	}

    // All returns Edit
    public function returnDetail(){

		return view('admin.refund_cancelation.return.view_return_details');
	}

    
    

    // All cancelation View
    public function cancelationView(){

		return view('admin.refund_cancelation.cancelation.index');
	}

    // All cancelation Edit
    public function cancelationEdit(){

		return view('admin.refund_cancelation.cancelation.edit_cancelation');
	}

    // All cancelation detail
    public function cancelationDetail(){

		return view('admin.refund_cancelation.cancelation.view_cancelation_details');
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
