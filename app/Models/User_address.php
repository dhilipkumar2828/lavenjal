<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_address extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="user_addresses";
    protected $fillable = ['user_id','full_name','address','city','state','zip_code','lat','lang','is_default','is_lift','door_no','flat_no','floor_no','phone_number','address_type','full_address','status','created_at','updated_at','deleted_at'];
}
