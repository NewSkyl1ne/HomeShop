@extends('layouts.front')
@section('content')
<section class="abt-tp">
  <div class="container">
    <div class="col-md-12">
      <h2>Frequently Asked Questions</h2>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{url('/')}}"> {{ $langg->lang17 }}</a></li>
          <li>Frequently Asked Questions</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="faq">
  <div class="container">
    <div class="col-md-12">
      <ul>@foreach($faqs as $fq)
                <li>
                <input type="checkbox" checked>
                <h2>{{ $fq->title }}</h2>
                <?php $details = strip_tags($fq->details); ?>
                <p>{!! $details  !!}</p>
                </li>
                @endforeach
            </ul>

    </div>
  </div>
</section>



@endsection