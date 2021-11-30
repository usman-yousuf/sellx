<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Sold;
use App\Models\Profile;
use App\Models\Defaulter;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class DefalterList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'defalter:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Defaulter to list';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $defaulter_ids = Sold::orderBy('created_at', 'DESC')->where('status','on_hold')->where('created_at','<=',Carbon::now()->subDays(env("sub_days")))->pluck('profile_id')->toArray();

        Sold::orderBy('created_at', 'DESC')->where('status','on_hold')->where('created_at','<=',Carbon::now()->subDays(7))->delete();

        foreach($defaulter_ids as $defaulter_profile_id) {

            Profile::where('id',$defaulter_profile_id)->update([
                'deposit' => 0,
                'max_bid_limit' => 0,
            ]);

            $defaulter = Defaulter::where('profile_id', $defaulter_profile_id)->first();

            if(NULL == $defaulter){
                $defaulter                     = new Defaulter();
                $defaulter->uuid               = Str::uuid();
                $defaulter->profile_id         = $defaulter_profile_id;
                $defaulter->penalty_percentage = 4;
            }
            else{
                $defaulter->penalty_percentage = (int) $defaulter->penalty_percentage * 2;
            }
            
            $defaulter->save();
        }
    }
}
