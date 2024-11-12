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
									Shipping Address
								</h4>
							</div>
							<div class="mr-table allproduct mt-4">
							        @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                                    <a href="{{route('user-add-shipping-address')}}" class="submit-btn add_new" onclick='getLocation()' type="submit" style="background: #d12438;">Add New</a>
									<div class="table-responsive">
									    
											<table id="example" class="table table-hover dt-responsive" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>#Sl No</th>
														<th>User Name</th>
														<th>phone</th>
														<th>Email</th>
														<th>View</th>
													</tr>
												</thead>
												<tbody>
												    @php $i = 0; @endphp
													 @foreach(@$list as $order)
													 @php $i++; @endphp
													<tr>
													    <td>
													        {{$i}}
													    </td>
														<td>
																{{$order->shipping_name}}
														</td>
														<td>
																{{$order->shipping_phone}}
														</td>
														<td>
																{{$order->shipping_email}}
														</td>
														<td>
															<a href="{{route('user-edit-shipping-address',$order->id)}}">
																	Edit
															</a>
															|
															<a href="{{route('user-delete-shipping-address',$order->id)}}">
																	Delete
															</a>
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
		<style>
	    .add_new{
	            float: right;
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

