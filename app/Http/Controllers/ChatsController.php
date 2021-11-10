<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMember;
use App\Models\ChatMessage;
use App\Models\NotificationPermission;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChatsController extends Controller
{
        /**
     * Discard Media by URL
     *
     * @param Request $request
     * @return void
     */
    public function discardMediaByUrl(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'required'
        ]);

        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
        // return sendSuccess('Success', null);

        // find media at local db
        // delete from local db
        $m = ChatMessage::where('file_path', 'LIKE', "%{$request->path}%")->orWhere('thumbnail', 'LIKE', "%{$request->path}%")->first();
        if(null != $m){
            $m->forceDelete();
            \Storage::disk('s3')->delete($request->path);
        }


        return sendSuccess('Success', null);

        // find media at aws server
        // delete media from aws server
    }


    public function createChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_uuid' => 'required|exists:profiles,uuid',
            'user_uuid' => 'required|exists:profiles,uuid',
        ]);

        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }


        $user = Profile::where('uuid',$request->user_uuid)->first();
        $mid = Profile::where('uuid',$request->member_uuid)->first();
        $mid = $mid->id;
        $user_id = $user->id;

        $user = User::whereHas('profiles', function ($q) use($user_id){
            $q->where('id', $user_id);
        })->first();
        // dd($user);

        $chat = Chat::with('members.user')
            ->where('type', 'single')
            ->whereHas('members', function ($query) use ($mid, $user_id) {
                $query->where('member_id', $user_id)
                    ->orWhere('member_id', $mid);
                $query->havingRaw('COUNT(*) = 2');
            })->first();

        if(!$chat){
            $chat = new Chat;
            $chat->uuid = Str::uuid();
            $chat->admin_id = $user_id;
        }

        if(isset($request->title))
            $chat->title = $request->title;

        $chat->type = 'single';
        $chat->save();

        if($chat){
            $member = new ChatMember;
            $member->uuid = Str::uuid();
            $member->chat_id = $chat->id;
            $member->member_id = $mid;
            $member->save();

            $member = new ChatMember;
            $member->uuid = Str::uuid();
            $member->chat_id = $chat->id;
            $member->member_id = $user_id;
            $member->save();
            
            $data['chat'] = Chat::where('id', $chat->id)->with('members', function ($q) use($user_id){
                $q->where('member_id', '!=', $user_id)->with('user');
            })->first();

            if(isset($request->message) || isset($request->media)){
                $request->request->add(['chat_id' => $chat->id]);
                $this->sendMessage($request);
            }
            
            return sendSuccess('Chat created successful.', $data);
        }
        return sendError('There is some problem.', null);
    }

    public function getExistingChat(Request $request){
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required|exists:profiles,uuid',
        ]);
        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $user = Profile::where('uuid',$request->profile_uuid)->first();
        $user_id = $user->id;

        $user = User::whereHas('profiles', function ($q) use($user_id){
            $q->where('id', $user_id);
        })->first();

        // if($user->chat_limit == 0){
        //     return sendError('You have reached your chats limit', null);
        // }

        $mid = (int) $request->profile_uuid;
        $memberIdAgains = ChatMember::where('member_id',$mid)->get();
        $mineAgains = ChatMember::where('member_id',$user_id)->get();

        $mia_f = null;
        $ma_f = null;

        foreach ($memberIdAgains as $mia) {
            foreach ($mineAgains as $ma) {
                if($mia->chat_id == $ma->chat_id){
                    $mia_f = $mia->chat_id;
                    $ma_f = $ma->chat_id;
                    break;
                }

            }
        }

        if($mia_f == null && $ma_f == null){
            return sendSuccess('No Existing Chat Found.', null);
        }

        //dd($mia_f, $ma_f);

        //dd(json_decode($mineAgains), json_decode($memberIdAgains));
        $chat = Chat::with('members.user')
            ->where('type', 'single')
            ->where('id', $mia_f)
            // ->whereHas('members', function ($query) use ($mid, $user_id) {
            //     $query->where('member_id', $user_id);
                    // ->orWhere('member_id', $mid);
                // $query->havingRaw('COUNT(*) >= 2');
            //})
            ->first();

        if(!$chat){
            return sendSuccess('No Existing Chat Found.', null);
        }

        return sendSuccess('Chat Found.', $chat);
    }

    public function getChatMessages(Request $request){
        $validator = Validator::make($request->all(), [
            'chat_uuid' => 'required|exists:chats,uuid'
        ]);
        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $user_id = (int)$request->user()->profile->id;
        $chat_id = Chat::where('uuid',$request->chat_uuid)->first();
        $chat_id = $chat_id->id;

        $check = ChatMember::where('chat_id', $chat_id)->where('member_id', $user_id)->first();
        if(!$check){
            return sendError('Chat not found.', null);
        }

        ChatMember::where('chat_id', $chat_id)
            ->where('member_id', '=', $user_id)
            ->update(['unread_count' => 0]);


        $messages = ChatMessage::with('sender')
            ->where('chat_id', $chat_id)
            ->where('id', '>', $check->last_message_id)
            ->orderBy('created_at', 'DESC');

        if(isset($request->offset) && isset($request->limit)){
            $messages->offset($request->offset)->limit($request->limit);
        }
        $data['messages'] = $messages->get();
        $data['chat'] = Chat::where('id', $chat_id)->with(['members' => function($query) use($user_id){
            $query->with('user')->where('member_id', '!=', $user_id);
        }])->first();
        // dd($chat);
        // $data['chat'] = Chat::with(['members' => function($query) use($user_id){
        //     $query->with('user')->where('member_id', '!=', $user_id);
        // }])->first();
        return sendSuccess('Chat found.', $data);
    }


    public function getNewUsers(Request $request){

        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required|exists:profiles,uuid',
        ]);
        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $user = Profile::where('uuid',$request->profile_uuid)->first();
        $user_id = $user->id;

        $my_chats = Chat::with('lastMessage', 'members')->whereHas('members', function ($query) use($user_id) {
            $query->where('member_id', $user_id)->where('is_deleted', false);
        })->get();
        
        $members = [];
        foreach($my_chats as $c){
            foreach ($c->members as $m)
                array_push($members, $m->member_id);
        }
        $users = Profile::where('user_id', '!=', $request->user()->id)->whereNotIn('id', $members)->where('is_approved', 1);
        if($request->search)
            $users->where('name', 'LIKE', '%'.$request->search.'%');
        $data['users'] = $users->get();

        return sendSuccess('success.', $data);
    }


    public function sendMessage(Request $request){

        $validator = Validator::make($request->all(), [
            'chat_uuid' => 'required|exists:chats,uuid'
        ]);

        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }


        $user_id = $request->user()->profile->id;
        $chat_id = Chat::where('uuid',$request->chat_uuid)->first();
        $chat_id = $chat_id->id;

        ChatMember::where('chat_id', $chat_id)
            ->where('member_id', '!=', $user_id)
            ->update(['unread_count' => \DB::raw('unread_count + 1')]);

        ChatMember::where('chat_id', $chat_id)
            ->update(['is_deleted' => false]);

        $message = new ChatMessage;
        $message->uuid = Str::uuid();
        $message->chat_id = $chat_id;
        $message->sender_id = $user_id;

        if(isset($request->message))
            $message->message = $request->message;
        if(isset($request->media))
            $message->file_path = $request->media;
        if(isset($request->ratio))
            $message->file_ratio = $request->ratio;
        if(isset($request->type))
            $message->file_type = $request->type;
        if(isset($request->thumbnail))
            $message->thumbnail = $request->thumbnail;

        $message->save();

        /*if ($request->media != '' && $request->media != null && $request->hasFile('media')) {
            $file = $request->file('media');
            $file_name = 'message_' . $message->id . '.' . $file->getClientOriginalExtension();
            $uploaded_path = public_path() . '/assets/messages';
            $file->move($uploaded_path, $file_name);
            $message->file_path = asset('assets/messages').'/' . $file_name;
            $message->file_ratio = $request->ratio;
            $message->file_type = $request->type;
            $message->save();
        }*/

        /*if ($request->thumbnail != '' && $request->thumbnail != null && $request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $file_name = 'message_thumb_' . $message->id . '_' .time().  '.' . $file->getClientOriginalExtension();
            $uploaded_path = public_path() . '/assets/messages';
            $file->move($uploaded_path, $file_name);
            $message->thumbnail = asset('assets/messages').'/' . $file_name;
            $message->save();
        }*/
        $chatMember = ChatMember::where('chat_id', (int)$request->chat_id)
            ->where('member_id', '!=', $user_id)
            ->first();
        // dd($chatMember);

        // $noti_pem = NotificationPermission::where('profile_id', $chatMember->member_id);
        // $noti_con = new NotificationsController;
        // $noti_con->addNotification($user_id, $chatMember->member_id, $message->chat_id, listNotficationTypes()['message_receive'], 'sent you a message', $noti_pem);

        $data['message'] = ChatMessage::where('id',$message->id)->first();
        return sendSuccess('Message sent successfully.', $data);
    }


    public function getChats(Request $request){

        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required|exists:profiles,uuid'
        ]);
        
        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $user_id =  Profile::where('uuid',$request->profile_uuid)->first();
        $user_id = $user_id->id;

        $chats = Chat::with(['lastMessage', 'members' => function($query) use($user_id){
            $query->with('user')->where('member_id', '!=', $user_id);
        }])->whereHas('members', function ($query) use($user_id) {
            $query->where('member_id', $user_id)
                ->where('is_deleted', false);
        });

// dd($chats);
        if($request->search){
            $search = $request->search;
            $chats->whereHas('members', function ($query) use($user_id, $search) {
                $query->where('member_id', '!=', $user_id)
                    ->whereHas('user', function ($q) use($search){
                        $q->where('name', 'Like', '%'.$search.'%');
                    });
            });
        }

        $chats->select('chats.*', DB::raw("(select unread_count from chat_members where chat_id = chats.id and member_id = ".$user_id." limit 1) as unread_count"));
        // dd($chats->get()[0]);
        $clone_chats = clone $chats;
        if(isset($request->offset) && isset($request->limit)){
            $chats->offset($request->offset)->limit($request->limit);
        }

        $data['chats'] = $chats->get();
        $data['total'] = $chats->count();
        $clone_chats->whereHas('members', function ($query) use($user_id) {
            $query->where('member_id', $user_id)->where('unread_count', '>', 0);
        });
        $data['total_unread_chats'] = $clone_chats->count();
        // dd($data);
        return sendSuccess('Success', $data);
    }

    public function getUnreadChatsCount(Request $request){
        // \DB::enableQueryLog();
        if (app('request')->user() != null) {
            $user_id = ($request->user_id) ? $request->user_id : $request->user()->profile_id;
        }
        else{
            return 0;
        }
        $chats = Chat::with(['lastMessage', 'members' => function($query) use($user_id){
            $query->with('user')->where('member_id', '!=', $user_id);
        // }])->whereHas('members', function ($query) use($user_id) {
        //     $query->where('member_id', $user_id)
        //         ->where('is_deleted', false);
        // })->whereHas('members', function ($query) use($user_id) {
        //     $query->where('member_id', '!=', $user_id)
        //         ->whereRaw("member_id NOT IN (Select blocked_id from block_users where user_id = ".$user_id.")")
        //         ->whereRaw("member_id NOT IN (Select user_id from block_users where blocked_id = ".$user_id.")");
        }]);

        $chats->select('chats.*', DB::raw("(select unread_count from chat_members where chat_id = chats.id and member_id = ".$user_id." limit 1) as unread_count"));
        $clone_chats = clone $chats;

        $clone_chats->whereHas('members', function ($query) use($user_id) {
            $query->where('member_id', $user_id)->where('unread_count', '>', 0);
        });
        $total_unread_chats = $clone_chats->count();

        // dd($total_unread_chats);
        // print_array(\DB::getQueryLog(), true);
        return $total_unread_chats;
    }


    public function deleteChat(Request $request){
        $validator = Validator::make($request->all(), [
            'chat_uuid' => 'required|exists:chats,uuid'
        ]);

        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $chat_id = Chat::where('uuid', $request->chat_uuid)->first();
        $user_id = $request->user()->profile->id;

        $check = ChatMessage::orderBy('id', 'DESC')->select('id')->first();
        if(!$check){
            return sendError('Chat not found.', null);
        }
        ChatMember::where('chat_id', $chat_id)
            ->where('member_id', $user_id)
            ->update(['is_deleted' => true, 'unread_count' => 0, 'last_message_id' => $check->id]);

        return sendSuccess('Chat deleted successfully.', null);
    }

    public function deleteMessage(Request $request){
        $validator = Validator::make($request->all(), [
            'message_uuid' => 'required|exists:chat_messages,uuid',
        ]);
        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $user_id = $request->user()->profile->id;

        $check = ChatMessage::where('sender_id', $user_id)->where('uuid', $request->message_uuid)->first();

        if($check){
            $check->update([
                        'is_deleted' => 1,
                        'updated_at' => Carbon::now()
                ]);
            return sendSuccess('Chat Message deleted successfully.', null);
        }
        return sendError('you cannot delete this message.', null);
    }


    /*public function getChatMedia(Request $request){
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required'
        ]);
        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $check = ChatMember::where('chat_id', $request->chat_id)->where('member_id', Auth::user()->id)->select('last_message_id')->first();
        if(!$check){
            return sendError('Chat not found.', null);
        }
        $data['media'] = ChatMessage::with('sender')
            ->where('chat_id', $request->chat_id)
            ->where('id', '>', $check->last_message_id)
            ->where('file_path', '!=', null)
            ->orderBy('created_at', 'ASC')
            ->get();
        return sendSuccess('Chat found.', $data);
    }*/
}
