
<?php $__env->startSection('content'); ?>
  <!--start content-->
  <main class="page-content cuustomerinfo">
                <div class="row">
					<div class="col-xl-3">
                        <div class="card">
                            <div class="card-header">
  <h6 class="mb">Profile</h6>
                                </div>
                            <div class="card-body">
              <div class="product-box mb-3 text-center">
                                                <img src="<?php echo e(asset('backend/assets/images/avatars/lavenjal-user.png')); ?>" alt="User image" style="width:5em;">
                                            </div>
<div class="text-center">
    <h5><strong><?php echo e($user->name); ?></strong></h5>
     <div class="customer-detail">
                   <h6 class="mb-0"><i class="lni lni-phone me-2"></i><?php echo e($user->phone); ?><h6>
        <h6 class="mb-0"><i class="fadeIn animated bx bx-message-alt-detail me-2 mb-3"></i><?php echo e($user->email); ?><h6>
   </div>
  <hr />

</div>
    <h4>Address</h4>
<?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="address-customer mb-4">
  <span class="type"><b class="badge bg-success me-2"><?php echo e($address->address_type=="home"?"Home":"Apartment"); ?></b><b class="Default badge bg-dark"><?php echo e($address->is_default=="true"?"Default":""); ?></b></span>
    <h5><?php echo e($user->name); ?></h5>
  <p>No <?php echo e($address->door_no); ?></p>
  <p> <?php echo e($address->address); ?></p>
  <p> <?php echo e($address->city); ?></p>
  <p> <?php echo e($address->state); ?> - <?php echo e($address->zip_code); ?></p>
  <!--<p><a class="mapview" href="#">View Map</a></p>-->

</div>
    <hr />
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


</div>
</div>
</div>
<div class="col-xl-9">
  <div class="card">
    <div class="card-header">
      <h6 class="mb">Order</h6>
    </div>
    <div class="card-body">

      <div class="table-responsive">
        <!-- <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Customer Name</th>
              <th>Water Suppliers</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="mc-table-profile">
                  <p><a href="<?php echo e(url('/orders-view')); ?>">#LV123456</a></p>
                </div>
              </td>
              <td>Pandian</td>
              <td><a href="<?php echo e(url('/orders-view')); ?>" class="text-danger">Vetri Water Suppliers</a> </td>
              <td><span class="badge bg-light-success text-success">Active</span></td>
              <td>
                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                  <a href="<?php echo e(url('/orders-view')); ?>" class="text-primary" data-bs-toggle="tooltip"
                    data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                  <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal"
                      data-bs-target="#exampleLargeModal"></i></a>
                </div>
              </td>
            </tr>

          </tbody>

        </table> -->
        <?php
            $deposit_amount=0;
        ?>
        
        <table id="example" class="table table-bordered" style="width:100%">
                     <thead>
                      <tr>
                          <th>Order ID</th>
                          <th>Customer Name</th>
                          <th>Delivery boy</th>
                          <th>Delivery Date</th>
                          <th>Status</th>
                          <!--<th>Action</th>-->
                        </tr>                               
                     </thead>                           				
                     <tbody>
                     <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                          $deposit_amount+=$order->deposit_amount;

                          $delivery_boy=\App\Models\User::where('id',$order->assigned_deliveryboy)->first();
                          
                        ?>
                          <tr>
                            <td><div><a href="<?php echo e(url('customer-orders').'/'.$order->order_id); ?>"><h6 class="mb-0">#<?php echo e($order->order_id); ?></h6></a>
                                                                            
                            <p class="opacity-50 mb-0">Order Date : <?php echo e($order->order_created); ?></p></div></td>
                            <td><?php echo e($order->name); ?>

                            <p><strong>#123</strong></p>
                            </td>
                            <td>
                              <a href="<?php echo e(url('customer-orders').'/'.$order->order_id); ?>" class="text-danger"><?php echo e(!empty($delivery_boy->name) ? $delivery_boy->name : ''); ?></a>
                              <div> <span class="badge bg-secondary">Delivery Boy</span></div>
                            </td>
                            <td><span class=""><?php echo e($order->delivery_date); ?> / <?php echo e($order->delivery_time); ?> </span></td>
                            <td><span class="badge bg-light-success text-success"><?php echo e($order->order_status); ?></span></td>
                            <!--<td>-->
                            <!--<div class="table-actions d-flex align-items-center gap-3 fs-6">-->
                            <!--<a href="<?php echo e(url('/orders-view')); ?>" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>-->
                            <!--<a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>-->
                            <!--</div>-->
                            <!--</td>-->
                          </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                
                                                                        
                                                    </tbody>
                                                </table>   
      </div>
    </div>
  </div>
  
         <div class="card">
                <div class="card-header">
                    <h6 class="mb">Details</h6>
                </div>
                 <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Total Deposit Amount:</h6>
                            <span><?php echo e($deposit_amount); ?></span>
                        </div>
                        
                        <div class="col-md-6">
                        <h6>Total Returnable Jars:</h6>
                            <span><?php echo e(!empty($user)?$user->returnablejar_qty:''); ?></span>
                        </div>
                    </div>
                    
        
                </div>
        </div>
</div>




   



</div>
</main>
<!--end page main-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjalwaters/public_html/resources/views/backend/customer/view.blade.php ENDPATH**/ ?>