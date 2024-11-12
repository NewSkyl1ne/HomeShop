@extends('layouts.admin') 



@section('content')  
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('new_asstes/css/bootstrap.min.css')}}?v=0.1" type="text/css">
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('new_asstes/css/webslidemenu.css')}}" />
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('new_asstes/css/font-awesome.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


					<input type="hidden" id="headerdata" value="PRODUCT">

					<div class="content-area">

						<div class="mr-breadcrumb">

							<div class="row">

								<div class="col-lg-12">

										<h4 class="heading">Products</h4>

										<ul class="links">

											<li>

												<a href="{{ route('admin.dashboard') }}">Dashboard </a>

											</li>

											<li>

												<a href="{{ route('admin-prod-index') }}">All Products</a>

											</li>
                      <li>
												<a href="javascript:;">{{ $langg->lang96 }} </a>
											</li>
										</ul>

								</div>

							</div>

						</div>

						<div class="product-area">

							<div class="row">

								<div class="col-lg-12">

									<div class="mr-table allproduct">



                        @include('includes.admin.form-success')  



										<div class="table-responsiv">

												<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">

													<thead>
                            <h3>Ratings and Reviews<h3>

														<tr>

									                        <th>Name</th>

									                        <th>Title</th>

									                        <th>Review</th>

									                        <th>Rating  ({{$stars}}/5)</th>

									                        <th>Time</th>

														</tr>

													</thead>
                          @foreach($ratings as $rating)
                             <tr>
                                        <td>{{$rating->name}}</td>
                                        <td>{{$rating->title}}</td>
                                        <td>{{$rating->review}}</td>
                                        <td><div class="str">
                                        @if($rating->rating == 5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        @elseif($rating->rating >= 4.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                        @elseif($rating->rating >= 4)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        @elseif($rating->rating >= 3.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        @elseif($rating->rating >= 3)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        @elseif($rating->rating >= 2.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        @elseif($rating->rating >= 2)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        @elseif($rating->rating >= 1.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        @elseif($rating->rating >= 1)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        @elseif($rating->rating >= 0.5)
                                        <i class="fa fa-star-half-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        @else($rating->rating == 0.0)
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        @endif 
                                        </div></td>  
                                <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $rating->review_date)->diffForHumans()}}</td>
                                <tr>     
                                       @endforeach

												</table>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>
@endsection   