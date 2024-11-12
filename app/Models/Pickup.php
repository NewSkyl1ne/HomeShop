<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    protected $fillable = ['location','shipping_charge'];
    public $timestamps = false;
}
