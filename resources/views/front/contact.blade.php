@extends('layouts.front')


@section('content')
<section class="abt-tp">
  <div class="container">
    <div class="col-md-12">
      <h2>Contact Us</h2>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{url('')}}"> {{ $langg->lang17 }}</a></li>
          <li>Contact Us</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="con-sec">
<iframe id="map-canvas" src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d4160.777194043614!2d77.32659334266994!3d28.726041557739002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x390cf97efb29df61%3A0x53d559ad032c7970!2sP8HH%2BPJR%2C%20Ghaziabad%2C%20Uttar%20Pradesh%20201102!3m2!1d28.7293098!2d77.3289987!5e0!3m2!1sen!2sin!4v1653966681888!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  <div class="container">
    <div class="col-md-12">
      <div class="con">
        <div class="row">
          <div class="col-md-9">
             <h2>Leave us a Message</h2>
             <p> We'd love to hear from you. </p>

             <form id="contactform" action="{{route('front.contact.submit')}}" method="POST">
                {{csrf_field()}}
                 @include('includes.admin.form-both') 
               <div class="form-group">
                 <div class="row">
                    <div class="col-md-6"><label>First Name <sup>*</sup></label>
                         <input type="text" name="name" class="input-field form-control" placeholder="{{ $langg->lang47 }} *" required="">
                    </div>
                    <div class="col-md-6"><label>Phone <sup>*</sup></label>
                        <input type="text" name="phonr" class="input-field form-control" placeholder="{{ $langg->lang48 }} *">
                    </div>
                 </div>
               </div>

                <div class="form-group">
                 <div class="row">
                    <div class="col-md-12"><label>Email <sup>*</sup></label>
                        <input type="email" name="email" class="input-field  form-control" placeholder="{{ $langg->lang49 }} *" required=""></div>
                 </div>
               </div>
               
               <div class="form-group">
                 <div class="row">
                    <div class="col-md-12"><label>Message </label>
                        <textarea name="text" class="input-field textarea form-control" placeholder="{{ $langg->lang50 }} *" required=""></textarea></div>
                 </div>
               </div>
               
               <button class="btn-po">Submit</button>
                            
              </form>
          </div>
          <div class="col-md-3">
            <h2>Our Store</h2>
            <ul>
              <li>P8HH+PJR, Ghaziabad, Uttar Pradesh 201102</li>
              <li>Mobile No- 93454592318</li>
              <li><a href="#">Email- nishant.kp08@gmail.com</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  <script src="{{asset('new_asstes/js/map.js')}}"></script>

@endsection