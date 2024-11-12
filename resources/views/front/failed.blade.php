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
                Your payment is failed 
            </h4>
           
            <?php 
            if(Session('qpay_session_id') !=  ''){
              ?>
               <p class="text">
                If you wish to try again please click the below link
                </p>
                <a href="{{ route('front.qpaySession') }}?type=retry" class="link">Retry Payment</a>
              <?php
             }else{
                ?>
              <?php
             }
             ?>
            
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection