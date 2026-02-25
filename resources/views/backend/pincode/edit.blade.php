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
            <div class="breadcrumb-title pe-3">Edit Pincode</div>
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
                    <form action="{{ url('pincode_update').'/'.$pincode->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                             <div class="col-lg-12 mb-3">
                                <label class="mb-2">City :</label>
                                <select class="form-control"name="city">
                                    <option value="">Select city</option>   
                                    @foreach($cities as $city)
                                      <option value="{{$city->id}}" {{$pincode->city==$city->id ? 'selected' : ''}}>{{$city->city}}</option>       
                                    @endforeach
                                </select>
                                @error('city')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-lg-12 mb-3">
                                <label class="mb-2">Pincode :</label>
                                <input class="form-control" type="text" name="pincode" value="{{ (!empty($pincode)? $pincode->pincode : '')}}"
                                    placeholder="" aria-label="default input example" onkeypress="return isNumberKey(event)">
                                @error('pincode')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="mb-2">Status :</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">Select status</option>
                                    <option value="active" {{ ($pincode->status == 'active'? 'selected' : '')}}>Active</option>
                                     <option value="inactive" {{ ($pincode->status == 'inactive'? 'selected' : '')}}>In Active</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                </div>
                <form>
                   
                   

            </div>

        
        </div>
    </div>
</div>
    </main>
    <!--end page main-->
    <script>
               function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
    </script>
@endsection
