<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'countries';


    // public function profiles()
    // {
    //     return $this->hasMany('\App\Models\Profile', 'id', 'profile_id');
    // }
}
