							{{-- If This product belongs to vendor then apply this --}}
                                @if($prod->user_id != 0)

                                {{-- check  If This vendor status is active --}}
                                @if($prod->user->is_vendor == 2)

	                            @if(isset($_GET['max']))  

	                            @if($prod->vendorPrice() <= $_GET['max'])

									<div class="col-lg-4 col-md-4 col-6 remove-padding">

												<a class="item" href="{{ route('front.product', $prod->slug) }}">
													<div class="item-img">
													@if(!empty($prod->features))
															<div class="sell-area">
															@foreach($prod->features as $key => $data1)
																<span class="sale" style="background-color:{{ $prod->colors[$key] }}">{{ $prod->features[$key] }}</span>
																@endforeach 
															</div>
														@endif
															<div class="extra-list">
																<ul>
																	<li>
																		@if(Auth::guard('web')->check())

																		<span href="javascript:;" class="add-to-wish" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title="{{ $langg->lang54 }}" data-placement="right"><i class="icofont-heart-alt" ></i>
																		</span>

																		@else 

																		<span href="javascript:;" rel-toggle="tooltip" title="{{ $langg->lang54 }}" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right">
																			<i class="icofont-heart-alt"></i>
																		</span>

																		@endif
																	</li>
																	<li>
																	<span class="quick-view" rel-toggle="tooltip" title="{{ $langg->lang55 }}" href="javascript:;" data-href="{{ route('product.quick',$prod->id) }}" data-toggle="modal" data-target="#quickview" data-placement="right"> <i class="icofont-eye"></i>
																	</span>
																	</li>
																	<li>
																		<span href="javascript:;" class="add-to-cart" data-href="{{ route('product.cart.add',$prod->id) }}"  data-toggle="tooltip" data-placement="right" title="{{ $langg->lang56}}" data-placement="right">
																			<i class="icofont-cart"></i>
																		</span>
																	</li>
																	<li>
																		<span href="javascript:;" class="add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}"  data-toggle="tooltip" data-placement="right" title="{{ $langg->lang57 }}" data-placement="right">
																			<i class="icofont-exchange"></i>
																		</span>
																	</li>
																</ul>
															</div>
														<img class="img-fluid" src="{{ $prod->photo ? asset('assets/images/products/'.$prod->photo):asset('assets/images/noimage.png') }}" alt="">
													</div>
													<div class="info">
														<div class="stars">
		                                                  <div class="ratings">
		                                                      <div class="empty-stars"></div>
		                                                      <div class="full-stars" style="width:{{App\Models\Rating::ratings($prod->id)}}%"></div>
		                                                  </div>
														</div>
														<h4 class="price">{{ $prod->showPrice() }}</h4>
														<h5 class="name">{{ $prod->showName() }}</h5>
													</div>
												</a>

									</div>

								@endif

								@else 

									<div class="col-lg-4 col-md-4 col-6 remove-padding">

												<a class="item" href="{{ route('front.product', $prod->slug) }}">
													<div class="item-img">
													@if(!empty($prod->features))
															<div class="sell-area">
															@foreach($prod->features as $key => $data1)
																<span class="sale" style="background-color:{{ $prod->colors[$key] }}">{{ $prod->features[$key] }}</span>
																@endforeach 
															</div>
														@endif
															<div class="extra-list">
																<ul>
																	<li>
																		@if(Auth::guard('web')->check())

																		<span href="javascript:;" class="add-to-wish" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title="{{ $langg->lang54 }}" data-placement="right"><i class="icofont-heart-alt" ></i>
																		</span>

																		@else 

																		<span href="javascript:;" rel-toggle="tooltip" title="{{ $langg->lang54 }}" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right">
																			<i class="icofont-heart-alt"></i>
																		</span>

																		@endif
																	</li>
																	<li>
																	<span class="quick-view" rel-toggle="tooltip" title="{{ $langg->lang55 }}" href="javascript:;" data-href="{{ route('product.quick',$prod->id) }}" data-toggle="modal" data-target="#quickview" data-placement="right"> <i class="icofont-eye"></i>
																	</span>
																	</li>
																	<li>
																		<span href="javascript:;" class="add-to-cart" data-href="{{ route('product.cart.add',$prod->id) }}"  data-toggle="tooltip" data-placement="right" title="{{ $langg->lang56}}" data-placement="right">
																			<i class="icofont-cart"></i>
																		</span>
																	</li>
																	<li>
																		<span href="javascript:;" class="add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}"  data-toggle="tooltip" data-placement="right" title="{{ $langg->lang57 }}" data-placement="right">
																			<i class="icofont-exchange"></i>
																		</span>
																	</li>
																</ul>
															</div>
														<img class="img-fluid" src="{{ $prod->photo ? asset('assets/images/products/'.$prod->photo):asset('assets/images/noimage.png') }}" alt="">
													</div>
													<div class="info">
														<div class="stars">
		                                                  <div class="ratings">
		                                                      <div class="empty-stars"></div>
		                                                      <div class="full-stars" style="width:{{App\Models\Rating::ratings($prod->id)}}%"></div>
		                                                  </div>
														</div>
														<h4 class="price">{{ $prod->showPrice() }}</h4>
														<h5 class="name">{{ $prod->showName() }}</h5>
													</div>
												</a>

									</div>

								@endif

								@endif

                                {{-- If This product belongs admin and apply this --}}

								@else 

							<div class="col-lg-4 col-md-4 col-6 remove-padding">

										<a class="item" href="{{ route('front.product', $prod->slug) }}">
											<div class="item-img">
											@if(!empty($prod->features))
													<div class="sell-area">
													@foreach($prod->features as $key => $data1)
														<span class="sale" style="background-color:{{ $prod->colors[$key] }}">{{ $prod->features[$key] }}</span>
														@endforeach 
													</div>
												@endif
													<div class="extra-list">
														<ul>
															<li>
																@if(Auth::guard('web')->check())

																<span href="javascript:;" class="add-to-wish" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title="{{ $langg->lang54 }}" data-placement="right"><i class="icofont-heart-alt" ></i>
																</span>

																@else 

																<span href="javascript:;" rel-toggle="tooltip" title="{{ $langg->lang54 }}" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right">
																	<i class="icofont-heart-alt"></i>
																</span>

																@endif
															</li>
															<li>
															<span class="quick-view" rel-toggle="tooltip" title="{{ $langg->lang55 }}" href="javascript:;" data-href="{{ route('product.quick',$prod->id) }}" data-toggle="modal" data-target="#quickview" data-placement="right"> <i class="icofont-eye"></i>
															</span>
															</li>
															<li>
																<span href="javascript:;" class="add-to-cart" data-href="{{ route('product.cart.add',$prod->id) }}"  data-toggle="tooltip" data-placement="right" title="{{ $langg->lang56}}" data-placement="right">
																	<i class="icofont-cart"></i>
																</span>
															</li>
															<li>
																<span href="javascript:;" class="add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}"  data-toggle="tooltip" data-placement="right" title="{{ $langg->lang57 }}" data-placement="right">
																	<i class="icofont-exchange"></i>
																</span>
															</li>
														</ul>
													</div>
												<img class="img-fluid" src="{{ $prod->photo ? asset('assets/images/products/'.$prod->photo):asset('assets/images/noimage.png') }}" alt="">
											</div>
											<div class="info">
												<div class="stars">
                                                  <div class="ratings">
                                                      <div class="empty-stars"></div>
                                                      <div class="full-stars" style="width:{{App\Models\Rating::ratings($prod->id)}}%"></div>
                                                  </div>
												</div>
												<h4 class="price">{{ $prod->showPrice() }}</h4>
												<h5 class="name">{{ $prod->showName() }}</h5>
											</div>
										</a>
							</div>

								@endif