@extends('backend.layouts.master')
@section('content')
    <style>
        .activeTab {
            display: block;
        }

        .dropzone {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #eff4ef;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.375rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            min-height: 120px !important;
        }
    </style>

    <!--start content-->
    <main class="page-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Edit Banner</div>
            <div class="ps-3">

            </div>

        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card p-3">
                    <div class="row">
                        {{-- <div class="col-md-12">
                            <h4 class="mb-3">Product Type</h4>
                            <label class="me-3">
                            <input type="radio" value="" name="anything" class="radioCls" id="yes" checked />
                            Single
                            </label>
                            <label>
                            <input type="radio" value="" name="anything" class="radioCls" id="no" />
                            Variant
                            </label>
                        </div> --}}
                    </div>

                    {{-- <div class="single someData mt-4" id="first"> --}}
                    <form action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="mb-2">Banner Image :</label>
                                <input class="form-control" type="file" name="photo" value="{{ $banner->name }}"
                                    placeholder="" aria-label="default input example">
                                    <img src="{{asset($banner->photo)}}" height=100 width=auto alt="banner image">
                                @error('photo')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="mb-2">Status :</label>
                                 <select class="form-control" name="status" id="status">
                                     <option value="">Select Status</option>
                                     <option value="active" {{ $banner->status  == 'active' ? 'selected' : ''}}>Active</option>
                                    <option value="inactive"  {{$banner->status  == 'inactive' ? 'selected' : ''}}>In Active</option>
                                 </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                            </div>
                          
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                
                        </div>
                </div>
                <form>
                    {{-- <div class="variant someData mt-4" id="second"> --}}

                    {{-- <div class="row">
              <div class="col-lg-6 mb-3">
                <label class="mb-2">Product Name :</label>
                <input class="form-control" type="text" placeholder="" aria-label="default input example">
              </div> --}}

                    {{-- <div class="col-lg-6 mb-3">
                <label class="mb-2"> Customer Price :</label>
                <input class="form-control" type="text" placeholder="" aria-label="default input example">
              </div> --}}

                    {{-- <div class="col-lg-6 mb-3">
                <label class="mb-2">Retailer Price :</label>
                <input class="form-control" type="text" placeholder="" aria-label="default input example">
              </div> --}}



                    {{-- <div class="col-lg-12 mb-3">
                <label class="mb-2">Description :</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div> --}}
                    {{--
              <div class="bgred mb-4">
                <div class="bgred2">
                  <div class="col-lg-12">
                    <div id="req_input" class="datainputs ">
                      <div class="row mb-3">
                        <div class="col-md-3"> <label class="mb-2">Size :</label> <input class="form-control"
                            name="size" type="text"></div>
                        <div class="col-md-3"> <label class="mb-2">Price :</label> <input class="form-control"
                            name="price" type="text"></div>
                        <div class="col-md-3"> <label class="mb-2">Quantity per Box :</label> <input
                            class="form-control" name="qty" type="text"></div>
                      </div>
                    </div>
                  </div> --}}


                    {{-- <div class="col-lg-12 mb-0">
                    <a href="#" id="addmore" class="add_input d-inline-block btn btn-success">Add more</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <label class="mb-2">Product Image :</label>
                <div id="dropzone">
                  <form class="dropzone needsclick mb-3" id="demo-upload" action="/upload">
                    <div class="dz-message needsclick">
                      <i class="bi bi-download"></i>
                      <span class="d-block">Upload Image</span>
                    </div>
                  </form>
                </div> --}}

            </div>

            {{-- <div class="col-lg-12">
                <label class="mb-2">Status :</label>
                <select class="form-select">
                  <option>-select</option>
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>
            <button type="button" class="btn btn-primary mt-3">Submit</button>
          </div> --}}


        </div>
    </div>
</div>
    </main>
    <!--end page main-->
@endsection
