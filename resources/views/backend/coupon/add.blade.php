@extends('backend.layouts.master')
@section('content')


  <!--start content-->
  <main class="page-content">


            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Add Coupon</div>
              </div>
            
            <!--end breadcrumb-->
       

              <div class="card p-3">
                <div class="row">
                   
                    <div class="col-lg-6 mb-3">
                    <label class="mb-2">Percentage :</label>
                    <input class="form-control" type="text" placeholder="" aria-label="default input example"></div>

                    <div class="col-lg-6 mb-3">
                    <label class="mb-2">Coupon Code :</label>
                    <input class="form-control" type="text" placeholder="" aria-label="default input example"></div>
                </div>
                <div class="col-lg-3">
                <button type="button" class="btn btn-primary">Submit</button>
                </div>
                </div>
              </div>
          </div>
  </main>
  <!--end page main-->
      
@endsection
