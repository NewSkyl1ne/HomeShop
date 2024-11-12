<?php

namespace App\Models\Api;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountModel extends Model
{
    protected $table = 'users';

	public function updateUserInfo($user_id,$data)
	{
	    $userData               =   [];
	    if( $data['name'] != '' ){
	       $userData['name']    =    $data['name'];
	    }
	    if( $data['phone'] != '' ){
	       $userData['phone']    =    $data['phone'];
	    }
	    /*if( $data['email'] != '' ){
	       $userData['email']    =    $data['email'];
	    }*/
	    if( $data['city'] != '' ){
	       $userData['city']    =    $data['city'];
	    }
	    if( $data['building_no'] != '' ){
	       $userData['building_no']    =    $data['building_no'];
	    }
	    if( $data['zone'] != '' ){
	       $userData['zone_no']    =    $data['zone'];
	    }if( $data['street'] != '' ){
	       $userData['street_no']    =    $data['street'];
	    }
	    if( @$data['photo'] != '' ){
	       $userData['photo']    =    $data['photo'];
	    }
	    	DB::table('users')
				->where("id", '=',  $user_id)
				->update($userData);
		/*if( @$data['photo'] == '' ){
			DB::table('users')
				->where("id", '=',  $user_id)
				->update([
					'name'=> $data['name'],
					'phone'=> $data['phone'],
					'email'=> $data['email'],
					'city'=> $data['city'],
					'building_no'=> $data['building_no'],
					'zone_no'=> $data['zone'],
					'street_no'=> $data['street'],
				]);
		}else{
			DB::table('users')
				->where("id", '=',  $user_id)
				->update(['name'=> $data['name'],
					'phone'=> $data['phone'],
					'email'=> $data['email'],
					'city'=> $data['city'],
					'building_no'=> $data['building_no'],
					'zone_no'=> $data['zone'],
					'street_no'=> $data['street'],
					'photo'=>$data['photo'] 
				]);	
		}*/
		return true;
	}
    /*public function checkOldPassword($user_id,$password)
    {
    	
    	$all = 	DB::table('users')->where('id', $user_id)->where('password', bcrypt($password))->first();
    	print_r(DB::getQueryLog());
    	print_r($all);
    }*/
}
