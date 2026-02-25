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
            <div class="breadcrumb-title pe-3">Edit City</div>
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
                    <form action="{{ url('city_update').'/'.$city->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="mb-2">City :</label>
                                <input class="form-control" type="text" name="city" value="{{ (!empty($city)? $city->city : '')}}"
                                    placeholder="" aria-label="default input example" >
                                @error('city')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="mb-2">Status :</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">Select status</option>
                                    <option value="active" {{ ($city->status == 'active'? 'selected' : '')}}>Active</option>
                                     <option value="inactive" {{ ($city->status == 'inactive'? 'selected' : '')}}>In Active</option>
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
