<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationPermission extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    use SoftDeletes;

    /**
     * Update Notification Settings
     *
     * @param Request $request
     * @param Integer $profile_id
     * @return void
     */
    public static function updateSetting($request, $profile_id)
    {
        $model = self::where('profile_id', $profile_id)->first();
        if(null == $model){
            $model = new self();
            $model->created_at = date('Y-m-d H:i:s');
            $model->profile_id = $profile_id;
        }
        else{
            $model->updated_at = date('Y-m-d H:i:s');
        }
        if(isset($request->enable_email_notifications)){
            $model->is_email_enable = $request->enable_email_notifications;
        }
        if(isset($request->enable_push_notifications)){
            $model->is_push_enable = $request->enable_push_notifications;
        }
        if(isset($request->enable_sms_notifications)){
            $model->is_sms_enable = $request->enable_sms_notifications;
        }

        try{
            $model->save();
            return getInternalSuccessResponse($model);
        }
        catch(\Exception $ex){
            // dd($ex->getMessage());
            return getInternalErrorResponse($ex->getMessage(), [], $ex->getCode());
        }
    }
}
