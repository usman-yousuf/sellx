<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Address extends Model
{
    use HasFactory, Notifiable;

    protected $with = ['countryInfo'];

    // get address profile
    public function profile()
    {
        return $this->belongsTo('App\Models\Profile', 'profile_id', 'id');
    }

    // get profile country
    public function countryInfo()
    {
        return $this->belongsTo('App\Models\Country', 'country', 'id');
    }

    /**
     * Add|Update Profile Address
     *
     * @param Request $request
     * @param Integer $profile_id
     *
     * @return void
     */
    public static function addUpdateAddress(Request $request, $profile_id = null)
    {
        if(isset($request->address) && !empty($request->address)){
            $model = self::where('uuid', $request->address)->first();
            $model->updated_at = date('Y-m-d H:i:s');
        }
        else{
            $model = new self();
            $model->uuid = \Str::uuid();
            $model->created_at = date('Y-m-d H:i:s');
            $model->profile_id = $profile_id;
        }

        $model->reciever_name = $request->reciever_name;
        $model->phone_code = $request->phone_code;
        $model->phone_number = $request->phone_number;

        $model->address1 = $request->address1;
        $model->address2 = $request->address2;
        $model->zip = $request->zip;
        $model->city = $request->city;
        $model->state = $request->state;
        $model->country = $request->country;
        $model->latitude = $request->latitude;
        $model->longitude = $request->longitude;

        $model->default = $request->default;

        try{
            $model->save();
            // $model = self::where('id', $model->id)->first();
            return getInternalSuccessResponse($model);
        }
        catch(\Exception $ex){
            return getInternalErrorResponse($ex->getMessage(), [],  $ex->getCode());
        }
    }
}
