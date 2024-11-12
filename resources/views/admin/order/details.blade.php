@extends('layouts.admin')
        
@section('content')
    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">Order Details <!--  <a class="add-btn" href="{{ route('admin-order-invoice',@$order->id) }}"><i class="fas fa-eye"></i> View Invoice</a> --> <a class="add-btn" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> Back</a></h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">Dashboard </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">Orders</a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">Order Details</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                
                        <div class="order-table-wrap">
                            @include('includes.admin.form-both')
                            <div class="row">
                                <div class="col-lg-6">
                                </div>
                                <div class="col-lg-6">
                                    <div class="footer-area">
                                        <a href="{{route('admin-order-invoice',$order->id)}}" class="mybtn1" style="    float: right;"><i class="fas fa-eye"></i> View Invoice</a>
                                    </div>
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
                                                        </tr><?php /*
                                                        
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
                            @endif */?>
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
                            @if( @$order->map_lat !='25.354826' && @$order->map_long !='51.183884000000035')
                            <br><br>
                            <div class="row shipping_location_details_div"  >
                                <div class="col-lg-12 order-details-table">
                                    <div class="mr-table">
                                        <h4 class="title">Shipping location map views</h4>
                                        <div class="table-responsiv shipping_location_details" style="text-align: center;">
                                            <br/>
                                            <a href="https://maps.google.com/maps?q=<?php echo @$order->map_lat;?>,<?php echo @$order->map_long;?>&hl" class="url_google_map" target="_blank">Click Here for Google Map</a>
                                            <br/><br/>
                                            <!--<a href="https://api.whatsapp.com/send?text=>"class="url_google_map_sharing"  target="_blank">-->
                                                <!-- Share Shipping Locations -->
                                            <!--    Click here to share on <img src="https://www-cdn.whatsapp.net/img/v4/whatsapp-logo.svg?v=46fe27fc8" style="background: #99f2aa;padding: 10px;border-radius: 21px;">-->
                                            <!--</a>-->
                                            <p></p>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-lg-5"></div>
                                    <div class="col-lg-2">
                                    <div class="wtsp  text-center" ><a target="_blank" href="https://api.whatsapp.com/send?text=<?php echo urlencode('https://maps.google.com/maps?q='.$order->map_lat.','.$order->map_long.'&hl');?>">
										   
										   <img src="{{url('/assets/images/whatsapp.png')}}" style="    width: 34%;"></a></div></div>
									<div class="col-lg-5"></div>
									</div>
                            @endif
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

{{-- LICENSE MODAL --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">License Key</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

                <div class="modal-body">
                    <p class="text-center">The Licenes Key is :  <span id="key" style="word-break: break-all;"></span> <a href="javascript:;" id="license-edit">Edit License</a><a href="javascript:;" id="license-cancel" class="showbox">Cancel</a></p>
                    <form method="POST" action="{{route('admin-order-license',$order->id)}}" id="edit-license" style="display: none;">
                        {{csrf_field()}}
                        <input type="hidden" name="license_key" id="license-key" value="">
                        <div class="form-group text-center">
                    <input type="text" name="license" placeholder="Enter New License Key" style="width: 40%; border: none;" required=""><input type="submit" name="submit" class="btn btn-primary" style="border-radius: 0; padding: 2px; margin-bottom: 2px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" id="license-btn" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


{{-- LICENSE MODAL ENDS --}}

{{-- MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">Send Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact-form">
                                <form id="emailreply">
                                    {{csrf_field()}}
                                    <ul>
                                        <li>
                                            <input type="email" class="input-field eml-val" id="eml" name="to" placeholder="Email *" value="" required="">
                                        </li>
                                        <li>
                                            <input type="text" class="input-field" id="subj" name="subject" placeholder="Subject *" required="">
                                        </li>
                                        <li>
                                            <textarea class="input-field textarea" name="message" id="msg" placeholder="Your Message *" required=""></textarea>
                                        </li>
                                    </ul>
                                    <button class="submit-btn" id="emlsub" type="submit">Send Email</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

{{-- MESSAGE MODAL ENDS --}}

@endsection

@section('scripts')

<script type="text/javascript">
$('#example').dataTable( {
  "ordering": false,
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      'responsive'  : true
} );
</script>

    <script type="text/javascript">
        $(document).on('click','#license' , function(e){
            var id = $(this).parent().find('input[type=hidden]').val();
            var key = $(this).parent().parent().find('input[type=hidden]').val();
            $('#key').html(id);  
            $('#license-key').val(key);    
    });
        $(document).on('click','#license-edit' , function(e){
            $(this).hide();
            $('#edit-license').show();
            $('#license-cancel').show();
        });
        $(document).on('click','#license-cancel' , function(e){
            $(this).hide();
            $('#edit-license').hide();
            $('#license-edit').show();
        });

        $(document).on('submit','#edit-license' , function(e){
  e.preventDefault();
  $('button#license-btn').prop('disabled',true);

      $.ajax({
       method:"POST",
       url:$(this).prop('action'),
       data:new FormData(this),
       dataType:'JSON',
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {
          if ((data.errors)) {
          $('.alert-danger').show();
          $('.alert-danger ul').html('');
            for(var error in data.errors)
            {
              $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>');
            }
            $("#modal1 .modal-content .modal-body .alert-danger").focus();
            $('button#license-btn').prop('disabled',false);
          }
          else
          {
            $('.alert-success').show();
            $('.alert-success p').html(data);
            $('button#license-btn').prop('disabled',false);
            $('#confirm-delete').modal('toggle');

           }
       }
        });
});
    </script>

@endsection