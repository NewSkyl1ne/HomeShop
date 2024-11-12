@extends('layouts.front')
@section('content')
<section class="abt-tp">
  <div class="container">
    <div class="col-md-12">
      <h2>Failed </h2>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{ route('front.index') }}">Home</a></li>
          <li>Failed </li>
        </ul>
      </div>
    </div>
  </div>
</section>




<section class="thankyou">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-11">
          <div class="content" style="background: #cf2336;">
            <div class="icon">
                <i class="icofont-check-circled"></i>
            </div>
            <h4 class="heading">
              Out of stock 
            </h4>
           
               <p class="text">
                   Selected Product Is Out of stock Please select after some time
                </p>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection