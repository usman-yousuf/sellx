<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Story;
use App\Models\UploadMedia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StoryController extends Controller
{
	public function get_story(Request $request){
	    $validator = Validator::make($request->all(), [
            'profile_uuid' => 'string|exists:profiles,uuid',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $user = Profile::orderBy('created_at', 'DESC')->whereHas('stories')->with('stories')->get();

        // dd();
        return sendSuccess("Stories",$user);
	}

   	public function update_story(Request $request){
   		$validator = Validator::make($request->all(), [
            'profile_uuid' => 'required|exists:profiles,uuid',
            'name' => 'string|required',
            'path' => 'string|required',
            'media_type' => 'string|required',
            'media_format' => 'string|required',
            'media_size' => 'string|required',
            'media_ratio' => 'string|required',
            'media_thumbnail' => 'string|required',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $profile = Profile::where('uuid',$request->profile_uuid)->first();

        $story = [
        	'uuid' => Str::uuid(),
        	'profile_id' => $profile->id,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addHours(24),
        ];

        if(isset($request->caption)){
        	$story += [
        		'caption' => $request->caption,
        	];
        }

        $story = Story::create($story);

        $media = [
        	'uuid' => Str::uuid(),
        	'profile_id' => $profile->id,
        	'type' => 'story',
        	'ref_id' => $story->id,
        	'name' => $request->name,
            'path' => $request->path,
            'media_type' => $request->media_type,
            'media_format' => $request->media_format,
            'media_size' => $request->media_size,
            'media_ratio' => $request->media_ratio,
            'media_thumbnail' => $request->media_thumbnail,
        ];
        $media = UploadMedia::create($media);

        return sendSuccess('Uploaded media',$media);
   	}

   	public function delete_story(Request $request){
   		$validator = Validator::make($request->all(), [
            'story_uuid' => 'required|string|exists:stories,uuid',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $story = Story::where('uuid', $request->story_uuid)->delete();

        return sendSuccess('Deleted',[]);
   	}
}
