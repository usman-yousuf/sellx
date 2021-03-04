<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocalisationSetting extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $with = ['currency', 'country', 'language'];

    use SoftDeletes;

    public function currency()
    {
        return $this->belongsTo('\App\Models\Currency', 'currency_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('\App\Models\Country', 'country_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo('\App\Models\Language', 'language_id', 'id');
    }

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
        if(isset($request->country_id)){
            $model->country_id = $request->country_id;
        }
        if(isset($request->currency_id)){
            $model->currency_id = $request->currency_id;
        }
        if(isset($request->language_id)){
            $model->language_id = $request->language_id;
        }
        if(isset($request->anonymity)) {
            $model->is_anonymity = $request->anonymity;
        }

        try{
            $model->save();
            $model = self::find($model->id);
            return getInternalSuccessResponse($model);
        }
        catch(\Exception $ex){
            // dd($ex->getMessage());
            return getInternalErrorResponse($ex->getMessage(), [], $ex->getCode());
        }
    }
}
