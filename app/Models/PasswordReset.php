<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PasswordReset extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'password_resets';

    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Generates Password Reset Token
     *
     * @param Request $request
     * @param [type] $code
     * @return void
     */
    public static function generatePasswordResetToken(Request $request, $code = null)
    {
        // check existing and delete that
        if(isset($request->email) && $request->email != ''){
            $model = self::where('email', $request->email)->where('type', 'email')->first();
        }
        else{
            $model = self::where('phone', $request->phone_code . $request->phone_number)->where('type', 'phone')->first();
        }
        if(null != $model){
            $model->delete();
        }

        // create new model
        $model = new self();
        $code = (null != $code)? $code : mt_rand(100000, 999999);
        if(isset($request->email) && $request->email != ''){
            $model->email = $request->email;
            $model->type = 'email';
        }
        else{
            $model->email = $request->email;
            $model->type = 'phone';
            $model->phone = $request->phone_code . $request->phone_number;
        }
        $model->token = $code;
        $model->created_at = date('Y-m-d H:i:s');

        if($model->save()){
            return $code;
        }
        else{
            return false;
        }
    }

    public static function deleteResetToken($request)
    {
        // check existing and delete that
        if(isset($request->email) && $request->email != ''){
            $model = self::where('email', $request->email)->where('type', 'email')->where('token', $request->code)->first();
        }
        else{
            $model = self::where('phone', $request->phone_code . $request->phone_number)->where('type',
            'phone')->where('token', $request->code)->first();
        }
        if(null == $model){
            return 0;
        }
        else{
            if($model->delete()){
                return true;
            }
            return -1;
        }
    }
}
