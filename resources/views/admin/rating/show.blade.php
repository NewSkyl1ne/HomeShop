@extends('layouts.load')
@section('content')
						<div class="content-area no-padding">
							<div class="add-product-content">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">

                                    <div class="table-responsive show-table">
                                        <table class="table">
                                            <tr>
                                                <th>Reviewer</th>
                                                <td>{{$data->user->name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td>{{$data->user->email}}</td>
                                            </tr>
                                            @if($data->user->phone != "")
                                            <tr>
                                                <th>Phone:</th>
                                                <td>{{$data->user->phone}}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th>Title:</th>
                                                <td>{{$data->title}}</td>
                                            </tr>
                                            <tr>
                                                <th>Review:</th>
                                                <td>{{$data->review}}</td>
                                            </tr>
                                            <tr>
                                                <th>Rating:</th>
                                                <td>{{$data->rating}}</td>
                                            </tr>

                                            <tr>
                                                <th>Reviewed at:</th>
                                                <td>{{ date('d-M-Y h:i:s',strtotime($data->review_date))}}</td>
                                            </tr>
                                        </table>
                                    </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

@endsection