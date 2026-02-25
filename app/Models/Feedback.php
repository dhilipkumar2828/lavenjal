<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\MostLike;
class Feedback extends Model
{
    use HasFactory;
    protected $table="feedback";
    protected $guarded=[];

public function users(){
    return $this->hasOne(User::class,'id','user_id');
}

public function most_likes(){
    return $this->hasOne(MostLike::class,'id','most_like');
}
}
