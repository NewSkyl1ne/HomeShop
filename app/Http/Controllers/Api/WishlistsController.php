<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\WishlistsModel;
use Auth;
use DB;
use Validator;

class WishlistsController extends Controller
{
    public function addWishlists(Request $request)
    {
    	$validator 				= 	Validator::make($request->all(), [
            'product_id' 			=> 	'required'
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        }
        $headerValue 				=   array_change_key_case(getallheaders(),CASE_LOWER);
    	$token 						=	@$headerValue['token'];
    	if( $token != '' ){
    		$user 					=	$this->checkToken($token);
    		if( isset($user)){
    			$user_id 			=	$user->id;
    			$input 				=	$request->all();
    			$prev 				= 	DB::table('wishlists')
    									->where('product_id','=',$input['product_id'])
    									->where('user_id','=',$user_id)
    									->get()->first();
	            if(@$prev->id != '')
	            { 

                    DB::table('wishlists')->where('id', '=', $prev->id)
                    ->where('product_id','=',$input['product_id'])
                    ->where('user_id','=',$user_id)
                    ->delete();
	            	$response               =   array();
                    $response['status']     =   200;
                    $response['message']    =   'Product Successfully remove from your Favorites List .';              
                    return response()->json(['success'=>$response]);              
	            }else{ 
    	            $Wishlists 				= 	new WishlistsModel;
    	            $Wishlists['user_id'] 		=	$user_id;
    	            $Wishlists['product_id'] 	=	$input['product_id'];
    	            $Wishlists->save();
    	            $response               =   array();
    		        $response['status']     =   200;
    		        $response['message']    =   'Product listed in your Favorites List .';		        
    		        return response()->json(['success'=>$response]);
                }
        	}
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Token not found !' ;
            return response()->json(['success'=>$response]);
    	}
    }
    public function wishlists($value='')
    {
    	$headerValue 				=   array_change_key_case(getallheaders(),CASE_LOWER);
    	$token 						=	@$headerValue['token'];
    	if( $token != '' ){
    		$user 					=	$this->checkToken($token);
    		if( isset($user)){
    			$user_id 			=	$user->id;
    			$products 				= 	DB::table('wishlists')
    									->select('products.*')
    									->join('products', 'products.id', '=', 'wishlists.product_id')
    									->where('wishlists.user_id','=',$user_id)
    									->get();
    			if( isset($products) ){
		        	$products_arr 			=	[];
		        	$i 						=	0;
		        	foreach ($products as $key => $value) {
		                $products_arr[$i]['id']     =   $value->id;
		        		$products_arr[$i]['name']	=	$value->name;
		        		$products_arr[$i]['slug']	=	$value->slug;
		        		$products_arr[$i]['price']	=	$value->price;
		        		$products_arr[$i]['photo']	=	'assets/images/products/'.$value->photo;
		        		$i++;
		        	}
		        	$response               =   array();
			        $response['status']     =   200;
			        $response['message']    =   'Successfully Executed ';
			        $response['data']		=	$products_arr;   	
			        return response()->json(['success'=>$response]);
		        }else{
		        	$response               =   array();
		            $response['status']     =   400;
		            $response['message']    =   'Data not found' ;
		            return response()->json(['success'=>$response]);
		        }
    		}
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Token not found !' ;
            return response()->json(['success'=>$response]);
    	}
    }
    public function checkToken( $token =	'' )
    {
    	if( $token == '' ){
    		return false;
    	}
    	$all 						= 	DB::table('users')->where('app_token', $token)->first();
    	return $all;
    }
}
