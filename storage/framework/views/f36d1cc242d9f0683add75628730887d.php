
<?php $__env->startSection('content'); ?>
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
            <div class="breadcrumb-title pe-3">Edit Product</div>
            <div class="ps-3">

            </div>

        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card p-3">
                    <div class="row">
                        
                    </div>

                    
                    <form id="edit_products" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Product Name :</label>
                                    <input type="hidden" id="url" name="url" value="<?php echo e(route('products.update', $product_edit->id)); ?>">
                                    <input class="form-control" type="text"id="name" name="name" value="<?php echo e($product_edit->name); ?>"
                                        placeholder="" aria-label="default input example">
                                    
                                        <div class="text-danger name"></div>
                                   
                                </div>
                                
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Retailer Price :</label>
                                    <input class="form-control" type="text" id="retailer_price" name="retailer_price"
                                        value="<?php echo e(!empty($product_edit->retailer_price) ? $product_edit->retailer_price : ''); ?>" placeholder="" aria-label="default input example" onkeypress="return isNumberKey(event)">
                                  
                                      <div class="text-danger retailer_price"></div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Customer Price :</label>
                                    <input class="form-control" type="text" id="customer_price" name="customer_price"
                                        value="<?php echo e($product_edit->customer_price); ?>" placeholder="" aria-label="default input example" onkeypress="return isNumberKey(event)">
                                  
                                      <div class="text-danger customer_price"></div>
                                </div>
                                
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Customer Discount  :</label>
                                    <input class="form-control customer_discount" type="text" id="customer_discount" name="customer_discount"
                                        value="<?php echo e($product_edit->customer_discount); ?>" placeholder="" aria-label="default input example" onkeypress="return isNumberKey(event)">
                                  
                                        <div class="text-danger customer_discount"></div>
                                   
                                </div> 
                                
                                
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Distributor Price :</label>
                                    <input class="form-control" type="text" id="distributor_price" name="distributor_price"
                                        value="<?php echo e(!empty($product_edit->distributor_price) ? $product_edit->distributor_price : ''); ?>" placeholder="" aria-label="default input example"  onkeypress="return isNumberKey(event)">
                                    
                                        <div class="text-danger distributor_price"></div>
                                    
                                </div>
                                
                                                            
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Distributor Discount  :</label>
                                    <input class="form-control distributor_discount" type="text" id="distributor_discount" name="distributor_discount"
                                        value="<?php echo e($product_edit->distributor_discount); ?>" placeholder="" aria-label="default input example" onkeypress="return isNumberKey(event)">
                                  
                                        <div class="text-danger distributor_discount"></div>
                                   
                                </div>

                             <div class="col-lg-6 mb-3">
                                <label class="mb-2">Customer Price After discount:</label>
                                <input class="form-control" type="text" id="customer_price_after_discount" name="customer_price_after_discount"
                                   placeholder="" value="<?php echo e($product_edit->c_price_discount); ?>"  aria-label="default input example"  onkeypress="return isNumberKey(event)" disabled>
                                
                                
                            </div>
                            

                            <div class="col-lg-6 mb-3">
                                <label class="mb-2">Distributor Price After discount:</label>
                                <input class="form-control" type="text" id="distributor_price_after_discount" name="distributor_price_after_discount"
                                   placeholder="" value="<?php echo e($product_edit->d_price_discount); ?>" aria-label="default input example"  onkeypress="return isNumberKey(event)" disabled>
                                
                                
                            </div>
                            

      
                            
                                <div class="col-lg-12 mb-3">
                                    <label class="mb-2">Product Description :</label>
                                    <textarea class="form-control" name="description" id="description" rows="3"><?php echo e($product_edit->description); ?></textarea>
                                   
                                   <div class="text-danger description"></div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Quantity Per Box :</label>
                                    <input class="form-control" type="number" id="quantity_per_case" name="quantity_per_case"
                                        value="<?php echo e($product_edit->quantity_per_case); ?>" placeholder=""
                                        aria-label="default input example">
                                   
                                    <div class="text-danger quantity_per_case"></div>
                                </div>
                                
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Size :</label>
                                    <input class="form-control" type="text" id="size" name="size" placeholder=""
                                        value="<?php echo e($product_edit->size); ?>" aria-label="default input example">
                                    
                                    <div class="text-danger size"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="mb-3">Is Returnable</h5>
                                            <label class="me-3">
                                                <input type="radio" value="yes"
                                                    <?php echo e($product_edit->is_returnable == 'yes' ? 'checked' : ''); ?> name="is_returnable"
                                                    class="radioCls deposit" id="yes">
                                                Yes
                                                <div class="text-danger is_returnable"></div>
                                            </label>
                                            <label>
                                                <input type="radio" value="no"
                                                    <?php echo e($product_edit->is_returnable == 'no' ? 'checked' : ''); ?> name="is_returnable"
                                                    class="radioCls no_deposit" id="no" />
                                                No
                                            </label>
                                        </div>
                                        
                                        <!--<div class="text-danger deposit_amount"></div>-->
                                        
                                        <div class="col-lg-6 deposit_amount"
                                            style="display:<?php echo e($product_edit->is_returnable == 'no' ? 'none' : 'block'); ?>">
                                            <label class="mb-2">Deposit Amount per Jar :</label>
                                            <input class="form-control" type="text"
                                            value="<?php echo e($product_edit->is_returnable=="yes" ? $product_edit->deposit_amount : ''); ?>" name="deposit_amount" placeholder=""
                                            aria-label="default input example" onkeypress="return isNumberKey(event)">
                                         </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Product Type :</label>
                                    <select class="form-select me-3" id="type" name="type">
                                        <option value="">-select-</option>
                                        <option value="jar" <?php echo e($product_edit->type == 'jar' ? 'selected' : ''); ?>>Jar</option>
                                        <option value="bottle" <?php echo e($product_edit->type == 'bottle' ? 'selected' : ''); ?>>Bottle</option>
                                    </select>
                                    
                                        <div class="text-danger type"></div>
                                   
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2"> Status :</label>
                                    <select class="form-select me-3" id="status" name="status">
                                        <option value="">-select-</option>
                                        <option value="active" <?php echo e($product_edit->status == 'active' ? 'selected' : ''); ?>>Active
                                        </option>
                                        <option value="inactive" <?php echo e($product_edit->status == 'inactive' ? 'selected' : ''); ?>>Inactive
                                        </option>
                                    </select>
                                    
                                        <div class="text-danger status"></div>
                                    
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Product Image :</label>
                                    <div id="dropzone">
                                        <div class="dz-message needsclick">
                                            <!--<i class="bi bi-download"></i>-->
                                            <input type="file" name="image" id="image" class="form-control">
                                            <img src="<?php echo e(asset($product_edit->image)); ?>" alt="" width="150px"
                                                height="150px">
                                            <!--<span class="d-block">Upload Image</span>-->
                                        </div>
                                        
                                            <div class="text-danger image"></div>
                                        
                                    </div>
                                </div>
                                
                                
                                 <div class="col-lg-6 mb-3">
                                    <label class="mb-2">Order No :</label>
                                    <div id="dropzone">
                                        <div class="dz-message needsclick">
                                            <!--<i class="bi bi-download"></i>-->
                                            <input type="text" name="orderby" id="orderby" class="form-control" value="<?php echo e($product_edit->orderby); ?>">
                                  
                                            <!--<span class="d-block">Upload Image</span>-->
                                        </div>
                                        
                                            <div class="text-danger orderby "></div>
                                        
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" style="width: auto">Update</button>
                            </div>
                
                        </div>
                <form>
                    

                    

                    

                    



                    
                    


                    

            </div>

            


        </div>
    </div>
</div>
    </main>
<?php $__env->stopSection(); ?>
    <!--end page main-->
        <!--end page main-->
 <?php $__env->startSection('scripts'); ?>
 
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
      
       
       
     
//update products
<script>
$("#edit_products").submit(function (e) {
    e.preventDefault();
    var url = $('#url').val();
    var form = $('#edit_products')[0];
    var formData = new FormData(form);
    $('.err').html('');
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
                    window.location.href="<?php echo e(url('products')); ?>";
            }
            
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

    var distributor_price=$('#distributor_price').val();
    var discount=$('#distributor_discount').val();
$('.distributor_discount_error').html("");
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lavenjalWeb-admin\resources\views/backend/product/edit.blade.php ENDPATH**/ ?>