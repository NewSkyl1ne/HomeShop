@extends('layouts.admin')
@section('content')

          <div class="content-area">
            <div class="mr-breadcrumb">
              <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">Website Loader</h4>
                    <ul class="links">
                      <li>
                        <a href="{{ route('admin.dashboard') }}">Dashboard </a>
                      </li>
                      <li>
                        <a href="javascript:;">Generel Settings</a>
                      </li>
                      <li>
                        <a href="{{ route('admin-gs-load') }}">Website Loader</a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
            <div class="add-logo-area">
              <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
              <div class="row justify-content-center">
                <div class="col-lg-6">

                        @include('includes.admin.form-both')  

                  <form class="uplogo-form" id="geniusform" action="{{ route('admin-gs-update') }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}   
                    <div class="loader-switcher">
                      <h4 class="title" style="margin-left: 80px;">
                           Loader :
                        </h4>
                                <div class="action-list">
                                    <select class="process select droplinks {{ $gs->is_loader == 1 ? 'drop-success' : 'drop-danger' }}">
                                      <option data-val="1" value="{{route('admin-gs-isloader',1)}}" {{ $gs->is_loader == 1 ? 'selected' : '' }}>Active</option>
                                      <option data-val="0" value="{{route('admin-gs-isloader',0)}}" {{ $gs->is_loader == 0 ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                  </div>
                    </div>
                    <div class="currrent-logo">
                      <h4 class="title">
                        Current Loader :
                      </h4>
                      <img src="{{ $gs->loader ? asset('assets/images/'.$gs->loader):asset('assets/images/noimage.png')}}" alt="">
                    </div>
                    <div class="set-logo">
                      <h4 class="title">
                        Set New Loader :
                      </h4>
                      <input class="img-upload1" type="file" name="loader">
                    </div>

                    <div class="currrent-logo">
                      <h4 class="title">
                        Current Loader :
                      <p class="sub-heading">(In Admin Panel)</p>
                      </h4>

                      <img src="{{ $gs->admin_loader ? asset('assets/images/'.$gs->admin_loader):asset('assets/images/noimage.png')}}" alt="">
                    </div>
                    <div class="set-logo">
                      <h4 class="title">
                        Set New Loader :
                      <p class="sub-heading">(In Admin Panel)</p>
                      </h4>
                      <input class="img-upload1" type="file" name="admin_loader">
                    </div>


                    <div class="submit-area">
                      <button type="submit" class="submit-btn">Save</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

@endsection