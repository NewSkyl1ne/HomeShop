<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['photo','link','platform_type','app_slug','page','type'];
    public $timestamps = false;
}
