@extends('layouts.front')
@section('content')

<!-- Breadcrumb Area End -->
<section class="abt-tp">
  <div class="container">
    <div class="col-md-12">
      <!-- <h2>Starphones & Tablets</h2> -->
      <div class="breadcrumb">
        <ul>
          <li><a href="{{route('front.index')}}">{{ $langg->lang17 }}</a></li>
          <li>{{ $langg->lang58 }}</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="listing">
  <div class="container-fluid">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-4 col-lg-3 ftr-sm">
          <div class="filter">
            <div class="cag">
              <h4>Categories</h4>
                @php
                $i=0;
                @endphp
                @foreach($categories as $c_value)
                @php $i++ @endphp
                @php $active= 0; @endphp
                @if($c_value->category_id == 0)         
                <article class="accord accord-single @if( @$_GET['category_id'] == $c_value->id || $perant_cat == $c_value->id  ) is-open @endif" >       
                <h4 class="accord__head" title="{{$c_value->name}}">{{$c_value->name}} </h4>
                @php
                $sub_cat    = DB::table('categories')->where('category_id',$c_value->id)->get()->all();
                if( count($sub_cat) > 0 ){
                @endphp
                @php $more =  0; @endphp
                  <div class="accord__body">
                    <input type="checkbox" class="read-more-state" id="post-{{$i}}" />
                    <ul class="read-more-wrap">
                      <li><a href="{{url('/search')}}?category_id={{$c_value->id}}" @if( @$_GET['category_id'] == $c_value->id) class="active" @endif>All</a></li>
                      @php $c= 0; @endphp
                      @foreach($sub_cat as $sc_value)
                      @php $c++ @endphp
                      @if($c == 6 && $perant_cat != $c_value->id)
                       <div class="read-more-target" >
                        @php $more =  1; @endphp
                      @endif
                      <li><a href="{{url('/search')}}?category_id={{$sc_value->id}}" @if( @$_GET['category_id'] == $sc_value->id) class="active" @php $active= 1; @endphp @endif>{{$sc_value->name}}</a></li>                      
                      @endforeach
                      @if($more == 1)
                      @php $more =  0; @endphp
                      </div> 
                      @endif
                    </ul>
                    @if($perant_cat != $c_value->id)
                    <label for="post-{{$i}}" class="read-more-trigger ativeClass_{{$perant_cat}}" ></label>
                    @endif
                  </div>
                @php
                }
                @endphp
                  </article>
                @endif
                @endforeach
            </div>
            <h3>Filters</h3>
            <div class="fil-sec">
              <h5>Prices</h5>
              <div id="slider-range"></div>
              <div class="slidecontainer">
                {{-- <p id="demo5">Maximum Price</p> --}}
                <p style="margin:0.25rem"><strong>₹ {{$min}}
                <span class="float-right">₹ {{$max}}</strong></span></p>
                <input type="range" class="slider1" name="priceinput" min="{{$min}}" max="{{$max}}" step="0" id="customRange3" value="{{$s}}" onclick="myFunction()">
              </div>
              <b><p style="float:left;margin-left:0.25rem">Min</p>
              <p style="float:right;margin-right:0.25rem">Max</p></b>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-9">
          <div class="row">
            <div class="col-md-12 no-padding">
              <div class="sel1 sel--black-panther" style="margin: 0px 0px 20px 14px;border: 1px solid #dddd;width: 160px;display: inline-block;">
              <select  name="sorting" id="sorting" class="sorting" onchange="handleSelect(this)">
                  <option value=""  style="background-color: #fd495d; color: #fff;transition: all 0.5s ease;"> Sort By (All)</option>
                  <option value="search"  style="background-color: #fd495d; color: #fff;transition: all 0.5s ease;"> (All)</option>
                  <option value="low" style="background-color: #fd495d; color: #fff;transition: all 0.5s ease;"><a>Price--Low to High</option>
                  <option value="high" style="background-color: #fd495d; color: #fff;transition: all 0.5s ease;">Price--High to Low</option>
                </select>
              </div>
              <script>
                var b=window.location.href;
                function handleSelect(elm)
                 { 
                  let abc = new URLSearchParams(window.location.search);
                  abc.set('min', elm.value);
                  if(abc.has('max')&&abc.has('select')){
                    window.location.href = window.location.pathname+"?"+abc;
                  }
                  else if(abc.has('search')){
                    window.location.href = window.location.pathname+"?"+abc+"&max="+{{$max}}+"&select="+{{$max}};
                  }
                  else{
                    window.location.href = window.location.pathname+"?"+abc+"&max="+{{$max}}+"&select="+{{$max}};
                  }
                  }
              </script>
              <div class="flt-xs">
                <span onclick="openNav()"><i class="fa fa-align-right"></i> Filter</span>
              </div>
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <div class="filter">
            <div class="cag">
              <h4>Categories</h4>
              <ul>
                @foreach($categories as $c_value)
                @if($c_value->category_id == 0)
                <li><a href="{{ url('search?category_id='.$c_value->id)}}">{{$c_value->name}}</a></li>
                @endif
                @endforeach
              </ul>
            </div>
            <h3>Filters</h3>
            <div class="fil-sec">
              <h5>Prices</h5>
              <div id="slider-range"></div>
              <div class="slidecontainer">
                {{-- <p id="demo5">Maximum Price</p> --}}
                <p style="margin:0.25rem"><strong>₹ {{$min}}
                  <span class="float-right">₹ {{$max}}</strong></span></p>
                <input type="range" class="slider1" name="priceinput" min="{{$min}}" max="{{$max}}" step="0" value="{{$s}}" id="myRange">
              </div>
              <b><p style="float:left;margin-left:0.25rem">Min</p>
                <p style="float:right;margin-right:0.25rem">Max</p></b>
            </div>
            
            
            
          </div>
                </div>

      <div class="breadcrumb">
            </div>
            <div class="row">
            @foreach($products AS $prod)
            
            <div class="col-md-6 col-lg-3 col-6 xsp-2">
              <div class="list-sec">
                <figure><a href="{{ route('front.product', $prod->slug) }}">
                <img src="{{ $prod->photo ? asset('assets/images/products/'.$prod->photo):asset('assets/images/noimage.png') }}"> 
                  </a>
                  <figcaption>
                    <ul>
                      @if(Auth::guard('web')->check())
                      <li><a  href="javascript:;" class="add-to-cart"  data-href="{{ route('product.cart.add',$prod->id) }}"  ><i class="fa fa-shopping-cart"></i> <span> Add to Inventory </span></a></li>
                      <li><a  href="javascript:;" class="add-to-wish" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title="{{ $langg->lang54 }}" data-placement="right"><i class="fa fa-heart-o"></i></a></li>
                      @else 
                      <li><a   href="javascript:;" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" ><i class="fa fa-shopping-cart"></i> <span> Add to Inventory </span></a></li>
                      <li><a   href="javascript:;"  title="{{ $langg->lang54 }}" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" ><i class="fa fa-heart-o"></i></a></li>
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
                           {{-- @elseif($rating >= 0.5)
                           <i class="fa fa-star-half-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i> --}}
                           @else($rating == 0.0)
                           <i></i>
                           {{-- <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i>
                           <i class="fa fa-star-o"></i> --}}
                           @endif <span class="float-right text-secondary">
                             {{-- Reviews ({{$rating}}) --}}
                            </span>
              </div>
            </div>
          </div>
             
            @endforeach
            
            </dv>

            
            <div class="col-md-12 no-padding">

              @if(isset($min) || isset($max))
                @if(isset($_GET['min']))
                  @php $min = $_GET['min'];
                  @endphp
                @endif
                @if(isset($_GET['select']))
                  @php $select = $_GET['select'];
                  @endphp
                @else 
                  @php
                    $select=$max;
                  @endphp
                @endif
                @if(!empty($category_id))
                  {!! $products->appends(['cat_id' => $cat_id ,'min' => $min, 'max' => $max,'select'=>$select,'category_id'=>$category_id])->links() !!}
                @elseif(!empty($best))
                  {!! $products->appends(['cat_id' => $cat_id ,'min' => $min, 'max' => $max,'select'=>$select,'best'=>$best])->links() !!}
                @elseif(!empty($top))
                  {!! $products->appends(['cat_id' => $cat_id ,'min' => $min, 'max' => $max,'select'=>$select,'top'=>$top])->links() !!}
                @elseif(!empty($discount))
                  {!! $products->appends(['cat_id' => $cat_id ,'min' => $min, 'max' => $max,'select'=>$select,'discount'=>$discount])->links() !!}
                @elseif(!empty($latest))
                  {!! $products->appends(['cat_id' => $cat_id ,'min' => $min, 'max' => $max,'select'=>$select,'latest'=>$latest])->links() !!}
                  @elseif(!empty($search))
                  {!! $products->appends(['cat_id' => $cat_id ,'min' => $min, 'max' => $max,'select'=>$select,'search'=>$search])->links() !!}
                @else
                {!! $products->appends(['cat_id' => $cat_id ,'min' => $min, 'max' => $max,'select'=>$select])->links() !!}
                @endif
              @elseif(!empty($sort))
              @if(!empty($category_id))
                {!! $products->appends(['category_id' => $category_id, 'search' => $search, 'sort' => $sort])->links() !!}
              @else
                {!! $products->appends(['cat_id' => $cat_id, 'min' => $min, 'max' => $max, 'sort' => $sort])->links() !!}
              @endif
              @else 
                {!! $products->appends(['category_id' => $category_id, 'search' => $search])->links() !!}  
              @endif
              
              <!-- <ul class="pagination">
                <li class="page-item"> <a class="page-link" href="#" aria-label="Previous"> <span aria-hidden="true"><i class="fa fa-angle-left"></i></span> <span class="sr-only">Previous</span> </a> </li>
                <li class="page-item"><a class="page-link" href="#">01</a></li>
                <li class="page-item"><a class="page-link" href="#">02</a></li>
                <li class="page-item"><a class="page-link" href="#">03</a></li>
                <li class="page-item"><a class="page-link" href="#">04</a></li>
                <li class="page-item"><a class="page-link" href="#">05</a></li>
                <li class="page-item"> <a class="page-link" href="#" aria-label="Next"> <span aria-hidden="true"><i class="fa fa-angle-right"></i></span> <span class="sr-only">Next</span> </a> </li>
              </ul> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>

  function myFunction(redirect=true) {
   
    var x = document.getElementById("customRange3").max;
    var x1 = document.getElementById("customRange3").min;
    var x2=document.getElementById("customRange3").value;
    // document.getElementById("demo5").innerHTML = "Price Range  :"+x1+'-'+x2;
    if(redirect){      
      const a = new URLSearchParams(window.location.search);
       idcat = a.get('category_id');
       a.set('select', x2);
       abc=a.get('search');
      if(a.has('max')){
        window.location.href = window.location.pathname+"?"+a;
       }
      else if(a.has('category_id')){
        window.location.href=window.location.pathname+'?category_id='+idcat+'&min='+x1+'&max='+x+'&select='+x2;
       }
      else if(a.has('search')){
        window.location.href=window.location.pathname+'?search='+abc+'&min='+x1+'&max='+x+'&select='+x2;
       }
       else if(a.has('latest')){
        window.location.href=window.location.pathname+'?latest=true&min='+x1+'&max='+x+'&select='+x2;
       }
       else if(a.has('best')){
        window.location.href=window.location.pathname+'?best=true&min='+x1+'&max='+x+'&select='+x2;
       }
       else if(a.has('top')){
        window.location.href=window.location.pathname+'?top=true&min='+x1+'&max='+x+'&select='+x2;
       }
       else if(a.has('discount')){
        window.location.href=window.location.pathname+'?discount=true&min='+x1+'&max='+x+'&select='+x2;
       }
      else{
         window.location.href=window.location.pathname+'?&min='+x1+'&max='+x+'&select='+x2;
       }
  }
}
  window.onload = function() {
   myFunction(false);
  };
  var slider = document.getElementById("myRange");
  slider.onchange = function() {
    var x = document.getElementById("myRange").max;
    var x1 = document.getElementById("myRange").min;
    var x2=document.getElementById("myRange").value;
    const a = new URLSearchParams(window.location.search);
       idcat = a.get('category_id');
       a.set('select', x2);
       abc=a.get('search');
      if(a.has('max')){
        window.location.href = window.location.pathname+"?"+a;
       }
      else if(a.has('category_id')){
        window.location.href=window.location.pathname+'?category_id='+idcat+'&min='+x1+'&max='+x+'&select='+x2;
       }
      else if(a.has('search')){
        window.location.href=window.location.pathname+'?search='+abc+'&min='+x1+'&max='+x+'&select='+x2;
       }
       else if(a.has('latest')){
        window.location.href=window.location.pathname+'?latest=true&min='+x1+'&max='+x+'&select='+x2;
       }
       else if(a.has('best')){
        window.location.href=window.location.pathname+'?best=true&min='+x1+'&max='+x+'&select='+x2;
       }
       else if(a.has('top')){
        window.location.href=window.location.pathname+'?top=true&min='+x1+'&max='+x+'&select='+x2;
       }
       else if(a.has('discount')){
        window.location.href=window.location.pathname+'?discount=true&min='+x1+'&max='+x+'&select='+x2;
       }
      else{
         window.location.href=window.location.pathname+'?&min='+x1+'&max='+x+'&select='+x2;
       }
  }
                
  </script>
@endsection

@section('scripts')

<script type="text/javascript">
 

  $(function () {
    $("#slider-range").slider({
    range: true,
    orientation: "horizontal",
    min: 0,
    max: 1000,
    values: [{{ isset($_GET['min']) ? $_GET['min'] : '0' }}, {{ isset($_GET['max']) ? $_GET['max'] : '1000' }}],
    step: 5,

    slide: function (event, ui) {
      if (ui.values[0] == ui.values[1]) {
        return false;
      }
      
      $("#min_price").val(ui.values[0]);
      $("#max_price").val(ui.values[1]);
    }
    });

    $("#min_price").val($("#slider-range").slider("values", 0));
    $("#max_price").val($("#slider-range").slider("values", 1));

  });
</script>

@endsection