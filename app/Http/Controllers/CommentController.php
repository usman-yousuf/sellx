<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Profile;
use App\Models\Auction;
use App\Models\AuctionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_comment(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            // 'auction_uuid' => 'required|exists:auctions,uuid',
            'auction_product_uuid' =>'required|exists:auction_products,uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        // $auction = Auction::where('uuid',$request->auction_uuid)->first();
        $auction_product = AuctionProduct::where('uuid',$request->auction_product_uuid)->first();
        
        if(NULL == $auction_product){

            return sendError('Auction product Does Not Exist,Data Missmatch',[]);
        }

        $comments = Comment::orderBy('created_at', 'DESC');
        $comments = $comments->where('auction_product_id',$auction_product->id);
        $comment_clone = $comments;
        $data['comments'] = $comments->with('user')->get();
        $data['total_comments'] = $comment_clone->count();


        return sendSuccess('Comments',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_comment(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            'profile_uuid' => 'required_without_all:comment_uuid|exists:profiles,uuid',
            'auction_uuid' => 'required_without_all:comment_uuid|exists:auctions,uuid',
            'auction_product_uuid' =>'required_without_all:comment_uuid|exists:auction_products,uuid',
            'comment' => 'required|string',
            'comment_uuid' => 'required_without_all:auction_product_uuid,auction_uuid,profile_uuid|exists:comments,uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        if(isset($request->comment_uuid)){

            $comment = Comment::where('uuid',$request->comment_uuid)->update(['comment' => $request->comment]);
            return sendSuccess('Updated comment',$comment);
        }

        $profile = Profile::where('uuid',$request->profile_uuid)->first();
        $auction = Auction::where('uuid',$request->auction_uuid)->first();
        $auction_product = AuctionProduct::where('uuid',$request->auction_product_uuid)->first();

        if(NULL == $profile || NULL == $auction || NULL == $auction_product){

            return sendError('Data Missmatch',[]);
        }

        $comment = [
                'uuid' => Str::uuid(),
                'profile_id' => $profile->id,
                'auction_id' => $auction->id,
                'auction_product_id' => $auction_product->id,
                'comment' => $request->comment,
        ];

        $comment = Comment::Create($comment);
        $comment = $comment->where('id',$comment->id)->with('user')->get();
        return sendSuccess('Commented',$comment);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function delete_comment(Request $request)
    {
        $deletedRows = Comment::where('uuid', $request->comment_uuid)->delete();

        return sendSuccess('Comment deleted',[]);
    }
}
