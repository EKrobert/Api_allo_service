<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticate
{
    use HasFactory, Notifiable, HasApiTokens ;
    protected $guard = 'admin';
    protected $table = 'admin'; 
    protected $fillable = [
        'password',
        'username'
    ];
}
