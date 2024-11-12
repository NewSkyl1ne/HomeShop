@extends('layouts.load')
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('new_asstes/css/bootstrap.min.css')}}?v=0.1" type="text/css">
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('new_asstes/css/webslidemenu.css')}}" />
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('new_asstes/css/font-awesome.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @extends('layouts.admin') 



@section('content')  

					<input type="hidden" id="headerdata" value="PRODUCT">

					<div class="content-area">

						<div class="mr-breadcrumb">

						<div class="content-area">
							<div class="social-links-area">
							<div class="add-product-content">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
                              <section class="sec1">
                                 <div class="container-fluid">
                                 <div class="col-md-12">
                                 <div class="hm-mainsec">
                                 <div class="row">
                                  <div class="col-md-10">
                                       <h2>Nothing Reviewed or Rated</h2>
   
                                  </div> 
                                 </div>
                                 </div>
                                 </div>
                                 </div>
                                 </div>
                               </section>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					

@endsection

