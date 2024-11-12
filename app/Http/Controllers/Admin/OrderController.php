<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Classes\GeniusMailer;
use App\Models\Order;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Generalsetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  DB;
use View;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables($status)
    {
        if($status == 'pending'){
            $datas = Order::where('status','=','pending')->get();
        }
        elseif($status == 'processing') {
            $datas = Order::where('status','=','processing')->get();
        }
        elseif($status == 'completed') {
            $datas = Order::where('status','=','completed')->get();
        }
        elseif($status == 'declined') {
            $datas = Order::where('status','=','declined')->get();
        }
        else{
          $datas = Order::orderBy('id','desc')->get();  
        }
        // echo "<pre>";
        // print_r($datas);
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('id', function(Order $data) {
                                //$id = '<a href="'.route('admin-order-invoice',$data->id).'">'.sprintf("%'.08d", $data->id).'</a>';
                                $id = sprintf("%'.08d", $data->id);
                                return $id;
                            })
                            ->editColumn('customer_email', function(Order $data) {
                                $userdata = DB::table('users')->where('id',@$data->user_id)->get()->first();
                                return @$userdata->email;
                            })
                            /*->editColumn('total_qty', function(Order $data) {
                                return $data->totalQty;
                            })*/
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->pay_amount.'₹';//$data->currency_sign * round($data->pay_amount * $data->currency_value , 2);
                            })
                            ->editColumn('payment_method', function(Order $data) {
                                return $data->method;
                            })
                            ->addColumn('action', function(Order $data) {
                                $class = strtolower($data->status);
                                $pending = $data->status == 'pending' ? 'selected' : '';
                                $processing = $data->status == 'processing' ? 'selected' : '';
                                $completed = $data->status == 'completed' ? 'selected' : '';
                                $declined = $data->status == 'declined' ? 'selected' : '';
                                $orders = '<select class="process select data-droplinks '.$class.'">'.
'<option value="'. route('admin-order-status',['id1' => $data->id, 'status' => 'pending']).'" '.$pending.'>Pending</option>'.
'<option value="'. route('admin-order-status',['id1' => $data->id, 'status' => 'processing']).'" '.$processing.'>Processing</option>'.
'<option value="'. route('admin-order-status',['id1' => $data->id, 'status' => 'completed']).'" '.$completed.'>Completed</option>'.
'<option value="'. route('admin-order-status',['id1' => $data->id, 'status' => 'declined']).'" '.$declined.'>Declined</option>'.'</select>';
                                return '<div class="action-list"><a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> View Details</a><!--<a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send Email</a>-->'.$orders.'</div>';
                            }) 
                            ->rawColumns(['customer_email', 'id', 'total_qty', 'pay_amount', 'payment_method', 'action'])
                            ->toJson(); //--- Returning Json Data To Client Side

    }
    public function index()
    {
        return view('admin.order.index');
    }
    public function pending()
    {
        return view('admin.order.pending');
    }
    public function processing()
    {
        return view('admin.order.processing');
    }
    public function completed()
    {
        return view('admin.order.completed');
    }
    public function declined()
    {
        return view('admin.order.declined');
    }
    public function show($id)
    {
        $order = Order::findOrFail($id);
        //$cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart = DB::table('order_products')->where('order_number','=',$order->order_number)->get();
        $order_details          =   1;
        $building_no    =   $order->shipping_building_no;
        $zone_no        =   $order->shipping_zone_no;
        $street_no      =   $order->shipping_street_no;
        return view('admin.order.details',compact('order','cart','order_details','building_no','zone_no','street_no'));
    }
    public function invoice($id)
    {
        
        $order = Order::findOrFail($id);
        $cart = DB::table('order_products')->where('order_number','=',$order->order_number)->get();
        $order_details          =   1;
        $building_no    =   $order->shipping_building_no;
        $zone_no        =   $order->shipping_zone_no;
        $street_no      =   $order->shipping_street_no;
        
        //$cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.invoice',compact('order','cart'));
    }
    public function emailsub(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1)
        {
            $data = [
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'body' => $request->message,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);                
        }
        else
        {
            $data = 0;
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            $mail = mail($request->to,$request->subject,$request->message,$headers);
            if($mail) {   
                $data = 1;
            }
        }

        return response()->json($data);
    }

    public function printpage($id)
    {
        // $order = Order::findOrFail($id);
        // $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $order = Order::findOrFail($id);
        $cart = DB::table('order_products')->where('order_number','=',$order->order_number)->get();
        $order_details          =   1;
        $building_no    =   $order->shipping_building_no;
        $zone_no        =   $order->shipping_zone_no;
        $street_no      =   $order->shipping_street_no;
        
        return view('admin.order.print',compact('order','cart'));
    }

    public function license(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart->items[$request->license_key]['license'] = $request->license;
        $order->cart = utf8_encode(bzcompress(serialize($cart), 9));
        $order->update();       
        $msg = 'Successfully Changed The License Key.';
        return response()->json($msg);
    }

    public function status($id,$status)
    {
        $mainorder = Order::findOrFail($id);
        if ($mainorder->status == "completed"){
        //--- Redirect Section        
        $msg = 'This Order is Already Completed';
        return response()->json($msg);      
        //--- Redirect Section Ends   

        }else{
        if ($status == "completed"){

            foreach($mainorder->vendororders as $vorder)
            {
                $uprice = User::findOrFail($vorder->user_id);
                $uprice->current_balance = $uprice->current_balance + $vorder->price;
                $uprice->update();
            }
                
          
        }
         if ($status == "declined"){
           

        }
        $stat['status'] = $status;
        $stat['payment_status'] = ucfirst($status);
        $order = VendorOrder::where('order_id','=',$id)->update(['status' => $status]);
        $mainorder->update($stat);
        //--- Redirect Section        
        $msg = 'Order Status Updated Successfully';
        return response()->json($msg);      
        //--- Redirect Section Ends   

        }
    }
}