@extends('layouts.front')
@section('content')
<section class="abt-tp">
  <div class="container">
    <div class="col-md-12">
      <h2>Sign In & Register</h2>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{ url('/')}}">Home</a></li>
          <li>Sign In & Register</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="lgn">
  <div class="container">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="lgn-sec login-form  signin-form">
            <h3>Sign In</h3>
            <p>Welcome back! Sign in Your Account</p>
            @include('includes.admin.form-login')
            <form id="loginform" action="{{ route('user.login.submit') }}" method="POST">
              {{ csrf_field() }}

              <div class="form-group">
                <label>Username or Email Address</label>
                <input type="email" class="form-control" name="email" placeholder="Type Email Address" required="">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="Password form-control" name="password" placeholder="Type Password Address" required="">
                
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12 col-lg-6 col-6">
                    <ul class="filt">
                      <li class="filt__item">
                        <label class="label--checkbox">
                          <input type="checkbox" class="checkbox" name="remember"  id="rp" {{ old('remember') ? 'checked' : '' }}>
                          Remember Me</label>
                      </li>
                    </ul>
                  </div>
                  <div class="col-md-12 col-lg-6 col-6 text-right">
                    <a href="{{ route('user-forgot') }}">Forgotten Password?</a>
                  </div>
                </div>
              </div>
               <input id="authdata" type="hidden"  value="Authenticating...">
              <button class="evw-btn">Login</button>
              
            </form>
          </div>
        </div>
        
        
        <div class="col-md-6">
          <div class="lgn-sec login-form signup-form">
            <h3>Create New Account</h3>
            <p>Create Your Account</p>
            @include('includes.admin.form-login')
            <form id="registerform" action="{{route('user-register-submit')}}" method="POST">
                          {{ csrf_field() }}
              <div class="form-group">
                <label>Full Name</label>
                <input type="text" class="User Name form-control" name="name" placeholder="Full Name" required="">
              </div>
              <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="User Name form-control" name="email" placeholder="Email Address" required="">
              </div>
              <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" minlength="8" maxlength="8" class="User Name  form-control" name="phone" placeholder="Phone Number" required="">
              </div> 
              <div class="form-group">
                <label>Password</label>
                 <input type="password" class="Password form-control" name="password" placeholder="Password" required="">
              </div>
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="Password form-control" name="password_confirmation" placeholder="Confirm Password" required="">
              </div>
              <input id="processdata" type="hidden"  value="Processing...">
              <button  type="submit" class="evw-btn">Register</button>
            </form>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</section>

@endsection