<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\CheckoutModel;
use Auth;
use DB;
use Validator;
use App\Models\Generalsetting;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request)
    {
        /* $validator 				= 	Validator::make($request->all(), [
            'shipping_name' => 'required',
            'shipping_phone' => 'required',
            'shipping_email'     => 'required', 
            'shipping_address' => 'required',
            'shipping_city' => 'required',
            'shipping_building_no' => 'required',
            'shipping_zone' => 'required',
            'shipping_street' => 'required',
            'delivery_time' => 'required',
            'payment_method' => 'required'
        ]);
        if ($validator->fails()) {
            $response               =   array();
            $response['status']     =   400;
            $response['message']    =   'Required files are cannot be null';  
            return response()->json(['success'=>$response]);
        } */
        $headerValue 				=   array_change_key_case(getallheaders(),CASE_LOWER);
    	$token 						=	@$headerValue['token'];
    	if( $token != '' ){
    		$user 					=	$this->checkToken($token);
    		if( isset($user)){
    			$user_id 			=	$user->id;
    			$input              =   $request->all();
    			$userData           =   [];
                if( @$input['billing_name'] != '')
                    $userData['name']         =   $input['billing_name'];

                if( @$input['billing_phone'] != '')
                    $userData['phone']        =   $input['billing_phone'];

                if( @$input['billing_email'] != '')
                    $userData['email']        =   $input['billing_email'];

                if( @$input['billing_address'] != '')
                    $userData['address']      =   $input['billing_address'];

                if( @$input['billing_city'] != '')
                    $userData['city']         =   @$input['billing_city'];

                if( @$input['billing_building_no'] != '')
                    $userData['building_no']  =   @$input['billing_building_no'];

                if( @$input['billing_zone'] != '')
                    $userData['zone_no']      =   @$input['billing_zone'];
                if( @$input['billing_street'] != '')
                    $userData['street_no']    =   @$input['billing_street'];
                if( count(@$userData)>0 ){
                    DB::table('users')->where('id',$user_id)->update($userData);
                }
                //$input['deleveryTime']   =   @$input['deleveryTime'];
                $input['disclaimer']     =   @$input['disclaimer'];
                $input['lat']            =   @$input['lat'];
                $input['long']           =   @$input['long'];
                $user 					        =	$this->checkToken($token);
                $cart                           =   DB::table('cart')
                                                        ->where('user_id','=',$user_id)
                                                        ->get();
                if( count($cart) > 0 ){
                    $totl_price                 =   0;
                    $totalQty                   =   0;
                    $order_number       =   str_random(4).time();
                    foreach ($cart as $key => $value) {
                        $totl_price     =   $totl_price + ($value->price*$value->qty);
                        $totalQty       =   $totalQty + $value->qty;
                        DB::table('order_products')->insert(
                                [
                                    'order_number'  => $order_number, 
                                    'product_id'    => $value->product_id,
                                    'qty'           => $value->qty,
                                    'price'         => $value->price,
                                    'updated_at'    => date('Y-m-d H:i:s')  ,
                                    'created_at'    => date('Y-m-d H:i:s')
                                ]
                            );
                        }
                    
                    $shipping_change                =   DB::table('pickups')->where('id','=',$input['shipping_city'])->get()->first();   
                    $shipping_charge                =   @$shipping_change->shipping_charge;
                    if(isset($shipping_charge) && $shipping_charge > 0 ){
                        $totalQty                   =   $totalQty + $shipping_charge;
                    }

        		    
                    
                    $order               =   new CheckoutModel;
                    $order['order_number']          =   @$order_number;
                    $order['user_id']               =   @$user_id;
                    $order['totalQty']              =   @$totalQty;
                    $order['pay_amount']            =   @$totl_price;
                    $order['shipping_name']         =   @$input['shipping_name'];
                    $order['shipping_phone']        =   @$input['shipping_phone'];
                    $order['shipping_email']        =   @$input['shipping_email'];
                    $order['shipping_address']      =   @$input['shipping_address'];
                    $order['shipping_city']         =   @$input['shipping_city'];
                    $order['shipping_building_no']  =   @$input['shipping_building_no'];
                    $order['shipping_zone_no']      =   @$input['shipping_zone'];
                    $order['shipping_street_no']    =   @$input['shipping_street'];
                    $order['shipping_zip']          =   @$input['shipping_zip'];
                    if($input['payement_type']=='2'){
                        $order['method']                =   'Payment by Card';
                    }else{
                        $order['method']                =   'Cash On Delivery';
                    }
                    //$order['method']                =   $input['payment_method'];
                    $order['shipping']              =   'shipto';
                    $order['customer_email']        =   @$user->email;
                    $order['customer_name']         =   @$user->name;
                    $order['customer_country']      =   0;
                    $order['customer_phone']        =   @$user->phone;
                    $order['customer_address']      =   @$user->address;
                    $order['customer_city']         =   @$user->city;
                    $order['customer_building_no']  =   @$user->building_no;
                    $order['customer_zone_no']      =   @$user->zone_no;
                    $order['customer_street_no']    =   @$user->street_no;
                    $order['customer_zip']          =   @$user->zip;
                    $order['tax']                   =   0;
                    $order['shipping_cost']         =   0;
                    $order['order_note']            =   0;
                    $order['coupon_code']           =   0;
                    $order['coupon_discount']       =   0;
                    $order['dp']                    =   0;
                    $order['payment_status']        =   "Pending";
                    $order['currency_sign']         =   '₹'; //$curr->sign;
                    $order['currency_value']        =   0; //$curr->value;*/
                    $order['delivery_time']         =   @$input['delivery_time'];
                    $order['disclaimer']            =   @$input['disclaimer'];
                    $order['map_lat']               =   @$input['lat'];
                    $order['map_long']              =   @$input['long'];
                    $order->save();
                    $lastid                         =   $order->id;
                    $order_id                       =   $lastid;
                    
                    if($input['payement_type']!='2'){
                        // Order Placed Mail
                        $gs                             =    Generalsetting::findOrFail(1);
                        $to                             =   $user->email;
                        $subject                        =   "Your Order Placed!!";
                        $msg                            =   "Hello ".$user->name."!\nYou have placed a new order. Please wait for your delivery. \nThank you.";
                        $headers                        =   "From: ".$gs->from_name."<".$gs->from_email.">";
                        mail($to,$subject,$msg,$headers); 
                        // End mail 
                         DB::table('cart')->where('user_id', '=', $user_id)->delete();  

                        $response               =   array();
                        $response['status']     =   200;
                        $response['message']    =   'Order successfully placed.';    
                        $response['data']['order_id']    =   $order_number; 

                        return response()->json(['success'=>$response]);
                    }else{
                        // DB::table('cart')->where( 'user_id', '=', $user_id )->delete(); 
                        if($order_id!=''){
                            $order_data                     =   DB::table('orders')->where('id',$order_id)->get()->first();
                            $QPAY_MERCHANT_AUTH_ID          =   'merchant.BATQNB01';
                            $QPAY_MERCHANT_AUTH_PASSWORD    =   '3cfa287f4f35640752ea6c8993a6c3a6';//b9eaada72668d6d686fa77d2e935012b';
                            $QAPY_MERCHANT_ID               =   'BATQNB01';
                            $QAPY_MERCHANT_NAME             =   'BASKET TRADING IPG';
                            $user                           =   DB::table('users')->where('id',$user_id)->get()->first();

                            $post_array                     =   array(
                                                                      "apiOperation"=>"CREATE_CHECKOUT_SESSION", 
                                                                      "interaction"=> array(
                                                                          "operation"=> "PURCHASE"
                                                                      ),
                                                                      "customer"=> array(
                                                                            "email"     => $user->email,
                                                                            "firstName" => str_replace(" ","",$user->name),
                                                                            "lastName"  => str_replace(" ","",$user->name),
                                                                            "phone"     => $user->phone
                                                                        ),
                                                                      "order"=> array(
                                                                          "currency"=> "₹",
                                                                           "id"=> $order_data->order_number ,
                                                                          "amount"=> $order_data->pay_amount
                                                                        )
                                                                    );
                           // print_r($post_array);
                            $post_array                     =   json_encode($post_array);
                            $ch = curl_init();
                            $ch = curl_init('https://ap-gateway.mastercard.com/api/rest/version/56/merchant/BATQNB01/session');                                                                      
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);                                                                  
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                                'Content-Type: application/json',                                                                                
                                'Content-Length: ' . strlen($post_array))                                                                       
                            );    
                            curl_setopt($ch, CURLOPT_USERPWD, $QPAY_MERCHANT_AUTH_ID . ":" . $QPAY_MERCHANT_AUTH_PASSWORD);                                                                                                               
                                                                                                                                                 
                            $result = curl_exec($ch);
                            $result = json_decode($result);
                            $session = @$result->session; 
                            
                            $response               =   array();
                            $response['status']     =   200;
                            $response['url']        =   url('/api/v1/qpay_action_payemnt/'.$order_id.'/'.@$session->id.'/'.$token); 
                            return response()->json(['success'=>$response]);


                            //return response()->json(['url'=> url('/api/v1/qpay_action_payemnt/'.$order_id.'/'.$session->id.'/'.$token) ]);

                        }else{
                            $response               =   array();
                            $response['status']     =   400;
                            $response['message']    =   'Error was found, please try again.'; 
                            return response()->json(['success'=>$response]);
                        }      
                    }
                }else{
                    $response               =   array();
                    $response['status']     =   400;
                    $response['message']    =   'Cart List was empty , please try again.'; 
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
    public function addShippingAddress(Request $request)
    {
        $validator                  =   Validator::make($request->all(), [
            'shipping_name'         => 'required',
            'shipping_phone'        => 'required',
            'shipping_email'        => 'required', 
            'shipping_address'      => 'required',
            'shipping_city_id'      => 'required',
            'building_no'           => 'required',
            'zone'                  => 'required',
            'street'                => 'required',
            'lat'                   => 'required',
            'long'                  => 'required',
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
                $order['user_id']         =   $user_id;
                $order['shipping_name']         =   $input['shipping_name'];
                $order['shipping_phone']        =   $input['shipping_phone'];
                $order['shipping_email']        =   $input['shipping_email'];
                $order['shipping_address']      =   $input['shipping_address'];
                $order['shipping_city']         =   $input['shipping_city_id'];
                $order['shipping_building_no']  =   $input['building_no'];
                $order['shipping_zone_no']      =   $input['zone'];
                $order['shipping_street_no']    =   $input['street'];
                $order['map_lat']               =   $input['lat'];
                $order['map_long']              =   $input['long'];
                $order['created_at']            =   date('Y-m-d H:i:s');
                DB::table('shipping_address')->insert(
                                [
                                    'user_id'           => $order['user_id'], 
                                    'shipping_name'     => $order['shipping_name'],
                                    'shipping_phone'    => $order['shipping_phone'],
                                    'shipping_email'    => $order['shipping_email'],
                                    'shipping_address'  => $order['shipping_address'],
                                    'shipping_city'     => $order['shipping_city'],
                                    'shipping_building_no'=> $order['shipping_building_no'],
                                    'shipping_zone_no'     => $order['shipping_zone_no'],
                                    'shipping_street_no'   => $order['shipping_street_no'],
                                    'map_lat'               =>$order['map_lat'],
                                    'map_long'               =>$order['map_long'],
                                    'created_at'        => date('Y-m-d H:i:s')
                                ]
                            );
                $id = DB::getPdo()->lastInsertId();
                // $data           =   [];
                $data[0]['id'] = (int)$id;
                $data[0]['shipping_name'] = $order['shipping_name'];
                $data[0]['shipping_phone'] = $order['shipping_phone'];
                $data[0]['shipping_email'] = $order['shipping_email'];
                $data[0]['shipping_address'] = $order['shipping_address'];
                $data[0]['shipping_city'] = (int)$order['shipping_city'];
                $data[0]['shipping_building_no'] = $order['shipping_building_no'];
                $data[0]['shipping_zone'] = $order['shipping_zone_no'];
                $data[0]['shipping_street'] = $order['shipping_street_no'];
                $data[0]['lat'] = $order['map_lat'];
                $data[0]['long'] = $order['map_long'];
                $response               =   array();
                $response['status']     =   200;
                $response['message']    =   'Successfully add shipping address.';   
                $response['data']       =   $data;   
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
    public function listShippingAddress(Request $request)
    {
        $headerValue                =   array_change_key_case(getallheaders(),CASE_LOWER);
        $token                      =   @$headerValue['token'];
        if( $token != '' ){
            $user                   =   $this->checkToken($token);
            if( isset($user)){
                $user_id            =   $user->id;
                $list               =   DB::table('shipping_address')
                                            ->where('user_id','=',$user_id)
                                            ->get();
                if( count($list)>0){
                    $data_list      =   [];$i=0;
                    foreach ($list as $key => $value) {
                        $data_list[$i]['id']                =   $value->id;
                        $data_list[$i]['shipping_name']     =   $value->shipping_name;
                        $data_list[$i]['shipping_phone']    =   $value->shipping_phone;
                        $data_list[$i]['shipping_email']    =   $value->shipping_email;
                        $data_list[$i]['shipping_address']  =   $value->shipping_address;
                        $data_list[$i]['shipping_city']     =   $value->shipping_city;
                        $data_list[$i]['shipping_building_no']=   $value->shipping_building_no;
                        $data_list[$i]['shipping_zone']     =   $value->shipping_zone_no;
                        $data_list[$i]['shipping_street']   =   $value->shipping_street_no;
                        $data_list[$i]['lat']               =   @$value->map_lat;
                        $data_list[$i]['long']              =   @$value->map_long;
                        $i++;
                    }
                    $response               =   array();
                    $response['status']     =   200;
                    $response['message']    =   'Successfully list.'; 
                    $response['data']    =   $data_list;   
                    return response()->json(['success'=>$response]);
                }else{
                    $response               =   array();
                    $response['status']     =   400;
                    $response['message']    =   'No data found !' ;
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
    public function editShippingAddress(Request $request)
    {
        $validator              =   Validator::make($request->all(), [
            'address_id'        =>  'required',
            'shipping_name'     => 'required',
            'shipping_phone'    => 'required',
            'shipping_email'    => 'required', 
            'shipping_address'  => 'required',
            'shipping_city_id' => 'required',
            'building_no'           => 'required',
            'zone'                  => 'required',
            'street'                => 'required',
            'lat'                => 'required',
            'long'                => 'required',
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
                $order['user_id']         =   $user_id;
                $order['shipping_name']         =   $input['shipping_name'];
                $order['shipping_phone']        =   $input['shipping_phone'];
                $order['shipping_email']        =   $input['shipping_email'];
                $order['shipping_address']      =   $input['shipping_address'];
                $order['shipping_city']      =   $input['shipping_city_id'];
                $order['shipping_building_no']  =   $input['building_no'];
                $order['shipping_zone_no']      =   $input['zone'];
                $order['shipping_street_no']    =   $input['street'];
                $order['created_at']            =   date('Y-m-d H:i:s');
                DB::table('shipping_address')->where('id','=',$input['address_id'])->update(
                                [
                                    'user_id'           => $order['user_id'], 
                                    'shipping_name'     => $order['shipping_name'],
                                    'shipping_phone'    => $order['shipping_phone'],
                                    'shipping_email'    => $order['shipping_email'],
                                    'shipping_address'  => $order['shipping_address'],
                                    'shipping_city'     => $order['shipping_city'],
                                    'shipping_building_no'=> $order['shipping_building_no'],
                                    'shipping_zone_no'     => $order['shipping_zone_no'],
                                    'shipping_street_no'   => $order['shipping_street_no'],
                                    'map_lat'           => $input['lat'],
                                    'map_long'          => $input['long'],
                                    'created_at'        => date('Y-m-d H:i:s')
                                ]
                            );
                $response               =   array();
                $response['status']     =   200;
                $response['message']    =   'Successfully update shipping address.';   
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
    public function deleteShippingAddress(Request $request)
    {
        $validator              =   Validator::make($request->all(), [
            'address_id'        =>  'required'
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
                DB::table('shipping_address')->where('user_id', '=', $user_id)->where('id', '=', $input['address_id'])->delete();  

                $response               =   array();
                $response['status']     =   200;
                $response['message']    =   'Successfully delete shipping address.';   
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
    public function orderHistory(Request $request)
    {
        $headerValue                =   array_change_key_case(getallheaders(),CASE_LOWER);
        $token                      =   @$headerValue['token'];
        if( $token != '' ){
            $user                   =   $this->checkToken($token);
            if( isset($user)){
                $user_id            =   $user->id;
                $orders = DB::table('orders')->where('user_id','=',$user_id)->orderBy('id','desc')->get();
                $ordersdata         =   [];
                $i=0;
                foreach ($orders as $key => $value) {
                    $ordersdata[$i]['order_number']         =   $value->order_number;
                    $ordersdata[$i]['Date']                 =   date('d M Y',strtotime($value->created_at));
                    $ordersdata[$i]['totalAmount']          =   $value->currency_sign.' '.$value->pay_amount;
                    $ordersdata[$i]['status']               =   ucfirst($value->status);
                    $i++;

                }
                $response               =   array();
                $response['status']     =   200;
                $response['message']    =   'Successfully Executed ';
                $response['data']       =   $ordersdata;    
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
    public function orderDetails(Request $request)
    {
        $validator              =   Validator::make($request->all(), [
            'order_number'        =>  'required'
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
                $order              =   DB::table('orders')->where('order_number','=',$input['order_number'])->get()->first();
                $order_product      =   DB::table('order_products')->where('order_number','=',$input['order_number'])->get();
                $orderData          =   [];
                $orderData['title'] =   'Order# '.$order->order_number.' ['.$order->status.']';
                $orderData['date']                          =   $order->created_at;
                $orderData['delivery_time'] =   $order->delivery_time;
                if($order->shipping == "shipto"){
                    $orderData['shippingMethod']                =   'Ship To Address';
                }else{
                    $orderData['shippingMethod']                =   'Pick Up';    
                }
                $orderData['shippingAddress']['name']       =   $order->shipping_name;
                $orderData['shippingAddress']['email']      =   $order->shipping_email;
                $orderData['shippingAddress']['phone']      =   $order->shipping_phone;
                $orderData['shippingAddress']['address']    =   $order->shipping_address;
                $orderData['shippingAddress']['shipping_city'] =   $order->shipping_city;
                $orderData['shippingAddress']['shipping_building_no']    =   $order->shipping_building_no;
                $orderData['shippingAddress']['shipping_zone']    =   $order->shipping_zone_no;
                $orderData['shippingAddress']['shipping_street']  =   $order->shipping_street_no;
                $orderData['billingAddress']['name']        =   $order->shipping_name;
                $orderData['billingAddress']['email']       =   $order->shipping_email;
                $orderData['billingAddress']['phone']       =   $order->shipping_phone;
                $orderData['billingAddress']['address']     =   $order->shipping_address;
                $orderData['shippingAddress']['customer_city']    =   $order->customer_city;
                $orderData['shippingAddress']['customer_building_no']    =   $order->customer_building_no;
                $orderData['shippingAddress']['customer_zone']  =   $order->customer_zone_no;
                $orderData['shippingAddress']['customer_street']  =   $order->customer_street_no;
                $orderData['paymentInformation']['price']   =   $order->currency_sign.' '.$order->pay_amount;
                $orderData['paymentInformation']['paymentMethod']   =   $order->method;
                $products_data          =   [];
                $i=0;
                foreach ($order_product as $p_key => $p_value) {
                    $product_id                             =   $p_value->product_id;
                    $products                               =   DB::table('products')->where('id','=',$product_id)->get()->first();
                    $products_data[$i]['name']              =   $products->name;
                    $products_data[$i]['image']             =   'assets/images/products/'.$products->photo;
                    $products_data[$i]['quantity']          =   $p_value->qty;
                    $products_data[$i]['price']             =   $order->currency_sign.' '.$products->price;
                    $products_data[$i]['total']             =   $order->currency_sign.' '.($products->price * $p_value->qty) ;
                    $i++;
                }
                $orderData['products_data']              =   $products_data;
                $response               =   array();
                $response['status']     =   200;
                $response['message']    =   'Successfully Executed ';
                $response['data']       =   $orderData;    
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
    public function checkToken( $token =    '' )
    {
        if( $token == '' ){
            return false;
        }
        $all                        =   DB::table('users')->where('app_token', $token)->first();
        return $all;
    }
    public function getCheckOutAmount(Request $request)
    {
        $validator              =   Validator::make($request->all(), [
            'city_id'        =>  'required'
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
                $input              =   $request->all();
                $user_id            =   $user->id;
                $cartList           =   DB::table('cart')->where('user_id','=',$user_id)->get();
                if( count($cartList)>0 ) {
                    $cartData       =   [];
                    $i              =   0;
                    $t_sub_total    =   0;
                    foreach ($cartList as $key => $value) {
                        $products                       =   DB::table('products')->where('id','=',$value->product_id)->get()->first();  
                        $sub_total                      =   $products->price * $value->qty;
                        //$cartData[$i]['sub_total']      =   $sub_total;
                        $t_sub_total                    =   $t_sub_total+$sub_total;
                        $i++;
                    }
                    $priceDetails                       =   [];
                    $priceDetails['discount']           =   0;
                    $total                              =   $t_sub_total;
                    $priceDetails['total']              =   $total;
                    $shippin_amnount                    =   DB::table('pickups')->where('id','=',$input['city_id'])->get()->first();
                    if( @$shippin_amnount->shipping_charge != '' ){
                        $priceDetails['shipping_amount']    =   (int)$shippin_amnount->shipping_charge;
                        $priceDetails['total_mrp']          =   $t_sub_total + $shippin_amnount->shipping_charge;
                    }else{
                        $priceDetails['shipping_amount']    =   (int)0; //$shippin_amnount->shipping_charge;
                        $priceDetails['total_mrp']          =   $t_sub_total; //+$shippin_amnount->shipping_charge;
                    }
                    
                    $response               =   array();
                    $response['status']     =   200;
                    $response['message']    =   'Successfully Executed ';     
                    $response['data']['price_details']      =   $priceDetails;      
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
}
