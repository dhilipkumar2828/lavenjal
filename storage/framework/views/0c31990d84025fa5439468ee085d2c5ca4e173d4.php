<!doctype html>
<html lang="en" class="semi-dark">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
  <meta name="base_url" content="<?php echo e(url('/')); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo e(asset('backend/assets/images/favicon-32x32.png')); ?>" type="image/png" />
  <!--plugins-->
  <link href="<?php echo e(asset('backend/assets/plugins/simplebar/css/simplebar.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/metismenu/css/metisMenu.min.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/select2/css/select2.min.css')); ?>"  rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/select2/css/select2-bootstrap4.css')); ?>"  rel="stylesheet" />
	<!-- <link href="assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" /> -->
  <!-- Bootstrap CSS -->
  <link href="<?php echo e(asset('backend/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/css/bootstrap-extended.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/css/style.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/css/icons.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('backend/assets/css/dropzone.css')); ?>" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

  <!-- loader-->
	<link href="<?php echo e(asset('backend/assets/css/pace.min.css')); ?>" rel="stylesheet" />

  <!--Theme Styles-->
  <link href="<?php echo e(asset('backend/assets/css/semi-dark.css')); ?>" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <title>Lavenjal : SLV Beverages </title>
  <style>
        .product_img {
            width: auto;
            background: #f5f5f5;
            height: 100px;
            width: 100px;
            overflow: hidden;
            justify-content: center;
            display: flex;
            align-content: center;
            align-items: center;
        }
        .product_img img{
            height: 90px;
            width: 90px;
        }
        .product_details h5 {
            font-weight: 700;
            font-size: 16px;
            border-bottom: 1px solid #3461ff21;
        }
        .product_details h6 {
            font-size: 14px;
        }
        
        
        
        .quantity {
          display: flex;
          align-items: center;
          padding: 0;
        }
        .quantity__minus, .quantity__plus {
            display: block;
            width: 25px;
            height: 25px;
            margin: 0;
            background: #3461ff;
            text-decoration: none;
            text-align: center;
            line-height: 24px;
        }
        .quantity__minus:hover,
        .quantity__plus:hover {
          background: #575b71;
          color: #fff;
        } 
        .quantity__minus {
            color: #fff;
          border-radius: 3px 0 0 3px;
        }
        .quantity__plus {
            color: #fff;
          border-radius: 0 3px 3px 0;
        }
        .quantity__input {
            width: 40px;
            height: 25px;
            margin: 0;
            padding: 0;
            text-align: center;
            border-top: 2px solid #3461ff;
            border-bottom: 2px solid #3461ff;
            border-left: 1px solid #3461ff;
            border-right: 2px solid #3461ff;
            background: #fff;
            color: #8184a1;
        }
        .quantity__minus:link,
        .quantity__plus:link {
          color: #8184a1;
        } 
        .quantity__minus:visited,
        .quantity__plus:visited {
          color: #fff;
        }
        .total-amount-section {
            background: #fff;
            /* height: 40px; */
            padding: 10px;
            display: flex;
            align-items: center;
            position: fixed;
            z-index: 999;
            bottom: 0;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            align-content: center;
            border-top: 2px solid #3461ff;
        }
        
  </style>
</head>
<body>
 

  <!--start content-->
    <!--<main class="page-content">-->
        <!--breadcrumb-->
    <!--    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">-->
    <!--        <div class="breadcrumb-title pe-3">Products List</div>-->
  
    <!--    </div>-->
    <!--    <div class="card" style="width:24em;">-->
    <!--        <div class="card-body p-4">-->
    <!--            <?php if($message = Session::get('success')): ?>-->
    <!--                <div class="alert alert-success"><?php echo e($message); ?></div>-->
    <!--            <?php endif; ?>-->
    <!--            <div class="table-responsive">-->
    <!--               <div class="container">-->
    <!--                   <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>-->
    <!--                 <div class="row">-->
    <!--                   <div class="col-6">-->
    <!--                      <div class="product_img">-->
    <!--                          <img src="<?php echo e(url($product->image)); ?>" alt="product_img" width=auto height=100/>-->
    <!--                     </div>-->
    <!--                   </div>-->
                       
    <!--                    <div class="col-6">-->
    <!--                      <span><?php echo e($product->description); ?></span>  -->
    <!--                   </div>-->
                       
    <!--                  </div>-->
    <!--                   <div class="row">-->
    <!--                    <div class="col-3">-->
    <!--                      <span><b><?php echo e($product->name); ?></b></span>  -->
    <!--                   </div>-->
    <!--                   </div>-->
    <!--                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>-->
    <!--               </div>-->

    <!--            </div>-->
    <!--        </div>-->
    <!--</main>-->
    <!--end page main-->
    
    
    <section>
        <div class="container" style="padding-bottom: 80px;">
            <div class="card mt-3 mb-3 p-2 ">
                <h4 class="mb-0" style="font-size: 20px;font-weight: 600;">Product List</h4>
            </div>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $cart=\App\Models\Carts::where('customer_id',$userid)->where('product_id',$product->id)->where('status','active')->first();
                
            ?>
            <div class="card mt-1 mb-1">
                <div class="row p-2">
                    <div class="col-md-4 col-4 mb-3">
                        <div class="product_img">
                            <img src="<?php echo e(url($product->image)); ?>" alt="product_img" width=auto height=100/>
                         </div>
                    </div>
                    <div class="col-md-8 col-8">
                        <div class="product_details">
                            <h5><?php echo e($product->name); ?></h5>
                            <h6>Rs <?php echo e($product->customer_price); ?>/-</h6>
                            <div class="quantity">
                            <a href="#" class="quantity__minus" data-product_id="<?php echo e($product->id); ?>"><span>-</span></a>
                            <input name="quantity" type="tel" class="quantity__input quantity__input_<?php echo e($product->id); ?> numbers" value="<?php echo e((!empty($cart) ? $cart->product_qty:1)); ?>" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
                            <input type="hidden" class="get_productQty_<?php echo e($product->id); ?>" value="<?php echo e((!empty($cart) ? $cart->product_qty:1)); ?>">
                            <a href="#" class="quantity__plus" data-product_id="<?php echo e($product->id); ?>"><span>+</span></a>
                        </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <a class="btn reset_product" style="width: 100%; width: 100%;color: #3461ff;border: 1px solid;" data-product_id="<?php echo e($product->id); ?>">Clear</a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-primary add_to_cart" style="width: 100%; border: 1px solid;" data-user_id="<?php echo e($userid); ?>" data-product_id="<?php echo e($product->id); ?>" >Add to Cart</a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="container-fluid total-amount-section">
            <h5>Total Amount : Rs <span class="totalamount"><?php echo e($totalamount->price); ?></span></h5>
        </div>
    </section>
    
    
    
<!-- Bootstrap bundle JS -->
 <script src="<?php echo e(asset('backend/assets/js/bootstrap.bundle.min.js')); ?>"></script>
  <!--plugins-->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src="<?php echo e(asset('backend/assets/js/jquery.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/simplebar/js/simplebar.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/metismenu/js/metisMenu.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/easyPieChart/jquery.easypiechart.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/peity/jquery.peity.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/pace.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')); ?>"></script>
	<script src="<?php echo e(asset('backend/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/apexcharts-bundle/js/apexcharts.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/datatable/js/jquery.dataTables.min.js')); ?>"></script>
	<script src="<?php echo e(asset('backend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')); ?>"></script>
	<script src="<?php echo e(asset('backend/assets/js/table-datatable.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/icons-feather-icons.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/select2/js/select2.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/form-select2.js')); ?>"></script>
  <!--app-->
  <script src="<?php echo e(asset('backend/assets/js/app.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/index2.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/dropzone.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/dropzone-script.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/main.js')); ?>"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker-standalone.css" integrity="sha512-wT6IDHpm/cyeR3ASxyJSkBHYt9oAvmL7iqbDNcAScLrFQ9yvmDYGPZm01skZ5+n23oKrJFoYgNrlSqLaoHQG9w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
  const minus = $('.quantity__minus');
  const plus = $('.quantity__plus');
  minus.click(function(e) {
    e.preventDefault();
    var product_id=$(this).data('product_id');
    const input = $('.quantity__input_'+product_id);
    var value = input.val();
    if (value > 1) {
      value--;
    }
    input.val(value);
  });
  
  plus.click(function(e) {
    e.preventDefault();
    var product_id=$(this).data('product_id');
    const input = $('.quantity__input_'+product_id);
    var value = input.val();
    value++;
    input.val(value);
  })
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).on("click",".add_to_cart",function(){
    var product_id=$(this).data('product_id');
    var user_id=$(this).data('user_id');
             $.ajax({
              url:"<?php echo e(url('QrCode_cartSave')); ?>",
              method:'POST',
              data:{
                  "_token": "<?php echo e(csrf_token()); ?>",
                  product_id:product_id,
                  user_id:user_id,
                  product_qty:$('.quantity__input_'+product_id).val()
                  },
              success:function(data){
                    toastr.success("Product added to their cart list");
                    $('.totalamount').html(data.totalamount['price']);
              }
          }); 
})

$(document).on("click",".reset_product",function(){
    var product_id=$(this).data('product_id');
    var product_qty=$('.get_productQty_'+product_id).val();
    $('.quantity__input_'+product_id).val(1);
})

$('.numbers').keypress(function (e) {
 if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
});
    </script>

</body>
</html><?php /**PATH /home/lavenjal/resources/views/backend/qrcode/view.blade.php ENDPATH**/ ?>