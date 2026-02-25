<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Sales_rep extends Authenticatable
{
    use HasFactory,Notifiable;
    protected $guard="salesreps";
    protected $fillable = ['name','phone','email','image','password','type','status'];
}
