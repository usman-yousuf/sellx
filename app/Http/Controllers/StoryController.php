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


        $user = Profile::orderBy('created_at', 'DESC')->whereHas('stories')->with('stories')->get();

        return sendSuccess("Stories",$user);
	}

   	public function update_story(Request $request){
   		$validator = Validator::make($request->all(), [
            'profile_uuid' => 'exists:profiles,uuid|required_without:story_uuid',
            'name' => 'string|required_without:is_live',
            'path' => 'string|required_without:story_uuid',
            'media_type' => 'string|required_without:is_live',
            'media_format' => 'string|required_without:is_live',
            'media_size' => 'string|required_without:is_live',
            'media_ratio' => 'string|required_without:is_live',
            'media_thumbnail' => 'string|required_without:is_live',
            'is_live' => 'boolean',
            'story_uuid' => 'string|exists:stories,uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        if($request->story_uuid){

            Story::where('uuid', $request->story_uuid)->update([
                'is_live' => $request->is_live,
            ]);      
            return sendSuccess('Status Changed',[]);
        }

        $profile = Profile::where('uuid',$request->profile_uuid)->first();

        // $story = Story::where('profile_id',$profile->id)->first();        
        // if($story->is_live == 1){
            
        //     return sendError('Already Live');
        // }

        $story = [
        	'uuid' => Str::uuid(),
        	'profile_id' => $profile->id,
            'is_live' => $request->is_live??0,
        	'caption' => $request->caption??NULL,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addHours(24),
        ];

        $story = Story::create($story);

        $media = [
        	'uuid' => Str::uuid(),
        	'profile_id' => $profile->id,
        	'type' => 'story',
        	'ref_id' => $story->id,
        	'name' => $request->name??NULL,
            'path' => $request->path,
            'media_type' => $request->media_type??NULL,
            'media_format' => $request->media_format??NULL,
            'media_size' => $request->media_size??NULL,
            'media_ratio' => $request->media_ratio??NULL,
            'media_thumbnail' => $request->media_thumbnail??NULL,
        ];
        $media = UploadMedia::create($media);

        $data = $story->where('id',$story->id)->with('media')->get();

        return sendSuccess('Uploaded media',$data);
   	}

   	public function delete_story(Request $request){
   		$validator = Validator::make($request->all(), [
            'story_uuid' => 'required|string|exists:stories,uuid',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $story = Story::where('uuid', $request->story_uuid)->first();

        UploadMedia::where('type','story')->where('ref_id',$story->id)->delete();

        $story->delete();
        return sendSuccess('Deleted',[]);
   	}
}
