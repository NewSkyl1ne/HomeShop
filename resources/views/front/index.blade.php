@extends('layouts.front') 

@section('content')



@if($ps->slider == 1 || $ps->service == 1)
	<!-- Hero Area Start -->
	<section class="hero-area">
		<div class="container-fluid p-0 ">

			@if($ps->slider == 1)

			@if(count($sliders))

			<section class="slider">
				<div id="owl-demo" class="owl-carousel owl-theme">
					@foreach($sliders as $data)
			         <div class="item"><a href="#"><img src="{{asset('assets/images/sliders/'.$data->photo)}}"></a></div>
			         @endforeach
			    </div>
		  </section>

			@endif

			@endif


		</div>
</section>
		


<section class="sec1">
   <div class="container-fluid">
      <div class="col-md-12">
         <div class="hm-mainsec">
            <div class="row">
               <div class="col-md-10">
                  <h2>Top Products</h2>
                  <div id="owl-demo1" class="owl-carousel owl-theme">
					@foreach($top_products as $prod)
                     <div class="item">
                        <figure>
                           <a href="{{ route('front.product', $prod->slug) }}">
                              <img src="{{ $prod->photo ? asset('assets/images/products/'.$prod->photo):asset('assets/images/noimage.png') }}"> 
                             <!--  <div class="sl">Sale</div> -->
                           </a>
                           <figcaption>
                              <ul>
                                 @if(Auth::guard('web')->check())
                                 <li><a  href="javascript:;" class="add-to-cart" data-href="{{ route('product.cart.add',$prod->id) }}"  title="{{ $langg->lang56}}"><i class="fa fa-shopping-cart"></i> <span> Add to Inventory </span></a></li>
                                 <li><a  href="javascript:;" class="add-to-wish" data-href="{{ route('user-wishlist-add',$prod->id) }}" title="{{ $langg->lang54 }}" ><i class="fa fa-heart-o"></i></a></li>
                                 @else 
                                  <li><a   href="javascript:;"  id="wish-btn"  data-toggle="modal"  data-target="#comment-log-reg"><i class="fa fa-shopping-cart"></i> <span> Add to Inventory </span></a></li>
                                 <li><a   href="javascript:;"  title="{{ $langg->lang54 }}" id="wish-btn"  data-toggle="modal"  data-target="#comment-log-reg" ><i class="fa fa-heart-o"></i></a></li>
                                 @endif
                              </ul>
                           </figcaption>
                        </figure>
                        <div class="it-sec">
                           <h4><a href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a></h4>
                            <h5>@if($prod->previous_price != 0 && $prod->previous_price != '') <span class="line-through" style="margin-right: 5px;">₹ {{ $prod->previous_price }}</span>@endif ₹ {{ $prod->showPrice() }}</h5>
                           @php
                            $rating = App\Models\Rating::ratings_new($prod->id);
                            
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
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @endif <span class="float-right text-secondary">
                              {{-- @if($rating>=1) Reviews ({{$rating}})
                              @else 
                              @endif --}}
                           </span>
                        </div>
                     </div>
					@endforeach
                  </div>
                  <div class="ads">
                     <div class="row">
                        <div class="col-md-9"><a href="{{ $large_banners->link }}" target="_blank"><img src="{{url('assets/images/banners/'.$large_banners->photo)}}" class="img-fluid"></a></div>
                        <div class="col-md-3"><a href="{{ $small_banners->link }}" target="_blank"><img src="{{url('assets/images/banners/'.$small_banners->photo)}}" class="img-fluid"></a></div>
                     </div>
                  </div>
                  <h2>Best Sellers</h2>
                  <div class="owl-carousel owl-theme owl-demo2">
                     @foreach($best_products as $prod)
                     <div class="item">
                        <figure>
                           <a href="{{ route('front.product', $prod->slug) }}">
                              <img src="{{ $prod->photo ? asset('assets/images/products/'.$prod->photo):asset('assets/images/noimage.png') }}"> 
                             <!--  <div class="sl">Sale</div> -->
                           </a>
                           <figcaption>
                              <ul>
                                 @if(Auth::guard('web')->check())
                                 <li><a  href="javascript:;" class="add-to-cart" data-href="{{ route('product.cart.add',$prod->id) }}" ><i class="fa fa-shopping-cart"></i> <span> Add to Inventory </span></a></li>
                                 <li><a  href="javascript:;" class="add-to-wish" data-href="{{ route('user-wishlist-add',$prod->id) }}" title="{{ $langg->lang54 }}" ><i class="fa fa-heart-o"></i></a></li>
                                 @else 
                                  <li><a   href="javascript:;" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" ><i class="fa fa-shopping-cart"></i> <span> Add to Inventory </span></a></li>
                                 <li><a   href="javascript:;" title="{{ $langg->lang54 }}" id="wish-btn" data-toggle="modal"  data-target="#comment-log-reg" ><i class="fa fa-heart-o"></i></a></li>
                                 @endif
                              </ul>
                           </figcaption>
                        </figure>
                        <div class="it-sec">
                           <h4><a href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a></h4>
                          <h5>@if($prod->previous_price != 0 && $prod->previous_price != '') <span class="line-through" style="margin-right: 5px;">₹ {{ $prod->previous_price }}</span>@endif ₹ {{ $prod->showPrice() }}</h5>
                           @php
                            $rating = App\Models\Rating::ratings_new($prod->id);
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
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @endif<span class="float-right text-secondary">
                              {{-- @if($rating>=1) Reviews ({{$rating}})
                              @else 
                              @endif --}}
                           </span> 
                        </div>
                     </div>
               @endforeach
                     
                  </div>
                  
        
                  <h2>Latest Arrivals </h2>
                  <div id="owl-demo3" class="owl-carousel owl-theme owl-demo2">
                     @foreach($latest_products as $prod1)
                     <div class="item">
                        <figure>
                           <a href="{{ route('front.product', $prod1->slug) }}">
                              <img src="{{ $prod1->photo ? asset('assets/images/products/'.$prod1->photo):asset('assets/images/noimage.png') }}"> 
                             <!--  <div class="sl">Sale</div> -->
                           </a>
                           <figcaption>
                              <ul>
                                 @if(Auth::guard('web')->check())
                                 <li><a  href="javascript:;" class="add-to-cart" data-href="{{ route('product.cart.add',$prod1->id) }}" ><i class="fa fa-shopping-cart"></i> <span> Add to Inventory </span></a></li>
                                 <li><a  href="javascript:;" class="add-to-wish" data-href="{{ route('user-wishlist-add',$prod1->id) }}" title="{{ $langg->lang54 }}" ><i class="fa fa-heart-o"></i></a></li>
                                 @else 
                                  <li><a   href="javascript:;" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" ><i class="fa fa-shopping-cart"></i> <span> Add to Inventory </span></a></li>
                                 <li><a   href="javascript:;" title="{{ $langg->lang54 }}" id="wish-btn" data-toggle="modal"  data-target="#comment-log-reg" ><i class="fa fa-heart-o"></i></a></li>
                                 @endif
                              </ul>
                           </figcaption>
                        </figure>
                        <div class="it-sec">
                           <h4><a href="{{ route('front.product', $prod1->slug) }}">{{ $prod1->showName() }}</a></h4>
                           <h5>@if($prod1->previous_price != 0 && $prod1->previous_price != '') <span class="line-through" style="margin-right: 5px;">₹ {{ $prod1->previous_price }}</span>@endif ₹ {{ $prod1->showPrice() }}</h5>
                           @php
                            $rating = App\Models\Rating::ratings_new($prod1->id);
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
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @endif<span class="float-right text-secondary">
                              {{-- Reviews ({{$rating}}) --}}
                           </span> 
                        </div>
                     </div>
               @endforeach
                     
                  </div>



        
                  <h2>Discounts </h2>
                  <div id="owl-demo3" class="owl-carousel owl-theme owl-demo2">
                     @foreach($discount_products as $prod1)
                      <div class="item">
                        <figure>
                           <a href="{{ route('front.product', $prod1->slug) }}">
                              <img src="{{ $prod1->photo ? asset('assets/images/products/'.$prod1->photo):asset('assets/images/noimage.png') }}"> 
                             <!--  <div class="sl">Sale</div> -->
                           </a>
                           <figcaption>
                              <ul>
                                 @if(Auth::guard('web')->check())
                                 <li><a  href="javascript:;" class="add-to-cart" data-href="{{ route('product.cart.add',$prod1->id) }}" ><i class="fa fa-shopping-cart"></i> <span> Add to Inventory </span></a></li>
                                 <li><a  href="javascript:;" class="add-to-wish" data-href="{{ route('user-wishlist-add',$prod1->id) }}" title="{{ $langg->lang54 }}" ><i class="fa fa-heart-o"></i></a></li>
                                 @else 
                                  <li><a   href="javascript:;" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" ><i class="fa fa-shopping-cart"></i> <span> Add to Inventory </span></a></li>
                                 <li><a   href="javascript:;" title="{{ $langg->lang54 }}" id="wish-btn" data-toggle="modal"  data-target="#comment-log-reg" ><i class="fa fa-heart-o"></i></a></li>
                                 @endif
                              </ul>
                           </figcaption>
                        </figure>
                        <div class="it-sec">
                           <h4><a href="{{ route('front.product', $prod1->slug) }}">{{ $prod1->showName() }}</a></h4>
                           <h5>@if($prod1->previous_price != 0 && $prod1->previous_price != '') <span class="line-through" style="margin-right: 5px;">₹ {{ $prod1->previous_price }}</span>@endif ₹ {{ $prod1->showPrice() }}</h5>
                           @php
                            $rating = App\Models\Rating::ratings_new($prod1->id);
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
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           @endif<span class="float-right text-secondary">
                              {{-- Reviews ({{$rating}}) --}}
                           </span> 
                        </div>
                     </div>
               @endforeach
                     
                  </div>

               </div>
               <div class="col-md-2">
                  <div class="ads ads-rgt">
                     @foreach( $side_banners AS $side)
                     <a href="{{ $side->link }}" target="_blank"><img src="{{url('assets/images/banners/'.$side->photo)}}" class="img-fluid"></a>
                     @endforeach
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>











@endif
@endsection
