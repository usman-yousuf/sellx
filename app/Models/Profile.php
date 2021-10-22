<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;



class Profile extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'profiles';


    protected $fillable = [
        'max_bid_limit',
    ];

    use SoftDeletes;
    protected $with = ['defaultAddress'];
    protected $appends = [
        'is_followed',
        'followers_count',
        'following_count',
        'average_rating',
        'total_ratings_count',
        'is_online',
        'deposit',
    ];

    protected $withCount = ['auction','comingauctions','totalsolds','pendingsolds'];

    public function getIsOnlineAttribute(){

        return Auction::Where('auctioneer_id',$this->id)->where('is_live',1)->count()?1:0;
    }

    public function getTotalRatingsCountAttribute(){
        if(\Auth::check()){
            if(null != \Auth::user()->active_profile_id){
                $res = \DB::select("SELECT count(*) as total_ratings FROM `reviews` where receiver_profile_id = ".\Auth::user()->active_profile_id);
                if($res[0]){
                    return (int)$res[0]->total_ratings;
                }
            }
        }
        return 0;
    }

    public function getAverageRatingAttribute(){
        if(\Auth::check()){
            if(null != \Auth::user()->active_profile_id){
                $res = \DB::select("SELECT count(*) as total_ratings, sum(rating) as average_rating FROM `reviews` where receiver_profile_id = ".\Auth::user()->active_profile_id);
                if($res[0]){
                    if($res[0]->total_ratings){
                        return (double)$res[0]->average_rating/(int)$res[0]->total_ratings;
                    }
                }
            }
        }
        return 0;

    }
    public function getDepositAttribute(){
        return 100000;

    }

    function getFollowersCountAttribute(){
        if(app('request')->user() != null){
            $profile_id = (app('request')->profile_id != null) ? app('request')->profile_id : app('request')->user()->active_profile_id;
            if($profile_id != null){
                $res1 = \DB::select("SELECT COUNT( DISTINCT (following_id)) AS follower_count FROM `followers` WHERE profile_id = ? ", [$profile_id]);
                if($res1[0] != null){
                    return $res1[0]->follower_count;
                }
            }
        }
        return 0;
    }

    function getFollowingCountAttribute(){
        if (app('request')->user() != null) {
            $profile_id = (app('request')->profile_id != null) ? app('request')->profile_id : app('request')->user()->active_profile_id;
            if($profile_id != null){
                $res1 = \DB::select("SELECT COUNT( DISTINCT (profile_id)) AS following_count FROM `followers` WHERE following_id = ?", [$profile_id]);
                if ($res1[0] != null) {
                return $res1[0]->following_count;
                }
            }
        }
        return 0;
    }

    use SoftDeletes;

    public function getIsFollowedAttribute(){
        $request = app('request');
        if($request->user()){
            if(null != $request->user()->active_profile_id){
                $res = \DB::select("SELECT count(*) as is_followed FROM `followers` where profile_id = ".$this->id." and following_id = ".$request->user()->active_profile_id);
                if(null != $res){
                    return (int)$res[0]->is_followed;
                }
            }
        }
        return 0;
    }

    function getTotalSoldsAttribute(){
      return  \DB::select(" SELECT s.* FROM solds AS s INNER JOIN ( auctions AS Auct INNER JOIN profiles AS Auctioneer ON Auct.auctioneer_id = Auctioneer.id ) ON s.auction_id = Auct.id WHERE Auctioneer.id = ".$this->id." ");
    }

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
        return $this->hasMany('\App\Models\Address', 'profile_id', 'id')->where('is_default', 1);
    }

    // Get all of the categories for the profile.
    public function categories()
    {
        return $this->belongsToMany('\App\Models\Category', 'profile_categories');
    }

    public function attachments()
    {
        return $this->hasMany('\App\Models\UploadMedia', 'profile_id', 'id');
    }

    public function LocalisationSetting()
    {
        return $this->hasOne('\App\Models\LocalisationSetting', 'profile_id', 'id');
    }
    public function notificationpermissions()
    {
        return $this->hasOne('\App\Models\NotificationPermission', 'profile_id', 'id');
    }

    public function biddings()
    {
        return $this->hasMany(Bidding::class, 'profile_id', 'id');
    }

    public function viewers()
    {
        return $this->hasMany(Viewer::class, 'profile_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'profile_id', 'id');
    }

    public function blocks()
    {
        return $this->hasMany(Block::class, 'ref_id', 'id')->where('ref_type', 'user');
    }

    public function chat()
    {
        return $this->hasMany(Chat::class, 'member_id', 'id');
    }

    public function stories()
    {
        return $this->hasMany(Story::class, 'profile_id', 'id');
    }

    public function auction()
    {
        return $this->hasMany(Auction::class, 'auctioneer_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'profile_id', 'id')->without('profile');
    }

    public function totalsolds()
    {
        return $this->hasMany(Auction::class, 'auctioneer_id', 'id')->whereHas('solds')->with('solds');
    }

    public function pendingsolds()
    {
        return $this->hasMany(Auction::class, 'auctioneer_id', 'id')->whereHas('solds')->with('solds')->where('status','pending');
    }

    public function comingauctions()
    {
        return $this->hasMany(Auction::class, 'auctioneer_id', 'id')->where('scheduled_date_time','>=',Carbon::now())->with('auction');
    }
    /**
     * Do something based on events of this model
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        // create notification_permission and localisation records
        static::created(function (Profile $model) {
            $temp = new LocalisationSetting();
                $temp->profile_id = $model->id;
                $temp->created_at = date('Y-m-d H:i:s');
            $temp->save();

            $temp = new NotificationPermission();
                $temp->profile_id = $model->id;
                $temp->created_at = date('Y-m-d H:i:s');
            $temp->save();

            if($model->profile_type == 'auctioneer'){

            }
        });
    }

    /**
     * Add|update an Auctioneer
     *
     * @param Request $request
     * @return void
     */
    public static function addUpdateAuctioneer($request)
    {
        $model = self::where('profile_type', 'auctioneer')->where('user_id', $request->user()->id)->first();
        if(null == $model){
            $model = new self();
            $model->profile_type = 'auctioneer';
            $model->created_at = date('Y-m-d H:i:s');
            $model->uuid = \Str::uuid();
            $model->user_id = $request->user()->id;
        }
        else{
            $model->updated_at = date('Y-m-d H:i:s');
        }

        $model->is_online = true;
        $model->is_approved = false;
        $model->auction_house_name = $request->auction_house_name;

        try{
            $model->save();

            // save categories in db
            $categories = $request->product_categories;
            if(!empty($categories))
            {
                $cat_ids = [];
                foreach ($categories as $key => $item) {
                    $itemObj = Category::where('uuid', $item)->first();
                    if(null != $itemObj){
                        $cat_ids[] = $itemObj->id;
                    }
                }

                if(!empty($cat_ids)){
                    $model->categories()->attach($cat_ids, ['created_at'=>date('Y-m-d H:i:s')]);
                }
            }

            // save mode attachments in db
            $attachmentResult = UploadMedia::addAttachments($request->user()->profile->id, $request->attachments, $model->id, 'profile');
            if(!$attachmentResult['status']){
                // dd($attachmentResult);
                return getInternalErrorResponse($attachmentResult['message'], [], $attachmentResult['responseCode']);
            }
            $user = User::where('id', $model->user->id)->first();
            $user->active_profile_id = $model->id;
            $updateResult = $user->save();

            $model = self::where('id', $model->id)->with('user')->first();
            return getInternalSuccessResponse($model);
        }
        catch(\Exception $ex){
            // dd($ex->getMessage());
            return getInternalErrorResponse($ex->getMessage(), [], $ex->getCode());
        }
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
        else if($request->screen_type == 'bid_limit'){
            $model->max_bid_limit = $request->max_bid_limit;
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
        if(isset($request->profile_uuid) && $request->profile_uuid != ''){
            $profile = Profile::where('uuid', $request->profile_uuid)->first();
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

        if(isset($request->first_name) &&  $request->first_name != ''){

            // dd('DumpMan');
            $profile->first_name   = $request->first_name;
        }
        if(isset($request->last_name) &&  $request->last_name != ''){
            $profile->last_name    = $request->last_name;
        }
        if(isset($request->username) &&  $request->username != ''){
            $profile->username     = $request->username;
        }
        if(isset($request->country) &&  $request->country != ''){
            $profile->country      = $request->country;
        }
        if(isset($request->dob) &&  $request->dob != ''){
            $profile->dob          = $request->dob;
        }
        if(isset($request->profile_type) &&  $request->profile_type != ''){
            $profile->profile_type = $request->profile_type;
        }
        if(isset($request->bio) &&  $request->bio != ''){
            $profile->bio          = $request->bio;
        }
        if(isset($request->description) &&  $request->description != ''){
            $profile->description  = $request->description;
        }
        if(isset($request->profile_image) && ('' != $request->profile_image)){
            $profile->profile_image = $request->profile_image;
        }
        if (isset($request->auction_house_logo) && ('' != $request->auction_house_logo)) {
            $profile->auction_house_logo = $request->auction_house_logo;
        }
        try{
            $profile->save();
            User::where('id', $profile->user_id)->update(['active_profile_id' =>$profile->id]); // update active profile

            $model = Profile::where('id', $profile->id)->with('user')->first();
            return $model;
        }
        catch(\Exception $ex){
            // dd($ex->getMessage());
            return false;
        }
    }


}
