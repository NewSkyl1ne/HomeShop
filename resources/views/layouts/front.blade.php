<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="{{asset('new_asstes/images/logo1.png')}}" type="image/png" sizes="16x16">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomeShop</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('new_asstes/css/bootstrap.min.css')}}?v=0.1" type="text/css">
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('new_asstes/css/webslidemenu.css')}}" />
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('new_asstes/css/font-awesome.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
  <link rel="stylesheet" type="text/css" media="all" href="{{asset('new_asstes/css/stylesheet.css')}}" />
    
    <script src="{{asset('new_asstes/js/jquery-2.1.0.min.js')}}" type="text/javascript"></script>
    
    <script src="{{asset('new_asstes/js/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('new_asstes/js/bootstrap.min.js')}}" type="text/javascript"></script>
  
  @yield('styles')

</head>

<body>
<div class="wsmenucontainer clearfix">
    <div id="overlapblackbg"></div>
    <div class="wsmobileheader clearfix"> <a id="wsnavtoggle" class="animated-arrow"><span></span></a> <a href="{{url('/')}}" class="smallogo" style="color:white"><img src="{{asset('new_asstes/images/logo1.png')}}" width="143" height="36" alt="" /></a>  </div>
    <div class="header-tp clearfix">
      <div class="container-fluid">
        <div class="col-md-12">
          <div class="tp-lft">Home Shopping Center</div>
          <div class="tp-rgt"><ul><li><a href="{{ route('front.contact') }}">Help Center</a></li>

          </ul></div>
            
        </div>
      </div>
    </div>

    <div class="header-mid clearfix">
      <div class="container-fluid clearfix">
        <div class="col-md-12">
          <div class="smllogo"><a href="{{ url('/') }}"><img src="{{asset('new_asstes/images/logo1.png')}}" alt="" height="70" style="margin-left: 35px;"/></a></div>
          <form mothed="GET" action="{{url('/search')}}">
          <div class="rightmenu">
              <div class="input-group">
         <input type="text" class="form-control" name="search" id="search" style="border-bottom-left-radius: 19px;border: 1px solid #ffffff !important;">
        <span class="input-group-btn">
            <button id="SearchButton" class="btn btn-search" type="submit" style="border-bottom-right-radius: 19px;"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </div>
  </form>
            <div class="mid-rgtsec clearfix">
           <div id="primary_nav_wrap" class="mid-rgt">
            @if(!Auth::guard('web')->check())
            <ul class="nav">
             <li class="nav-item">
                <a href="{{ route('user.login') }}"><i class="fa fa-heart-o"></i><span>My Favorite</span></a> 
             </li>
            <li class="nav-item"><a href="{{ route('user.login') }}"><i class="fa fa-shopping-cart"></i><span>My Inventory</span> </a> </li>
            <li class="nav-item"> <a href="{{ route('user.login') }}"><i class="fa fa-user"></i><span>Sign In</span></a> </li>
            </ul>
            @else
            <ul class="nav">
              <li class="nav-item"> 
                <a href="{{ route('user-wishlists') }}"><i class="fa fa-heart-o"></i><span>My Wishlists</span></a> 
             </li>
            <li class="nav-item"> <a href="{{ route('front.cart') }}"><i class="fa fa-shopping-cart"></i> <span>My Inventory</span>
             </a> </li>
            <li> 
                <a href="#"><i class="fa fa-user"></i><span>My Account</span></a> 
                <ul>
          <li><a href="{{ route('user-dashboard') }}">Account Details</a></li>
          <li><a href="{{ route('user-orders') }}">My Orders</a></li>
          <li><a href="{{ route('user-shipping-address') }}">Shipping Address</a></li>
          <li><a href="{{ route('user-logout') }}">Logout</a></li>
        </ul>
             </li>
            </ul>
            @endif
           </div>
    </div>
            
        </div>
       </div>
    </div>
    <div class="headerfull">
      <div class="wsmain">
        <nav class="wsmenu clearfix">
          <ul class="mobile-sub wsmenu-list">
            @foreach($categories as $data)
            @if($data->category_id == 0)
            <li><a href="{{ url('search?category_id='.$data->id)}}" class="">{{ $data->name }}</a>
              @php
              $subCat   = [];
              $i= 0;
              @endphp
              @foreach($categories as $data_new)
              @if($data_new->category_id == $data->id) 
              @php $i++ @endphp 
              @php
                $subCat[$i]['cat_id']   = $data_new->id;
                $subCat[$i]['cat_name']   = $data_new->name;
              @endphp
              @endif
              @endforeach
              @if(count($subCat)>0)
                <div class="megamenu clearfix">
                  <div class="container-fluid">
                    <div class="row">
                            <div class="col-md-2">
                                @php
                                // $cat_image = DB::table('categories')->where('id',$data->category_id)->get()->first();
                                @endphp
                            <img src="{{asset('assets/images/categories/'.$data->photo)}}" class="img-fluid"> 
                            </div>
                        <div class="col-md-10"><div class="row">
                        <ul class="col-lg-3 col-md-12 col-xs-12 link-list">
                        <li><a href="{{ url('search?category_id='.$data->id)}}"><i class="fa fa-angle-right"></i>All</a></li>
                        </ul>
                        @foreach($subCat as $value)
                        <ul class="col-lg-3 col-md-12 col-xs-12 link-list">
                        <li><a href="{{ url('search?category_id='.$value['cat_id'])}}"><i class="fa fa-angle-right"></i>{{ $value['cat_name']}}</a></li>
                        </ul>
                        
                        @endforeach
                        </div>
                        </div>
                    </div>
                  </div>
                </div>
              @endif
              </li>
            @endif
            @endforeach
            
          </ul>
        </nav>
      </div>
    </div>
  </div>   
   
@yield('content')

    
  <footer>
    <div class="ftr-tp">
      <div class="container">
        <div class="col-md-12">
          <ul>
            <li ><i class="fa fa-lock" style="color: #fff;font-size: 50px;"></i><p>SAFE AND SECURE</p></li>
            <li><i class="fa fa-shopping-bag" style="color: #fff;font-size: 50px;"></i><<p>SHOP ON GO</p></li>
            <li><i class="fa fa-info-circle" style="color: #fff;font-size: 50px;"></i><p>HELP CENTER</p></li>
            <li><i class="fa fa-truck" style="color: #fff;font-size: 50px;"></i><p>FREE DELIVERY</p></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer">
      <div class="container-fluid">
        <div class="col-md-12">
          <div class="row">
          <div class="col-md-12">
          <div class="accordion clearfix">
            <div class="row">
              <div class="col-md-3">
                 <span class="target-fix" id="accordion1"></span>
            <a href="#accordion1" id="open-accordion1" title="open"><div>Categories</div></a>
            <a href="#accordion" id="close-accordion1" title="close">Categories</a> 
            <div class="accordion-content">
              <ul>
                   @foreach($categories as $data)
                    @if($data->category_id == 0)
                    <li class="dropdown-item">
                      <a href="{{ url('search?category_id='.$data->id)}}">
                        {{ $data->name }}
                      </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
              </div>
              <div class="col-md-3">
                <span class="target-fix" id="accordion2"></span>
            <a href="#accordion2" id="open-accordion2" title="open"><div>About Us</div></a>
            <a href="#accordion" id="close-accordion2" title="close">About Us</a> 
            <div class="accordion-content">
                <ul>
                  @foreach(DB::table('pages')->where('footer','=',1)->get() as $data)
                <li>
                  <a href="{{ route('front.page',$data->slug) }}">
                    {{ $data->title }}
                  </a>
                </li>
                @endforeach
                </ul>
                </div>
              </div>
              <div class="col-md-3">
                <span class="target-fix" id="accordion3"></span>
            <a href="#accordion3" id="open-accordion3" title="open"><div>Need Help?</div></a>
            <a href="#accordion" id="close-accordion3" title="close">Need Help?</a> 
            <div class="accordion-content">
                <ul>
                  <li><a href="{{url('/faq')}}">FAQ </a></li>
                  <li><a href="{{url('/contact')}}">Contact Us</a></li>
                </ul>
                </div>
              </div>
              <div class="col-md-3">
                <span class="target-fix" id="accordion4"></span>
            <a href="#accordion4" id="open-accordion4" title="open"><div>Business</div></a>
            <a href="#accordion" id="close-accordion4" title="close">Business</a> 
            <div class="accordion-content">
                <ul>
                  <li><a href="{{route('front.search')}}">Online Shopping </a></li>
                    <li>
                       <a  href="javascript:;" data-toggle="modal" data-target="#enquiry-login">Advertise on HomeShop</a>
                    </li>
                    <li>
                       <a  href="javascript:;" data-toggle="modal" data-target="#enquiry-login">Media Enquiries</a>
                    </li>
                </ul>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
        </div>
        <div class="col-md-12 ftr-btm clearfix">
          <div class="ftr-lft">
            @php
            $social = DB::table('socialsettings')->get()->first();            
            @endphp
            <ul>
              <li><a href="{{$social->facebook}}" target="_blank"><i class="fa fa-facebook"></i></a></li>
              <li><a href="{{$social->twitter}}" target="_blank"><i class="fa fa-twitter"></i></a></li>
              <li><a href="{{$social->linkedin}}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
              <!-- <li><a href="{{$social->gplus}}" target="_blank"><i class="fa fa-google"></i></a></li> -->
            </ul>
          </div>
          <div class="ftr-rgt">
            <ul>
              <li><img src="{{asset('new_asstes/images/crd1.png')}}"></li>
              <li><img src="{{asset('new_asstes/images/crd2.png')}}"></li>
              <li><img src="{{asset('new_asstes/images/crd3.png')}}"></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
<script type="text/javascript" src="{{asset('new_asstes/js/webslidemenu.js')}}"></script>
  <script type="text/javascript">
  var mainurl = "{{url('/')}}";
  var gs      = {!! json_encode($gs) !!};
  var langg    = {!! json_encode($langg) !!};
</script>


<script src="{{asset('new_asstes/js/owl.carousel.js')}}" type="text/javascript"></script>
 <script src="{{asset('assets/front/js/jquery.accord.min.js')}}"></script> 
 <script src="{{asset('new_asstes/js/jquery.fancybox.js')}}" type="text/javascript"></script>


<script type="text/javascript" src="{{asset('new_asstes/js/main.js')}}"></script>




  <script src="{{asset('assets/front/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- popper -->
  <script src="{{asset('assets/front/js/popper.min.js')}}"></script>
  <!-- bootstrap -->
  
 <!--  // <script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script> -->
  <!-- plugin js-->
  <script src="{{asset('assets/front/js/plugin.js')}}"></script>
  <!-- main -->
 <?php /*  <script src="{{asset('assets/front/js/main.js')}}"></script> */ ?>
  <script src="{{asset('assets/front/js/notify.js')}}"></script>
 
  
  <!-- custom -->
  <script src="{{asset('assets/front/js/custom.js')}}"></script>
<!-- <script src="{{asset('new_asstes/js/price.js')}}" type="text/javascript"></script>  -->
</body>
</html>

    <div class="modal fade" id="enquiry-login" tabindex="-1" role="dialog" aria-labelledby="vendor-login-Title" aria-hidden="true">
        <div class="modal-dialog" role="document">
    <div class="modal-content login-area">
      <div class="modal-header text-center header-area">
        <h4 class="modal-title w-100 font-weight-bold title">Enquiry</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="enquiry_from" action="" method="POST" >
          {{csrf_field()}}
      <div class="modal-body mx-3">
        
        <div class="form-input">
            <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
            <i class="icofont-user-alt-5"></i>
        </div>
        <div class="form-input">
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
            <i class="icofont-user-alt-5"></i>
        </div>
        <div class="form-input">
            <select class="form-control" id="type" name="type" required style="background: #f3f8fc;padding: 0px 30px 0px 45px;font-size: 14px;">
              <option value=''>(-- Select Type --)</option>
              <option value="Advertise on HomeShop">Advertise on HomeShop</option>
              <option value="Media Enquiries">Media Enquiries</option>
            </select>
            <i class="icofont-user-alt-5"></i>
        </div>
        <div class="form-input">
            <textarea  class="form-control" id="msg" name="msg" required  placeholder="Message" style="background: #f3f8fc;padding: 0px 30px 0px 45px;font-size: 14px;" ></textarea>
            <i class="icofont-user-alt-5"></i>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
          <input type="reset" id="configreset" value="Reset" class="submit-btn " style="background: #222222;">
        <button class=" submit-btn " type="submit" >Send</button>
      </div>
      </form>
    </div>
  </div>
    </div> 



<!-- LOGIN MODAL -->
  <div class="modal fade" id="comment-log-reg" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <nav class="comment-log-reg-tabmenu">
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link login active" id="nav-log-tab" data-toggle="tab" href="#nav-log" role="tab" aria-controls="nav-log" aria-selected="true">
            Login
            </a>
            <a class="nav-item nav-link" id="nav-reg-tab" data-toggle="tab" href="#nav-reg" role="tab" aria-controls="nav-reg" aria-selected="false">
            Register
            </a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-log" role="tabpanel" aria-labelledby="nav-log-tab">
                <div class="login-area">
                  <div class="header-area">
                    <h4 class="title">LOGIN NOW</h4>
                  </div>
                  <div class="login-form signin-form">
                        @include('includes.admin.form-login')
                    <form class="mloginform" action="{{ route('user.login.submit') }}" method="POST">
                      {{ csrf_field() }}
                      <div class="form-input">
                        <input type="email" name="email" placeholder="Type Email Address" required="">
                        <i class="icofont-user-alt-5"></i>
                      </div>
                      <div class="form-input">
                        <input type="password" class="Password" name="password" placeholder="Type Password Address" required="">
                        <i class="icofont-ui-password"></i>
                      </div>
                      <div class="form-forgot-pass">
                        <div class="left">
                          <input type="checkbox" name="remember"  id="mrp" {{ old('remember') ? 'checked' : '' }}>
                          <label for="mrp">Remember Password</label>
                        </div>
                        <div class="right">
                          <a href="javascript:;" id="show-forgot">
                          Forgot Password
                          </a>
                        </div>
                      </div>
                      <input type="hidden" name="modal"  value="1">
                      <input class="mauthdata" type="hidden"  value="Authenticating...">
                      <button type="submit" class="submit-btn">Login</button>
                        @if(App\Models\Socialsetting::find(1)->f_check == 1 || App\Models\Socialsetting::find(1)->g_check == 1)
                        <div class="social-area">
                            <h3 class="title">Or</h3>
                            <p class="text">Sign In with social media</p>
                            <ul class="social-links">
                              @if(App\Models\Socialsetting::find(1)->f_check == 1)
                              <li style="">
                                <a href="{{ route('social-provider','facebook') }}"> 
                                 <i class="fa fa-facebook-square" aria-hidden="true" style="font-size: 25px;background: #4267b2;color: #fff;"></i>
                                </a>
                              </li>
                              @endif
                              @if(App\Models\Socialsetting::find(1)->g_check == 1)
                              <li  style="">
                                <a href="{{ route('social-provider','google') }}">
                                  <i class="fa fa-google" aria-hidden="true" style="color: #fff;font-size: 25px;background: #d12438;"></i>
                                </a>
                              </li>
                              @endif
                            </ul>
                        </div>
                        @endif 
                    </form>
                  </div>
                </div>
          </div>
          <div class="tab-pane fade" id="nav-reg" role="tabpanel" aria-labelledby="nav-reg-tab">
                <div class="login-area signup-area">
                    <div class="header-area">
                        <h4 class="title">Signup Now</h4>
                    </div>
                    <div class="login-form signup-form">
                       @include('includes.admin.form-login')
                        <form class="mregisterform" action="{{route('user-register-submit')}}" method="POST">
                          {{ csrf_field() }}

                            <div class="form-input">
                                <input type="text" class="User Name" name="name" placeholder="Full Name" required="">
                                <i class="icofont-user-alt-5"></i>
                            </div>

                            <div class="form-input">
                                <input type="email" class="User Name" name="email" placeholder="Email Address" required="">
                                <i class="icofont-email"></i>
                            </div>

                            <div class="form-input">
                                <input type="text" class="User Name" name="phone" placeholder="Phone Number" required="">
                                <i class="icofont-phone"></i>
                            </div>
                            <div class="form-input">
                              <!-- <label>Building No</label> -->
                              <input type="number" class="User Name  form-control" name=" building_no" placeholder="Building No" required="">
                            </div>
                            <div class="form-input">
                             <!--  <label>Zone</label> -->
                              <input type="number" class="User Name  form-control" name="zone_no" placeholder="Zone *" required="">
                            </div>
                            <div class="form-input">
                              <!-- <label>Street</label> -->
                              <input type="number" class="User Name  form-control" name="street_no" placeholder="Street *" required="">
                            </div>
                            <div class="form-input">
                             <!--  <label>City</label> -->
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
                            <div class="form-input">
                                <input type="text" class="User Name" name="address" placeholder="Address" required="">
                                <i class="icofont-location-pin"></i>
                            </div>

                            <div class="form-input">
                                <input type="password" class="Password" name="password" placeholder="Password" required="">
                                <i class="icofont-ui-password"></i>
                            </div>

                            <div class="form-input">
                                <input type="password" class="Password" name="password_confirmation" placeholder="Confirm" required="">
                                <i class="icofont-ui-password"></i>
                            </div>


                                  <!--   <ul class="captcha-area">
                                        <li>
                                            <p><img class="codeimg1" src="{{asset("assets/images/capcha_code.png")}}" alt=""> <i class="fas fa-sync-alt pointer refresh_code "></i></p>
                                        
                                        </li>
                                    </ul>

                            <div class="form-input">
                                <input type="text" class="Password" name="codes" placeholder="{{ $langg->lang51 }}" required="">
                                <i class="icofont-refresh"></i>
                            </div> -->


                            <input class="mprocessdata" type="hidden"  value="{{ $langg->lang188 }}">
                            <button type="submit" class="submit-btn">{{ $langg->lang189 }}</button>
                        
                        </form>
                    </div>
                </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- LOGIN MODAL ENDS -->



<?php 
$para     = '';
if( count($_GET) > 0){
  $para     = '?';$i=0;
  foreach ($_GET as $key => $value) {$i++;
    if( $key != 'sort'){
    if( $i != 1){
      $para   .= '&';
    }
    $para   .= $key.'='.$value;
    }
  }
}
?>
    <script type="text/javascript">
  $("#shipp_to_different_Address_ck").click(function(){
     var id     =  $(this).data('id');
     if( id == 0 ){
        $(this).data('id','1');
        var html = $(".shippin_html_jqery").html();
        $(".newshippingAddress_html").html(html);
     }else{
        $(this).data('id','0');
        $(".newshippingAddress_html").html('');
     }
  });
  $("body").on('change','#sorting',function(){
    var value     = $(this).val();
    var para      = '<?php echo $para; ?>';
    if( para == ''){
      para  = '?sort='+value;
    }{
      para  = para+'&sort='+value;
    }
    //window.location.replace( "{{url('/')}}/search"+para);
  });
  $("body").on('focusout','.slider-rangem',function(){
    alert('ds');
  });
  $("body").on('change','.shipping_city_class',function(){
    var value = $(this).attr('data-price');
  });
  </script>
  @php
  $sock_cart_msg   = session("sock_cart_msg");
  $cart_msg   = session("cart_msg");
  @endphp
  @if($sock_cart_msg != '')
    <script type="text/javascript">
    $.notify('{{session("sock_cart_msg")}}',"error");
    </script>
  @php
  session(['sock_cart_msg' => '']);
  @endphp
  @endif
  
  @php
  $subscribers_msg   = session("subscribers_msg");
  @endphp
  @if($subscribers_msg != '')
    <script type="text/javascript">
    $.notify('{{session("subscribers_msg")}}',"success");
    </script>
  @php
  session(['subscribers_msg' => '']);
  @endphp
  @endif
  
  
  @if($cart_msg != '')
    <script type="text/javascript">
    $.notify('{{session("cart_msg")}}',"success");
    </script>
  @php
  session(['cart_msg' => '']);
  @endphp
  @endif
<script type="text/javascript">
$("body").on('click','.cat_list',function(){
    var id = $(this).data('id');
    $('#category_id').val(id);
});
</script>
@if( isset($perant_cat))
@if(@$perant_cat != '' )
<script type="text/javascript">
  var perant_cat   = '<?php echo $perant_cat; ?>';
  var active  = '<?php echo $active ?>';
  // if( active == 0 ){
    $(".ativeClass_"+perant_cat).click();
  // }
</script>
@endif
@endif
<script type="text/javascript">
$(".pagination li a").click(function(){
  var href= $(this).attr('href');  
  if( href != '' ){
    location.replace(href)
  }
});
</script>


<style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
        }
        
        input[type=number] {
            -moz-appearance:textfield; /* Firefox */
        }
    </style>
    
    <script>
        // $(".minus_cart").click(function(){
        $('body').on('click','.minus_cart',function(){
             var url                =   '<?php echo route('product.cart.updateCart_ajax') ?>';
            var id                  =   $(this).data('id');
            var qty                 =   $('#cart_quant_'+id).val();
             var _token             =   $('input[name=_token]').val();
            $.ajax({
               method:"POST",
               url:url,
               data:'_token='+_token+'&id='+id+'&qty='+qty,
               success:function(data)
               {
                   $('.crt').html(data);
               }
            });
        });
        //$(".add_cart").click(function(){
        $('body').on('click','.add_cart',function(){
            var url                 =   '<?php echo route('product.cart.updateCart_ajax') ?>';
            var id                  =   $(this).data('id');
            var qty                 =   $('#cart_quant_'+id).val();
            var _token              =   $('input[name=_token]').val();
            //alert(_token);
            $.ajax({
               method:"POST",
               url:url,
               data:'_token='+_token+'&id='+id+'&qty='+qty,
               success:function(data)
               {
                   $('.crt').html(data);
               }
            });
        });
        
        $(".enquiry_from").submit(function(){
            var type                =   $('.enquiry_from #type').val();
            var msg                 =   $('.enquiry_from #msg').val();
            var name                 =   $('.enquiry_from #name').val();
            var email                 =   $('.enquiry_from #email').val();
            var _token              =   $('input[name=_token]').val();
            if( type != '' && msg != '' && name != '' && email != '' ){
                var url             =   '<?php echo route('front-sentEnquiry') ?>';
                $.ajax({
                    method:"POST",
                    url:url,
                    data:'_token='+_token+'&type='+type+'&msg='+msg+'&name='+name+'&email='+email,
                    success:function(data)
                    {
                        $("#enquiry-login .close").click();
                        $.notify('Successfully sent your Enquiry , We will contact you soon ',"success");
                        $("#configreset").click();
                    }
                });
            }
            return false;
        });
    </script>
