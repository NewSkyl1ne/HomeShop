@extends('layouts.front')
@section('content')
<section class="abt-tp">
  <div class="container">
    <div class="col-md-12">
      <h2>Success </h2>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{ route('front.index') }}">Home</a></li>
          <li>Success </li>
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
                Your cancel request is successfully Completed
            </h4>
               <p class="text">
                If you wish to go to order history then click below
                </p>
                <a href="{{ route('user-orders') }}" class="link">Return To Orders</a>          
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection