
<?php $__env->startSection('content'); ?>
<?php
$dashboard=\App\Models\Order::count();
$return_jars=\App\Models\Order::select(DB::raw("SUM(returnablejar_qty) as jarcount"))->first();
$total_sales=\App\Models\Order::select(DB::raw("SUM(total) as totalsales"))->first();
$customers=\App\Models\User::select('id','name')->where('user_type','customer')->limit(5)->orderBy('id','desc')->get();  
$orders=DB::table('orders')->join('users','users.id','=','orders.customer_id')->orderBy('orders.id','desc')->where('orders.status','Order placed')->get(['orders.*','users.*','orders.status as order_status','users.id as user_id','orders.created_at as order_created']);

?>
      <!--start content-->
      <main class="page-content">
              
              <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
                <div class="col">
                  <div class="card radius-10">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <p class="mb-1">Total Products</p>
                          <h4 class="mb-0 text-primary"><?php echo e(count(\App\Models\Product::where('status','active')->get())); ?></h4>
                        </div>
                        <div class="ms-auto fs-2 text-primary">
                          <i class="bi bi-cart-check"></i>
                        </div>
                      </div>
                      <div class="my-2"></div>
                      <!-- <small class="mb-0"><span class="text-success">+2.5 <i class="bi bi-arrow-up"></i></span> Compared to last month</small> -->
                    </div>
                  </div>
                 </div>
                 <div class="col">
                  <div class="card radius-10">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <p class="mb-1">Total Customer</p>
                          <h4 class="mb-0 text-success"><?php echo e(count(\App\Models\User::where('user_type','customer')->get())); ?></h4>
                        </div>
                        <div class="ms-auto fs-2 text-success">
                          <i class="bi bi-person"></i>
                        </div>
                      </div>
                      <div class="my-2"></div>
                      <!-- <small class="mb-0"><span class="text-success">+3.6 <i class="bi bi-arrow-up"></i></span> Compared to last month</small> -->
                    </div>
                  </div>
                 </div>
                 <div class="col">
                  <div class="card radius-10">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <p class="mb-1">Total Retailer</p>
                          <h4 class="mb-0 text-pink"><?php echo e(count(\App\Models\User::where('user_type','retailer')->get())); ?></h4>
                        </div>
                        <div class="ms-auto fs-2 text-pink">
                          <i class="bi bi-bag-check"></i>
                        </div>
                      </div>
                      <div class="my-2"></div>
                      <!-- <small class="mb-0"><span class="text-danger">-1.8 <i class="bi bi-arrow-down"></i></span> Compared to last month</small> -->
                    </div>
                  </div>
                 </div>
                 <div class="col">
                  <div class="card radius-10">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <p class="mb-1">Total Delivery Boy</p>
                          <h4 class="mb-0 text-orange"><?php echo e(count(\App\Models\User::where('user_type','delivery_agent')->get())); ?></h4>
                        </div>
                        <div class="ms-auto fs-2 text-orange">
                        <i class="fadeIn animated bx bx-vial"></i>
                        </div>
                      </div>
                      <div class="my-2"></div>
                      <!-- <small class="mb-0"><span class="text-success">+3.7 <i class="bi bi-arrow-up"></i></span> Compared to last month</small> -->
                    </div>
                  </div>
                 </div>
                 <div class="col">
                  <div class="card radius-10">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <p class="mb-1">Total Distributor</p>
                          <h4 class="mb-0 text-pink"><?php echo e(count(\App\Models\User::where('user_type','distributor')->get())); ?></h4>
                        </div>
                        <div class="ms-auto fs-2 text-pink">
                          <i class="bi bi-bag-check"></i>
                        </div>
                      </div>
                      <div class="my-2"></div>
                      <!-- <small class="mb-0"><span class="text-danger">-1.8 <i class="bi bi-arrow-down"></i></span> Compared to last month</small> -->
                    </div>
                  </div>
                 </div>
                 <div class="col">
                  <div class="card radius-10">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <p class="mb-1">Total Orders</p>
                          <h4 class="mb-0 text-orange"><?php echo e(count(\App\Models\Order::get())); ?></h4>
                        </div>
                        <div class="ms-auto fs-2 text-orange">
                        <i class="fadeIn animated bx bi-bag-check-fill"></i>
                        </div>
                      </div>
                      <div class="my-2"></div>
                      <!-- <small class="mb-0"><span class="text-success">+3.7 <i class="bi bi-arrow-up"></i></span> Compared to last month</small> -->
                    </div>
                  </div>
                 </div>
              </div><!--end row-->
              </div><!--end row-->
              
           
  
  
              <div class="row d-none">
                <div class="col-12 col-lg-8 col-xl-8">
                  <div class="card radius-10">
                    <div class="card-body">
                       <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center mb-3">
                          <div class="col">
                            <h5 class="mb-0">Total Distributor</h5>
                          </div>
                          <div class="col">
                            <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                               <div class="font-13"><i class="bi bi-circle-fill text-primary"></i><span class="ms-2">Sales</span></div>
                               <div class="font-13"><i class="bi bi-circle-fill text-success"></i><span class="ms-2">Orders</span></div>
                            </div>
                          </div>
                       </div>
                       <div id="chart1"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-lg-4 col-xl-4">
                  <div class="card radius-10">
                    <div class="card-body">
                      <div class="d-flex align-items-center gap-4">
                        <div class="">
                          <span class="donut" data-peity='{ "fill": ["#8932ff", "rgba(135, 50, 255, 0.15)"], "innerRadius": 28, "radius": 50, "width": 67, "height": 67}'>3/5</span>
                        </div>
                        <div class="">
                          <h4 class="mb-0">68%</h4>
                          <p class="mb-1">Conversation Rate</p>
                        </div>
                        <div class="dropdown ms-auto">
                          <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                            </li>
                            <li>
                              <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="border-top my-4"></div>
                      <div class="d-flex align-items-center gap-4">
                        <div class="">
                          <span class="donut" data-peity='{ "fill": ["#ff6632", "rgba(255, 101, 50, 0.15)"], "innerRadius": 28, "radius": 50, "width": 67, "height": 67}'>3.5/5</span>
                        </div>
                        <div class="">
                          <h4 class="mb-0">76%</h4>
                          <p class="mb-1">Traffic this year</p>
                        </div>
                        <div class="dropdown ms-auto">
                          <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                            </li>
                            <li>
                              <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card radius-10">
                    <div class="card-body">
                       <div class="d-flex align-items-end">
                          <div>
                            <h4 class="mb-1">256.2K</h4>
                            <p class="mb-0">Visitors this year</p>
                          </div>
                          <div class="ms-auto">
                            <p class="mb-0 text-danger">1.5% <i class="bi bi-arrow-up"></i></p>
                          </div>
                       </div>
                       <div id="chart2"></div>
                    </div>
                  </div>
                </div>
              </div><!--end row-->
  
              <div class="row d-none">
                 <div class="col-12 col-lg-6 col-xl-6 d-flex">
                   <div class="card radius-10 w-100">
                    <div class="card-body">
                      <div class="row g-3 align-items-center">
                        <div class="col">
                          <h5 class="mb-0">Statistics</h5>
                        </div>
                        <div class="col">
                          <div class="d-flex">
                            <div class="dropdown ms-auto">
                              <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                </li>
                                <li>
                                  <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                     </div>
                      <div class="row row-cols-1 row-cols-md-3 g-3 mt-4">
                         <div class="col text-center">
                              <div class="w_chart" id="chart3" data-percent="68">
                              <span class="w_percent"></span>
                            </div>
                              <h5 class="mt-3 mb-0">2.4K</h5>
                              <p class="mb-0 font-13">Customers</p>
                            </div>
                            <div class="col text-center">
                              <div class="w_chart" id="chart4" data-percent="78">
                              <span class="w_percent"></span>
                            </div>
                            <h5 class="mt-3 mb-0">1.8K</h5>
                             <p class="mb-0 font-13">Item Sold</p>
                          </div>
                          <div class="col text-center">
                            <div class="w_chart" id="chart5" data-percent="46">
                            <span class="w_percent"></span>
                          </div>
                             <h5 class="mt-3 mb-0">2.6K</h5>
                             <p class="mb-0 font-13">Tickets</p>
                        </div>
                      </div>
                      <div class="bg-light p-3 radius-10 mt-3">
                        <p class="mb-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable</p>
                      </div>
                    </div>
                   </div>
                 </div>
                 <div class="col-12 col-lg-6 col-xl-6 d-flex">
                  <div class="card radius-10 w-100">
                    <div class="card-body">
                      <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center">
                        <div class="col">
                          <h5 class="mb-0">Product Actions</h5>
                        </div>
                        <div class="col">
                          <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                             <div class="font-13"><i class="bi bi-circle-fill text-primary"></i><span class="ms-2">Views</span></div>
                             <div class="font-13"><i class="bi bi-circle-fill text-warning"></i><span class="ms-2">Clicks</span></div>
                          </div>
                        </div>
                       </div>
                        <div id="chart6"></div>
                      </div>
                    </div>
                 </div>
              </div><!--end row-->
              
  
              <div class="card radius-10 d-none">
                 <div class="card-body">
                   <div class="row g-3">
                     <div class="col-12 col-lg-4 col-xl-4 d-flex">
                      <div class="card mb-0 radius-10 border shadow-none w-100">
                        <div class="card-body">
                          <h5 class="card-title">Top Sales Locations</h5>
                          <h4 class="mt-4">₹36.2K <i class="flag-icon flag-icon-us rounded"></i></h4>
                          <p class="mb-0 text-secondary font-13">Our Most Customers in US</p>
                          <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item border-top">
                              <div class="d-flex align-items-center gap-2">
                                 <div><i class="flag-icon flag-icon-us"></i></div>
                                 <div>United States</div>
                                 <div class="ms-auto">289</div>
                              </div>
                            </li>
                            <li class="list-group-item">
                             <div class="d-flex align-items-center gap-2">
                                <div><i class="flag-icon flag-icon-au"></i></div>
                                <div>Malaysia</div>
                                <div class="ms-auto">562</div>
                             </div>
                           </li>
                           <li class="list-group-item">
                             <div class="d-flex align-items-center gap-2">
                                <div><i class="flag-icon flag-icon-in"></i></div>
                                <div>India</div>
                                <div class="ms-auto">354</div>
                             </div>
                           </li>
                           <li class="list-group-item">
                             <div class="d-flex align-items-center gap-2">
                                <div><i class="flag-icon flag-icon-ca"></i></div>
                                <div>Indonesia</div>
                                <div class="ms-auto">147</div>
                             </div>
                           </li>
                           <li class="list-group-item">
                             <div class="d-flex align-items-center gap-2">
                                <div><i class="flag-icon flag-icon-ad"></i></div>
                                <div>Turkey</div>
                                <div class="ms-auto">652</div>
                             </div>
                           </li>
                           <li class="list-group-item">
                             <div class="d-flex align-items-center gap-2">
                                <div><i class="flag-icon flag-icon-cu"></i></div>
                                <div>Netherlands</div>
                                <div class="ms-auto">287</div>
                             </div>
                           </li>
                           <li class="list-group-item">
                             <div class="d-flex align-items-center gap-2">
                                <div><i class="flag-icon flag-icon-is"></i></div>
                                <div>Italy</div>
                                <div class="ms-auto">634</div>
                             </div>
                           </li>
                           <li class="list-group-item">
                             <div class="d-flex align-items-center gap-2">
                                <div><i class="flag-icon flag-icon-ge"></i></div>
                                <div>Canada</div>
                                <div class="ms-auto">524</div>
                             </div>
                           </li>
                          </ul>
                        </div>
                      </div>
                     </div>
                     <div class="col-12 col-lg-8 col-xl-8 d-flex">
                      <div class="card mb-0 radius-10 border shadow-none w-100">
                        <div class="card-body">
                          <div class="" id="geographic-map"></div>
                         </div>
                        </div>
                    </div>
                   </div><!--end row-->
                 </div>
              </div>
  

              
            </main>
         <!--end page main-->
         <!--start overlay-->
          <div class="overlay nav-toggle-icon"></div>
         <!--end overlay-->
  
         <!--Start Back To Top Button-->
               <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
               


<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\lavenjalWeb-admin\resources\views/backend/dashboard.blade.php ENDPATH**/ ?>