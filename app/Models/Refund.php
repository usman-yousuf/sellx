<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'refunds';

    protected $fillable = [
        'uuid',
        'profile_id',
        'refund_amount',
        'name',
        'iban',
        'swift_code',
        'branch_code',
        'branch_address',
        'country',
        'city',
    ];

    use SoftDeletes;
}