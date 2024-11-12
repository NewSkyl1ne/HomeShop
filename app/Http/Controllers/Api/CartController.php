<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\CartModel;
use Auth;
use DB;
use Validator;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
    	$validator 				= 	Validator::make($request->all(), [
            'product_id' 		=> 	'required',
            'quantity'			=>	'required'
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
    			$product_id 		=	$input['product_id'];
    			$qty 				=	$input['quantity'];
    			// need to check product is there or not
    			// pending
    			$prev 				=	DB::table('cart')
    									->where('product_id','=',$input['product_id'])
    									->where('user_id','=',$user_id)
    									->get()->first();
    			if( isset($prev) ){
    				$response               =   array();
		            $response['status']     =   400;
		            $response['message']    =   'Product was already in your Inventory !' ;
		            return response()->json(['success'=>$response]);
    			}
    			$products 			= 	DB::table('products')
    									->where('id','=',$input['product_id'])
    									->get()->first();    			
    			$cart 				= 	new CartModel;
    			$cart['user_id']	=	$user_id;
    			$cart['product_id']	=	$input['product_id'];
    			$cart['qty']		=	$input['quantity'];
    			$price 				= 	$products->price * $input['quantity'];
    			$cart['price']		=	$products->price;
    			$cart->save();
    			$response               =   array();
		        $response['status']     =   200;
		        $response['message']    =   'Successfully Added To Inventory.';		        
		        return response()->json(['success'=>$response]);
    		}else{
                $response               =   array();
                $response['status']     =   400;
                $response['message']    =   'Token not found !' ;
                return response()->json(['success'=>$response]);
            }
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Token not found !' ;
            return response()->json(['success'=>$response]);
    	}
    }
    public function listCart( Request $request )
    {
    	$headerValue 				=   array_change_key_case(getallheaders(),CASE_LOWER);
    	$token 						=	@$headerValue['token'];
    	if( $token != '' ){
    		$user 					=	$this->checkToken($token);
    		if( isset($user)){
    			$user_id 			=	$user->id;
    			$cartList 			=	DB::table('cart')
    									->where('user_id','=',$user_id)
    									->get();
				if( isset($cartList) ) {
					$cartData 		=	[];
					$i 				=	0;
					$t_sub_total 	=	0;
					foreach ($cartList as $key => $value) { 
						$cartData[$i]['cart_id']		=	$value->id;
						$cartData[$i]['product_id']		=	$value->product_id;
						$products 					= 	DB::table('products')
					    									->where('id','=',$value->product_id)
					    									->get()->first();   
						$cartData[$i]['product_name']		=	$products->name;
						$cartData[$i]['product_photo']		=	'assets/images/products/'.$products->photo;
						$cartData[$i]['quantity']		=	$value->qty;
						$cartData[$i]['unit_price']		=	$products->price;
						$sub_total  				=	$products->price * $value->qty;
						$cartData[$i]['sub_total']		=	$sub_total;
						$t_sub_total 					=	$t_sub_total+$sub_total;
						$i++;
					}
					$priceDetails 						=	[];
					
					$priceDetails['discount']			=	0;
					/*$generalsettings 							= 	DB::table('generalsettings')
					    									->where('id','=','1')
					    									->get()->first(); 
					$tax 								=	$generalsettings->tax;
					$priceDetails['tax'] 				=	$tax;*/
					$total 								=	$t_sub_total;//(($t_sub_total*$tax)/100)+$t_sub_total;
					$priceDetails['total'] 				=	$total;
                    $shippin_amnount                    =   DB::table('pickups')->where('id','=',$user->city)->get()->first();
                    if( isset($shippin_amnount->shipping_charge) ){
                        $priceDetails['shipping_amount']    =   $shippin_amnount->shipping_charge;
                        $priceDetails['total_mrp']          =   $t_sub_total+$shippin_amnount->shipping_charge;
                    }else{
                        $priceDetails['shipping_amount']    =   "0";
                        $priceDetails['total_mrp']          =   $t_sub_total;
                    }
                    $last_order = DB::table('orders')->where('user_id',$user_id)->orderBy('id','DESC')->get()->first();
                    //echo $user_id;
                    $map_details                        =   [];
                    if( @$last_order->id != '' ){
                        if( $last_order->map_lat == "" ){
                            $map_details['lat']                 =   '25.2839926';
                            $map_details['long']                =   '51.4419567';  
                        }else{
                            $map_details['lat']                 =   $last_order->map_lat;
                            $map_details['long']                =   $last_order->map_long;    
                        } 
                    }else{
                        $map_details['lat']                 =   '25.2839926';
                        $map_details['long']                =   '51.4419567';  
                    }
					$response               =   array();
			        $response['status']     =   200;
			        $response['message']    =   'Successfully Executed ';
			        $response['data']['cart_list']		    =	$cartData;   	
			        $response['data']['price_details']		=	$priceDetails;   
			        $response['data']['map_details']		=	$map_details;   
			        return response()->json(['success'=>$response]);
				}else{
					$response               =   array();
		            $response['status']     =   400;
		            $response['message']    =   'Data not found' ;
		            return response()->json(['success'=>$response]);
				}						
    		}else{
                $response               =   array();
                $response['status']     =   400;
                $response['message']    =   'Token not found !' ;
                return response()->json(['success'=>$response]);
            }
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Token not found !' ;
            return response()->json(['success'=>$response]);
    	}
    }
    public function updateQuantity( Request $request )
    {
    	$validator 				= 	Validator::make($request->all(), [
            'cart_id' 			=> 	'required',
            'quantity'			=>	'required'
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
    			$cartData 			=	DB::table('cart')
	    									->where('id','=',$input['cart_id'])
	    									->get()->first();
	    		if( !isset($cartData)){
	    			return response()->json(['success'=>[ 0 => 'Product was not found in your Inventory list.' ]], 400);
	    		}
    			$products 			= 	DB::table('products')
	    									->where('id','=',$cartData->product_id)
	    									->get()->first(); 
	    		if( !isset($products)){
	    			return response()->json(['success'=>[ 0 => 'Product was not found in our list.' ]], 400);
	    		}
	    		$price 				=	$products->price * $input['quantity'];
    			DB::table('cart')
    								->where('id', $input['cart_id'])
    								->update(
								        [	'qty' => $input['quantity'],
								        	'price' => $price ,
								        	'updated_at' => date('Y-m-d H:i:s') ]
								    );
				$response               =   array();
		        $response['status']     =   200;
		        $response['message']    =   'Successfully update Inventory Product Quantity.';		        
		        return response()->json(['success'=>$response]);
    		}else{
                $response               =   array();
                $response['status']     =   400;
                $response['message']    =   'Token not found !' ;
                return response()->json(['success'=>$response]);
            }
    	}else{
    		$response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Token not found !' ;
            return response()->json(['success'=>$response]);
    	}
    }
    public function removeCart( Request $request )
    {
        $validator              =   Validator::make($request->all(), [
            'cart_id'           =>  'required'
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        }
        $headerValue                =   array_change_key_case(getallheaders(),CASE_LOWER);
        $token                      =   @$headerValue['token'];
        if( $token != '' ){
            $user                   =   $this->checkToken($token);
            if( isset($user)){
                $user_id            =   $user->id;
                $input              =   $request->all();
                $cart               =   DB::table('cart')
                                            ->where('user_id','=',$user_id)
                                            ->where('id','=',$input['cart_id'])
                                            ->get()->first();
                if( @$cart->id != ''){
                    DB::table('cart')->where('user_id', '=', $user_id)->where('id', '=',$input['cart_id'])->delete(); 
                    $response               =   array();
                    $response['status']     =   200;
                    $response['message']    =   'Product Successfully removed from your Inventory.';               
                    return response()->json(['success'=>$response]);     
                }else{
                    $response               =   array();
                    $response['status']     =   400;
                    $response['message']    =   'Product Not found in your Inventory !' ;
                    return response()->json(['success'=>$response]);
                }
            }else{
                $response               =   array();
                $response['status']     =   400;
                $response['message']    =   'Token not found !' ;
                return response()->json(['success'=>$response]);
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
