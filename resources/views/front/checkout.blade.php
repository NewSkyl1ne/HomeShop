@extends('layouts.front')

@section('content')

<section class="abt-tp">
  <div class="container">
    <div class="col-md-12">
      <h2>Billing</h2>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{url('/')}}">Home</a></li>
          <li>Billing</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="billing">
  <div class="container">
    <div class="col-md-12 clearfix">
      <h2>Billing Address</h2>
      
      <form method="POST" action="{{route('front.placeorder')}}" id="checkoutform">
         
      	{{ csrf_field() }}
       <div class="row">
         <div class="col-md-7">
           <div class="form-group">
          <div class="row">
            <div class="col-md-12"><label> Name <sup>*</sup> </label><input type="text" name="b_name" class="form-control" value="{{$user->name}}" @if($user->city != '' ) disabled  @else required @endif ></div>
          </div>
        </div>
        
        <div class="form-group">
          <div class="row">
            <div class="col-md-6"><label>Email Address <sup>*</sup> </label><input type="text" name="b_email" class="form-control" value="{{$user->email}}"  @if($user->city != '' ) disabled  @else required @endif ></div>
            <div class="col-md-6"><label>Phone Number <sup>*</sup> </label><input  type="tel" minlength="8" maxlength="8"  name="b_phone" class="form-control" value="{{$user->phone}}"  @if($user->city != '' ) disabled  @else required @endif ></div>
          </div>
        </div><?php /*
        <div class="form-group">
          <div class="row">
            <div class="col-md-4"><label>Building No <sup>*</sup> </label><input type="number" name="b_building_no" class="form-control" value="{{$user->building_no}}" placeholder="Building No *"  @if($user->building_no != '' ) disabled  @else required @endif ></div>
            <div class="col-md-4"><label>Zone <sup>*</sup> </label><input type="number"  name="b_zone_no" class="form-control" value="{{$user->zone_no}}" placeholder="Zone *"  @if($user->zone_no != '' ) disabled  @else required @endif   ></div>
            <div class="col-md-4"><label>Street <sup>*</sup> </label><input type="number"  name="b_street_no" class="form-control" value="{{$user->street_no}}" placeholder="Street *"   @if($user->street_no != '' ) disabled  @else required @endif  ></div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12">
              <label>Choose Your city <sup>*</sup> </label>
              <select class="form-control   @if($user->city == '' )  shipping_city_class @endif " name="b_city"  @if($user->city != '' ) disabled  @else required @endif  >
                <option value="">Choose City(*)</option>
                @php 
                $list               =   DB::table('pickups')->get();
                @endphp
                @if( count($list) > 0 )
                @foreach( $list as $value)
                <option value="{{$value->id}}"  data-price="{{$value->shipping_charge}}" @php if($user->city == $value->id ) echo "selected"; @endphp >{{$value->location}}</option>
                 @php 
                 if($user->city == $value->id ){
                 $shpping_charge = $value->shipping_charge;
                 }
                 
                 @endphp
                @endforeach
                @endif
              </select>
            </div>
          </div>
        </div>
         <div class="form-group">
          <div class="row">
            <div class="col-md-12"><label>Address </label></div>
            <div class="col-md-12"><input type="text" class="form-control" name="b_address" placeholder="Building Address" value="{{$user->address}}"  @if($user->address != '' ) disabled  @endif ></div>
          </div>
        </div> */ ?>
        <!-- <div class="form-group">
          <div class="row">
            <div class="col-md-6"><label>Street Number<sup>*</sup> </label><input type="text" class="form-control"></div>
            <div class="col-md-6"><label>Zone Number<sup>*</sup> </label><input type="text" class="form-control"></div>
          </div>
        </div> -->
        
        
         </div>
         
         <!--<div class="col-md-5">
           <div class="form-group">
          <div class="row">
            <div class="col-md-12"><label>Order Notes </label>
            	<textarea class="form-control" name="order_notes"></textarea>
            </div>
          </div>
        </div>
         <div class="form-group">
          <div class="row">
            <div class="col-md-12"><ul><li class="filt__item"><a href="{{url('/user/login')}}"><label class="label--checkbox">Create an Account</label></a></li></ul></div>
          </div>
        </div>
         </div> -->
       </div>
        
        
      
      
      <h2>Shipping Details</h2>
      <!--<div class="row">-->
      <!--      <div class="col-md-12"><ul><li class="filt__item"><label class="label--checkbox" id="shipp_to_different_Address">-->
      <!--      	<input type="checkbox" class="checkbox" value="1" name="shipp_to_different_Address" data-id="0"  id="shipp_to_different_Address_ck">Ship to Different Address ?</label></li></ul></div>-->
      <!--</div>-->
      <span class="newshippingAddress_html">
          <!--<h2></h2>-->
        <?php 
        $user = Auth::user();
        $shipping_address=DB::table('shipping_address')->where('user_id','=',$user->id)->get();
          ?>
        <div class="form-group">
          <div class="row">
            <div class="col-md-8">
              <label>Choose Shipping Address <sup>*</sup> </label>
              <select class="form-control shipping_city_class_html"  name="shipping_address" id="shipping_address" required >
                <option value="">Choose Shipping Address(*)</option>
                @php 
                $list               =   DB::table('pickups')->get();
                @endphp
                @if( count($shipping_address) > 0 )
                @foreach( $shipping_address as $value)
                <option value="{{$value->id}}"  >   {{$value->shipping_name}},
                                                    {{$value->shipping_email}},
                                                     {{$value->shipping_phone}}
                                                  <?php  /* Building Number: {{$value->shipping_building_no}},
                                                    Zone Number: {{$value->shipping_zone_no}},
                                                    Street Number: {{$value->shipping_street_no}} */ ?>
                </option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="col-md-4">
                <a  href="{{route('user-add-shipping-address')}}" class="gllpSearchButton btn-po"  >Add New Shipping Address</a>
            </div>
          </div>
        </div>
      <div class="row shipping_address_row" style="display: none;">
         <div class="col-md-7">
           <div class="form-group">
          <div class="row">
            <div class="col-md-12"><label> Name <sup>*</sup> </label>
            	<input type="text" class="form-control shipping_name" value="" name="shipping_name"  required></div>
          </div>
        </div>
        
        <div class="form-group">
          <div class="row">
            <div class="col-md-6"><label>Email Address <sup>*</sup> </label>
            	<input type="email" class="form-control shipping_email" value="" name="shipping_email" required></div>
            <div class="col-md-6"><label>Phone Number <sup>*</sup> </label>
            	<input  type="tel" minlength="8" maxlength="8"  class="form-control shipping_phone" value="" name="shipping_phone" required></div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-4"><label>Building No </label><input type="number" name="shipping_building_no" class="form-control shipping_building_no" value="" placeholder="Building No "></div>
            <div class="col-md-4"><label>Zone <sup>*</sup> </label><input type="number"  name="shipping_zone_no" class="form-control shipping_zone_no" value="" placeholder="Zone *" required  ></div>
            <div class="col-md-4"><label>Street  </label><input type="number"  name="shipping_street_no" class="form-control shipping_street_no" value="" placeholder="Street "></div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12">
              <label>Choose Your city <sup>*</sup> </label>
              <input type="text" class="form-control shipping_city" placeholder="Shipping City" value="" name="shipping_city" required>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12"><label>Address <sup>*</sup></label></div>
            <div class="col-md-12">
            	<input type="text" class="form-control shipping_address" placeholder="Building Address" value="" name="shipping_address" ></div>
          </div>
        </div>
        <input type="hidden" class="gllpLatitude  form-control" name="lat" id="map-lat"  value="25.354826"/>
        <input type="hidden" class="gllpLongitude  form-control" name="long" id="map-long" value="51.183884000000035"/>
        
         </div>
       </div>
      </span>
      <?php /*
      <h2>Select Your location</h2>
        <!-- Map area -->
         
        <div class="row">
             <div class="col-md-12">
            <script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyDxy-EJ14mC78Yo4mUW950ZwOs-bc3OotM"></script>
            <script src="{{asset('new_asstes/js/jquery-gmaps-latlon-picker.js')}}" type="text/javascript"></script>
            <fieldset class="gllpLatlonPicker">
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-10">
        		        <input type="text" placeholder="Search Location..." class="gllpSearchField  form-control">
        		    </div>
        		    <div class="col-md-2">
        		        <input type="button" class="gllpSearchButton btn-po" value="search" style="    margin-top: 0px;">
        		    </div>
        		</div><br>
        		<div class="gllpMap" style="width:100%;height:500px;">Google Maps</div>
        		<br/>
        		<input type="hidden" class="gllpLatitude  form-control" name="lat" id="map-lat"  value="25.354826"/>
        		<input type="hidden" class="gllpLongitude  form-control" name="long" id="map-long" value="51.183884000000035"/>
        		<input type="hidden" class="gllpZoom" value="8"/>
        		
        		<br/>
        	</fieldset></div>
        </div> */?>
        <!-- End Map area -->
        <!--<div class="row" style="margin-top: 15px;">
            <div class="col-md-6">
                <input type="text" name="lat" id="map-lat" class=" form-control" value="" placeholder="Latitude ">
            </div>
            <div class="col-md-6">
            <input type="text" name="long" id="map-long"  class=" form-control" value="" placeholder="Longitude ">
            </div>
        </div>-->
        <h2 style="display:none;">Coupon</h2>
        <div class="form-group" style="display:none;">
          <div class="row">
            <div class="col-md-8" >
            <input name="coupon" id="couponCode" type="text" class="input-field couponCode" placeholder="Enter Coupon Code"/>
            </div>
            <div class="col-md-4">
                <button id="redeemCoupon" class="gllpSearchButton btn-po">Reedem Coupon</button>
            </div>
          </div>
        </div>


      <h2>Your Order</h2>
      
      <div class="yor">
        <ul>
        	@php 
            $total_amount   = 0;
            @endphp
            @foreach($cartlist as $value)
            @php
            $product = DB::table('products')
                           ->where('id', '=', $value->product_id)
                           ->get()->first();                        
            @endphp
          <li>
            <div class="yor-lft">{{$value->qty}} X</div>
            <div class="yor-mid">{{$product->name}} 
             <a href="{{url('/item/'.$product->slug)}}"><img src="{{ $product->photo ? asset('assets/images/products/'.$product->photo):asset('assets/images/noimage.png') }}" class="img-fluid" style="width: 68px;"></a> </div>
          
            <div class="yor-rgt">QAR @php echo  $sub_total = $product->price * $value->qty @endphp</div>
          </li>
           @php    $total_amount =  $total_amount + $sub_total; @endphp
           @endforeach
          
        </ul>
      </div>
      <?php /*
       <h2>Choose Your Delevery Time</h2>
      <div class="form-group">
          <div class="row">
            <div class="col-md-12"></div>
            <div class="col-md-12">
              <select class="form-control" name="deleveryTime" required>
                <option value="">Choose Delevery Time(*)</option>
                @php 
                $list               =   DB::table('delivery_time')->get();
                @endphp
                @if( count($list) > 0 )
                @foreach( $list as $value)
                <option value="{{$value->time}}">{{$value->time}}</option>
                @endforeach
                @endif
              </select></div>
          </div>
        </div>
        */
        ?>
         <h2>Disclaimer</h2>
      <div class="form-group">
          <div class="row">
            <div class="col-md-12"></div>
            <div class="col-md-12">
                @php
                $pages 						= 	DB::table('pages')->where('slug','Disclaimer')->get()->first();
                
                @endphp
            <p>@php echo $pages->details; @endphp</p>
             <?php /* <select name="deleveryTime" >
                <option value="">Choose Delevery Time(*)</option>
                @php 
                $list               =   DB::table('delivery_time')->get();
                @endphp
                @if( count($list) > 0 )
                @foreach( $list as $value)
                <option value="{{$value->time}}">{{$value->time}}</option>
                @endforeach
                @endif
              </select> */?>
              </div> 
          </div>
        </div>
        
      <div class="ttl clearfix">
        <ul>
          <li>Cart Subtotal <span>QAR {{$total_amount}} </span> </li>
          @php 
          if( @$shpping_charge == '' || @$shpping_charge == 0 ){
            @endphp
            <li>Shipping <span  class="shipping_charge" >Free Shipping</span> </li>
            @php 
          }else{
             @endphp
            <li>Shipping Charge <span class="shipping_charge" translate="no">QAR {{$shpping_charge}} </span> </li>
            @php 
            $total_amount = $total_amount+ $shpping_charge;
          }
          @endphp
		  <li> 	Discount <span class="total_discount" translate="no">QAR 0</span> </li>
      <li style="display:none" class="remove_coupon"> <button id="removeCoupon"  style="background-color: #d02034;color:#fff">Remove Coupon</button></li>
          <li>Order Total <span class="total_charge ">QAR {{$total_amount}} </span> </li>
        </ul>
      </div>
      
     <div class="cd-sec">
        <div class="row">
            <div class="col-md-12"><ul>
              <li class="filt__item">
                <label class="label--checkbox">
                  <input type="radio" class="checkbox" value="1" name="payement_type" required>
                  <span>Cash on delivery </span> <br> 
                </label>
              </li>
                <li class="filt__item">
                <label class="label--checkbox">
                  <input type="radio" class="checkbox" value="2" name="payement_type" required>
                  <span>Payment by Card</span>
                </label>
              </li>
            </ul>
          </div>
          </div>
      </div>
      
      <button class="btn-po" type="submit" id="placeoorder">Place Order</button>
      </form>
    </div>
  </div>
</section>

<span class="shippin_html_jqery" style="display: none;">
	<h2></h2>
      <div class="row">
         <div class="col-md-7">
           <div class="form-group">
          <div class="row">
            <div class="col-md-12"><label> Name <sup>*</sup> </label>
            	<input type="text" class="form-control shipping_name" value="" name="shipping_name" required></div>
          </div>
        </div>
        
        <div class="form-group">
          <div class="row">
            <div class="col-md-6"><label>Email Address <sup>*</sup> </label>
            	<input type="email" class="form-control" value="" name="shipping_email" required></div>
            <div class="col-md-6"><label>Phone Number <sup>*</sup> </label>
            	<input  type="tel" minlength="8" maxlength="8"  class="form-control shipping_phone" value="" name="shipping_phone" required></div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-4"><label>Building No <sup>*</sup> </label><input type="number" name="shipping_building_no" class="form-control shipping_building_no" value="" placeholder="Building No *" required ></div>
            <div class="col-md-4"><label>Zone <sup>*</sup> </label><input type="number"  name="shipping_zone_no" class="form-control shipping_zone_no" value="" placeholder="Zone *" required  ></div>
            <div class="col-md-4"><label>Street <sup>*</sup> </label><input type="number"  name="shipping_street_no" class="form-control shipping_street_no" value="" placeholder="Street *" required ></div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12">
              <label>Choose Your city <sup>*</sup> </label>
   
              <input type="text" class="form-control shipping_city" placeholder="Shipping City" value="" name="shipping_city" required>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12"><label>Address <sup>*</sup></label></div>
            <div class="col-md-12">
            	<input type="text" class="form-control shipping_address" placeholder="Building Address" value="" name="shipping_address" required></div>
          </div>
        </div>
        
        
         </div>
       </div>
</span>
<script>
    $(document).ready(function(){
        $("body").on('change','.shipping_city_class',function(){
            var price =  $('option:selected', this).attr('data-price');
            var tottal  =   '<?php echo $total_amount; ?>';
            var sub_total   =   parseInt(price) + parseInt(tottal);
            $(".shipping_charge").html('QAR '+price);
            $(".total_charge").html ('QAR '+sub_total);
        })
       
    })
    $('body').on('change','#shipping_address',function(){
       var id = $(this).val();
       if(id != ''){
            var shippin_address = '<?php echo  json_encode($shipping_address); ?>';
            shippin_address     =   $.parseJSON(shippin_address)
            console.log(shippin_address);
            var shiping_place_list='<?php echo  DB::table('pickups')->get(); ?>';
            shiping_place_list     =   $.parseJSON(shiping_place_list);
            $.each(shippin_address, function (index, titleObj) {
                if(id == titleObj.id){
                  $.each(shiping_place_list, function (index, element) {
                    if(titleObj.shipping_city==element.id)
                    {
                      var price = element.shipping_charge;
                      var tottal  =   '<?php echo $total_amount; ?>';
                      var sub_total   =   parseInt(price) + parseInt(tottal);
                      $(".shipping_charge").html('QAR '+price);
                      $(".total_charge").html ('QAR '+sub_total);
                    }
                  });
                   $('.shipping_name').val(titleObj.shipping_name);
                   $('.shipping_email').val(titleObj.shipping_email);
                   $('.shipping_phone').val(titleObj.shipping_phone);
                   $('.shipping_building_no').val(titleObj.shipping_building_no);
                   $('.shipping_zone_no').val(titleObj.shipping_zone_no);
                   $('.shipping_street_no').val(titleObj.shipping_street_no);
                   $('.shipping_city_class').val(titleObj.shipping_city);
                   $('.shipping_address').val(titleObj.shipping_address);
                   $('.gllpLatitude').val(titleObj.map_lat);
                   $('.gllpLongitude').val(titleObj.map_long);  
                   $('#shipping_address').removeAttr('required');
                   $(".shipping_address_row").show();
                }
            });
       }else{
           $('.shipping_name').val('');
           $('.shipping_email').val('');
           $('.shipping_phone').val('');
           $('.shipping_building_no').val('');
           $('.shipping_zone_no').val('');
           $('.shipping_street_no').val('');
           $('.shipping_city_class').val('');
           $('.shipping_address').val('');
           $(".shipping_address_row").hide();
           $('#shipping_address').attr('required','required');
       }
    });

    $("#redeemCoupon").click(function(){
        var couponCode =$('#couponCode').val();
        var coupon_list='<?php echo  DB::table('coupons')->get(); ?>';
        coupon_list     =   $.parseJSON(coupon_list);
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; 
		var yyyy = today.getFullYear();
		if(dd<10) 
		{
    		dd='0'+dd;
		} 

		if(mm<10) 
		{
    		mm='0'+mm;
		}	 
		today = yyyy+'-'+mm+'-'+dd;
   		var valid_status=false;
          $.each(coupon_list, function (index, couponList) {
            if(couponCode==couponList.code)
            {
              valid_status=true;
				var tottal  =   '<?php echo $total_amount; ?>';
				if(today>couponList.end_date)
				{
					alert("Your Coupon is expired on"+couponList.end_date);
						$(".total_discount").html('QAR 0');
                      	$(".total_charge").html ('QAR '+tottal);
						  $('#couponCode').val('');
						$('.remove_coupon').css('display','none');
				}else if(today<couponList.start_date)
				{
						alert("Your Coupon is valid from"+couponList.start_date)
						$(".total_discount").html('QAR 0');
                      	$(".total_charge").html ('QAR '+tottal);
                      	$('#couponCode').val('');
						$('.remove_coupon').css('display','none');	
				}else{
					if(couponList.type==1)
					{
            			if(parseInt(couponList.price)>tottal)
            			{
              				alert("You cant redeem this coupon ,To redeem this add some more item");
              				$('#couponCode').val('');
            			}else{
             				var sub_total   =     parseInt(tottal)-parseInt(couponList.price);
                      		$(".total_discount").html('QAR '+couponList.price);
                      		$(".total_charge").html ('QAR '+sub_total);	
							$('.remove_coupon').css('display','block');
            			}
					  
					}else if(couponList.type==0)
					{
					  	var total_discount_amn=((couponList.price*tottal)/100);
            			if(total_discount_amn>tottal)
            				{
              					alert("You cant redeem this coupon ,To redeem this add some more item");
              					$('#couponCode').val()='';
            			}else{
             					var sub_total=parseInt(tottal)-parseInt(total_discount_amn);
                      			$(".total_discount").html('QAR '+total_discount_amn+'('+couponList.price+'%)');
                      			$(".total_charge").html ('QAR '+sub_total);	
								            $('.remove_coupon').css('display','block');
            				}   
					}

				}

            }
          });
          if(valid_status==false)
          {
            alert("Invalid coupon");
			$('.remove_coupon').css('display','none');
			var tottal  =   '<?php echo $total_amount; ?>';
			$(".total_discount").html('QAR 0');
			$(".total_charge").html ('QAR '+tottal);
			$('#couponCode').val('');
          }
    }); 

    $("#removeCoupon").click(function(){
      var tottal  =   '<?php echo $total_amount; ?>';
      $(".total_discount").html('QAR 0');
      $(".total_charge").html ('QAR '+tottal);
	  $('#couponCode').val('');
	  $('.remove_coupon').css('display','none');	

    });
    $('#checkoutform').on('submit',function(){
     $('#preloader').show();
     
     document.getElementById("placeoorder").style.display = "none";
});
</script>




@endsection


