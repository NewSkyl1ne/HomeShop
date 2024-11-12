<section class="crt">
  <div class="container">
    <div class="col-md-12">
      @if( count($cartlist)>0 )
      <div class="table-responsive">
        <form  method="POST" action="{{route('product.cart.update')}}">
          {{ csrf_field() }}
        <table class="table">
          <thead>
            <tr>
              <td>&nbsp;</td>
              <td>Product</td>
              <td>Price</td>
              <td>Quantity</td>
              <td>Total</td>
            </tr>
          </thead>
          <tbody>
            @php 
            $total_amount   = 0;
            @endphp
            @foreach($cartlist as $value)
            @php
            $product = DB::table('products')
                           ->where('id', '=', $value->product_id)
                           ->get()->first();                        
            @endphp
            <tr>
              <td width="5%"><a href="{{url('/removecart/'.$value->id)}}"><i class="fa fa-close"></i></a></td>
              <th scope="row" width="45%"><div class="crt-mlft" style="display: flex;flex-wrap: wrap;align-items: center;"><div class="crt-img" >
                <a href="{{url('/item/'.$product->slug)}}">
                  <img src="{{ $product->photo ? asset('assets/images/products/'.$product->photo):asset('assets/images/noimage.png') }}" class="img-fluid">
                </a></div>
                <div class="crt-txt">
                  <a href="{{url('/item/'.$product->slug)}}">
                  <h4>{{$product->name}}<br>
                    <!-- <span>Brand Name</span> --></h4></a>
                </div></th>
              <td width="15%">₹ {{$product->price}}</td>
              <td width="20%"><div class="input-group"> <!--id="CC-prodDetails-quantity" -->
                  <input type="number" name="cart_quant[{{$value->id}}]" id="cart_quant_{{$value->id}}" class="form-control input-number" value="{{$value->qty}}" min="1" max="500" readonly>
                  <span class="input-group-btn">
                  <button id="qty-minus" type="button" class="btn btn-default btn-number minus_cart" data-type="minus" data-field="cart_quant[{{$value->id}}]" data-id="{{$value->id}}"> <span class="fa fa-minus"></span> </button>
                  </span>
                  <span class="input-group-btn">
                  <button id="qty-plus" type="button" class="btn btn-default btn-number add_cart" data-type="plus" data-field="cart_quant[{{$value->id}}]" data-id="{{$value->id}}" > <span class="fa fa-plus"></span> </button>
                  </span></div></td>
              <td width="15%">₹ @php echo  $sub_total = $product->price * $value->qty @endphp</td>
                @php    $total_amount =  $total_amount + $sub_total; @endphp
            </tr>
            @endforeach
           
          </tbody>
        </table>
      
       
      </div>
      
       <div class="ttl clearfix">
        <ul>
          <li>Free Delivery  </li>
          <li>Total <span>₹ {{$total_amount}}</span> </li>
        </ul>
      </div>

      <div class="col-md-12 clearfix no-padding">
       <!-- <div class="crt-lft">
         <input type="text" class="form-control" placeholder="Coupon Code"><button class="btn-ac">Apply Coupon</button>
       </div> -->
       <div class="crt-rgt">
         <!-- <a><button type="submit" style="border: 0px;background: #fff0;">Update Basket</button></a> -->
         <a href="{{url('/checkout')}}">Proceed to Check Out</a>
       </div>
      </div>
      </form>
      @else
       <div class="page-center">
        <h4 class="text-center">{{ $langg->lang60 }}</h4>              
      </div>
       @endif
    </div>
  </div>
</section>