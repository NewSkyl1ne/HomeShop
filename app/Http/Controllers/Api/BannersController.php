<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\BannersModel;
use Auth;
use DB;
use Validator;

class BannersController extends Controller
{
    public function getBanners(Request $request)
    { 
    	$banners 						= 	DB::table('sliders')->get();//->where('type','Large')
    	if( isset($banners) ){
    		$banner 					=		[];
    		$i 							=		0;
    		foreach ($banners as $key => $value) { $i++;
    			$banner[$i]['id'] 		     =	$value->id;
                $banner[$i]['title_text']    =   $value->title_text;  
    			$banner[$i]['subtitle_text'] =	$value->subtitle_text;  
                $banner[$i]['photo']        =   'assets/images/sliders/'.$value->photo;  

    		}
            $banner = array_values($banner);
    		$response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Successfully Executed ';
            $response['data']		=	$banner;   	
            return response()->json(['success'=>$response]);	
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Data not found' ;
            return response()->json(['success'=>$response]);
    	}
    }
    public function getSubBanners(Request $request)
    { 
    	$banners 						= 	DB::table('banners')->where('platform_type','2')->get();
    	if( isset($banners) ){
    		$banner 					=	[];
    		$i 							=	0;
    		foreach ($banners as $key => $value) { $i++;
    			$banner[$i]['id'] 		=	$value->id;
    			$banner[$i]['photo'] 	=	'assets/images/banners/'.$value->photo;
                $banner[$i]['slug']     =   $value->app_slug;
    		}	
            $banner = array_values($banner); 
    		$response               =   array();
            $response['status']     =   200;
            $response['message']    =   'Successfully Executed ';
            $response['data']		=	$banner;   	
            return response()->json(['success'=>$response]);	
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Data not found' ;
            return response()->json(['success'=>$response]);
    	}
    }
}
