
<?php $__env->startSection('content'); ?>
<!--start content-->
<!--start content-->
<main class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3 d-flex" style="white-space: nowrap">Order Invoice : #<?php echo e($order->order_id); ?></div>
        <div class="breadcrumb-title pe-3"> <span class="badge badge status-ongoing"><?php echo e($order->status); ?></span></div>

<form action="<?php echo e(url('order_status')); ?>" method="post" class="d-flex mb-0" style="width: 100%; text-align: right">
    <?php echo csrf_field(); ?>
        <div class="ms-auto">
            <div class="btn-group align-items-center">
                <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                <label class="pe-2">
    <h6><strong>Status: </strong></h6>
  </label>
  <select class="form-select me-3" name="status" placeholder="Select status">
    <option value="Order placed" <?php echo e($order->status=="Order placed" ? 'selected' : ''); ?>>Order Placed</option>
    <option value="On the way" <?php echo e($order->status=="On the way" ? 'selected' : ''); ?>>On the way</option>
    <option value="Delivery" <?php echo e($order->status=="Delivery" ? 'selected' : ''); ?>>Delivery</option>
    <option value="Cancelled" <?php echo e($order->status=="Cancelled" ? 'selected' : ''); ?>>Cancelled</option>
  </select>
<?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
  <button type="submit" class="btn btn-primary" style="border-radius: 5px">Submit</button>
</div>
</div>
</form>
</div>
<!--end breadcrumb-->

<ul class="nav nav-pills mb-3 bg-white p-1" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button"
      role="tab" aria-controls="pills-home" aria-selected="true">Order Details</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button"
      role="tab" aria-controls="pills-profile" aria-selected="false">Order Info</button>
  </li>
  <!--<li class="nav-item" role="presentation">-->
  <!--  <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button"-->
  <!--    role="tab" aria-controls="pills-contact" aria-selected="false">Ratings</button>-->
  <!--</li>-->
</ul>
<!--tab-1-->
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
    <div class="card">
      <div class="card-header py-3">
        <div class="row g-3 align-items-center justify-content-between">
          <div class="col-12 col-lg-3 col-md-6">
            <h5 class="mb-1">Order ID : #<?php echo e($order->order_id); ?></h5>
            <p class="mb-0"><?php echo e($order->created_at); ?></p>
          </div>



          <div class="card card-stepper shadow-none col-lg-8 text-black d-none">
            <div class="card-body">
              <ul id="progressbar-2" class="d-flex justify-content-between mx-0 mt-0 px-0 pt-0">
                <li class="step0 active text-center" id="step1"></li>
                <li class="step0 active text-center" id="step2"></li>
                <li class="step0 active text-center" id="step3"></li>
                <li class="step0 text-muted text-end" id="step4"></li>
              </ul>
              <div class="d-flex justify-content-between">
                <div class="d-lg-flex align-items-center">
                  <i class="fas fa-clipboard-list fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                  <div>
                    <p class="fw-bold mb-1">Order Processed</p>
                    <p class="fw-bold mb-0">17/02/2022</p>
                  </div>
                </div>
                <div class="d-lg-flex align-items-center">
                  <i class="fas fa-box-open fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                  <div>
                    <p class="fw-bold mb-1">Order</p>
                    <p class="fw-bold mb-0">Shipped</p>
                  </div>
                </div>
                <div class="d-lg-flex align-items-center">
                  <i class="fas fa-shipping-fast fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                  <div>
                    <p class="fw-bold mb-1">Order</p>
                    <p class="fw-bold mb-0">En Route</p>
                  </div>
                </div>
                <div class="d-lg-flex align-items-center">
                  <i class="fas fa-home fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                  <div>
                    <p class="fw-bold mb-1">Order</p>
                    <p class="fw-bold mb-0">Arrived</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <hr />
        <div class="card-body p-0">

          <div class="row row-cols-1 row-cols-xl-3 row-cols-xxl-3">

            <div class="col commoncardheader">
              <div class="card border shadow-none">
                <div class="card-header">
                  <h6 class="mb"><i class="bi bi-person text-primary"></i> Customer</h6>
                </div>
                <div class="order-invoice card-body">
                  <div class="d-flex flex-column align-items-center gap-3">

                    <div class="info">

                      <p class="mb-2"><strong>Name</strong> : <?php echo e($customer->name); ?>

                      </p>
                      <p class="mb-2"><strong>Phone Number</strong> : <?php echo e($customer->phone); ?></p>
                      <p class="mb-2"><strong>Email ID</strong> : <?php echo e($customer->email); ?></p>
                      <p class="mb-2"><strong>Address</strong> : <?php echo e((!empty($address)?$address->address .' '.$address->city.' '.$address->state:"")); ?></p>
                        <p class="mb-2"><strong>Lat</strong> : <?php echo e((!empty($address)?$address->lat:'')); ?></p>      
                        
                        <p class="mb-2"><strong>Lang</strong> : <?php echo e((!empty($address)?$address->lang:'')); ?></p>
                        
                        
                        <iframe 
                        class="w-100"
                          height="170" 
                          frameborder="0" 
                          scrolling="no" 
                          marginheight="0" 
                          marginwidth="0" 
                          src="https://maps.google.com/maps?q=<?php echo e((!empty($address)?$address->lat:'')); ?>,<?php echo e((!empty($address)?$address->lang:'')); ?>&hl=en&z=14&amp;output=embed"
                         >
                         </iframe>




                      <!--   <a href="https://maps.google.com/maps?q='<?php echo e((!empty($address)?$address->lat:'')); ?>','<?php echo e((!empty($address)?$address->lang:'')); ?>'&hl=es;z=14&amp;output=embed" -->
                      <!--          style="color:#0000FF;text-align:left" -->
                      <!--          target="_blank"-->
                      <!--         >-->

                      <!--<p class="mb-0 text-danger"><strong></strong>View map</p>-->
                      <!--</a>-->
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col commoncardheader">
              <div class="card border shadow-none">
                <div class="card-header">
                  <h6 class="mb"><i class="bi bi-truck text-success"></i> <?php echo e($order->user_type=="customer" ? "Delivery Partner":"Distributor"); ?></h6>
                </div>
                <div class="order-invoice card-body">
                  <div class="d-flex flex-column gap-3">

                    <div class="info agent">

                      <p class="mb-2"><strong>Name</strong> : <?php echo e(!empty($delivery_boy) ? $delivery_boy->name : ''); ?> 
                      </p>
                 
                      <p class="mb-2"><strong>Phone Number</strong> : <?php echo e(!empty($delivery_boy) ? $delivery_boy->phone:''); ?></p>
                      <p class="mb-2"><strong>Email ID</strong> : <?php echo e(!empty($delivery_boy) ? $delivery_boy->email:''); ?></p>
            
            
                            <?php if(!empty($A_del)): ?>
                            
                            
                                  <iframe 
                               class="w-100"
                                  height="170" 
                                  frameborder="0" 
                                  scrolling="no" 
                                  marginheight="0" 
                                  marginwidth="0" 
                                  src="https://maps.google.com/maps?q=<?php echo e((!empty($A_del)?$A_del->lat:'')); ?>,<?php echo e((!empty($A_del)?$A_del->lang:'')); ?>&hl=en&z=14&amp;output=embed"
                                 >
                                 </iframe>
                         
                         
                         <!--<a href="https://maps.google.com/maps?q='<?php echo e((!empty($A_del)?$A_del->lat:'')); ?>','<?php echo e((!empty($A_del)?$A_del->lang:'')); ?>'&hl=es;z=14&amp;output=embed" -->
                         <!--       style="color:#0000FF;text-align:left" -->
                         <!--       target="_blank"-->
                         <!--      >-->

                         <!-- <p class="mb-0 text-danger"><strong></strong>View map</p>-->
                         <!-- </a>-->
                          <?php endif; ?>
                      <!--<p class="mb-2"><strong>State</strong> : Tamilnadu</p>-->
                  
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            
            <!--<div class="col commoncardheader">-->
            <!--  <div class="card border shadow-none">-->
            <!--    <div class="card-header">-->
            <!--      <h6 class="mb"><i class="bi bi-truck text-success"></i> <?php echo e($order->user_type=="customer" ? "Near by Delivery Partners":"Distributor"); ?></h6>-->
            <!--    </div>-->
            <!--    <div class="order-invoice card-body">-->
            <!--      <div class="d-flex flex-column gap-3">-->

            <!--        <div class="info agent">-->

            <!--          <p class="mb-2"><strong>Name</strong> : <?php echo e(!empty($delivery_boy) ? $delivery_boy->name : ''); ?> -->
            <!--          </p>-->
                 
            <!--          <p class="mb-0 text-danger"><strong></strong>View map</p>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--</div>-->
            
            
            
            <div class="col commoncardheader">
              <div class="card shadow-none">
                <div class="order-invoice card-body p-0">
                  <div class="row">
                    <div class="card col-lg-6 text-center shadow-none">
                      <div class="box-bg p-3 border h-100">
                        <img src="<?php echo e(asset('backend/assets/images/icons/water-can.png')); ?>" class="mb-3" alt="logo icon">
                        <h6 class="mb-2 text-primary">Return Jar</h6>
                        <h6 class="mb-0"><?php echo e($order->returnablejar_qty); ?></h6>
                      </div>
                    </div>
                    <div class="card col-lg-6 text-center shadow-none">
                      <div class="box-bg p-3 border h-100">
                        <i class="bi bi-calendar-check"></i>
                        <h6 class="mb-2 text-success mt-2">Delivery Date</h6>
                        <h6 class="mb-0"><?php echo e($order->delivery_date); ?></h6>
                        <span><?php echo e($order->delivery_time); ?></span>
                      </div>
                    </div>
                    <div class="card col-lg-6 text-center shadow-none">
                      <div class="box-bg p-3 border h-100">
                        <i class="bi bi-wallet2 mb-2"></i>
                        <h6 class="mb-2 text-pink">Refundable Amount</h6>
                        <h6 class="mb-0">₹<?php echo e($order->deposit_amount); ?></h6>
                      </div>
                    </div>
                    <!--<div class="card col-lg-6 text-center shadow-none">-->
                    <!--  <div class="box-bg p-3 border h-100">-->
                    <!--    <i class="lni lni-rupee mb-2"></i>-->
                    <!--    <h6 class="mb-2 text-orange">Payment Reference</h6>-->
                    <!--    <h6 class="mb-0">#123</h6>-->
                    <!--  </div>-->
                    <!--</div>-->
                  </div>
                </div>
              </div>

            </div>
            <!--end row-->
          </div>
        </div>

        <div class="card">
          <div class="card-body">

            <div class="row">
              <div class="col-12 col-lg-8">
                <div class="card border shadow-none radius-10">
                  <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">S.no</th>
                          <th scope="col">Product</th>
                          <th scope="col">Quantity</th>
                          <th scope="col">Sub Total</th>
                        </tr>
                      </thead>
                      <tbody>

                     <?php $__currentLoopData = $order_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <th scope="row"><?php echo e($key+1); ?></th>
                          <td><a class="d-flex align-items-center gap-2 imgtable" href="#">
                              <div class="product-box">
                                <img src="<?php echo e(asset($order_detail->product_image)); ?>" alt="">
                              </div>
                              <div>
                                <h6 class="mb-1 product-title fw-bold"><?php echo e($order_detail->product_name); ?></h6>
  
                              </div>
                            </a>
                          </td>
                          <td><?php echo e($order_detail->quantity); ?></td>
                          <td> ₹<?php echo e($order_detail->total_amount); ?></td>
                        </tr>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="card border shadow-none bg-light radius-10">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                      <div>
                        <h5 class="mb-0">Order Summary</h5>
                      </div>
                      <!-- <div class="ms-auto">
                                   <button type="button" class="btn alert-success radius-30 px-4">Confirmed</button>
                                </div> -->
                    </div>
                    <div class="d-flex align-items-center mb-3">
                      <div>
                        <p class="mb-0">Subtotal</p>
                      </div>
                      <div class="ms-auto">
                        <h5 class="ms-auto">₹<?php echo e(number_format($subtotal,2,'.','')); ?></h5>
                      </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                      <div>
                        <p class="mb-0">Refundable</p>
                      </div>
                        <h5 class="ms-auto">₹<?php echo e(number_format($order->deposit_amount,2,'.','')); ?></h5>
                      </div>
                    
                    <div class="d-flex align-items-center mb-3">
                      <div>
                        <p class="mb-0">Delivery Charges</p>
                      </div>
                      <div class="ms-auto">
                        <h5 class="mb-0 text-danger">₹<?php echo e(number_format($order->deliver_charge,2,'.','')); ?></h5>
                      </div>
                      
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                      <div>
                        <p class="mb-0"> Discount Amount</p>
                      </div>
                      <div class="ms-auto">
                        <h5 class="mb-0 text-danger"> - ₹<?php echo e(number_format($order->discount_amount,2,'.','')); ?></h5>
                      </div>
                      
                    </div>
                    
                    <hr>
                    <div class="d-flex align-items-center mb-3">
                      <div>
                        <p class="mb-0">Order Total</p>
                      </div>
                      <div class="ms-auto">
                        <h5 class="mb-0 text-danger">₹<?php echo e(number_format($order->total,2,'.','')); ?></h5>
                      </div>
                     </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <!--end row-->
      </div>
    </div>
  </div>
</div>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
      <div class="wrapper">
    <div class="bg-white p-3 border-5">
      <table class="table table-bordered table-left bg-white" style="width:100%;">
        <thead>
        </thead>
        <tbody>

          <tr>
            <th>
              <h6><strong class="">Delivery Partner Name</strong></h6>
            </th>
            <td><?php echo e(!empty($delivery_boy) ? $delivery_boy->name:''); ?>

              <!-- <Span>-</Span> -->
            </td>
          </tr>
          <tr>
            <th>
              <h6><strong>Delivery Date</strong></h6>
            </th>
            <td><?php echo e($order->delivery_date); ?></td>
          </tr>
          <tr>
            <th>
              <h6><strong class="">Time</strong></h6>
            </th>
            <td><?php echo e($order->delivery_time); ?></td>
          </tr>
          <!--<tr>-->
          <!--  <th>-->
          <!--    <h6><strong>Remark</strong></h6>-->
          <!--  </th>-->
          <!--  <td>Customer Delay</td>-->
          <!--</tr>-->

        </tbody>
      </table>
    </div>
</div>
  </div>
</div>
<!--<div class="tab-content" id="pills-tabContent">-->
<!--  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">-->
<!--    <div class="bg-white p-3  border-5">-->
<!--      <table class="table table-bordered table-left bg-white" style="width:100%">-->
<!--        <thead>-->
<!--        </thead>-->
<!--        <tbody>-->
<!--          <tr>-->
<!--            <th>-->
<!--              <h6><strong>Ratings</strong></h6>-->
<!--            </th>-->
<!--            <td>-->
<!--              <i class="bi bi-star-fill color-yellow"></i>-->
<!--              <i class="bi bi-star-fill color-yellow"></i>-->
<!--              <i class="bi bi-star-fill color-yellow"></i>-->
<!--              <i class="bi bi-star-fill "></i>-->
<!--              <i class="bi bi-star-fill "></i>-->
<!--            </td>-->
<!--          </tr>-->
<!--          <tr>-->
<!--            <th>-->
<!--              <h6><strong>Comments</strong></h6>-->
<!--            </th>-->
<!--            <td>-->
<!--              Timing too Delay to recieve</td>-->
<!--          </tr>-->
<!--        </tbody>-->
<!--      </table>-->
<!--    </div>-->

<!--  </div>-->
<!--</div>-->


</div>



<!--tab-1 End-->
</main>
<!--end page main-->

<?php $__env->stopSection(); ?>

<!-- Sales Rep -->
<div class="col">

  <!-- Modal -->
  <div class="modal fade" id="exampleLargeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Sales Representative</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="col commoncardheader">
            <div class="card shadow-none">
              <!-- <div class="card-header">
                                <h6 class="mb">Customer</h6>
                                </div> -->
              <div class="order-invoice card-body">
                <div class="d-flex align-items-center gap-3">
                  <!-- <div class="icon-box bg-light-primary border-0">
                                <i class="bi bi-person text-primary"></i>
                              </div> -->

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Submit</button> -->
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjal/resources/views/backend/orders/customer-order.blade.php ENDPATH**/ ?>