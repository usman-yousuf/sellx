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
        
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required|exists:profiles,uuid',
            'ref_type' => 'in:user,story,auction,product',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $block = Block::orderBy('created_at', 'DESC');

        $profile = Profile::where('uuid', $request->profile_uuid)->first();

        $block->where('profile_id', $profile->id);

        if(isset($request->ref_type)){

            $block->where('ref_type', $request->ref_type);

            if(isset($request->ref_uuid)){
                
                if($request->ref_type == 'user'){

                    $ref = Profile::where('uuid', $request->ref_uuid)->first();         
                }
                if($request->ref_type == 'story'){

                    $ref = Story::where('uuid', $request->ref_uuid)->first();         
                }
                if($request->ref_type == 'auction'){

                    $ref = Auction::where('uuid', $request->ref_uuid)->first();    
                    dd($ref->id);     
                }
                if($request->ref_type == 'product'){

                    $ref = Product::where('uuid', $request->ref_uuid)->first();         
                }

                if($ref != ''){

                    $block->where('ref_id', $ref->id);
                }
            }

        }

        $cloned_models = clone $block;
            
        if(isset($request->offset) && isset($request->limit) ){

                $cloned_models->offset($request->offset)->limit($request->limit);
        }

        $block = $cloned_models->get();

        return sendSuccess('Data', $block);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_block(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required|exists:profiles,uuid',
            'type' => 'required|in:block,report,both',
            'ref_type' => 'required|in:user,story,auction,product',
            'ref_uuid' => 'required',
            'report_type' => 'required',
            'description' => 'required_with:report_type',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $profile = Profile::where('uuid', $request->profile_uuid)->first();

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

        if($ref == ''){

            return sendError('invalid UUID',[]);
        }

        $block = [
            'uuid' => Str::uuid(),
            'profile_id' => $profile->id,
            'ref_type' => $request->ref_type,
            'ref_id' => $ref->id,
            'type' => $request->type,
            'report_type' => $request->report_type,
            'description' => $request->description,
        ];

        $block = Block::create($block);

        return sendSuccess('Sucess',$block);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_block(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'block_uuid' => 'exists:blocks,uuid|required_without:block_uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $block = Block::where('uuid', $request->block_uuid)->first();
        $block->delete();
        return sendSuccess('Deleted',$block);

        
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
