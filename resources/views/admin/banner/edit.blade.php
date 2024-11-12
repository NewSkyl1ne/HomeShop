@extends('layouts.load')

@section('content')
            <div class="content-area">

              <div class="add-product-content">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error') 
                      <form id="geniusformdata" action="{{route('admin-sb-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">Current Featured Image *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <div class="img-upload full-width-img">
                                <div id="image-preview" class="img-preview" style="background: url({{ $data->photo ? asset('assets/images/banners/'.$data->photo):asset('assets/images/noimage.png') }});">
                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>Upload Image</label>
                                    <input type="file" name="photo" class="img-upload" id="image-upload">
                                  </div>
                                  <p class="text">Prefered Size: (600x600) or Square Sized Image</p>
                            </div>

                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">Platform Type *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="platform_type" required="">
                                  <option value="">Select Platform Type {{$data->platform_type}}</option>
                                  <option value="1" {{ $data->platform_type == 1 ? 'selected' : '' }}>Website</option>
                                  <option value="2" {{ $data->platform_type == 2 ? 'selected' : '' }}>App</option>
                              </select>
                          </div>
                        </div>
                        <div class="row" style="">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">App Slug *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="app_slug" id="app_slug">
                                  <option value="">Select Platform Type</option>
                                  <option value="Best" {{ $data->app_slug == 'Best' ? 'selected' : '' }} >Best</option>
                                  <option value="Top" {{ $data->app_slug == 'Top' ? 'selected' : '' }} >Top</option>
                                  <option value="Latest" {{ $data->app_slug == 'Latest' ? 'selected' : '' }} >Latest</option>
                                  <option value="Discount" {{ $data->app_slug == 'Discount' ? 'selected' : '' }} >Discount</option>
                              </select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">Type *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="type" required="">
                                  <option value="">Select Type</option>
                                  <option value="Small" {{ $data->type == 'Small' ? 'selected' : '' }}>Small</option>
                                  <option value="Large" {{ $data->type == 'Large' ? 'selected' : '' }}>Large</option>
                              </select>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">Page *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="page" placeholder="Page" value="{{ $data->page }}">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">Link *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="link" placeholder="Link" value="{{ $data->link }}">
                          </div>
                        </div>



                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">Save</button>
                          </div>
                        </div>
                      </form>


                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


@endsection