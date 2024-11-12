@extends('layouts.admin')
@section('content')

                        <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">Customer Details <a class="add-btn" href="{{ route('admin-user-index') }}"><i class="fas fa-arrow-left"></i> Back</a></h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">Dashboard </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">Customers</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-user-index') }}">Customers List</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-user-show',$data->id) }}">Details</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                            <div class="add-product-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">

                                    <div class="table-responsive show-table">
                                        <table class="table">
                                            <tr>
                                                <th width="50%">Customer ID#</th>
                                                <td>{{$data->id}}</td>
                                            </tr>
                                            <tr>
                                                <th>Photo</th>
                                                <td>
                                            @if($data->is_provider == 1)
                                              <img src="{{ $data->photo ? asset($data->photo):asset('assets/images/noimage.png')}}" alt="No Image">
                                            @else
                                              <img src="{{ $data->photo ? asset('assets/images/users/'.$data->photo):asset('assets/images/noimage.png')}}" alt="No Image">                                            
                                            @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{$data->name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{$data->email}}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{$data->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{$data->address}}</td>
                                            </tr>
                                            @if($data->city != null)
                                            @php
                                            $shipping_data = DB::table('pickups')->where('id', '=', $data->city)->get()->first();
                                            @endphp
                                            <tr>
                                                <th>City</th>
                                                <td>{{$shipping_data->location}}<!-- {{$data->city}} --></td>
                                            </tr>
                                            @endif
                                            @if($data->fax != null)
                                            <tr>
                                                <th>Fax</th>
                                                <td>{{$data->fax}}</td>
                                            </tr>
                                            @endif
                                            @if($data->zip != null)
                                            <tr>
                                                <th>Zip Code</th>
                                                <td>{{$data->zip}}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th>Building No</th>
                                                <td>{{$data->building_no}}</td>
                                            </tr>
                                            <tr>
                                                <th>Zone</th>
                                                <td>{{$data->zone_no}}</td>
                                            </tr>
                                            <tr>
                                                <th>Street</th>
                                                <td>{{$data->street_no}}</td>
                                            </tr>
                                            <tr>
                                                <th>Joined</th>
                                                <td>{{$data->created_at->diffForHumans()}}</td>
                                            </tr>

                                            <tr class="text-center">
                                                <td colspan="2"><a class="btn sendEmail send" href="javascript:;" class="send" data-email="{{ $data->email }}" data-toggle="modal" data-target="#vendorform"><i class="fa fa-send"></i> Send Email </a></td>
                                            </tr>
                                            
                                        </table>
                                    </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

{{-- MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">Send Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact-form">
                                <form id="emailreply1">
                                    {{csrf_field()}}
                                    <ul>
                                        <li>
                                            <input type="email" class="input-field eml-val" id="eml1" name="to" placeholder="Email *" value="" required="">
                                        </li>
                                        <li>
                                            <input type="text" class="input-field" id="subj1" name="subject" placeholder="Subject *" required="">
                                        </li>
                                        <li>
                                            <textarea class="input-field textarea" name="message" id="msg1" placeholder="Your Message *" required=""></textarea>
                                        </li>
                                    </ul>
                                    <button class="submit-btn" id="emlsub1" type="submit">Send Message</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

{{-- MESSAGE MODAL ENDS --}}


@endsection