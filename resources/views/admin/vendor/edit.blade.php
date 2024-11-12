@extends('layouts.load')
@section('content')

						<div class="content-area">
							<div class="add-product-content">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">
                        					@include('includes.admin.form-error') 
											<form id="geniusformdata" action="{{ route('admin-vendor-edit',$data->id) }}" method="POST" enctype="multipart/form-data">
												{{csrf_field()}}

												<?php /*<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Email *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="email" class="input-field" name="email" placeholder="Email Address" value="{{ $data->email }}" disabled="">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Shop Name *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_name" placeholder="Shop Name" required="" value="{{ $data->shop_name }}">
													</div>
												</div>




												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Shop Details *</h4>
														</div>
													</div>
													<div class="col-lg-7">
													<textarea class="nic-edit" name="shop_details" placeholder="Details">{{ $data->shop_details }}</textarea> 
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Owner Name *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="owner_name" placeholder="Owner Name" required="" value="{{ $data->owner_name }}">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Shop Number *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_number" placeholder="Shop Number" required="" value="{{ $data->shop_number }}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Shop Address *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_address" placeholder="Shop Address" required="" value="{{ $data->shop_address }}">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Registration Number </h4>
																<p class="sub-heading">(This Field is Optional)</p>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="reg_number" placeholder="Registration Number" value="{{ $data->reg_number }}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Message </h4>
																<p class="sub-heading">(This Field is Optional)</p>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_message" placeholder="Message" value="{{ $data->shop_message }}">
													</div>
												</div>*/?>
												<div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                                <h4 class="heading">Customer Profile Image *</h4>
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <div class="img-upload">
						                            	@if($data->is_provider == 1)
						                                <div id="image-preview" class="img-preview" style="background: url({{ $data->photo ? asset($data->photo):asset('assets/images/noimage.png') }});">
						                            	@else
						                                <div id="image-preview" class="img-preview" style="background: url({{ $data->photo ? asset('assets/images/users/'.$data->photo):asset('assets/images/noimage.png') }});">
						                                @endif
						                                @if($data->is_provider != 1)
						                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>Upload Image</label>
						                                    <input type="file" name="photo" class="img-upload" id="image-upload">
						                                @endif
						                                  </div>
						                                  <p class="text">Prefered Size: (600x600) or Square Sized Image</p>
						                            </div>
						                          </div>
						                        </div>

						                        
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Name *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="name" placeholder="User Name" required="" value="{{ $data->name }}">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Email *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="email" class="input-field" name="email" placeholder="Email Address" value="{{ $data->email }}" disabled="">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Phone *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="phone" placeholder="Phone Number" required="" value="{{ $data->phone }}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Address *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="address" placeholder="Address" required="" value="{{ $data->address }}">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">City </h4>
														</div>
													</div>
													<div class="col-lg-7">
														@php
			                                            $shipping_data = DB::table('pickups')->get();
			                                            @endphp
														<select class="input-field" name="city" required="">
															<option value="">(-- Choose City --)</option>
															@foreach($shipping_data AS $key=>$value)
															<option value="{{$value->id}}" @if($value->id == $data->city) selected @endif>{{$value->location}}</option>
															@endforeach
														</select>
														<!-- <input type="text" class="input-field" name="phone" placeholder="City" value="{{ $data->phone }}"> -->
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">Building No *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="building_no" placeholder="Building No" required="" value="{{ $data->building_no }}">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">Zone *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="zone_no" placeholder="Zone" required="" value="{{ $data->zone_no }}">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">Street *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="street_no" placeholder="Street" required="" value="{{ $data->street_no }}">
													</div>
												</div>
												

												<div class="row">
													<div class="col-lg-4">
													<div class="left-area">
													<h4 class="heading">CR Document *</h4>
													</div>
													</div>
													<div class="col-lg-7">
													<div>
													<label><i class="icofont-upload-alt"></i>Upload CR Document</label>
													<a href="{{ $data->cr_doc ? asset('assets/images/vendorCRDocs/'.$data->cr_doc):asset('assets/images/noimage.png') }}" class="btn btn-primary active float-right" role="button" aria-pressed="true" target="_blank">View Uploaded CR Document</a>
													<input type="file" class="form-control-file" name="cr_doc">
													</div>
													
													</div>
													</div>
													
													<div class="row">
													<div class="col-lg-4">
													<div class="left-area">
													<h4 class="heading">Document *</h4>
													</div>
													</div>
													<div class="col-lg-7">
													<div id="image-preview" class="img-preview" style="">
													<label><i class="icofont-upload-alt"></i>Upload Document</label>
													<a href="{{ $data->doc ? asset('assets/images/vendorDocs/'.$data->doc):asset('assets/images/noimage.png') }}" class="btn btn-primary active float-right" role="button" aria-pressed="true" target="_blank">View Uploaded Document</a>
													<input type="file" class="form-control-file" name="doc">
													</div>
													
													</div>
													</div>
													

												<div class="row" style="display: none;">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Fax </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="fax" placeholder="Fax" value="{{ $data->fax }}">
													</div>
												</div>


												<div class="row" style="display: none;">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Postal Code </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="zip" placeholder="Postal Code" value="{{ $data->zip }}">
													</div>
												</div>


						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                              
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <button class="addProductSubmit-btn" type="submit">Submit</button>
						                          </div>
						                        </div>

											</form>


											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

@endsection