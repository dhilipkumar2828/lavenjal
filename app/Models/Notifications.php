<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table="notifications";
    protected $fillable = ['user_id','order_id','status','message','type','removed_user'];
}
