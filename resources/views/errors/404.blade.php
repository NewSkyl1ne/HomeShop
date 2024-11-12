@extends('layouts.front')
@section('content')

<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ul class="pages">
          <li>
            <a href="{{ route('front.index') }}">
              Home
            </a>
          </li>
          <li>
            <a href="javascript:;">
              404
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumb Area End -->

<section class="fourzerofour">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <img src="{{  asset('assets/front/images/404.png')}}" alt="">
            <h4 class="heading">
              Oops! You're lost...
            </h4>
            <p class="text">
              The page you are looking for might have been moved,
              renamed, or might never existed.
            </p>
            <a class="mybtn1" href="{{ route('front.index') }}">Back Home</a>
          </div>
        </div>
      </div>
    </div>
  </section>


@endsection