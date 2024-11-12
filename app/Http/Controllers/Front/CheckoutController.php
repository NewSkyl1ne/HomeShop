<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\GeniusMailer;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Coupon;
use App\Models\Generalsetting;
use App\Models\PaymentGateway;
use App\Models\Pickup;
use App\Models\User;
use App\Models\Notification;
use App\Models\VendorOrder;
use App\Models\UserNotification;
use Session;
use Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\Api\CheckoutModel;
use View;

class CheckoutController extends Controller
{
    public function loadpayment($slug1,$slug2)
    {
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        }
        else {
            $curr = Currency::where('is_default','=',1)->first();
        }
        $payment = $slug1;
        $pay_id = $slug2;
        $gateway = '';
        if($pay_id != 0) {
            $gateway = PaymentGateway::findOrFail($pay_id);
        }
        return view('load.payment',compact('payment','pay_id','gateway','curr'));
    }

    public function checkout()
    {
        $flags=0;   
        $user = Auth::user();
        if(!$user){
        return redirect('/carts');
        }
        else{
        $cartlist = DB::table('cart')->where('user_id', '=', $user->id)->get();
              if(count($cartlist)==0){
                 return redirect('/carts');
              }
              else{
                foreach ($cartlist as $key => $value) {
                    $products      =   DB::table('products')->where('id','=',$value->product_id)->get()->first();
                    if($products->stock>=(int)$value->qty)
                    {

                    }
                    else
                    {
                        $flags++;
                    }
                }
                if($flags==0)
                {
                    return view('front.checkout', ['cartlist'=>$cartlist, 'user' => $user]);
                }
                else
                {
                    return redirect()->route('front.cartoutstock');
                    return "The quantity you give is not in our stock!";
                }
                 
              }          

            }
    }

    public function placeorder(Request $request)
    {
        $user                       = Auth::user();
        $order_number       =   str_random(4).time();
        $input                      =   $request->all();
        $flag=0;
        if( @$input['shipping_name'] != ''){ 
           $input['shipping_name']      =   $input['shipping_name'];
           $input['shipping_phone']     =   $input['shipping_phone'];
           $input['shipping_email']     =   $input['shipping_email'];
           $input['shipping_city']     =   $input['shipping_city'];
           $input['shipping_address']   =   $input['shipping_address'];
           $input['shipping_building_no']   =   $input['shipping_building_no'];
           $input['shipping_zone_no']   =   $input['shipping_zone_no'];
           $input['shipping_street_no']   =   $input['shipping_street_no'];
        }else{
           if( $user->city == '' || $user->city == 0){
                $input['shipping_name']         =   @$input['b_name'];
                $input['shipping_phone']        =   @$input['b_phone'];
                $input['shipping_email']        =   @$input['b_email'];
                $input['shipping_address']      =   @$input['b_address'];
                $input['shipping_city']         =   @$input['b_city'];
                $input['shipping_building_no']  =   @$input['b_building_no'];
                $input['shipping_zone_no']      =   @$input['b_zone_no'];
                $input['shipping_street_no']    =   @$input['b_street_no'];
               
                $new_user_data                  =   [];
                $new_user_data['name']          =   @$input['b_name'];
                $new_user_data['phone']         =   @$input['b_phone'];
                $new_user_data['email']         =   @$input['b_email'];
                $new_user_data['address']       =   @$input['b_address'];
                $new_user_data['city']          =   @$input['b_city'];
                $new_user_data['building_no']   =   @$input['b_building_no'];
                $new_user_data['zone_no']       =   @$input['b_zone_no'];
                $new_user_data['street_no']     =   @$input['b_street_no'];
                DB::table('users')->where('id',$user->id)->update($new_user_data);
                $user                       = Auth::user();
           }else{
               $input['shipping_name']      =   $user->name;
               $input['shipping_phone']     =   $user->phone;
               $input['shipping_email']     =   $user->email;
               $input['shipping_address']   =   $user->address;
               $input['shipping_city']      =   $user->city;
               $input['shipping_building_no']  =   $user->building_no;
               $input['shipping_zone_no']     =   $user->zone_no;
               $input['shipping_street_no']   =   $user->street_no;
           }

        }
        $input['deleveryTime']   =   @$input['deleveryTime'];
        $input['disclaimer']     =   @$input['disclaimer'];
        //exit;
        $user_id                        =   $user->id;
        $cart                           =   DB::table('cart')->where('user_id','=',$user_id)->get();
        if( count($cart) > 0 ){
            $totl_price                 =   0;
            $totalQty                   =   0;
            $v_p                =   [];
            $i=0;
            foreach ($cart as $key => $value) {
                $totl_price     =   $totl_price + ($value->price*$value->qty);
                $totalQty       =   $totalQty + $value->qty;
                $products      =   DB::table('products')->where('id','=',$value->product_id)->get()->first();
                if($products->stock>=(int)$value->qty)
                {
                  
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
                    $p_stock                           =   DB::table('products')->where('id','=',$value->product_id)->get()->first();
                    $p_stock_c    = $p_stock->stock-$value->qty;
                    DB::table('products')->where('id','=',$value->product_id)->update(
                            [
                                'stock'  => $p_stock_c, 
                            ]
                        );
                    if( $p_stock->user_id != '' ){
                        $v_p[$i]['p_id']        =   $p_stock->id;
                        $v_p[$i]['p_price']     =   $p_stock->price;
                        $v_p[$i]['v_id']        =   $p_stock->user_id;
                        $v_p[$i]['p_qty']       =   $value->qty;
                    }
                    $i++;
                    
                }
                else
                {
                    Session::put('product_name', $products->name);
                    $flag++;
                }
               
            }
            if($flag==0)
            {
                $shipping_change                =   DB::table('pickups')->where('id','=',$input['shipping_city'])->get()->first();   
            
                $shipping_charge                =   @$shipping_change->shipping_charge;
                if(isset($shipping_charge) && $shipping_charge > 0 ){
                    $totl_price                   =   $totl_price + $shipping_charge;
                }
                $discount_amnt=0;
                if(@$input['coupon']!=null)
                {
                    $coupon_list=DB::table('coupons')->where('code',@$input['coupon'])->get();
               
                    if($coupon_list[0]->type==0)
                    {
                       
                        $discount_amnt=(($totl_price*$coupon_list[0]->price)/100);
                    }else if($coupon_list[0]->type==1)
                    {
                        $discount_amnt=$coupon_list[0]->price;
                    }
                    $totl_price=$totl_price - $discount_amnt;
                }
             
                //$input                        =   $request->all();
                $order                          =   new CheckoutModel;
                $order['order_number']          =   $order_number;
                $order['user_id']               =   $user_id;
                $order['totalQty']              =   $totalQty;
                $order['pay_amount']            =   $totl_price;
                $order['shipping_name']         =   @$input['shipping_name'];
                $order['shipping_phone']        =   @$input['shipping_phone'];
                $order['shipping_email']        =   @$input['shipping_email'];
                $order['shipping_address']      =   @$input['shipping_address'];
                $order['shipping_city']         =   @$input['shipping_city'];
                $order['shipping_zip']          =   @$input['shipping_zip'];
                $order['shipping_building_no']      =   @$input['shipping_building_no'];
                $order['shipping_zone_no']          =   @$input['shipping_zone_no'];
                $order['shipping_street_no']        =   @$input['shipping_street_no'];
                if($input['payement_type']=='2'){
                    $order['method']                =   'Payment by Card';
                }else{
                    $order['method']                =   'Cash On Delivery';
                }
                $order['shipping']              =   'Qpay';
                $order['customer_email']        =   $user->email;
                $order['customer_name']         =   $user->name;
                $order['customer_country']      =   0;
                $order['customer_phone']        =   $user->phone;
                $order['customer_address']      =   $user->address;
                $order['customer_city']         =   $user->city;
                $order['customer_building_no']     =   $user->building_no;
                $order['customer_zone_no']         =   $user->zone_no;
                $order['customer_street_no']       =   $user->street_no;
                $order['customer_zip']          =   $user->zip;
                $order['tax']                   =   0;
                $order['shipping_cost']         =   0;
                $order['order_note']            =   0;
                $order['coupon_code']           =  @$input['coupon'];
                $order['coupon_discount']       =   $discount_amnt;
                $order['dp']                    =   0;
                $order['payment_status']        =   "Pending";
                $order['currency_sign']         =   '₹';//$curr->sign;
                $order['currency_value']        =   0;//$curr->value;*/
                $order['delivery_time']         =   @$input['deleveryTime'];
                $order['disclaimer']            =   @$input['disclaimer'];
                $order['map_lat']               =   @$input['lat'];
                $order['map_long']              =   @$input['long'];
                $order['created_at']            =   date('Y-m-d H:i:s');
                $order['updated_at']            =   date('Y-m-d H:i:s');
                // dd($order_number);
                $order->save();
                $notification = new Notification;
                $notification->order_id = $order_number;
                $notification->notification_text=" New Order ".$order_number;
                $notification->save();

                $lastid = $order->id;
                Session::put('order_id', $lastid);
                Session::put('order_number', $order_number); 
                if( count($v_p)>0){
                    foreach ($v_p as $key => $value) {
                        $amount                     =   DB::table('users')->where('id',$value['v_id'])->get()->first();
                        DB::table('vendor_orders')->insert(
                            [
                                'order_id'      => $lastid, 
                                'user_id'       => $value['v_id'],
                                'qty'           => $value['p_qty'],
                                'price'         => $value['p_price'],
                                'order_number'  => $order_number, 
                                'status'        => 'pending'
                            ]
                        );
                        $new_amount             =   $amount->current_balance + $value['p_price'];
                        DB::table('users')->where('id',$value['v_id'])->update(['current_balance'=>$new_amount]);
                    }
                }    
                if($input['payement_type']!='2'){
                      
                    DB::table('cart')->where('user_id', '=', $user_id)->delete();  
                    $success_url    = action('Front\PaymentController@payreturn');
                    return redirect($success_url);
                }else{
                    //  DB::table('cart')->where('user_id', '=', $user_id)->delete();  
                    if(Session('order_id')!=''){
                        return redirect()->route('front.qpaySession');
                    }else{
                        return redirect()->route('payment.cancle');
                    }
                }
            }else
            {
                return redirect()->route('front.cartoutstock');
                return "The quantity you give is not in our stock!";
            }
           
        }
    }
  
    public static function incrmentStock()
        {
        
        $order_id=Session('order_id');
        $results= DB::table('order_products')->where('order_number',$order_id);
        foreach ($results as $key => $value) {
        $p_stock = DB::table('products')->where('id','=',$value->product_id)->get()->first();
        $p_stock_c = $p_stock->stock+$value->qty;
       DB::table('products')->where('id','=',$value->product_id)->update(
       [
        'stock' => $p_stock_c, 
        ]
       );
       }
        
       }

    public function cashondelivery(Request $request)
    {
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }
        $gs = Generalsetting::findOrFail(1);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        foreach($cart->items as $key => $prod)
        {
        if(!empty($prod['item']['license']) && !empty($prod['item']['license_qty']))
        {
                foreach($prod['item']['license_qty']as $ttl => $dtl)
                {
                    if($dtl != 0)
                    {
                        $dtl--;
                        $produc = Product::findOrFail($prod['item']['id']);
                        $temp = $produc->license_qty;
                        $temp[$ttl] = $dtl;
                        $final = implode(',', $temp);
                        $produc->license_qty = $final;
                        $produc->update();
                        $temp =  $produc->license;
                        $license = $temp[$ttl];
                         $oldCart = Session::has('cart') ? Session::get('cart') : null;
                         $cart = new Cart($oldCart);
                         $cart->updateLicense($prod['item']['id'],$license);  
                         Session::put('cart',$cart);
                        break;
                    }                    
                }
        }
        }
        $order = new Order;
        $success_url = action('Front\PaymentController@payreturn');
        $item_name = $gs->title." Order";
        $item_number = str_random(4).time();
        $order['user_id'] = $request->user_id;
        $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9)); 
        $order['totalQty'] = $request->totalQty;
        $order['pay_amount'] = round($request->total / $curr->value, 2);
        $order['method'] = $request->method;
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_name'] = $request->name;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['tax'] = $request->tax;
        $order['customer_phone'] = $request->phone;
        $order['order_number'] = str_random(4).time();
        $order['customer_address'] = $request->address;
        $order['customer_country'] = $request->customer_country;
        $order['customer_city'] = $request->city;
        $order['customer_zip'] = $request->zip;
        $order['shipping_email'] = $request->shipping_email;
        $order['shipping_name'] = $request->shipping_name;
        $order['shipping_phone'] = $request->shipping_phone;
        $order['shipping_address'] = $request->shipping_address;
        $order['shipping_country'] = $request->shipping_country;
        $order['shipping_city'] = $request->shipping_city;
        $order['shipping_zip'] = $request->shipping_zip;
        $order['order_note'] = $request->order_notes;
        $order['coupon_code'] = $request->coupon_code;
        $order['coupon_discount'] = $request->coupon_discount;
        $order['dp'] = $request->dp;
        $order['payment_status'] = "Pending";
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;


            if (Session::has('affilate')) 
            {
                $val = $request->total / 100;
                $sub = $val * $gs->affilate_charge;
                $user = User::findOrFail(Session::get('affilate'));
                $user->affilate_income += $sub;
                $user->update();
                $order['affilate_user'] = $user->name;
                $order['affilate_charge'] = $sub;
            }
        $order->save();
       
                    if($request->coupon_id != "")
                    {
                       $coupon = Coupon::findOrFail($request->coupon_id);
                       $coupon->used++;
                       if($coupon->times != null)
                       {
                            $i = (int)$coupon->times;
                            $i--;
                            $coupon->times = (string)$i;
                       }
                        $coupon->update();

                    }

        foreach($cart->items as $prod)
        {
            $x = (string)$prod['size_qty'];
            if(!empty($x))
            {
                $product = Product::findOrFail($prod['item']['id']);
                $x = (int)$x;
                $x = $x - $prod['qty'];
                $temp = $product->size_qty;
                $temp[$prod['size_key']] = $x;
                $temp1 = implode(',', $temp);
                $product->size_qty =  $temp1;
                $product->update();               
            }
        }


        foreach($cart->items as $prod)
        {
            $x = (string)$prod['stock'];
            if($x != null)
            {

                $product = Product::findOrFail($prod['item']['id']);
                $product->stock =  $prod['stock'];
                $product->update();  
                if($product->stock <= 5)
                {
                    $notification = new Notification;
                    $notification->product_id = $product->id;
                    $notification->save();                    
                }              
            }
        }

        $notf = null;

        foreach($cart->items as $prod)
        {
            if($prod['item']['user_id'] != 0)
            {
                $vorder =  new VendorOrder;
                $vorder->order_id = $order->id;
                $vorder->user_id = $prod['item']['user_id'];
                $notf[] = $prod['item']['user_id'];
                $vorder->qty = $prod['qty'];
                $vorder->price = $prod['price'];
                $vorder->order_number = $order->order_number;             
                $vorder->save();
            }

        }

        if(!empty($notf))
        {
            $users = array_unique($notf);
            foreach ($users as $user) {
                $notification = new UserNotification;
                $notification->user_id = $user;
                $notification->order_number = $order->order_number;
                $notification->save();    
            }
        }

        Session::forget('cart');

        return redirect($success_url);
    }

    public function gateway(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }
        foreach($cart->items as $key => $prod)
        {
        if(!empty($prod['item']['license']) && !empty($prod['item']['license_qty']))
        {
                foreach($prod['item']['license_qty']as $ttl => $dtl)
                {
                    if($dtl != 0)
                    {
                        $dtl--;
                        $produc = Product::findOrFail($prod['item']['id']);
                        $temp = $produc->license_qty;
                        $temp[$ttl] = $dtl;
                        $final = implode(',', $temp);
                        $produc->license_qty = $final;
                        $produc->update();
                        $temp =  $produc->license;
                        $license = $temp[$ttl];
                         $oldCart = Session::has('cart') ? Session::get('cart') : null;
                         $cart = new Cart($oldCart);
                         $cart->updateLicense($prod['item']['id'],$license);  
                         Session::put('cart',$cart);
                        break;
                    }                    
                }
        }
        }
        $settings = Generalsetting::findOrFail(1);
        $order = new Order;
        $success_url = action('Front\PaymentController@payreturn');
        $item_name = $settings->title." Order";
        $item_number = str_random(4).time();
        $order['user_id'] = $request->user_id;
        $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
        $order['totalQty'] = $request->totalQty;
        $order['pay_amount'] = round($request->total / $curr->value, 2);
        $order['method'] = $request->method;
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_name'] = $request->name;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['tax'] = $request->tax;
        $order['customer_phone'] = $request->phone;
        $order['order_number'] = str_random(4).time();
        $order['customer_address'] = $request->address;
        $order['customer_country'] = $request->customer_country;
        $order['customer_city'] = $request->city;
        $order['customer_zip'] = $request->zip;
        $order['shipping_email'] = $request->shipping_email;
        $order['shipping_name'] = $request->shipping_name;
        $order['shipping_phone'] = $request->shipping_phone;
        $order['shipping_address'] = $request->shipping_address;
        $order['shipping_country'] = $request->shipping_country;
        $order['shipping_city'] = $request->shipping_city;
        $order['shipping_zip'] = $request->shipping_zip;
        $order['order_note'] = $request->order_notes;
        $order['txnid'] = $request->txn_id4;
        $order['coupon_code'] = $request->coupon_code;
        $order['coupon_discount'] = $request->coupon_discount;
        $order['dp'] = $request->dp;
        $order['payment_status'] = "Pending";
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;
            if (Session::has('affilate')) 
            {
                $val = $request->total / 100;
                $sub = $val * $gs->affilate_charge;
                $user = User::findOrFail(Session::get('affilate'));
                $user->affilate_income += $sub;
                $user->update();
                $order['affilate_user'] = $user->name;
                $order['affilate_charge'] = $sub;
            }
        $order->save();
        $notification = new Notification;
        $notification->order_id = $order->id;
        $notification->save();
                    if($request->coupon_id != "")
                    {
                       $coupon = Coupon::findOrFail($request->coupon_id);
                       $coupon->used++;
                       if($coupon->times != null)
                       {
                            $i = (int)$coupon->times;
                            $i--;
                            $coupon->times = (string)$i;
                       }
                        $coupon->update();

                    }

        foreach($cart->items as $prod)
        {
            $x = (string)$prod['size_qty'];
            if(!empty($x))
            {
                $product = Product::findOrFail($prod['item']['id']);
                $x = (int)$x;
                $x = $x - $prod['qty'];
                $temp = $product->size_qty;
                $temp[$prod['size_key']] = $x;
                $temp1 = implode(',', $temp);
                $product->size_qty =  $temp1;
                $product->update();               
            }
        }


        foreach($cart->items as $prod)
        {
            $x = (string)$prod['stock'];
            if($x != null)
            {

                $product = Product::findOrFail($prod['item']['id']);
                $product->stock =  $prod['stock'];
                $product->update();  
                if($product->stock <= 5)
                {
                    $notification = new Notification;
                    $notification->product_id = $product->id;
                    $notification->save();                    
                }              
            }
        }

        $notf = null;

        foreach($cart->items as $prod)
        {
            if($prod['item']['user_id'] != 0)
            {
                $vorder =  new VendorOrder;
                $vorder->order_id = $order->id;
                $vorder->user_id = $prod['item']['user_id'];
                $notf[] = $prod['item']['user_id'];
                $vorder->qty = $prod['qty'];
                $vorder->price = $prod['price'];
                $vorder->order_number = $order->order_number;             
                $vorder->save();
            }

        }

        if(!empty($notf))
        {
            $users = array_unique($notf);
            foreach ($users as $user) {
                $notification = new UserNotification;
                $notification->user_id = $user;
                $notification->order_number = $order->order_number;
                $notification->save();    
            }
        }


        Session::forget('cart');


        return redirect($success_url);
    }


}
