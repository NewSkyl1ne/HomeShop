@extends('layouts.front')
@section('content')
<section class="abt-tp">
  <div class="container">
    <div class="col-md-12">
      <h2>{{ $langg->lang169 }}</h2>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{ route('front.index') }}">Home</a></li>
          <li>{{ $langg->lang169 }}</li>
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
                {{ $gs->order_title }}
            </h4>
            <p class="text">
                {{ $gs->order_text }}
            </p>
            <a href="{{ route('front.index') }}" class="link">{{ $langg->lang170 }}</a>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection