@extends('layouts.front')
@section('content')


<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
        <div class="col-lg-8">
					<div class="user-profile-details">
						<div class="order-history">
							<div class="header-area">
								<h4 class="title">
									Edit Shipping Address
								</h4>
							</div>
							<div class="mr-table allproduct mt-4">
							        @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
									<div class="table-responsiv">
											<form action="{{route('user-update-shipping-address',$data->id)}}" method="POST" >
											   {{ csrf_field() }}
                                              <div class="form-group">
                                                <label for="email">Shipping Name:</label>
                                                <input type="text" class="form-control" name="shipping_name" placeholder="Shipping Name" value="{{$data->shipping_name}}" required>
                                              </div>
                                              <div class="form-group">
                                                <label for="email">Shipping Phone:</label>
                                                <input type="number" class="form-control" name="shipping_phone" placeholder="Shipping Phone" value="{{$data->shipping_phone}}" required>
                                              </div>
                                              <div class="form-group">
                                                <label for="email">Shipping Email:</label>
                                                <input type="email" class="form-control" name="shipping_email" placeholder="Shipping Email" value="{{$data->shipping_email}}"  required>
                                              </div>
                                              <div class="form-group">
                                                <label for="email">Shipping Building Number:</label>
                                                <input type="number" class="form-control" name="shipping_building_no" placeholder="Shipping Building Number" value="{{$data->shipping_building_no}}"  required>
                                              </div>
                                              <div class="form-group">
                                                <label for="email">Shipping Zone Number:</label>
                                                <input type="number" class="form-control" name="shipping_zone_no" placeholder="Shipping Zone Number"  value="{{$data->shipping_zone_no}}" required>
                                              </div>
                                              <div class="form-group">
                                                <label for="email">Shipping Street Number:</label>
                                                <input type="number" class="form-control" name="shipping_street_no" placeholder="Shipping Street Number"  value="{{$data->shipping_street_no}}" required>
                                              </div>
                                   
                                              <div class="form-group">
                                                <label for="email">Shipping Address:</label>
                                                <textarea class="form-control" name="shipping_address" placeholder="Shipping Address" >{{$data->shipping_address}}</textarea>
                                              </div>
                                      
                                              <button class="submit-btn" type="submit" style="background: #d12438;">Update</button>
                                              <a href="{{route('user-shipping-address')}}" class="submit-btn back_a" type="submit" style="background: #b9afb0;">Back</a>
                                            </form>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<style>
	    button,.back_a{
	        width: 120px;
            height: 50px;
            background: #d12438;
            color: #fff;
            font-size: 14px;
            line-height: 50px;
            font-weight: 600;
            text-align: center;
            text-transform: uppercase;
            border: 0px;
            border-radius: 3px;
            cursor: pointer;
            -webkit-transition: all 0.3s ease-in;
            -o-transition: all 0.3s ease-in;
            transition: all 0.3s ease-in;
	    }
	</style>
@endsection