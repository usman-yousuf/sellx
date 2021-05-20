<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UploadMedia extends Model
{
    use HasFactory;

    protected $table = 'upload_media';
    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    use SoftDeletes;

    /**
     * Add Profile Attachments
     *
     * @param [type] $urls
     * @param [type] $model_id
     * @param [type] $model_type
     * @return void
     */
    public static function addAttachments($profile_id, $urls, $model_id, $model_type, $media_type=null, $media_format=null, $media_size=null, $media_ratio=null, $media_thumbnail=null)
    {
        //dd($profile_id, $urls, $model_id, $model_type, $media_type, $media_format, $media_size, $media_ratio, $media_thumbnail);
        $status = true;
        $attachments = explode(',', $urls);
        $file_urls = [];
        $message = 'Success';
        $code = 200;
        if(!empty($attachments)){
            foreach ($attachments as $key => $item) {
                if(!empty(trim($item))){
                    $file_urls[] = $item;
                }
            }

            if(!empty($file_urls)){
                foreach ($file_urls as $key => $item) {
                    $model = new self();
                    $model->uuid = \Str::uuid();
                    $model->profile_id = $profile_id;
                    $model->path = $item;
                    $model->type = $model_type;
                    $model->ref_id = $model_id;

                    $model->media_type = $media_type;
                    $model->media_format = $media_format;
                    $model->media_size = $media_size;
                    $model->media_ratio = $media_ratio;
                    $model->media_thumbnail = $media_thumbnail;

                    $model->created_at = date('Y-m-d H:m:i');
                    try{
                        $model->save();
                    }
                    catch(\Exception $ex){
                        $status = false;
                        $message = $ex->getMessage();
                        $code = $ex->getCode();
                        break;
                    }
                }
            }
        }
        if(!$status){
            return getInternalErrorResponse($message, [], $code);
        }
        return getInternalSuccessResponse($file_urls);
    }
}
