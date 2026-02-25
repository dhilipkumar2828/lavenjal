@extends('backend.layouts.master')
@section('content')
   <!--start content-->
 <!--start content-->
 <main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Order Invoice</div>

              <div class="ms-auto">
                <div class="btn-group align-items-center">
                  <label class="pe-2"><h6><strong>Status: </strong></h6></label>
                <select class="form-select">
                            <option>Order Place</option>
                            <option>Processing</option>
                            <option>Ongoing</option>
                            <option>Completed</option>
                            <option>Returned</option>
                        </select>
                </div>
              </div>
            </div>
            <!--end breadcrumb-->
            
              <div class="card">
                <div class="card-header py-3"> 
                  <div class="row g-3 align-items-center">
                    <div class="col-12 col-lg-2 col-md-6">
                      <h5 class="mb-1">Order ID : #789</h5>
                      <p class="mb-0">Tue, Feb 20, 2022, 8:44PM</p>
                    </div> 
                    <div class="col-12 col-lg-3 col-md-6">
                      <h5 class="mb-1">Sales Representative</h5>
                      <p class="mb-0">9876543210</p>
                      <p class="mb-0">karthik@gmail.com</p>
                    </div> 
                    <div class="rescheduled">
                      <span class="badge bg-light-success text-success">Rescheduled</span>
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
                                <h6 class="mb">Customer</h6>
                                </div>
                           <div class="order-invoice card-body">
                            <div class="d-flex align-items-center gap-3">
                              <div class="icon-box bg-light-primary border-0">
                                <i class="bi bi-person text-primary"></i>
                              </div>
                              <div class="info">
                           
                                <p class="mb-1"><strong>Name</strong> : Karthik (#123)</p>
                                <p class="mb-1"><strong>Phone Number</strong> : 9876543210</p>
                                <p class="mb-1"><strong>Email ID</strong> : karthik@gmail.com</p>
                                <p class="mb-1"><strong>Address</strong> : 47-A, Street Name, <br>Ashok pillar, Chennai - 600083</p>
                                <p class="mb-1"><strong>Lift Available</strong> 4th floor</p>
                                <p class="mb-1 text-danger"><strong></strong>View map</p>
                              </div>
                           </div>
                           </div>
                         </div>
                      </div>
                      <div class="col commoncardheader">
                        <div class="card border shadow-none">
                        <div class="card-header">
                                <h6 class="mb">Delivery Agent</h6>
                                </div>
                          <div class="order-invoice card-body">
                            <div class="d-flex align-items-center gap-3">
                              <div class="icon-box bg-light-primary border-0">
                              <i class="bi bi-truck text-success"></i>
                              </div>
                              <div class="info">
                      
                                 <p class="mb-1"><strong>Name</strong> : Karthik</p>
                                 <p class="mb-1"><strong>Phone Number</strong> : 9876543210</p>
                                 <p class="mb-1"><strong>Email ID</strong> : karthik@gmail.com</p>
                                 <p class="mb-1"><strong>Address</strong> : 47-A, Street Name, <br>Ashok pillar</p>
                                 <p class="mb-1 text-danger"><strong></strong>View map</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card shadow-none">
                          <div class="order-invoice card-body p-0">
                            <div class="row">
                                <div class="card col-lg-6 text-center shadow-none">
                                  <div class="bg-light p-3 border">
                                  <i class="fadeIn animated bx bx-bong" style="font-size: 20px;"></i>
                                   <p class="mb-0">Return Jar</p>
                                   <h6 class="mb-0">10</h6>
                                   </div>
                                </div>
                                <div class="card col-lg-6 text-center shadow-none">
                                <div class="bg-light p-2 border">
                                <i class="bi bi-calendar-check"></i>
                                   <p class="mb-0">Delivery Date</p>
                                   <h6 class="mb-0">Feb 22, 2022</h6>
                                   <span>8.00 PM</span>
                                   </div>
                                </div>
                                <div class="card col-lg-6 text-center shadow-none">
                                <div class="bg-light p-2 border">
                                <i class="bi bi-wallet2"></i>
                                   <p class="mb-0">Refundable Amount</p>
                                   <h6 class="mb-0">₹450</h6>
                                   </div>
                                </div>
                                <div class="card col-lg-6 text-center shadow-none">
                                <div class="bg-light p-3 border">
                                <i class="lni lni-rupee"></i>
                                   <p class="mb-0">Payment Reference</p>
                                   <!-- <h6 class="mb-0">₹45</h6> -->
                                   </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div><!--end row-->
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
                              <tr>
                                <th scope="row">1</th>
                                <td><a class="d-flex align-items-center gap-2 imgtable" href="#">
                                  <div class="product-box">
                                    <img src="{{asset('backend/assets/images/can.png')}}" alt="">
                                  </div>
                                  <div>
                                    <h6 class="mb-1 product-title fw-bold">Lavenjal 20L Jar </h6>
                                    <span class="text-dark"><b> ₹30.00 </b></span>
                                  </div>
                                    </a>
                                </td>
                                <td>2</td>
                                <td> ₹60.00</td>
                              </tr>

                              <tr>
                                <th scope="row">2</th>
                                <td><a class="d-flex align-items-center gap-2 imgtable" href="#">
                                  <div class="product-box">
                                    <img src="{{asset('backend/assets/images/can.png')}}" alt="">
                                  </div>
                                <div>
                                  <h6 class="mb-1 product-title fw-bold">Packaged Drinking water</h6>
                                  <span class="text-dark"><b> ₹125.00 </b>(31% Offer) </span>
                                </div>
                                  </a>
                                </td>
                                <td>2 Set</td>
                                <td> ₹60.00</td>
                              </tr>

                              <tr>
                                <th scope="row">3</th>
                                <td><a class="d-flex align-items-center gap-2 imgtable" href="#">
                                  <div class="product-box">
                                    <img src="{{asset('backend/assets/images/can.png')}}" alt="">
                                  </div>
                                  <div>
                                    <h6 class="mb-1 product-title fw-bold">Lavenjal 20L Jar </h6>
                                      <span class="text-dark"><b> ₹30.00 </b></span>
                                  </div>                                                        
                                  </a>
                                </td>
                                <td>2</td>
                                <td> ₹60.00</td>
                              </tr>

                              <tr>
                                <th scope="row">4</th>
                                <td><a class="d-flex align-items-center gap-2 imgtable" href="#">
                                  <div class="product-box">
                                    <img src="{{asset('backend/assets/images/can.png')}}" alt="">
                                  </div>
                                  <div>
                                    <h6 class="mb-1 product-title fw-bold">Packaged Drinking water</h6>
                                    <span class="text-dark"><b> ₹125.00 </b>(31% Offer) </span>
                                  </div>
                                  </a>
                                </td>
                                <td>2 Set</td>
                                <td> ₹60.00</td>
                              </tr>
                            
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
                                 <div class="ms-auto">
                                   <button type="button" class="btn alert-success radius-30 px-4">Confirmed</button>
                                </div>
                              </div>
                                <div class="d-flex align-items-center mb-3">
                                  <div>
                                    <p class="mb-0">Subtotal</p>
                                  </div>
                                  <div class="ms-auto">
                                    <h5 class="mb-0">₹1450.00</h5>
                                </div>
                              </div>
                              <div class="d-flex align-items-center mb-3">
                                <div>
                                  <p class="mb-0">Refundable</p>
                                </div>
                                <div class="ms-auto">
                                  <h5 class="mb-0">₹450.00</h5>
                              </div>
                            </div>
                              <div class="d-flex align-items-center mb-3">
                                <div>
                                  <p class="mb-0">Delivery Charges</p>
                                </div>
                                <div class="ms-auto">
                                  <h5 class="mb-0">₹50.00</h5>
                              </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                              <div>
                                <p class="mb-0">Order Total</p>
                              </div>
                              <div class="ms-auto">
                                <h5 class="mb-0 text-danger">₹2000.00</h5>
                            </div>
                          </div>
                          </div>
                        </div>
                        <div class="card border shadow-none bg-light radius-10">
                          <div class="card-body">
                              <div class="d-flex align-items-center mb-4">
                                 <div>
                                    <h5 class="mb-0">Rescheduled</h5>
                                 </div>
                                 <div class="ms-auto">
                                   <button type="button" class="btn alert-success radius-30 px-4">Confirmed</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          </div>
                        </div>
                     </div>
                  </div><!--end row-->
                </div>
              </div>

          </main>
       <!--end page main-->
      
@endsection