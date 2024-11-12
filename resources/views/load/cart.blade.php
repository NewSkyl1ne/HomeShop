								


									@if(Session::has('cart'))
										<div class="dropdownmenu-wrapper">
												<div class="dropdown-cart-header">
													<span class="item-no">
														<span class="cart-quantity">
									{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}
														</span>Item(s)
													</span>

													<a class="view-cart" href="{{ route('front.cart') }}">
													View Cart
													</a>
												</div><!-- End .dropdown-cart-header -->
												<ul class="dropdown-cart-products">
													@foreach(Session::get('cart')->items as $product)
														<li class="product cremove{{ $product['item']['id'].$product['size'] }}">
															<div class="product-details">
																<div class="content">
																	<a href="{{ route('front.product',$product['item']['slug']) }}"><h4 class="product-title">{{strlen($product['item']['name']) > 45 ? substr($product['item']['name'],0,45).'...' : $product['item']['name']}}</h4></a>

																	<span class="cart-product-info">
																		<span class="cart-product-qty" id="cqt{{$product['item']['id'].$product['size']}}">{{$product['qty']}}</span><span>{{ $product['item']['measure'] }}</span>
																		x <span id="prct{{$product['item']['id'].$product['size']}}">{{ App\Models\Product::convertPrice($product['item']['price']) }}</span>
																	</span>
																</div>
															</div><!-- End .product-details -->

															<figure class="product-image-container">
																<a href="{{ route('front.product', $product['item']['slug']) }}" class="product-image">
																	<img src="{{ $product['item']['photo'] ? asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}" alt="product">
																</a>
																<div class="cart-remove" data-class="cremove{{ $product['item']['id'].$product['size'] }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size']) }}" title="Remove Product">
																	<i class="icofont-close"></i>
																</div>
															</figure>
														</li><!-- End .product -->
													@endforeach
												</ul><!-- End .cart-product -->

												<div class="dropdown-cart-total">
														<span>Total</span>

														<span class="cart-total-price">
															<span class="cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00' }}
															</span>
														</span>
												</div><!-- End .dropdown-cart-total -->

												<div class="dropdown-cart-action">
														<a href="{{ route('front.checkout') }}" class="mybtn1">Checkout</a>
												</div><!-- End .dropdown-cart-total -->
										</div>
									@else 
									<p class="mt-1 pl-3 text-left">Cart is empty.</p>
									@endif