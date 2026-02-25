
<?php $__env->startSection('content'); ?>
   <!--start content-->
   <main class="page-content cuustomerinfo">
        <div class="row">
					
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb">Distributor Order</h6>
                    </div>
                    <div class="card-body">
                            <ul class="nav nav-pills ordernav" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link Processing active ordertabs" data-user_type="distributor" id="ordertabs1" data-bs-toggle="tab" data-bs-target="#orders1" type="button" role="tab" data-order_status="Order placed" aria-controls="home" aria-selected="true"> Order Placed</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link ordertabs2 ordertabs" data-user_type="distributor"  id="ordertabs2" data-bs-toggle="tab" data-bs-target="#orders2" type="button" data-order_status="On the way" role="tab" aria-controls="profile" aria-selected="false">On the way</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link ordertabs" data-user_type="distributor"  id="ordertabs3" data-bs-toggle="tab" data-order_status="Delivery" data-bs-target="#orders3" type="button" role="tab" aria-controls="contact" aria-selected="false">Delivery</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link ordertabs" data-user_type="distributor"  data-order_status="Cancelled" id="ordertabs4" data-bs-toggle="tab" data-bs-target="#orders4" type="button" role="tab" aria-controls="delivery" aria-selected="false">
                                Cancelled</button>
                            </li>
                           
                            </ul>
                            <div class="tab-content mt-4" id="myTabContent">
                                <!-- tabs 1 -->
                                    <div class="tab-pane fade show Processing active" id="orders1" role="tabpanel" aria-labelledby="ordertabs1">

                                            <div class="table-responsive">
                                                <table id="example" class="table table-bordered" style="width:100%">
                                         <thead>
                                             <tr>
                                               <th>  S.no</th>
                                               <th>Order ID</th>
                                               <th>Customer Name</th>
                                               <th>Distributor</th>
                                               <th>Delivery Date</th>
                                               <th>Status</th>
                                               <th>Action</th>
                                              </tr>
                                          </thead>				
                                                    <tbody>
                                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>          
                                        <tr>
                                            
                                         <td><?php echo e($key+1); ?></td>
                                         
                                         <td>
                                             <div><a href="<?php echo e(url('/customer-orders'.'/'.$order->order_id)); ?>"><h6 class="mb-0">#<?php echo e($order->order_id); ?></h6></a>
                                            <p class="opacity-50 mb-0">Order Date : <?php echo e(($order->order_created)); ?></p></div>
                                        </td>
                                        
                                         <td><?php echo e($order->name); ?>

                                        </td>
                                        
                                        <td><a href="<?php echo e(url('/customer-orders'.'/'.$order->order_id)); ?>" class="text-danger"><?php echo e($order->assigned_distributor_name); ?></a>
                                        </td>
                                        
                                         <td>
                                             <span class=""><?php echo e($order->delivery_date); ?> / <?php echo e($order->delivery_time); ?></span>
                                         </td>
                                         
                                         <td>  
                                         <a href="<?php echo e(url('/customer-orders'.'/'.$order->order_id)); ?>" class="text-danger"><span class="badge status-orderplace"><?php echo e($order->order_status); ?></span></a>
                                         </td>
                                         
                                         
                                          <td>
                                              <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                                                <a href="<?php echo e(url('/customer-orders'.'/'.$order->order_id)); ?>" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                  
                                                      </div>
                                            </td>
                                         </tr>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                                                                             
                                                                        
                                                                    


                                                    </tbody>
                                                </table>
                                            </div>

                                    </div>
                                <!-- tabs 1 -->

                                <!-- tabs 2 -->
                                    <div class="tab-pane fade" id="orders2" role="tabpanel" aria-labelledby="ordertabs2">

                                        <div class="table-responsive">
                                                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                        <tr>
                                                          <th>  S.no</th>
                                                            <th>Order ID</th>
                                                            <th>Customer Name</th>
                                                            <th>Distributor</th>
                                                            <th>Delivery Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>				
                                                    <tbody class="order_table">
                                                    
                                                                        
                                                                             
                                                    </tbody>
                                                        </table>
                                        </div>

                                    </div>
                                <!-- tabs 2 -->

                                <!-- tabs 3 -->
                                    <div class="tab-pane fade" id="orders3" role="tabpanel" aria-labelledby="ordertabs3">

                                            <div class="table-responsive">
                                                                <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                                                <thead>
                                                        <tr>
                                                        <th>S.no</th>
                                                            <th>Order ID</th>
                                                            <th>Customer Name</th>
                                                            <th>Delivery Boy</th>
                                                            <th>Delivery Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>				
                                                    <tbody class="order_table">
                                                     
                                                                       
                                                          </tbody>
                                                                </table>
                                            </div>
                                    </div>
                                <!-- tabs 3 -->

                                <!-- tabs 4 -->
                                    <div class="tab-pane fade" id="orders4" role="tabpanel" aria-labelledby="ordertabs4">
                                            <div class="table-responsive">
                                                                    <table id="example4" class="table table-striped table-bordered" style="width:100%">
                                                                    <thead>
                                                        <tr>
                                                       
                                                        <th>S.no</th>
                                                            <th>Order ID</th>
                                                            <th>Customer Name</th>
                                                            <th>Delivery Boy</th>
                                                            <th>Delivery Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>				
                                                    <tbody class="order_table">
                                                   
                                                                    </tbody>
                                                                    </table>
                                            </div>
                                    </div>
                                <!-- tabs 4 -->

                              

                            </div>
                    </div>
                </div>
            </div>
        </div>
   </main>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
$(document).ready(function() {
        $('#example').DataTable({
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [6] }, 
    ]
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjalwaters/public_html/resources/views/backend/orders/distributor-order-list.blade.php ENDPATH**/ ?>