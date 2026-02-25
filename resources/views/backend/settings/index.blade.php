@extends('backend.layouts.master')
@section('content')
<style>
    .someData{
			max-width:100%;
			display:none;
		}
		
		.activeTab{
			display:block;
		}
    .dropzone {
      display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color:#eff4ef;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.375rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    min-height: 120px !important;
    }
  </style>

  <!--start content-->
  <main class="page-content">


<!--breadcrumb-->
<!-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Product Settings</div>
              <div class="ps-3">
             
              </div>
           
          </div> -->
          <!--end breadcrumb-->
       

              <div class="row">
                  <div class="col-xl-12 mx-auto">
          
                      <div class="card p-3">



                          <div class="row">
                          <div class="col-md-12">
                            <h4 class="mb-3">Product Settings</h4>
                              <label class="me-3">
                                  <input type="radio" value="" name="anything" class="radioCls" id="yes" checked />
                                  Customer
                              </label>
                              <label>
                                  <input type="radio" value="" name="anything" class="radioCls" id="no" />
                                  Retailer
                              </label>
                          </div>
                          </div>


<div class="single someData mt-4" id="first">
              
                              <div class="row">
                                  <div class="col-lg-6 mb-3">
                                  <label class="mb-2">Product Customer Deposit Amount  :</label>
                                  <input class="form-control" type="text" placeholder="" aria-label="default input example" value="₹150"></div>
                               
                                  </div>
                              <button type="button" class="btn btn-primary">Submit</button>
                          </div>
                  
                  <div class="variant someData mt-4" id="second">
                    
                              <div class="row">
                                  <div class="col-lg-6 mb-3">
                                  <label class="mb-2">Product Retailer Deposit Amount :</label>
                                  <input class="form-control" type="text" placeholder="" aria-label="default input example" vaue="₹100">
                                </div>
                              
                              </div>
                              <button type="button" class="btn btn-primary mt-3">Submit</button>
                          </div>


                      </div>



                      

                  </div>
              </div>
          </main>
      <!--end page main-->
      
@endsection