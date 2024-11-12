@extends('layouts.front')
@section('content')


<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
        <div class="col-lg-8">
          @include('includes.form-success')
          <div class="user-profile-details">
            <div class="account-info">
              <div class="header-area">
                <h4 class="title">
                Account Information
                </h4>
              </div>
              <div class="edit-info-area">
              </div>
              <div class="main-info">
                <h5 class="title">{{ @$user->name }}</h5>
                <ul class="list">
                  <li>
                    <p><span class="user-title">Email:</span> {{ $user->email }}</p>
                  </li>
                  @if(@$user->phone != null)
                  <li>
                    <p><span class="user-title">Phone:</span> {{ $user->phone }}</p>
                  </li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection