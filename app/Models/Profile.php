<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'profiles';
    // protected $with = ['country'];

    // get profile user
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    // get profile addresses
    public function addresses()
    {
        return $this->hasMany('\App\Models\Address', 'profile_id', 'id');
    }

    // get default address
    public function defaultAddress()
    {
        return $this->hasMany('\App\Models\Address', 'profile_id', 'id')->where('default', 1);
    }

    /**
     * Update Profile Chunk info
     *
     * @param Request $request
     * @param String $profile_uuid
     * @return void
     */
    public static function updateProfileChunks($request, $profile_uuid)
    {
        $model = self::where('uuid', $profile_uuid)->first();
        $model->updated_at = date('Y-m-d H:i:s');

        if($request->screen_type == 'username'){
            $model->username = $request->username;
        }
        else if($request->screen_type == 'names'){
            $model->first_name = $request->first_name;
            $model->last_name = $request->last_name;
        }
        else if($request->screen_type == 'image'){
            $model->profile_image = $request->profile_image;
        }

        try{
            $model->save();
            $model = self::where('id', $model->id)->with('user')->first();
            return $model;
        }
        catch(\Exception $ex){
            // dd($ex->getMessage());
            return false;
        }
    }

    /**
     * Add|Update User Profile
     *
     * @param Request $request
     * @param Integer $user_id
     *
     * @return void
     */
    public static function addUpdateModel($request, $user_id = null)
    {
        if(isset($request->profile_id) && $request->profile_id != ''){
            $profile = Profile::where('uuid', $request->profile_id)->first();
            if(null == $profile){
                return sendError('Invalid or Expired Information Provided', []);
            }
            $profile->updated_at = date('Y-m-d H:i:s');
        }
        else{
            $profile = new Profile();
            $profile->uuid = \Str::uuid();
            $profile->user_id = $user_id;
            $profile->created_at = date('Y-m-d H:i:s');
        }
        $profile->is_online = (isset($request->is_online) && ($request->is_online != ''))? $request->is_online : true;
        $profile->is_approved = ($request->profile_type == 'buyer');

        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->username = $request->username;
        $profile->country = $request->country;
        $profile->dob = $request->dob;
        $profile->profile_type = $request->profile_type;
        $profile->profile_image = $request->profile_image;

        try{
            $profile->save();
            User::where('id', $profile->user_id)->update(['active_profile_id' =>$profile->id]); // update active profile
            // return $profile->with('user', 'country');
            return Profile::find($profile->id)->with('user')->first();
        }
        catch(\Exception $ex){
            // dd($ex->getMessage());
            return false;
        }
    }
}
