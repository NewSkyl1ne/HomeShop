<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Generalsetting;
use App\Models\Currency;
use Illuminate\Support\Facades\Session;

class Shops extends Model
{
	public $table = 'shop_details';

    protected $fillable = ['user_id','name', 'owner_name', 'number', 'building_no', 'zone_no', 'street_no','city','address', 'registration_number', 'created_date'];


}