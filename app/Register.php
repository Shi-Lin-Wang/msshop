<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    //
    protected $connections = 'wtlab108';
    protected $table = 'account';
    protected $fillable = [
        'account', 'password','email','phone',
    ];
}
