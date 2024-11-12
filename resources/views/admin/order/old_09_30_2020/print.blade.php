<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="{{$seo->meta_keys}}">
        <meta name="author" content="GeniusOcean">

        <title>{{$gs->title}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('assets/print/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/print/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('assets/print/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/print/css/style.css')}}">
  <link href="{{asset('assets/print/css/print.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}"> 
  <style type="text/css">
@page { size: auto;  margin: 0mm; }
@page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 287mm;
  }

html {
    overflow: scroll;
    overflow-x: hidden;
}
::-webkit-scrollbar {
    width: 0px;  /* remove scrollbar space */
    background: transparent;  /* optional: just make scrollbar invisible */
}
  </style>
</head>
<body onload="window.print();">
                                        <div class="invoice-wrap">
                                            <div class="invoice__title">
                                                <div class="row reorder-xs">
                                                    <div class="col-sm-12">
                                                        <div class="invoice__logo text-center">
                                                            <img src="{{asset('new_asstes/images/logo.jpg')}}" alt="basket">
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                            <br>
                                             <div class="order-table-wrap">
                            @include('includes.admin.form-both')
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody><tr class="tr-head">
                                                <th class="order-th" width="45%">Order ID</th>
                                                <th width="10%">:</th>
                                                <th class="order-th" width="45%">{{@$order->order_number}}</th>
                                            </tr>
                                            <tr>
                                                <th width="45%">Total Cost</th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{@$order->currency_sign}} {{@$order->pay_amount}}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%">Ordered Date</th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{date('d-M-Y H:i:s a',strtotime(@$order->created_at))}}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%">Payment Method</th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{@$order->method}}</td>
                                            </tr>
            
                                            @if($order->method == "Payment by Card")
                                            <tr>
                                                <th width="45%">Payment Status</th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{@$order->payment_status}}</td>
                                            </tr>                
                                            @endif 
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody><tr class="tr-head">
                                                            <th class="order-th" width="45%">Billing Address</th>
                                                            <th width="10%"></th>
                                                            <th width="45%"></th>
                                                        </tr>
                                                        <tr>
                                                            <?php $userdata = DB::table('users')->where('id',@$order->user_id)->get()->first(); ?>
                                                            <th width="45%">Name</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$userdata->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Email</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$userdata->email}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Phone</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$userdata->phone}}</td>
                                                        </tr><?php /*
                                                        <tr>
                                                            <th width="45%">City</th>
                                                            <th width="10%">:</th>
                                                            @php 
                                                            $shipping_data = DB::table('pickups')->where('id', '=', @$userdata->city)->get()->first(); 
                                                            @endphp
                                                            <td width="45%">{{@$shipping_data->location}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%"><strong>Building No:</strong></th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$userdata->building_no}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%"><strong>Zone:</strong></th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$userdata->zone_no}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%"><strong>Street:</strong></th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$userdata->street_no}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Address</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$userdata->address}}</td>
                                                        </tr>
                                                        
                                                        @if($order->affilate_user != null)
                                                        <tr>
                                                            <th width="45%">Affilate User</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$order->affilate_user}}</td>
                                                        </tr>
                                                        @endif
                                                        @if(@$order->affilate_charge != null)
                                                        <tr>
                                                            <th width="45%">Affilate Charge</th>
                                                            <th width="10%">:</th>
                                                            @if($gs->currency_format == 0)
                                                            <td width="45%">{{ @$order->currency_sign }}{{@$order->affilate_charge}}</td>
                                                            @else 
                                                            <td width="45%">{{@$order->affilate_charge}}{{ @$order->currency_sign }}</td>
                                                            @endif
                                                        </tr>
                                                        @endif
                                                        */ ?>
                                                    </tbody></table>
                                                </div>
                                            </div>
                                            @if($order->dp == 0)
                                            <div class="col-lg-6">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                        <tr class="tr-head">
                                                            <th class="order-th" width="45%"><strong>Shipping Address</strong></th>
                                                            <th width="10%"></th>
                                                            <td width="45%"></td>
                                                        </tr>
                                                         @if($order->shipping == "pickup")
                                                        <tr>
                                                            <th width="45%"><strong>Pickup Location:</strong></th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$order->pickup_location}}</td>
                                                        </tr>
                                                        @else
                                                        <tr>
                                                            <th width="45%"><strong>Name:</strong></th>
                                                            <th width="10%">:</th>
                                                            <td>{{@$order->shipping_name == null ? @$order->customer_name : @$order->shipping_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%"><strong>Email:</strong></th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$order->shipping_email == null ? @$order->customer_email : @$order->shipping_email}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%"><strong>Phone:</strong></th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$order->shipping_phone == null ? @$order->customer_phone : @$order->shipping_phone}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%"><strong>City:</strong></th>
                                                            <th width="10%">:</th>
                                                             @php 
                                                            $shipping_data = DB::table('pickups')->where('id', '=', @$order->shipping_city)->get()->first(); 
                                                            @endphp
                                                            <td width="45%">{{@$shipping_data->location}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%"><strong>Building No:</strong></th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$order->shipping_building_no}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%"><strong>Zone:</strong></th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$order->shipping_zone_no}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%"><strong>Street:</strong></th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$order->shipping_street_no}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%"><strong>Address:</strong></th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$order->shipping_address == null ? @$order->customer_address : @$order->shipping_address}}</td>
                                                        </tr>
                                                        @endif
                                                    </tbody></table>
                                                </div>
                                            </div>
                                @endif
                            </div>
                            <div class="row">
                                    <div class="col-lg-12 order-details-table">
                                        <div class="mr-table">
                                            <h4 class="title">Products Ordered</h4>
                                            <div class="table-responsiv">
                                                    <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <tr>
                                                                    <th width="10%">Product ID#</th>
                                                                    <th >Product Title</th>
                                                                    <th width="10%">Quantity</th>
                                                                    <th width="10%"> Price</th>
                                                                </tr>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $i =0; @endphp 
                                                            @foreach($cart as $product)
                                                            @php $i++; 
                                                            $product_data = DB::table('products')->where('id', '=', $product->product_id)->get()->first();          
                                                            @endphp
                            
                                                                <tr>
                                                                    <td>{{@$i}}</td>
                                                                    <!-- <td></td>
                                                                    <td></td> -->
                                                                    <td>{{@$product_data->name}}</td>
                                                                    <td>{{@$product->qty}}</td>
                                                                    <td>@php echo @$product->price@endphp</td>
                                                                    
                                                                    <!--<td>@php echo $product->price*$product->qty @endphp</td>-->
                                                                </tr>
                                                            @endforeach

                                                   
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center mt-2">
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Main Content Area End -->
                </div>
            </div>


    </div>

<!-- ./wrapper -->

<script type="text/javascript">
setTimeout(function () {
        window.close();
      }, 500);
</script>
</body>
</html>
