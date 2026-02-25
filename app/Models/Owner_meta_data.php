<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
class Owner_meta_data extends Model
{
    use HasFactory;
     use SoftDeletes;
    protected $table ='owners_meta_data';
    protected $fillable =['user_id','user_type','name_of_shop','nature_of_shop','ownership_type','name_of_owner','owner_contact_no','owner_email','full_address','pincode','aadhar_number','landmark','area_sqft','lat','lang','storage_capacity','selling_jars_weekly','twenty_ltres_sold_now','pet_bottle_sold_now','delivery_type','no_of_delivery_boys','gst_no','gst_certificate','govt_certificate','shop_photo','additional_info','agreement_date','shop_started_at','assigned_distributor','assign_sales_rep','status','delivery_range','deleted_at'];



}


