@extends('layouts.front')
@section('content')
<section class="abt-tp">
  <div class="container">
    <div class="col-md-12">
      <h2>{{$productt->name}}</h2>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li>Product Details</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="det">
  <div class="container">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-5">
          <div class="slider-container">
            <div id="slider" class="slider owl-carousel">
              <div class="item">
                <div class="ex1" data-src="{{asset('assets/images/products/'.$productt->photo)}}">
                  <a data-fancybox="images" href="{{asset('assets/images/products/'.$productt->photo)}}"><img src="{{asset('assets/images/products/'.$productt->photo)}}" alt="" /></a>
                </div>
              </div>
              @foreach($productt->galleries as $gal)
              <div class="item">
                <div class="ex1" data-src="{{asset('assets/images/galleries/'.$gal->photo)}}">
                 <a data-fancybox="images" href="{{asset('assets/images/galleries/'.$gal->photo)}}"> <img src="{{asset('assets/images/galleries/'.$gal->photo)}}" alt="" /></a>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          <div class="thumbnail-slider-container">
            <div id="thumbnailSlider" class="thumbnail-slider owl-carousel">
              <div class="item"><img src="{{asset('assets/images/products/'.$productt->photo)}}" alt="" /></div>
              @foreach($productt->galleries as $gal)
              <div class="item">
                <img src="{{asset('assets/images/galleries/'.$gal->photo)}}" alt="" />
              </div>
              @endforeach
              
            </div>
          </div>
        </div>
        
        <div class="col-md-7">
           <div class="row">
             <div class="col-md-6 col-lg-7 det-rgt">
                <h2>{{$productt->name}}</h2>
                <div class="str">
                  @php
                            $rating = App\Models\Rating::ratings_new($productt->id);
                           @endphp
                           @if($rating == 5)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           @elseif($rating >= 4.5)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-half-o"></i>
                           @elseif($rating >= 4)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($rating >= 3.5)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-half-o"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($rating >= 3)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($rating >= 2.5)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-half-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($rating >= 2)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($rating >= 1.5)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-half-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($rating >= 1)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @else($rating == 0.0)
                            <i></i>
                           @endif</div>
                          @php echo $productt->sub_details @endphp
                <p class="pdcode"><span>{{ $langg->lang77 }}: </span> {{ sprintf("%'.08d",$productt->id) }}</p>
                
             </div>
             <div class="col-md-6 col-lg-5">
               <div class="ad-bas">
                @if($productt->stock != 0 )
                <h4>Availability: <span> In Stock</span></h4>
                @else
                <h4>Availability: <span style="color:#d12438;"> Out of Stock</span></h4>
                @endif
                  
                  <h3>₹ {{ $productt->showPrice() }}</h3>
                  <label>Quantity</label>
                  <div class="input-group"> 
                  <input id="CC-prodDetails-quantity" type="text" name="quant[{{$productt->id}}]" class="form-control input-number qttotal" value="1" min="1" max="500">
                  <span class="input-group-btn">
                  <button id="qty-minus" type="button" class="btn btn-default btn-number"  data-type="minus" data-field="quant[{{$productt->id}}]"> <span class="fa fa-minus"></span> </button>
                  </span>
                  <span class="input-group-btn">
                  <button id="qty-plus" type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[{{$productt->id}}]"> <span class="fa fa-plus"></span> </button>
                  </span> 
                  </div>
                  <!-- <label>Color</label> -->
                  <!-- <select class="form-control"><option>White with Gold</option><option>White with Gold</option><option>White with Gold</option></select> -->
                   @if(Auth::guard('web')->check())
                    <a  href="javascript:;" class="adbs" id="addcrt"><i class="fa fa-shopping-cart"></i> ADD to Inventory</a>   
                   @else 
                   <a class="adbs" href="javascript:;" title="Add to Inventory " data-toggle="modal" id="wish-btn" data-target="#comment-log-reg"   ><i class="fa fa-shopping-cart"></i> ADD to Inventory</a>                    
                   @endif
                  <div class="cwish">
                   <ul>
                    <!-- <li><a href="#"><i class="fa fa-refresh"></i> Compare</a></li> -->
                    @if(Auth::guard('web')->check())
                    <li><a  href="javascript:;" class="add-to-wish" data-href="{{ route('user-wishlist-add',$productt->id) }}" title="{{ $langg->lang54 }}" ><i class="fa fa-heart-o"></i> Add to Wishlist </a></li>
                    @else 
                    <li><a  href="javascript:;"  title="Add to Inventory " data-toggle="modal" id="wish-btn" data-target="#comment-log-reg"  ><i class="fa fa-heart-o"></i> Add to Wishlist </a></li>
                    @endif
                  </ul>
                  </div>

                  <input type="hidden" name="product_id" id="product_id" value="{{$productt->id}}">
               </div>
             </div>
           </div>
        </div>
        
      </div>
    </div>
  </div>
</section>
<section class="det-sec clearfix">
  <div class="container">
    <div class="col-md-12 clearfix">
    <div class="row">
    <div class="col-md-9">
      <dl class="responsive-tabs clearfix">
        <dt> Description</dt>
        <dd >
          <div class="col-md-12 clearfix animated fadeIn xsp-2">
            <div class="des">
              <p>{!! $productt->details !!}</p>
            </div>
          </div>
        </dd>
        @php
        if( is_array($productt->features) ){
        @endphp
        <dt> Specification </dt>
        <dd >
        <div class="col-md-12 clearfix animated fadeIn xsp-2">
          <div class="spec">
            <ul>
              @foreach( $productt->features as $key => $value )
               <li><span>{{$value}}</span><span>{{$productt->colors[$key]}}</span></li>
              @endforeach                 
            </ul>
          </div>
        </div>
        @php
        }
        @endphp
        </dd>
        <dt> Buy & Return Policy</dt>
        <dd >
          <div class="col-md-12 clearfix animated fadeIn xsp-2">
            <div class="des">
              <p>{!! $productt->policy !!}</p> 
            </div>
          </div>
        </dd>
        
        <dt> Reviews ({{ count($productt->ratings) }})</dt>
        <dd>
          <div class="col-md-12 clearfix animated fadeIn xsp-2">
            <div class="rvw">
              <h4 class="title">
                    {{ $langg->lang96 }} 
                    @if(count($productt->ratings)>0)
                      <span style="background: #4a1ec7;padding: 10px;color: #fff;font-weight: 700;"> {{App\Models\Rating::rating($productt->id)}}</span>
                    @else
                    @endif
                  </h4>
            @if(count($ratings) > 0)
              <ul>
                @foreach($ratings as $data)
                <li>
                 
                           <div class="str">
                           @if($data->rating == 5)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           @elseif($data->rating >= 4.5)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-half-o"></i>
                           @elseif($data->rating >= 4)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($data->rating >= 3.5)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-half-o"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($data->rating >= 3)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($data->rating >= 2.5)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-half-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($data->rating >= 2)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($data->rating >= 1.5)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-half-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @elseif($data->rating >= 1)
                           <i class="fa fa-star"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           {{-- @elseif($data->rating >= 0.5)
                           <i class="fa fa-star-half-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i> --}}
                           @else($data->rating == 0.0)
                           <i></i>
                           {{-- <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i> --}}
                           @endif 
                  </div>
                  <p><b>{{$data->title}}</b></p>
                  <p>{{$data->review}} </p>
                  <h4>{{$data->name}} <span>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->review_date)->diffForHumans()}}</span></h4>
                </li>
                @endforeach
                
              </ul>
              @endif
            </div>
            <!--  unais
            <div class="row">
              <div class="col-md-12">
                <div class="rvw-rgt">
                   <h4>Add Your Comment</h4>
                   <p>Rating</p>
                   <div class="star-rating">
                      <div class="star-rating__wrap">
                        <input class="star-rating__input" id="star-rating-5" type="radio" name="rating" value="5">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-5" title="5 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-4" type="radio" name="rating" value="4">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-4" title="4 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-3" type="radio" name="rating" value="3">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-3" title="3 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-2" type="radio" name="rating" value="2">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-2" title="2 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-1" type="radio" name="rating" value="1">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-1" title="1 out of 5 stars"></label>
                      </div>
                    </div>
                    <form>
                      <div class="form-group clearfix">
                      <div class="row">
                        <div class="col-md-3"><label>Name</label></div>
                        <div class="col-md-9"><input type="text" class="form-control"></div>
                      </div>
                      </div>
                      <div class="form-group clearfix">
                      <div class="row">
                        <div class="col-md-3"><label>Email</label></div>
                        <div class="col-md-9"><input type="text" class="form-control"></div>
                      </div>
                      </div>
                      <div class="form-group clearfix">
                      <div class="row">
                        <div class="col-md-3"><label>review</label></div>
                        <div class="col-md-9"><textarea class="form-control"></textarea></div>
                      </div>
                      </div>
                      <div class="form-group clearfix">
                      <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9"><button class="evw-btn">ADD to Inventory</button></div>
                      </div>
                      </div>
                    </form>       
                  </div>
                </div>
              </div> -->
          </div>
        </dd>

        <dt> Supplied By</dt>
        <dd >
          <div class="col-md-12 clearfix animated fadeIn xsp-2">
          
          <div class="spec">
          @if($seller_name!=null)
            <ul>          
                             <li><span>Shop Name</span><span>{{$seller_name->name}}</span></li>
                             <li><span>Owner Name</span><span>{{$seller_name->owner_name}}</span></li>
                             <li><span>Shop Number</span><span>{{$seller_name->number}}</span></li>
                             <li><span>Reg number</span><span>{{$seller_name->building_no}}</span></li>
                             <li><span>Shop address</span><span>{{$seller_name->zone_no}}</span></li>
                             <li><span>Shop Message</span><span>{{$seller_name->street_no}}</span></li>
                             <li><span>Shop Details</span><span>{{$seller_name->city}}</span></li>
                             <li><span>Shop Details</span><span>{{$seller_name->address}}</span></li>
                               
            </ul>
            @else
            <ul>
                             <li><span>Shop Name</span><span>Admin</span></li>
                             <li><span>Owner Name</span><span>Admin</span></li>
                             <li><span>Shop Number</span><span>Admin</span></li>
                             <li><span>Reg number</span><span>Admin</span></li>
                             <li><span>Shop address</span><span>Admin</span></li>
                             <li><span>Shop Message</span><span>Admin</span></li>
                             <li><span>Shop Details</span><span>Admin</span></li>
                             <li><span>Shop Message</span><span>Admin</span></li>
                               
            </ul>
            @endif
            </div>
          </div>
        </dd>
      </dl>
      </div>
      <div class="col-md-3">
        <div class="ads ads-rgt">
           @foreach( $side_banners AS $side)
             <a href="{{ $side->link }}" target="_blank"><img src="{{url('assets/images/banners/'.$side->photo)}}" class="img-fluid"></a>
             @endforeach
        </div>
      </div>
      
      </div>
    </div>
  </div>
</section>

@endsection


@section('scripts')


<script type="text/javascript">
    
          $(document).on("submit", "#emailreply1" , function(){
          var token = $(this).find('input[name=_token]').val();
          var subject = $(this).find('input[name=subject]').val();
          var message =  $(this).find('textarea[name=message]').val();
          $('#subj1').prop('disabled', true);
          $('#msg1').prop('disabled', true);
          $('#emlsub').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('/user/admin/user/send/message')}}",
            data: {
                '_token': token,
                'subject'   : subject,
                'message'  : message,
                  },
            success: function( data) {
          $('#subj1').prop('disabled', false);
          $('#msg1').prop('disabled', false);
          $('#subj1').val('');
          $('#msg1').val('');
        $('#emlsub').prop('disabled', false);
        if(data == 0)
        $.notify("Oops Something Goes Wrong !!","error");
        else
        $.notify("Message Sent !!","success");
        $('.close').click();
            }

        });          
          return false;
        });

</script>


<script type="text/javascript">
          $(document).on("submit", "#emailreply" , function(){
          var token = $(this).find('input[name=_token]').val();
          var subject = $(this).find('input[name=subject]').val();
          var message =  $(this).find('textarea[name=message]').val();
          var email = $(this).find('input[name=email]').val();
          var name = $(this).find('input[name=name]').val();
          var user_id = $(this).find('input[name=user_id]').val();
          var vendor_id = $(this).find('input[name=vendor_id]').val();
          $('#subj').prop('disabled', true);
          $('#msg').prop('disabled', true);
          $('#emlsub').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('/vendor/contact')}}",
            data: {
                '_token': token,
                'subject'   : subject,
                'message'  : message,
                'email'   : email,
                'name'  : name,
                'user_id'   : user_id,
                'vendor_id'  : vendor_id
                  },
            success: function() {
              $('#subj').prop('disabled', false);
              $('#msg').prop('disabled', false);
              $('#subj').val('');
              $('#msg').val('');
              $('#emlsub').prop('disabled', false);
              $.notify("Message Sent !!","success");
              $('.ti-close').click();
            }
        });          
          return false;
        });
</script>

@endsection