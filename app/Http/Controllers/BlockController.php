<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Block;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_block(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_block(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_type' => 'required|in:user,story,auction,product',
            'type' => 'required|in:block,report,both',
            'ref_uuid' => 'required',
            'profile_uuid' => 'required|exists:profiles,uuid',
            'report_type' => 'required',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        if($request->ref_type == 'user'){

            $ref = Profile::where('uuid', $request->ref_uuid)->first();         
        }
        if($request->ref_type == 'story'){

            $ref = Story::where('uuid', $request->ref_uuid)->first();         
        }
        if($request->ref_type == 'auction'){

            $ref = Auction::where('uuid', $request->ref_uuid)->first();         
        }
        if($request->ref_type == 'product'){

            $ref = Product::where('uuid', $request->ref_uuid)->first();         
        }
        dd($ref->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_block(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Block $block)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Block $block)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        //
    }
}
