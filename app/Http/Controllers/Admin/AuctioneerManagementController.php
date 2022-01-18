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
use App\Models\Category;
use App\Models\ProfileCategory;

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
		// dd($user);
		$categories = ProfileCategory::where('Profile_id', $user->id)->first();
		// dd($categories);
		$category = Category::where('id', $categories->category_id)->first();
		// dd($cat);
		return view('admin.auctioneermanagement.auctioneer_details', ['user'=> $user, 'category'=> $category]);
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

		$categories = ProfileCategory::where('Profile_id', $profile->id)->first();
		$category = Category::where('id', $categories->category_id)->first();

		return view('admin.auctioneermanagement.auction_house_profile', ['profile'=>$profile, 'user'=>$user, 'category'=> $category]);
	}
	// auction view
    public function auctionView(Request $request){
		$auctions = Profile::where('profile_type', 'auctioneer')->with('auction')->with('categories')->get();
		// dd($auctions);
		return view('admin.auctions.index', ['auctions'=> $auctions]);
	}

	// All auctions edit view
    public function editAuctionView($uuid, $cat_id, Request $request){
		$auction = Auction::where('uuid', $uuid)->first();
		$profile = Profile::where('id', $auction->auctioneer_id)->where('profile_type', 'auctioneer')->first();
		// dd($profile->id);
		$profile_category = ProfileCategory::where('profile_id', $profile->id)->where('category_id', $cat_id)->first();
		$category = Category::where('id', $profile_category->category_id)->first();
		// dd($category);

		return view('admin.auctions.edit_auction', ['auction'=> $auction, 'profile'=> $profile, 'category'=> $category]);
	} 

	// All auctions edit
    public function editAuction($uuid, $cat_id, Request $request){
		
		$auction = Auction::where('uuid', $uuid)->first();
		$profile = Profile::where('id', $auction->auctioneer_id)->where('profile_type', 'auctioneer')->first();

		if(isset($request->auction_name))
			$auction->title = $request->auction_name;

		if(isset($request->auction_date))
			$auction->scheduled_date_time = $request->auction_date;

		$auction->save();


		if(isset($request->auction_house_name))
			$profile->auction_house_name = $request->auction_house_name;

		$profile->save();

		$profile_category = ProfileCategory::where('profile_id', $profile->id)->where('category_id', $cat_id)->first();
		$category = Category::where('id', $profile_category->category_id)->first();

		if(isset($request->category))
			$category->name = $request->category;

		$category->save();

		return redirect()->route('admin.auctions');
	}

    // auction products detail view
    public function auctionProductsDetail($uuid, Request $request){
		// dd($uuid);
		$auction = Auction::where('uuid', $uuid)->first();
		// dd($auction);
		$profile = Profile::where('id', $auction->auctioneer_id)->where('profile_type', 'auctioneer')->with('categories')->with('products')->first();
		// dd($profile);
		$auction_details = ['profile'=> $profile];
		// dd($auction_details);
		return view('admin.auctions.auction_products_detail', ['auction_details'=> $auction_details]);
	}


	public function deleteAuction(Request $request, $uuid){

		$auction = Auction::where('uuid', $uuid)->first();
		// dd($auction);
		$profile = Profile::where('id', $auction->auctioneer_id)->first();

		if($auction->delete() && $profile->delete()){
			return redirect()->route('admin.auctions');
		}

	}

    // All auctions products view
    public function allAuctionsProducts(Request $request){

		$all_auctions = Profile::where('profile_type', 'auctioneer')->with('categories')->with('products')->with('auction')->get();
		// dd($all_auctions);
		return view('admin.auctions.products_of_auctions', ['all_auctions'=> $all_auctions]);
	}

	// All Won lists
    public function wonList(){

		return view('admin.auctions.wonlist');
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
		// dd($users);
		return view('admin.auctioneermanagement.approval_request',compact('users',$users));
	}

	public function approvalRequestForm(Request $request, $uuid){
		// dd($uuid);
		$user = Profile::where('uuid', $uuid)->where('profile_type', 'auctioneer')->where('is_approved', 0)->first();
		// dd($user);
		return view('admin.auctioneermanagement.approval_request_form',compact('user',$user));

	}
    // use this function for user status update view page
    public function updateUsersForm(Request $request, $uuid){

		$users = Profile::where('profile_type', 'auctioneer')->where('is_approved', 1)->first();
		// dd($users);
		return view('admin.usermanagement.update',compact('users',$users));

	}

	// use this function for user status update view page
    public function updateUsersFormView(Request $request, $uuid){

		$users = Profile::where('profile_type', 'auctioneer')->where('is_approved', 1)->first();
		// dd($users);
		return view('admin.auctioneermanagement.auctioneers_status',compact('users',$users));

	}

	
    // use this function for user status update
    public function updateAuctioneerForm(Request $request, $uuid){
		$profile = Profile::where('uuid', $request->uuid)->first();

		if($profile){
			// dd($profile);
			$profile = new Profile();
			
			$profile = Profile::where('uuid', $uuid)->update([
				'is_approved' => $request['is_approved'],
				// 'updated_at' =>Carbon::now()
			]);
			return redirect()->route('admin.auctioneer.view_approval_request');
		}
		return redirect()->route('admin.auctioneer');
		
	}

	public function updateApprovalRequests(Request $request, $uuid){
		// dd($uuid);
		$profile =  Profile::where('uuid', $request->uuid)->first();
			if($profile){
				// dd('ok');
				$auctioneer_profile = new Profile();

				$auctioneer_profile = Profile::where('uuid', $uuid)->update([
					'is_approved' => $request['is_approved'],
					// 'updated_at' => Carbon::now()
				]);

				if($auctioneer_profile){
					return redirect()->route('admin.auctioneer');
				}
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
