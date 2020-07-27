<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Errors extends Model
{
    protected $fillable = [
        'page',
        'error_code',
        'error_message',
        'ip',
    ];
}
