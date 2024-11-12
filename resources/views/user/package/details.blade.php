@extends('layouts.front')
@section('content')
<style type="text/css">
    .back_but{
        display: block;
        background: #d12438;
        color: #fff;
        padding: 6px;
        font-size: 16px;
        border-radius: 14px;
        width: 96px;
        padding-left: 15px;
        margin-left: 50px;
    }
</style>
<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
                <div class="col-lg-8">
<div class="user-profile-details">
                        
<div class="account-info">
                            <div class="header-area">
                                <h4 class="title" style="display: flex; flex-wrap: wrap">
                                    Package Details 
                                    <a class="back_but" href="{{route('user-package')}}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                                </h4>
                            </div>
                            <div class="pack-details">
                                <div class="row">

                                    <div class="col-lg-4">
                                        <h5 class="title">
                                            Plan:
                                        </h5>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="value">
                                            {{$subs->title}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5 class="title">
                                            Price:
                                        </h5>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="value">
                                            {{$subs->price}}{{$subs->currency}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5 class="title">
                                            Durations:
                                        </h5>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="value">
                                            {{$subs->days}} Day(s)
                                    </p></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5 class="title">
                                            Product(s) Allowed:
                                        </h5>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="value">
                                            {{ $subs->allowed_products == 0 ? 'Unlimited':  $subs->allowed_products}}
                                        </p>
                                    </div>
                                </div>

                                        @if(!empty($package))
                                            @if($package->subscription_id != $subs->id)
                                <div class="row">
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-8">
                                        <span class="notic"><b>Note:</b> Your Previous Plan will be deactivated!</span>
                                    </div>
                                </div>

                                <br>
                                            @else
                                <br>

                                            @endif
                                        @else
                                <br>
                                <br>
                                <br>
                                        @endif

                                        <form id="subscribe-form" action="{{route('user-vendor-request-submit')}}" method="POST" enctype="multipart/form-data">

                            @include('includes.form-success')
                            @include('includes.form-error')
                                            
                                            {{ csrf_field() }}


                                        @if($user->is_vendor == 0)

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Shop Name *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="shop_name" placeholder="Shop Name" required>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Owner Name *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="owner_name" placeholder="Owner Name" required>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Phone  Number *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="tel" minlength="8" maxlength="8" class="form-control" name="shop_number" placeholder="Shop Number" required>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Shop Building No *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="number" class="form-control" name="building_no" placeholder="Shop Building No " required>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Shop Zone *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="number" class="form-control" name="zone_no" placeholder="Shop Zone " required>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Shop Street *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="number" class="form-control" name="street_no" placeholder="Shop Street " required>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Shop City *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                <select class="form-control"  name="city" required="" >
                                                  <option value="">Choose City(*)</option>
                                                  @php 
                                                  $list               =   DB::table('pickups')->get();
                                                  @endphp
                                                  @if( count($list) > 0 )
                                                  @foreach( $list as $value)
                                                  <option value="{{$value->id}}" >{{$value->location}}</option>
                                                  @endforeach
                                                  @endif
                                                </select>
                                                   
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Shop Address *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="shop_address" placeholder="Shop Address" required>
                                            </div>
                                        </div>

                                        <br>
                                         <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Shop Type *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                <select class="form-control shop_type"  name="shop_type" required="" >
                                                    <option value="">Shop Type(*)</option>
                                                    <option value="company" >Company</option>
                                                    <option value="individual" >Individual</option>
                                                  
                                                </select>
                                                   
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1 reg_number" >
                                                    CR Number *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="reg_number" placeholder="Registration Number" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1 " >
                                                    Document Proof *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="file" name="file" class="img-upload" id="image-upload" required>
                                            </div>
</div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Message <small>(Optional)</small>
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                <textarea class="form-control"name="shop_message" placeholder="Message" rows="5"></textarea>
                                            </div>
                                        </div>

                                        <br>


                                        @endif
                                        <input type="hidden" name="subs_id" value="{{ $subs->id }}">

                                 @if($subs->price != 0)       

                              <?php /* <div class="row">
                                    <div class="col-lg-4">
                                        <h5 class="title pt-1">
                                            Select Payment Method *
                                        </h5>
                                    </div>
                                    <div class="col-lg-8">

                                            <select name="method" id="option" onchange="meThods(this)" class="option" required="">
                                                <option value="">Select an option</option>
                                                <option value="Paypal">Paypal</option>
                                                <option value="Stripe">Stripe</option>
                                            </select>

                                    </div>
                                </div>*/ ?>


                                            <div id="stripes" style="display: none;">

                                    <br>



                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Card *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="card" id="scard" placeholder="Card">
                                            </div>
                                        </div>

                                    <br>


                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Cvv *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="cvv" id="scvv" placeholder="Cvv">
                                            </div>
                                        </div>

                                    <br>


                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Month *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="month" id="smonth" placeholder="Month">
                                            </div>
                                        </div>


                                    <br>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="title pt-1">
                                                    Year *
                                                </h5>
                                            </div>
                                            <div class="col-lg-8">
                                                    <input type="text" class="option" name="year" id="syear" placeholder="Year">
                                            </div>
                                        </div>

                                            </div>
                                            <div id="paypals">
                                                <input type="hidden" name="cmd" value="_xclick">
                                                <input type="hidden" name="nuuuue="1">
                                                <input type="hidden" name="lc" value="UK">
                                                <input type="hidden" name="currency_code" value="{{strtoupper($subs->currency_code)}}">
                                                <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest">
                                            </div>

                                @endif
                                <div class="row">
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-8">
                                            <button type="submit" class="adbs" style="width: 29%;">Submit</button>
                                    </div>
                                </div>




                                 </form>



                            </div>
                        </div>
                    </div>
                </div>
      </div>
    </div>
  </section>
<script type="text/javascript">
    $(".shop_type").change(function(){
        var shop_type = $(this).val();
        // alert(shop_type);
        if( shop_type == 'company' ){
            $(".reg_number").html('CR Number *');
        }
        if( shop_type == 'individual' ){
            $(".reg_number").html('QID Number *');
        }
    });
</script>
@endsection



@section('scripts')

@if($subs->price != 0)
<script type="text/javascript">
    
        function meThods(val) {
            var action1 = "{{route('user.paypal.submit')}}";
            var action2 = "{{route('user.stripe.submit')}}";

             if (val.value == "Paypal") {
                $("#subscribe-form").attr("action", action1);
                $("#scard").prop("required", false);
                $("#scvv").prop("required", false);
                $("#smonth").prop("required", false);
                $("#syear").prop("required", false);
                $("#stripes").hide();
            }
            else if (val.value == "Stripe") {
                $("#subscribe-form").attr("action", action2);
                $("#scard").prop("required", true);
                $("#scvv").prop("required", true);
                $("#smonth").prop("required", true);
                $("#syear").prop("required", true);
                $("#stripes").show();
            }
        }    
</script>
@endif

<script type="text/javascript">
    
$('#subscribe-form').on('submit',function(){
     $('#preloader').show();
});

    
</script>

@endsection