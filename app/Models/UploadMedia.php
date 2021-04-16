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
    public static function addAttachments($profile_id, $urls, $model_id, $model_type)
    {
        $status = true;
        $attchments = explode(',', $urls);
        $file_urls = [];
        $message = 'Success';
        $code = 200;
        if(!empty($attchments)){
            foreach ($attchments as $key => $item) {
                $file_urls[] = $item;
            }
            if(!empty($file_urls)){
                foreach ($file_urls as $key => $item) {
                    $model = new self();
                    $model->uuid = \Str::uuid();
                    $model->profile_id = $profile_id;
                    $model->path = $item;
                    $model->type = $model_type;
                    $model->type = $model_type;
                    $model->ref_id = $model_id;
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
