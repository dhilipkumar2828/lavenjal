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
                                        
                                        <td>                                     <a href="<?php echo e(url('/customer-orders'.'/'.$order->order_id)); ?>" class="text-danger"><?php echo e($order->assigned_distributor_name); ?></a>
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
                                                </table><?php /**PATH C:\xampp\htdocs\lavenjalWeb-admin\resources\views/backend/reports/delivery_table.blade.php ENDPATH**/ ?>