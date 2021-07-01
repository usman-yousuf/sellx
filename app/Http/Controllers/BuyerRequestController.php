<?php 

namespace App\Http\Controllers;

use App\Models\AuctionProduct;
use App\Models\BuyerRequest;
use App\Models\Profile;
use App\Models\Sold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BuyerRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_complain(Request $request)
    {
        

        $data = BuyerRequest::orderBy('created_at', 'DESC');

        // dd($request->all());
        if(isset($request->type)){

            $data->where('type', $request->type);
        }
        if(isset($request->status)){

            $data->where('status', $request->status);
        }

        if(isset($request->user_uuid)){

            $profile = Profile::where('uuid',$request->user_uuid)->first();
            if(null == $profile){
                return sendError('User not found',[]);
            }
            $data->where('profile_id', $profile->id);
        }

        $cloned_models = clone $data;

        if(isset($request->offset) && isset($request->limit)){

            $data->offset($request->offset)->limit($request->limit);
        }

        $data = $data->get();
        $total_bids = $cloned_models->count();

        return sendSuccess('$data',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_complain(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'auction_product_uuid' => 'required|exists:auction_products,uuid',
            'profile_uuid' => 'required|exists:profiles,uuid',
            'product_name' => 'required',
            'username' => 'required',
            'subject' => 'required',
            'complain_description' => 'required',
            'type' => 'required'
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $profile = Profile::where('uuid',$request->profile_uuid)->first();
        $auction_product = AuctionProduct::where('uuid',$request->auction_product_uuid)->first();
        

        $compilain = [
            'uuid' => Str::uuid(),
            'auction_product_id' => $auction_product->id,
            'profile_id' => $profile->id,
            'product_name' => $request->product_name,
            'username' => $request->username,
            'subject' => $request->subject,
            'complain_description' => $request->complain_description,
            'status' => "pending",
            'type' => $request->type,

        ];

        $complained = BuyerRequest::create($compilain);

        if($complained){
            $sold = [
                'status' => 'on_hold',
            ];

            Sold::where('auction_product_id',$auction_product->id)->where('profile_id',$profile->id)->update($sold);
        }

        return sendSuccess('Complain Registered Sucessfully', $complained);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function show(BuyerRequest $complain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function edit(BuyerRequest $complain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuyerRequest $complain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuyerRequest $complain)
    {
        //
    }
}
