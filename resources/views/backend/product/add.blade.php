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
            <div class="breadcrumb-title pe-3">Add Product</div>
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
                    <form id="add_products" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="mb-2">Product Name :</label>
                                <input type="hidden" id="url" name="url" value="{{ route('products.store') }}">
                                <input class="form-control" type="text" name="name" value="{{ old('name') }}"
                                    placeholder="" aria-label="default input example">
                                
                                    <div class="text-danger name"></div>
                               
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="mb-2">Retailer Price :</label>
                                <input class="form-control" type="text" id="retailer_price" name="retailer_price"
                                    value="{{ !empty(old('retailer_price')) ? old('retailer_price') : '' }}" placeholder="" aria-label="default input example"  onkeypress="return isNumberKey(event)">
                                
                                    <div class="text-danger retailer_price"></div>
                                
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="mb-2">Customer Price :</label>
                                <input class="form-control customer_discount" type="text" id="customer_price" name="customer_price"
                                    value="{{ old('customer_price') }}" placeholder="" aria-label="default input example" onkeypress="return isNumberKey(event)">
                              
                                    <div class="text-danger customer_price"></div>
                               
                            </div>
                            
                           <div class="col-lg-6 mb-3">
                                <label class="mb-2">Customer Discount  :</label>
                                <input class="form-control customer_discount" type="text" id="customer_discount" name="customer_discount"
                                    value="{{ !empty(old('customer_discount')) ? old('customer_discount') : '' }}" placeholder="" aria-label="default input example" onkeypress="return isNumberKey(event)">
                              
                                    <div class="text-danger customer_discount"></div>
                               
                            </div>  

                            <div class="col-lg-6 mb-3">
                                <label class="mb-2">Distributor Price :</label>
                                <input class="form-control distributor_discount" type="text" id="distributor_price" name="distributor_price"
                                    value="{{ !empty(old('distributor_price')) ? old('distributor_price') : '' }}" placeholder="" aria-label="default input example"  onkeypress="return isNumberKey(event)">
                                
                                    <div class="text-danger distributor_price"></div>
                                
                            </div>
                            

                            
                            
                            <div class="col-lg-6 mb-3">
                                <label class="mb-2">Distributor Discount  :</label>
                                <input class="form-control distributor_discount" type="text" id="distributor_discount" name="distributor_discount"
                                    value="{{ !empty(old('distributor_discount')) ? old('distributor_discount') : '' }}" placeholder="" aria-label="default input example" onkeypress="return isNumberKey(event)">
                              
                                    <div class="text-danger distributor_discount"></div>
                               
                            </div>
                            
                            <div class="col-lg-6 mb-3">
                                <label class="mb-2">Customer Price After discount:</label>
                                <input class="form-control" type="text" id="customer_price_after_discount" name="customer_price_after_discount"
                                   placeholder="" aria-label="default input example"  onkeypress="return isNumberKey(event)" disabled>
                                
                                
                            </div> 

                            

                            
                            
                           <div class="col-lg-6 mb-3">
                                <label class="mb-2">Distributor Price After discount:</label>
                                <input class="form-control" type="text" id="distributor_price_after_discount" name="distributor_price_after_discount"
                                   placeholder="" aria-label="default input example"  onkeypress="return isNumberKey(event)" disabled>
                                
                                
                            </div>
                            

                            
                            

                                <div class="col-lg-12 mb-3">
                                    <label class="mb-2">Product Description :</label>
                                    <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                                    
                                        <div class="text-danger description"></div>
                                    
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Quantity Per Box :</label>
                                    <input class="form-control" type="text" id="quantity_per_case" name="quantity_per_case"
                                        value="{{ old('quantity_per_case') }}" placeholder=""
                                        aria-label="default input example" onkeypress="return isNumberKey(event)">
                                    
                                        <div class="text-danger quantity_per_case"></div>
                                    
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Size :</label>
                                    <input class="form-control" type="text" id="size"  value="{{ old('size') }}" name="size"
                                        placeholder="" aria-label="default input example">
                                    
                                        <div class="text-danger size"></div>
                                   
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h5 class="mb-3">Is Returnable</h5>
                                        <label class="me-3">
                                            <input type="radio" value="yes"
                                                {{ old('is_returnable') == 'yes' ? 'checked' : '' }} id="is_returnable" name="is_returnable"
                                                class="radioCls deposit" id="yes" checked />
                                            Yes
                                            
                                                <div class="text-danger is_returnable"></div>
                                         
                                        </label>
                                        <label>
                                            <input type="radio" value="no"
                                                {{ old('is_returnable') == 'no' ? 'checked' : '' }} name="is_returnable"
                                                class="radioCls no_deposit" id="no" />
                                            No
                                        </label>
                                    </div>
                                
                                    <div class="col-lg-6 deposit_amount">
                                        <label class="mb-2">Deposit Amount per Jar :</label>
                                        <input class="form-control" type="text" id="deposit_amount" name="deposit_amount"
                                            value="{{ old('deposit_amount') }}" placeholder=""
                                            aria-label="default input example" onkeypress="return isNumberKey(event)">
                                        
                                            <!--<div class="text-danger deposit_amount"></div>-->
                                        
                                    </div>
                                </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Product Type :</label>
                                    <select class="form-select me-3" id="type" name="type">
                                        <option value="">-select-</option>
                                        <option value="jar" {{ old('type') == 'jar' ? 'selected' : '' }}>Jar</option>
                                        <option value="bottle" {{ old('type') == 'bottle' ? 'selected' : '' }}>Bottle
                                        </option>
                                    </select>
                                    
                                        <div class="text-danger type"></div>
                                    
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2"> Status :</label>
                                    <select class="form-select me-3" id="status" name="status">
                                        <option value="">-select-</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    
                                    <div class="text-danger status"></div>
                                   
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Product Image :</label>
                                    <div id="dropzone">
                                        {{-- <form class="dropzone needsclick" id="demo-upload" action="/upload"> --}}
                                        <div class="dz-message needsclick">
                                            <!--<i class="bi bi-download"></i>-->
                                            <input type="file" name="image" id="image"  class="form-control me-3">
                                            <!--<span class="d-block">Upload Image</span>-->
                                        </div>
                                        
                                            <div class="text-danger image"></div>
                                        
                                        {{-- </form> --}}
                                    </div>
                                </div>
                                
                                
                                  <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Order No :</label>
                                    <div id="dropzone">
                                        {{-- <form class="dropzone needsclick" id="demo-upload" action="/upload"> --}}
                                        <div class="dz-message needsclick">
                                            <!--<i class="bi bi-download"></i>-->
                                            <input type="text" name="orderby" id="image"  class="form-control me-3">
                                            <!--<span class="d-block">Upload Image</span>-->
                                        </div>
                                        
                                            <div class="text-danger orderby"></div>
                                        
                                        {{-- </form> --}}
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
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
              <button type="button" class="btn btn-primary mt-3">Submit</button>
            </div>

          </div> --}}
        </div>
    </div>
</div>
    </main>
 @endsection
       
       
  @section('scripts') 
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

    
    <script>
        // add product

$("#add_products").submit(function (e) {
    e.preventDefault();
    var url = $('#url').val();
    var form = $('#add_products')[0];
    var formData = new FormData(form);
    var redirect = $('meta[name="base_url"]').attr('content') + '/products';
    $.ajax({
        url: url,
        method: 'POST',
        contentType: false,
        processData: false,
        data: formData,
        success: function (data) {

            if(data.success==false){
                 $('.' + data.type).append('<div class="text-danger err">' + data.msg + '</div>');
            }else{
                    window.location.href="{{url('products')}}";
            }
        //   {{Session::flash('success','Product Added successfully')}};
        },
        error: function (xhr) {
                $('.distributor_discount_error').html("");
                    $('.customer_discount_error').html("");
            $('.err').html('');
            $.each(xhr.responseJSON.errors, function (key, value) {
                $('.' + key).append('<div class="text-danger err">' + value + '</div>');
            });
        }
    });
});


$(document).on("keyup",".distributor_discount",function(){
$('.distributor_discount_error').html("");
    var distributor_price=$('#distributor_price').val();
    var discount=$('#distributor_discount').val();

    var amt=(Number(distributor_price)* Number(discount/100));

    if(Number(discount) > Number(distributor_price)){
        $('#distributor_discount').after('<span class="text-danger distributor_discount_error">Must be less than distributor amount</span>')
        return false;
    }
    $('.distributor_discount_error').html("");
    
    $('#distributor_price_after_discount').val( Number(distributor_price) - Number(discount));
    
})


$(document).on("keyup",".customer_discount",function(){
 $('.customer_discount_error').html("");
    var customer_price=$('#customer_price').val();
    var discount=$('#customer_discount').val();
    
    if(Number(discount) > Number(customer_price)){
        $('#customer_discount').after('<span class="text-danger customer_discount_error">Must be less than customer amount</span>')
        return false;
    }
    $('.customer_discount_error').html("");
    var amt=(Number(customer_price)* Number(discount/100));

    $('#customer_price_after_discount').val( Number(customer_price) - Number(discount));
    
})
    </script>
 @endsection
