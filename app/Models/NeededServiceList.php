<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeededServiceList extends Model
{
    use HasFactory;
    protected $table="needed_servicelist";
    protected $guarded = [];
}
