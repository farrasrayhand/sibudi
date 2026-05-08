<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guestbook extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'organization',
        'visit_date',
        'message',
        'photo',
        'status',
    ];
}
