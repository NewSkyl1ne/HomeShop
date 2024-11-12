<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\PaymentGateway;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orders()
    {
        $user = Auth::guard('web')->user();
        $orders = Order::where('user_id','=',$user->id)->orderBy('id','desc')->get();
        return view('user.order.index',compact('user','orders'));
    }

    public function order($id)
    {
        $user = Auth::guard('web')->user();
        $order = Order::findOrfail($id);
        $userid=$user->id;
        $orderid=$order->user_id;
        if($userid==$orderid)
        {
            $order = Order::findOrfail($id);
            $cart = DB::table('order_products')->where('order_number','=',$order->order_number)->get();
            //unserialize(bzdecompress(utf8_decode($order->cart)));
            return view('user.order.details',compact('user','order','cart'));
        }
        else
        {   
            $orders = Order::where('user_id','=',$user->id)->orderBy('id','desc')->get();
            return view('user.order.index',compact('user','orders'));
        }
    }

    public function orderdownload($slug,$id)
    {
        $user = Auth::guard('web')->user();
        $order = Order::where('order_number','=',$slug)->first();
        if(!isset($order) || $order->user_id != $user->id)
        {
            return redirect()->back();
        }
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return response()->download(public_path('assets/files/'.$cart->items[$id]['item']['file']));
    }

    public function orderprint($id)
    {
        $user = Auth::guard('web')->user();
        $order = Order::findOrfail($id);
        //$cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart = DB::table('order_products')->where('order_number','=',$order->order_number)->get();
        return view('user.order.print',compact('user','order','cart'));
    }

    public function cancleOrder($id)
    {
        $result= DB::table('orders')->where('order_number','=',$id)->update(['status'  => 'declined',]);
        $result2= DB::table('vendor_orders')->where('order_number','=',$id)->update(['status'  => 'declined',]);
        if($result)
        {
            $admin=DB::table('admins')->get()->first();
            $order = DB::table('orders')->where('order_number','=',$id)->get()->first();
            //notification
            $notification 				= 	new Notification;
            $notification->order_id = $order->order_number;
            $notification->notification_text="Order canceled ".$order->order_number;
	        $notification->save();
          
            //admin mail
            $no=DB::table('orders')->where('order_number',$id)->get()->first();
            
            //customer mail
           
            $cart = DB::table('order_products')->where('order_number','=',$order->order_number)->get();
            foreach ($cart as $key => $ordered_product) 
            {
                $p_stock=DB::table('products')->where('id','=',$ordered_product->product_id)->get()->first();
                $p_stock_c    = $p_stock->stock+$ordered_product->qty;
                DB::table('products')->where('id','=',$ordered_product->product_id)->update(['stock'  => $p_stock_c,]);
                if($p_stock->user_id!=0)
                {
                    $user=DB::table('users')->where('id','=',$p_stock->user_id)->get()->first();
                    // vendormail

                }
            }
        }

        return view('user.order.cancelsuccess');
    }

    public function trans()
    {
        $id = $_GET['id'];
        $trans = $_GET['tin'];
        $order = Order::findOrFail($id);
        $order->txnid = $trans;
        $order->update();
        $data = $order->txnid;
        return response()->json($data);            
    }  

}
