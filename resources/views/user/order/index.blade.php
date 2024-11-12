@extends('layouts.front')
@section('content')


<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
        <div class="col-lg-8">
					<div class="user-profile-details">
						<div class="order-history fix-mob">
							<div class="header-area">
								<h4 class="title">
									Purchased Items
								</h4>
							</div>
							<div class="mr-table allproduct">
									<div class="table-responsive table-fix">
											<table id="example" class="table table-hover dt-responsive" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>#Order</th>
														<th>Date</th>
														<th>Order Total</th>
														<th>Order Status</th>
														<th>View</th>
													</tr>
												</thead>
												<tbody>
													 @foreach($orders as $order)
													<tr>
														<td>
																{{$order->order_number}}
														</td>
														<td>
																{{date('d M Y',strtotime($order->created_at))}}
														</td>
														<td>
																{{$order->currency_sign}} {{$order->pay_amount }}
														</td>
														<td>
																{{ucfirst($order->status)}}
														</td>
														<td>
															<a href="{{route('user-order',$order->id)}}">
																	VIEW ORDER
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
@endsection