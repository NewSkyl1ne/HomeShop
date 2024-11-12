@extends('layouts.admin')
        
@section('content')
        <div class="content-area">
<div class="mr-breadcrumb">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="heading">Order Invoice <a class="add-btn" href="{{ route('admin-order-index') }}"><i class="fas fa-arrow-left"></i> Back</a></h4>
                                <ul class="links">
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}">Dashboard </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">Orders</a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">Invoice</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                   <div class="order-table-wrap">
                            @include('includes.admin.form-both')
                            <div class="row">
                                <div class="col-sm-6">
                                    <!--<div class="invoice__logo text-left">-->
                                    <!--   <img src="http://localhost/laravel/testing/shopping_cart/files/assets/images/1571567295logo.png" alt="woo commerce logo">-->
                                    <!--</div>-->
                                </div>
                                <div class="col-lg-6 text-right">
                                    <a class="btn  add-newProduct-btn print" href="{{route('admin-order-print',$order->id)}}" target="_blank"><i class="fa fa-print"></i> Print Invoice</a>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody><tr class="tr-head">
                                                <th class="order-th" width="45%">Order ID</th>
                                                <th width="10%">:</th>
                                                <th class="order-th" width="45%">{{@$order->order_number}}</th>
                                            </tr>
                                            <!--<tr>-->
                                            <!--    <th width="45%">Total Product</th>-->
                                            <!--    <th width="10%">:</th>-->
                                            <!--    <td width="45%">{{@$order->totalQty}}</td>-->
                                            <!--</tr>-->
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
                                                        </tr>
                                                        
                                                        <!-- <tr>
                                                            <th width="45%">Country</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$order->customer_country}}</td>
                                                        </tr> -->
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
                                                        <!-- <tr>
                                                            <th width="45%">Postal Code</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{@$order->customer_zip}}</td>
                                                        </tr> -->
                            @if($order->coupon_code != null)
                            <!-- <tr>
                                <th width="45%">Coupon Code</th>
                                <th width="10%">:</th>
                                <td width="45%">{{@$order->coupon_code}}</td>
                            </tr> -->
                            @endif
                            @if($order->coupon_discount != null)
                            <!-- <tr>
                                <th width="45%">Coupon Discount</th>
                                <th width="10%">:</th>
                                @if($gs->currency_format == 0)
                                <td width="45%">{{ @$order->currency_sign }}{{ @$order->coupon_discount }}</td>
                                @else 
                                <td width="45%">{{ @$order->coupon_discount }}{{ @$order->currency_sign }}</td>
                                @endif
                            </tr> -->
                            @endif
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
                               
                                <!-- <tr>
                                    <th width="45%"><strong>Country:</strong></th>
                                    <th width="10%">:</th>
                <td width="45%">{{@$order->shipping_country == null ? @$order->customer_country : @$order->shipping_country}}</td>
                                </tr> -->
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
                               <!--  <tr>
                                    <th width="45%"><strong>Postal Code:</strong></th>
                                    <th width="10%">:</th>
                <td width="45%">{{@$order->shipping_zip == null ? @$order->customer_zip : @$order->shipping_zip}}</td>
                                </tr> -->
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
                                   <!--  <th>Shop Name</th>
                                    <th>Status</th> -->
                                    
                                    <th >Product Title</th>
                                    <th width="10%">Quantity</th>
                                    <th width="10%"> Price</th>
                                    
                                   <!--  <th width="10%">Size</th>
                                    <th width="10%">Color</th> 
                                    <th width="10%">Total Price</th>-->
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

                                                        <?php /*
                                @foreach($cart->items as $key => $product)
                                    <tr>
                                        <input type="hidden" value="{{$key}}">
                                            <td>{{ $product['item']['id'] }}</td>

                                            <td>
                                                @if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                @endphp
                                                @if(isset($user))
                                                <a target="_blank" href="{{route('admin-vendor-show',$user->id)}}">{{$user->shop_name}}</a>
                                                @else
                                                Vendor Removed
                                                @endif
                                                @endif

                                            </td>
                                            <td>
                                                @if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->first();
                                                @endphp
                                                {{$user->status}}
                                                @endif
                                            </td>


                                            <td>
                                                <input type="hidden" value="{{ $product['license'] }}">

                                                @if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                @endphp
                                                @if(isset($user))
                                              <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{strlen($product['item']['name']) > 30 ? substr($product['item']['name'],0,30).'...' : $product['item']['name']}}</a>
                                                @else
                                                <a href="javascript:;">{{strlen($product['item']['name']) > 30 ? substr($product['item']['name'],0,30).'...' : $product['item']['name']}}</a>
                                                @endif
                                                @endif


                                                @if($product['license'] != '')
                              <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-info product-btn" id="license" style="padding: 5px 12px;"><i class="fa fa-eye"></i> View License</a>
                                                @endif

                                            </td>
                                            <td>{{$product['qty']}} {{ $product['item']['measure'] }}</td>
                                            <td>{{$product['size']}}</td>
                                            <td><span style="width: 40px; height: 20px; display: block; background: {{$product['color']}};"></span></td>
                                            <td>{{$order->currency_sign}}{{ round($product['price'] * $order->currency_value , 2) }}</td>

                                    </tr>
                                @endforeach */?>
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center mt-2">
                                        <!-- <a class="btn sendEmail send" href="javascript:;" class="send" data-email="{{ @$order->customer_email }}" data-toggle="modal" data-target="#vendorform">
                                                <i class="fa fa-send"></i> Send Email
                                        </a> -->
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Main Content Area End -->
                </div>
            </div>


    </div>

@endsection