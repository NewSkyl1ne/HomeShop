@extends('layouts.front')
@section('content')      

<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
<div class="col-lg-8">
                    <div class="user-profile-details">
                        <div class="account-info">
                            <div class="header-area">
                                <h4 class="title">
                                    Edit Profile
                                </h4>
                            </div>
                            <div class="edit-info-area">
                                
                                <div class="body">
                                        <div class="edit-info-area-form">
                                                <div class="gocover" style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <form id="userform" action="{{route('user-profile-update')}}" method="POST" enctype="multipart/form-data">
                                                    
                                                    {{ csrf_field() }}

                                                    @include('includes.admin.form-both') 
                                                    <div class="upload-img">
                                                        @if($user->is_provider == 1)
                                                        <div class="img"><img src="{{ $user->photo ? asset($user->photo):asset('assets/images/noimage.png') }}" style="border-radius: 50%;width: 90px;height: 90px;margin-top: 4px;margin-left: 4px;"></div>
                                                        @else
                                                        <div class="img"><img src="{{ $user->photo ? asset('assets/images/users/'.$user->photo):asset('assets/images/noimage.png') }}" style="border-radius: 50%;width: 90px;height: 90px;margin-top: 4px;margin-left: 4px;"></div>
                                                        @endif
                                                        <div class="file-upload-area">
                                                            <div class="upload-file">
                                                                    <input type="file" name="photo" class="upload" style="background: #d12438;">
                                                                    <span>Upload</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                                <input name="name" type="text" class="input-field" placeholder="User Name *" required="" value="{{ $user->name }}">
                                                        </div>
                                                        <div class="col-lg-6">
                                                                <input name="email" type="email" class="input-field" placeholder="Email Address *" required="" value="{{ $user->email }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                                <input name="phone" type="tel" minlength="8" maxlength="8"  class="input-field" placeholder="Phone Number *" required="" value="{{ $user->phone }}">
                                                        </div>
                                                        <input name="fax" type="hidden" class="input-field" placeholder="Fax *" value="{{ $user->fax }}">
                                                        <!-- <div class="col-lg-6">
                                                                <input name="fax" type="text" class="input-field" placeholder="Fax *" value="{{ $user->fax }}">
                                                        </div> -->
                                                        <?php /*
                                                        <div class="col-lg-6">
                                                            <select class="input-field"  name="city" required >
                                                                <option value="">Choose City(*)</option>
                                                                @php 
                                                                $list               =   DB::table('pickups')->get();
                                                                @endphp
                                                                @if( count($list) > 0 )
                                                                @foreach( $list as $value)
                                                                <option value="{{$value->id}}" @php if( $user->city == $value->id){ echo "selected"; } @endphp  >{{$value->location}}</option>
                                                                @endforeach
                                                                @endif
                                                              </select>
                                                               <!--  <input name="city" type="text" class="input-field" placeholder="City *" value="{{ $user->city }}"> -->
                                                        </div> */?>
                                                    </div>
                                                <?php /*
                                                    <div class="row">
                                                        <!-- <div class="col-lg-6">
                                                            <select class="input-field"  name="city" required >
                                                                <option value="">Choose City(*)</option>
                                                                @php 
                                                                $list               =   DB::table('pickups')->get();
                                                                @endphp
                                                                @if( count($list) > 0 )
                                                                @foreach( $list as $value)
                                                                <option value="{{$value->id}}" @php if( $user->city == $value->id){ echo "selected"; } @endphp  >{{$value->location}}</option>
                                                                @endforeach
                                                                @endif
                                                              </select>
                                                        </div> -->
                                                        <!-- <div class="col-lg-6">
                                                                <input name="zip" type="text" class="input-field" placeholder="Zip *" value="{{ $user->zip }}">
                                                        </div>-->
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <input name="building_no" type="text" class="input-field" placeholder="Building No *" required value="{{ $user->building_no }}">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input name="zone_no" type="text" class="input-field" placeholder="Zone *" required value="{{ $user->zone_no }}">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input name="street_no" type="text" class="input-field" placeholder="Street *"  required value="{{ $user->street_no }}">
                                                        </div>

                                                    </div>
                                                    <input type="hidden" class="input-field" name="address" required="" >
                                                    <!--
                                                    <div class="row" >
                                                        <div class="col-lg-12">
                                                            <textarea class="input-field" name="address" required="" placeholder="Address *">{{ $user->address }}</textarea>
                                                        </div>

                                                    </div>-->
*/?>
                                                        <div class="form-links">
                                                            <button class="submit-btn" type="submit" style="background: #d12438;" >Save</button>
                                                        </div>
                                                </form>
                                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
      </div>
    </div>
  </section>

@endsection