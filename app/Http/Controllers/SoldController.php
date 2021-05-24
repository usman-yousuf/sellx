<?php

namespace App\Http\Controllers;

use App\Models\Sold;
use App\Models\Bidding;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SoldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_sold(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sold_uuid' => 'required|exists:profiles,uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_sold(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bidding_uuid' => 'required|exists:biddings,uuid',        
            'status' => 'required',        
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $bid = Bidding::where('uuid', $request->bidding_uuid)->first();


        $sold = [
            'uuid' => Str::uuid(),
            'bidding_id' => $bid->id,
            'price' => $bid->total_price,
            'type' => $bid->status,
            'status' => $request->status,
            'total_price' => $bid->total_price,
            // 'discount' => $bid->id,
        ];

        if(isset($request->discount)){
            $total = $bid->total_price - ($bid->total_price * ($request->discount/100));
            $sold += [
                'discount' => $request->discount, 
            ];
            $sold['total_price'] = $total;
        }

        $sold = Sold::create($sold);

        return sendSuccess('Sold',$sold);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sold  $sold
     * @return \Illuminate\Http\Response
     */
    public function show(Sold $sold)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sold  $sold
     * @return \Illuminate\Http\Response
     */
    public function edit(Sold $sold)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sold  $sold
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sold $sold)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sold  $sold
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sold $sold)
    {
        //
    }
}
