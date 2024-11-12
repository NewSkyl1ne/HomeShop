@extends('layouts.front')
@section('content')
<section class="abt-tp">
  <div class="container">
    <div class="col-md-12">
      <h2>{{ $page->title }}</h2>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{ url('/')}}">{{ $langg->lang17 }}</a></li>
          <li>{{ $page->title }}</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="lgn">
  <div class="container">
    <div class="col-md-12">
      <div class="row">
            <div class="col-md-12 clearfix animated fadeIn xsp-2" style="text-align: justify;">
            <div class="des">
              <p> {!! $page->details !!}</p>
            </div>
      </div>
    </div>
  </div>
</section>

<style type="text/css">
.des p {
    line-height: 35px;
    color: #626567;
    }
</style>

@endsection
