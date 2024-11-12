@extends('layouts.front')
@section('content')<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .user-rating {
    direction: rtl;
    font-size: 20px;
    unicode-bidi: bidi-override;
    padding: 10px 30px;
    display: inline-block;
}
.user-rating input {
    opacity: 0;
    position: relative;
    left: -15px;
    z-index: 2;
    cursor: pointer;
}
.user-rating span.star:before {
    color: #777777;
    content:"ï€†";
    /*padding-right: 5px;*/
}
.user-rating span.star {
    display: inline-block;
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    position: relative;
    z-index: 1;
}
.user-rating span {
    margin-left: -15px;
}
.user-rating span.star:before {
    color: #777777;
    content:"\f006";
    /*padding-right: 5px;*/
}
.user-rating input:hover + span.star:before, .user-rating input:hover + span.star ~ span.star:before, .user-rating input:checked + span.star:before, .user-rating input:checked + span.star ~ span.star:before {
    color: #ffd100;
    content:"\f005";
}

.selected-rating{
    color: #ffd100;
    font-weight: bold;
    font-size: 3em;
}
</style>
	<!-- User Dashbord Area Start -->
	<section class="user-dashbord">
		<div class="container">
			<div class="row">
				@include('includes.user-dashboard-sidebar')
				<div class="col-lg-8">
					<div class="user-profile-details">
						<div class="order-details fix-mob">
							<div class="header-area">
								<h4 class="title">
									My Order Details
								</h4>
							</div>
							<div class="view-order-page">
								<h3 class="order-code">Order# {{$order->order_number}} [{{$order->status}}]</h3>
								<?php /*<div class="print-order text-right">
									<a href="{{route('user-order-print',$order->id)}}" target="_blank" class="print-order-btn">
										<i class="fa fa-print"></i> print order
									</a>
								</div>*/ ?>
								<p class="order-date">Order Date {{date('d-M-Y',strtotime($order->created_at))}}</p>

@if($order->dp == 1)

                                                        <div class="billing-add-area">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h5>Billing Address</h5>
                                                                    <address>
                                                                        <?php $user                       = Auth::user();?>
                                                                        Name: {{$user->name}}<br>
                                                                        Email: {{$user->email}}<br>
                                                                        Phone: {{$user->phone}}<br>
                                                                        Address: {{$user->address}}<br>
                                                                        
                                                                    </address>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h5>Payment Information</h5>
                                                                    <p>Paid Amount: {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</p>
                                                                    <p>Payment Method: {{$order->method}}</p>

                                                                    @if($order->method != "Cash On Delivery")
                                                                        @if($order->method=="Stripe")
                                                                            {{$order->method}} Charge ID: <p>{{$order->charge_id}}</p>
                                                                        @endif
                                                                        {{$order->method}} Transaction ID: <p id="ttn">{{$order->txnid}}</p><a id="tid" style="cursor: pointer;">Edit Transaction ID</a> <a style="display: none; cursor: pointer;" id="tc" >Cancel</a>
                                                                        <form id="tform">
                                                                        <input style="display: none; width: 100%;" type="text" id="tin" placeholder="Enter Transaction ID & Press Enter" required="">
                                                                        <input type="hidden" id="oid" value="{{$order->id}}">
                                                                        <button style="margin-top: 5px; display: none;" id="tbtn" type="submit" class="btn btn-default btn-sm">Submit</button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

@else
                                                        <div class="shipping-add-area">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    @if($order->shipping == "shipto")
                                                                        <h5>Shipping Address</h5>
                                                                        <address>
                Name: {{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}<br>
                Email: {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}<br>
                Phone: {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}<br>
                Building No: {{$order->shipping_building_no}}<br>
                Zone: {{$order->shipping_zone_no}}<br>
                Street: {{$order->shipping_street_no}}<br>
                Address: {{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}<br>
                @php 
                $shipping_data = DB::table('pickups')->where('id', '=', $order->shipping_city)->get()->first(); 
                @endphp
                City : {{@$shipping_data->location}}

                                                                        </address>
                                                                    @else
                                                                        <h5>PickUp Location</h5>
                                                                        <address>
                                                                            Address: {{$order->pickup_location}}<br>
                                                                        </address>
                                                                    @endif

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h5>Shipping Method</h5>
                                                                    @if($order->shipping == "shipto")
                                                                        <p>Ship To Address</p>
                                                                    @else
                                                                        <p>Pick Up</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="billing-add-area">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h5>Billing Address</h5>
                                                                    <address>
                                                                        Name: {{$user->name}}<br>
                                                                        Email: {{$user->email}}<br>
                                                                        Phone: {{$user->phone}}<br>
                                                                        Building No: {{$user->building_no}}<br>
                                                                        Zone: {{$user->zone_no}}<br>
                                                                        Street: {{$user->street_no}}<br>
                                                                        Address: {{$user->address}}<br>
                                                                        @php 
                                                                        $c_data = DB::table('pickups')->where('id', '=', $user->city)->get()->first(); 
                                                                        @endphp
                                                                        City : {{@$c_data->location}}
                                                                    </address>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h5>Payment Information</h5>
                                                                    <p>Product Amount: {{$order->currency_sign}} {{ $order->pay_amount }}</p>
                                                                    @php
                                                                    $total = @$shipping_data->shipping_charge + $order->pay_amount;
                                                                    @endphp
                                                                    <p>Shipping Amount: {{$order->currency_sign}} {{ @$shipping_data->shipping_charge }}</p>
                                                                    <hr>
                                                                    <p>Paid Amount: {{$order->currency_sign}} {{ $total }}</p>
                                                                    <p>Payment Method: {{$order->method}}</p>

                                                                    @if($order->method != "Payment by Card")
                                                                    <p>Payment Status: {{$order->payment_status}}</p>     
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
@endif
                                                        <br>




								<div >
									<h5>Ordered Products:</h5>
									<table class="table table-responsive table-bordered veiw-details-table">
                                <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <!-- <th>Size</th>
                                    <th>Color</th> -->
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Review</th>
                                </tr>
                                </thead>
										<tbody>
                                            @php $i =0; @endphp 
                                @foreach($cart as $product)
                                @php $i++; 
                                $product_data = DB::table('products')->where('id', '=', $product->product_id)->get()->first();     
                                @endphp
                                
                                    <tr>
                                        
                                        <td>{{$i}}</td>
                                        <td><a href="/item/{{$product_data->slug}}"><img src="{{ $product_data->photo ? asset('assets/images/products/'.$product_data->photo):asset('assets/images/noimage.png') }}"></img></a></td>
                                        <td id="val">{{$product_data->name}}</td>
                                        <td>{{$product->qty}}</td>
                                        <td>₹ {{$product->price}}</td>
                                        <td>₹ @php echo $product->price*$product->qty @endphp</td>
                                    <?php /*
                                            <td>{{ $product['item']['id'] }}</td>
                                            <td>
                                                <input type="hidden" value="{{ $product->license }}">
                                                @if($product->user_id != 0)
                                                @php
                                                $user = App\Models\User::find($product->user_id);
                                                @endphp
                                                @if(isset($user))
                                              <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{strlen($product['item']['name']) > 30 ? substr($product['item']['name'],0,30).'...' : $product['item']['name']}}</a>
                                                @else
                                                <a href="javascript:;">{{strlen($product['item']['name']) > 30 ? substr($product['item']['name'],0,30).'...' : $product['item']['name']}}</a>
                                                @endif
                                                @endif
                                                @if($product['item']['type'] != 'Physical')
                                                @if($order->payment_status == 'Completed')
                                                    @if($product['item']['file'] != null)
                                                <a href="{{ route('user-order-download',['slug' => $order->order_number , 'id' => $product['item']['id']]) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                                    @else
                                            <a target="_blank" href="{{ $product['item']['link'] }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                                    @endif
                                                @if($product['license'] != '')
                              <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-info product-btn" id="license"><i class="fa fa-eye"></i> View License</a>                                                
                                                @endif
                                                @endif
                                                @endif
                                            </td>
                                            <td>{{$product['qty']}} {{ $product['item']['measure'] }}</td>
                                            <td>{{$product['size']}}</td>{{route('user-vendor-request',$sub->id)}}
                                            <td><span style="width: 40px; height: 20px; display: block; border: 10px solid {{$product['color'] == "" ? "white" : $product['color']}};"></span></td>
                                            <td>{{$order->currency_sign}}{{round($product['item']['price'] * $order->currency_value,2)}}</td>
                                            <td>{{$order->currency_sign}}{{round($product['price'] * $order->currency_value,2)}}</td>
                                            */
                                           if($order->status=="completed")
                                           {
                                            $prev 				= 	DB::table('ratings')->where('product_id','=',$product->product_id)
                                            ->where('user_id','=',$order->user_id)
                                            ->get();
                                            if(count($prev)>0)
                                            {
                                                ?>
                                                <td>
                                                    <!-- Review({{$prev[0]->rating}}.0) -->
                                                    <td> <a href="javascript:;" onclick="updatereview(this);" value="{{$prev}}" data-toggle="modal" data-target="#review-update-rating" class="btn btn-info product-btn"><i class="fa fa-eye"></i>Update Review</a>
                                                </td>
                                                <?php

                                            }else
                                            {
                                                ?>
                                                <td> <a href="javascript:;" onclick="test(this);" value="{{$product->product_id}}" id="reviewrate" data-toggle="modal" data-target="#review-rating" class="btn btn-info product-btn"><i class="fa fa-eye"></i> Rate&Review</a>
                                                </td> 
                                                <?php
                                            }
                                           }else
                                         {
                                        ?>
                                        <td></td>
                                        <?php
                                         }
                                        ?>
                                            
                                                                             </tr>
                                @endforeach
										</tbody>
									</table>
                                </div>

									<div class="edit-account-info-div">
										<div class="form-group">
											<a class="back-btn" href="{{ route('user-orders') }}">Back</a>
                                            <button type="button" class="btn-po" data-toggle="modal" @if($order->status=="declined"||$order->status=="completed") disabled hidden @endif data-target="#confirm-cancel-order" style="margin-top:10px !important">Cancel Order</button>
										</div>
									</div>
                                    <div class="edit-account-info-div">
										<div class="form-group">
                                        <!-- <a   class="btn-po"><u>Cancel Order</u></a> -->
                                       
										</div>
									</div>
                                    
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

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
                    <p class="text-center">The Licenes Key is :  <span id="key"></span></p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-cancel-order" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header d-block text-left">
        <h4 class="modal-title d-inline-block">Cancel Order</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

                <div class="modal-body">
                    <p class="text-left">Are you sure want to cancel this order ? <span id="key"></span></p>
                </div>
                <div class="modal-footer">
                    <div class="justify-content-left">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    <div class="justify-content-right">
                    <a type="button" href="{{ route('order-cancle-request',$order->order_number) }}" class="btn btn-success">confirm</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="review-rating" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header d-block text-left">
        <h4 class="modal-title d-inline-block">Rate&Review</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

        <div class="modal-body">
            <form  method="POST" action="{{ route('review.submit') }}">
                {{csrf_field()}}
                <label for="rating">Please provide rating</label>
                <span id="rating" class="user-rating">
                    <input type="radio"  name="rating" value="5"><span class="star"></span>

                    <input type="radio" name="rating" value="4"><span class="star"></span>

                    <input type="radio" name="rating" value="3"><span class="star"></span>

                    <input type="radio" name="rating" value="2"><span class="star"></span>

                    <input type="radio" name="rating" value="1"><span class="star"></span>
                </span>
                <br>
                <span>
                    <label for="review">Please drop review</label>
                    <textarea id="review" name="review" rows="3" cols="40"></textarea>
                </span>
                <span style="display:none">
                    <input type="text" name="product_id" id="product_id" >
                </span>
                <span style="display:none">
                    <input type="text" name="title" value="title" id="title" >
                </span>
                
                <br>
            
        </div>
                <div class="modal-footer">
                    <div class="justify-content-left">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    <input  class="btn btn-danger" type="submit">

                    
                </div>
              </form>
            </div>
        </div>
    </div>

<div class="modal fade" id="review-update-rating" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-block text-left">
                <h4 class="modal-title d-inline-block">Update Rate & Review</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('review.update.submit') }}">
                    {{csrf_field()}}
                    <label for="rating">Update rating</label>
                    <span id="rating_Update" class="user-rating">
                        <input type="radio" id="radio5" name="rating" value="5"><span class="star"></span>

                        <input type="radio" id="radio4" name="rating" value="4"><span class="star"></span>

                        <input type="radio" id="radio3" name="rating" value="3"><span class="star"></span>

                        <input type="radio" id="radio2" name="rating" value="2"><span class="star"></span>

                        <input type="radio" id="radio1" name="rating" value="1"><span class="star"></span>
                    </span>
                    <br>
                    <span>
                    <label for="review">Update review</label>
                        <textarea id="review_Update" name="review" rows="3" cols="40"></textarea>
                    </span>
                    <span style="display:none">
                        <input type="text" name="product_id" id="product_id_Update" >
                    </span>
                    <span style="display:none">
                        <input type="text" name="title" value="titleUpdate" id="title_Update" >
                    </span>
                    <br>
                    <div class="modal-footer">
                        <div class="justify-content-left">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                        <input class="btn btn-danger" type="submit">
                        <div class="justify-content-left">
                            <a type="button" onclick="$('#review-update-rating').modal('hide');" data-toggle="modal" data-target="#confirm-delete-review" id="product_desc" class="btn btn-danger">Delete</a>
                    </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-delete-review" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-block text-left">
                <h4 class="modal-title d-inline-block">Delete Product Review & Rating</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p class="text-left">Are you sure want to delete product review and ratings ? <span id="key"></span></p>
                </div>
                <div class="modal-footer">
                    <div class="justify-content-left">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                <div class="justify-content-right">
                    <a type="button"  onclick="deletereview()" class="btn btn-danger">Confirm</a>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>

        function test(element){
            var product_id=element.getAttribute('value');
            console.log(product_id,"product_id")
            document.getElementById("product_id").value=product_id;
            console.log(document.getElementById("product_id").value,"document]")
            

        }
        function updatereview(element)
        {
            var product=element.getAttribute('value');
            product=JSON.parse(product);
            console.log(product,"product")
            for(var i=1;i<=product[0].rating;i++)
                {
                    document.getElementById('radio'+i).checked =true;
                }
            document.getElementById("title_Update").value=product[0].title;
            document.getElementById("review_Update").value=product[0].review;
            document.getElementById("product_id_Update").value=product[0].product_id;
            document.getElementById("product_desc").value=product[0];

        }
        function deletereview()
        {

            var product=document.getElementById("product_desc").value;
            $.ajax({
                    type: "POST",
                    headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
                    url:"{{ route('review-delete-submit') }}",
                    data:{id:product.id},
                    success:function(data){
                        if(data)
                        {
                            window.location.reload();
                        }
                    }
            });


        }
    </script>

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
    <script>
      
    $(document).on("click", "#tid" , function(e){
        $(this).hide();
        $("#tc").show();
        $("#tin").show();
        $("#tbtn").show();  
    });
    $(document).on("click", "#tc" , function(e){
        $(this).hide();
        $("#tid").show();
        $("#tin").hide();  
        $("#tbtn").hide();       
    });
    $(document).on("submit", "#tbtn" , function(e){
        console.log(hai,"hai")
        var oid = $("#oid").val();
        var tin = $("#tin").val();
            $.ajax({
                    type: "GET",
                    url:"{{URL::to('user/json/trans')}}",
                    data:{id:oid,tin:tin},
                    success:function(data){
                        $("#ttn").html(data);
                        $("#tin").val("");
                        $("#tid").show();
                        $("#tin").hide(); 
                        $("#tbtn").hide(); 
                        $("#tc").hide(); 
                      }
              });     
        return false;      
    });
    </script>
    <script type="text/javascript">
    $(document).on('click','#license' , function(e){
            var id = $(this).parent().find('input[type=hidden]').val();
            $('#key').html(id);  

    });

    </script>
@endsection