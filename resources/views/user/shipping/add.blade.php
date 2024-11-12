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
									Add New Shipping Address
								</h4>
							</div>
							<div class="mr-table allproduct mt-4">
							        @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
									<div class="table-responsiv">
											<form action="{{route('user-save-shipping-address')}}" class="needs-validation" id="forms1" method="POST">
											   {{ csrf_field() }}
                                              <div class="form-group">
                                                <label for="email">Shipping Name:</label>
                                                <input type="text" class="form-control" name="shipping_name" placeholder="Shipping Name" value="" required>
                                                <div class="invalid-feedback">
                                                  Valid Shipping Name is required.
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="email">Shipping Phone:</label>
                                                <input type="number" class="form-control" name="shipping_phone" placeholder="Shipping Phone" value="" required>
                                                <div class="invalid-feedback">
                                                  Valid Shipping Phone is required.
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="email">Shipping Email:</label>
                                                <input type="email" class="form-control" name="shipping_email" placeholder="Shipping Email" value=""  required>
                                                <div class="invalid-feedback">
                                                  Valid Shipping Email is required.
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="email">Shipping Building Number:</label>
                                                <input type="number" class="form-control" name="shipping_building_no" placeholder="Shipping Building Number" value=""  >
                                              </div>
                                              <div class="form-group">
                                                <label for="email">Shipping Zone Number:</label>
                                                <input type="number" class="form-control" id="shipping_zone_no" name="shipping_zone_no" placeholder="Shipping Zone Number"  value="" required>
                                                <div class="invalid-feedback">
                                                  Valid Shipping Zone Number is required.
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="email">Shipping Street Number:</label>
                                                <input type="number" class="form-control" name="shipping_street_no" placeholder="Shipping Street Number"  value="" >
                                              </div>
                                           
                                              <div class="form-group">
                                                <label for="email">Shipping Address:</label>
                                                <textarea class="form-control" id="shipping_address" name="shipping_address" placeholder="Shipping Address" required></textarea>
                                                <div class="invalid-feedback">
                                                  Valid Shipping Address is required.
                                                </div>
                                              </div>
                                              <div class="row">
             <div class="col-md-12">
          
	
                                              <button class="submit-btn" type="submit" style="background: #d12438;" onclick="myFunction()">Add</button>
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
	        width: 145px;
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