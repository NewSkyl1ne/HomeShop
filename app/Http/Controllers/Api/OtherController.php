<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class OtherController extends Controller
{
    public function getAllCitys()
    {
    	
    	$list               =   DB::table('pickups')->get();
    	if( count($list) > 0 ){
    		$citylis_Ar 	=	[];
    		$i 				=	0;
    		foreach ($list as $key => $value) {
    			$citylis_Ar[$i]['id']  = $value->id;
    			$citylis_Ar[$i]['city']  = $value->location;
    			$i++;
    		}
    		$response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Successfully list.'; 
            $response['data']    	=   $citylis_Ar;   
            return response()->json(['success'=>$response]);
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'No data found !' ;
            return response()->json(['success'=>$response]);
    	}
    }	
    public function deliveryTime()
    {
    	$list               =   DB::table('delivery_time')->get();
    	if( count($list) > 0 ){
    		$delivery_time_Ar 	=	[];
    		$i 				=	0;
    		foreach ($list as $key => $value) {
    			$delivery_time_Ar[$i]['id']  = $value->id;
    			$delivery_time_Ar[$i]['time']  = $value->time;
    			$i++;
    		}
    		$response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Successfully list.'; 
            $response['data']    	=   $delivery_time_Ar;   
            return response()->json(['success'=>$response]);
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'No data found !' ;
            return response()->json(['success'=>$response]);
    	}
    }
}
