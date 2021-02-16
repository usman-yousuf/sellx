<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // all profiles of user
    public function profiles()
    {
        return $this->hasMany('\App\Models\Profile', 'user_id', 'id');
    }

    // active profile of user
    public function activeProfile()
    {
        return $this->hasOne('\App\Models\Profile', 'user_id', 'id');
    }

    /**
     * Updted User Chunks info
     *
     * @param Request $request
     * @param String $user_uuid
     *
     * @return void
     */
    public static function updateUserChunks($request, $user_uuid)
    {
        $model = self::where('uuid', $user_uuid)->first();
        $model->updated_at = date('Y-m-d H:i:s');

        if($request->screen_type == 'phone'){
            $model->phone_number = $request->phone_number;
            $model->phone_code = $request->phone_code;
        }
        else if($request->screen_type == 'email'){
            $model->email = $request->email;
        }

        try{
            $model->save();
            return $model;
        }
        catch(\Exception $ex){
            // dd($ex->getMessage());
            return false;
        }
    }
}
