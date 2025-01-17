<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticate
{
    use Notifiable;
    
    protected $fillable = [
        'password',
        'username'
    ];
}
