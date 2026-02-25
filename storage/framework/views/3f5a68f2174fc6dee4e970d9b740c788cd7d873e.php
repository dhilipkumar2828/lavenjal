<?php
$notifications=\App\Models\Notifications::where('status','read')->orderBy('id','desc')->limit('10')->get();

foreach($notifications as $notification){
        $order=\App\Models\Order::where('id',$notification->order_id)->first();
        $user_order=\App\Models\Order::first();
        if(!empty($order)){
            $user=\App\Models\User::where('id',$order->customer_id)->first();
            $user_name=(!empty($user->name) ? $user->name : "");
            $user_img=(!empty($user->user_img) ? $user->user_img : "backend/assets/images/avatars/lavenjal-user.png");
        }else{
            $user_name=(!empty($user->name) ? $user->name : "");
            if(!empty($user_order)){
              $user=\App\Models\User::where('id',$notification->user_id)->first();
             }
            else{
              $user="";
            }
            $user_name=(!empty($user)?$user->name:"");
            $user_img=(!empty($user->user_img) ? $user->user_img : "backend/assets/images/avatars/lavenjal-user.png");
        }
        $notification->user_name=$user_name;
        $notification->user_img=$user_img;
}

?>


<!-- Modal -->
<div class="modal fade" id="notification_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Notifications</h5>
       <button class="btn btn-primary messages clear-all" data-view_type="" data-type="clear_all" data-id="">Clear all</button>
      </div>
      <div class="modal-body" style="overflow: scroll;height: 400px;">
              
                <div class="show_notifications all_notification_render">
                    
                </div>
                 </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal_close" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
<!--start top header-->
<header class="top-header">
        <nav class="navbar navbar-expand">
          <div class="mobile-toggle-icon d-xl-none">
              <i class="bi bi-list"></i>
            </div>

            <div class="search-toggle-icon d-xl-none ms-auto">
              <i class="bi bi-search"></i>
            </div>

            <div class="top-navbar-right ms-auto">
              <ul class="navbar-nav align-items-center">

                <?php if(!empty(Auth::user())): ?>
               <li class="nav-item dropdown dropdown-large">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                  <div>
                    <span class="notify-badge notification_count"><?php echo e(count(\App\Models\Notifications::where('status','read')->get())); ?></span>
                    <i class="bi bi-messenger"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end p-0" style="width:30em;">
                  <div class="p-2 border-bottom m-2 d-flex justify-content-between align-items-center">
                      <h5 class="h5 mb-0">Messages</h5>
                      <button class="btn btn-primary messages clear-all" data-type="clear_all" data-id="" data-view_type="limit">Clear all</button>
                  </div>
                 <div class="header-message-list p-2">
                    <div class="dropdown-item bg-light radius-10 mb-1">
             
                    </div>
                    <span class="notification_render">
                        <?php echo $__env->make('backend.notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </span>
                    <?php if(count(\App\Models\Notifications::where('status','read')->get())>10): ?>
                <div class="text-center">
                    <button class="btn btn-primary view_all" data-type="clear_all" data-id="" >View all</button>
                 </div>
                 <?php endif; ?>
                </div>
               <!-- <div class="p-2">-->
               <!--   <div><hr class="dropdown-divider"></div>-->
               <!--     <a class="dropdown-item" href="#">-->
               <!--       <div class="text-center">View All Messages</div>-->
               <!--     </a>-->
               <!-- </div>-->
               <!--</div>-->
              </li> 
              <?php endif; ?>
              <li class="nav-item dropdown dropdown-large">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                  <div class="user-setting d-flex align-items-center gap-1">
                    <img src="<?php echo e(asset('backend/assets/images/favicon-32x32.png')); ?>" class="user-img" alt="">
                    <div class="user-name d-none d-sm-block"><?php echo e(!empty(auth()->user())?auth()->user()->name:(!empty(auth()->guard('salesreps')) ? auth()->guard('salesreps')->user()->name:'')); ?></div>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                     <a class="dropdown-item" href="#">
                       <div class="d-flex align-items-center">
                          <img src="<?php echo e(asset('backend/assets/images/favicon-32x32.png')); ?>" alt="" class="rounded-circle" width="40" height="40">
                          <div class="ms-3">
                            <h6 class="mb-0 dropdown-user-name">Lavenjal</h6>
                            <small class="mb-0 dropdown-user-designation text-secondary">Super Admin</small>
                          </div>
                       </div>
                     </a>
                   </li>
                   <li><hr class="dropdown-divider"></li>

                    <!-- <li>
                      <a class="dropdown-item" href="#">
                         <div class="d-flex align-items-center">
                           <div class="setting-icon"><i class="bi bi-gear-fill"></i></div>
                           <div class="setting-text ms-3"><span>Setting</span></div>
                         </div>
                       </a>
                    </li>


                    <li>
                      <a class="dropdown-item" href="#">
                         <div class="d-flex align-items-center">
                           <div class="setting-icon"><i class="bi bi-cloud-arrow-down-fill"></i></div>
                           <div class="setting-text ms-3"><span>Downloads</span></div>
                         </div>
                       </a>
                    </li> -->
                    <!-- <li><hr class="dropdown-divider"></li> -->
                    <li>
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                         <div class="d-flex align-items-center">
                           <div class="setting-icon"><i class="bi bi-lock-fill"></i></div>
                           <div class="setting-text ms-3">
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                    <?php echo e(__('Logout')); ?>


                          </div>
                         </div>
                       </a>
                    </li>
                </ul>
              </li>
              </ul>
              </div>
        </nav>
      </header>
       <!--end top header-->

       <!--start sidebar -->
<aside class="sidebar-wrapper" data-simplebar="true">
  <div class="sidebar-header">
    <div>
    <img src="<?php echo e(asset('backend/assets/images/logo_white.svg')); ?>" class="logo-icon" alt="logo icon">
    </div>

    <div class="toggle-icon ms-auto d-none"><i class="bi bi-chevron-double-left"></i>
    </div>
  </div>
  <!--navigation-->

  <ul class="metismenu" id="menu">
        <?php if(!empty(auth()->user())): ?>
    <li>
      <a href="<?php echo e(url('/dashboard')); ?>">
        <div class="parent-icon"><i class="bi bi-house-door"></i>
        </div>
        <div class="menu-title">Dashboard</div>
      </a>
    </li>
    <li>
    <a href="<?php echo e(url('/products')); ?>">
        <div class="parent-icon"><i class="bi bi-grid"></i>
        </div>
        <div class="menu-title">Product List</div>
      </a>
    </li>
    <li>
    <a href="<?php echo e(route('banner.index')); ?>">
        <div class="parent-icon"><i class="bi bi-grid"></i>
        </div>
        <div class="menu-title">Banner List</div>
    </a>
    </li>
    <li>
    <a href="<?php echo e(url('/customer')); ?>">
        <div class="parent-icon"><i class="fadeIn animated bx bx-list-ol"></i>
        </div>
        <div class="menu-title">Customer List</div>
      </a>
    </li>
    <li>
    <a href="<?php echo e(url('/retailer')); ?>">
        <div class="parent-icon"><i class="fadeIn animated bx bx-store"></i>
        </div>
        <div class="menu-title">Retailer List</div>
      </a>
    </li>
    <li>
    <a href="<?php echo e(url('/delivery_agent')); ?>">
        <div class="parent-icon"><i class="fadeIn animated bx bx-male"></i>
        </div>
        <div class="menu-title">Delivery Partners List</div>
      </a>
    </li>

        <li>
    <a href="<?php echo e(url('/delivery_agent_map')); ?>">
        <div class="parent-icon"><i class="fadeIn animated bx bx-male"></i>
        </div>
        <div class="menu-title">Delivery Partners Maps</div>
      </a>
    </li>

    
    <li>
    <a href="<?php echo e(url('/distributor')); ?>">
        <div class="parent-icon"><i class="lni lni-layers"></i>
        </div>
        <div class="menu-title">Distributor List</div>
      </a>
    </li>
            <li>
    <a href="<?php echo e(url('city')); ?>">
        <div class="parent-icon"><i class="lni lni-layers"></i>
        </div>
        <div class="menu-title">City List</div>
      </a>
    </li>
    
        <li>
    <a href="<?php echo e(url('pincode')); ?>">
        <div class="parent-icon"><i class="lni lni-layers"></i>
        </div>
        <div class="menu-title">Pincode List</div>
      </a>
    </li>
    
    <li>
        <a href="<?php echo e(url('unavailable_lists')); ?>">
            <div class="parent-icon"><i class="lni lni-layers"></i>
            </div>
            <div class="menu-title">Downloaded but no service</div>
         </a>
    </li>
    
     <li>

          <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-list"></i>
                </div>
                <div class="menu-title">Orders</div>
              </a>
              <ul class="bg-light border-0">

                <li> <a href="<?php echo e(url('/customer-order-list')); ?>"><i class="bi bi-arrow-right-short"></i>Customer  Orders</a>
                </li>
                <li> <a href="<?php echo e(url('/retailer-order-list')); ?>"><i class="bi bi-arrow-right-short"></i>Retailer Orders</a>
                </li>
                <li> <a href="<?php echo e(url('/deliveryboy-order-list')); ?>"><i class="bi bi-arrow-right-short"></i>Delivery Partners Orders</a>
                </li>
                 <li> <a href="<?php echo e(url('/distributor-order-list')); ?>"><i class="bi bi-arrow-right-short"></i>Distributor Orders</a>
                </li>
               

              </ul>
</li>

     <li>

          <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-list"></i>
                </div>
                <div class="menu-title">Reports</div>
              </a>
              <ul class="bg-light border-0">

                <li> <a href="<?php echo e(url('/customer-order-report')); ?>"><i class="bi bi-arrow-right-short"></i>Customer  Reports</a>
                </li>
                <li> <a href="<?php echo e(url('/retailer-order-report')); ?>"><i class="bi bi-arrow-right-short"></i>Retailer Reports</a>
                </li>
                <li> <a href="<?php echo e(url('/deliveryboy-order-report')); ?>"><i class="bi bi-arrow-right-short"></i>Delivery Partners Reports</a>
                </li>
                <li> <a href="<?php echo e(url('/distributor_report')); ?>"><i class="bi bi-arrow-right-short"></i>Distributor Reports</a>
                </li>

              </ul>
</li>
   
    
    
         <li>
    <a href="<?php echo e(url('feedback/delivery')); ?>">
        <div class="parent-icon"><i class="fadeIn animated bx bx-male"></i>
        </div>
        <div class="menu-title">Delivery Feedback</div>
      </a>
    </li>
    
    
            <li>
    <a href="<?php echo e(url('feedback/customer')); ?>">
        <div class="parent-icon"><i class="fadeIn animated bx bx-male"></i>
        </div>
        <div class="menu-title">Customer Feedback</div>
      </a>
    </li>
    
    
    
    
    <!--<li>-->
    <!--  <a href="javascript:;">-->
    <!--    <div class="parent-icon"><i class="lni lni-certificate"></i>-->
    <!--    </div>-->
    <!--    <div class="menu-title">Report</div>-->
    <!--  </a>-->
    <!--</li>-->
    <!--<li>-->
    <!--  <a href="user-panel">-->
    <!--    <div class="parent-icon"><i class="lni lni-user"></i>-->
    <!--    </div>-->
    <!--    <div class="menu-title">User Panel</div>-->
    <!--  </a>-->
    <!--</li>-->

    <li>
    <!--<li>-->
    <!--<a href="<?php echo e(url('/product-settings')); ?>">-->
    <!--    <div class="parent-icon"><i class="bi bi-file-earmark-code"></i>-->
    <!--    </div>-->
    <!--    <div class="menu-title">Product Settings</div>-->
    <!--  </a>-->
    <!--</li>-->
    <!--<li>-->
    <!--<a href="<?php echo e(url('/coupon')); ?>">-->
    <!--    <div class="parent-icon"><i class="fadeIn animated bx bx-receipt"></i>-->
    <!--    </div>-->
    <!--    <div class="menu-title">Coupon</div>-->
    <!--  </a>-->
    <!--</li>-->
    <!--<li>-->
    <!--<a href="<?php echo e(url('/wallet')); ?>">-->
    <!--    <div class="parent-icon"><i class="fadeIn animated bx bx-blanket"></i>-->
    <!--    </div>-->
    <!--    <div class="menu-title">Wallet</div>-->
    <!--  </a>-->
    <!--</li>-->
    <!--<li>-->
      <a href="<?php echo e(url('/sales-representative')); ?>">
        <div class="parent-icon"><i class="bi bi-person"></i>
        </div>
        <div class="menu-title">Sales Representative</div>
      </a>
    </li>
    <li>
    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
        <div class="parent-icon"><i class="bi bi-lock-fill"></i>
        </div>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
        <div class="menu-title">
        Logout</div>
      </a>
    </li>
  <?php endif; ?>
      <?php if(!empty(auth()->guard('salesreps')->user())): ?>

    <li>
        <a href="<?php echo e(url('/delivery_agent_map')); ?>">
            <div class="parent-icon"><i class="fadeIn animated bx bx-male"></i>
            </div>
            <div class="menu-title">Delivery Partners Maps</div>
          </a>
    </li>

  <?php endif; ?>
  </ul>

  

  <!--end navigation-->
</aside>
<!--end sidebar -->
<?php /**PATH /Users/mithra/Downloads/lavenjal_backup/resources/views/backend/layouts/header.blade.php ENDPATH**/ ?>