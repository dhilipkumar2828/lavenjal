@extends('backend.layouts.master')
@section('content')
<!--start content-->
<!--start content-->
<main class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Order Invoice : #789</div>
        <div class="breadcrumb-title pe-3"> <span class="badge bg-secondary">Order Placed</span></div>


        <div class="ms-auto">
  <div class="btn-group align-items-center">
    <label class="pe-2">
      <h6><strong>Status: </strong></h6>
    </label>
    <select class="form-select me-3">
      <option>Order Place</option>
      <option>Processing</option>
      <option>Ongoing</option>
      <option>Completed</option>
      <option>Returned</option>
    </select>

    <button type="type" class="btn btn-primary">Submit</button>
  </div>
</div>
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
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button"
      role="tab" aria-controls="pills-contact" aria-selected="false">Ratings</button>
  </li>
</ul>
<!--tab-1-->
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
    <div class="card">
      <div class="card-header py-3">
        <div class="row g-3 align-items-center justify-content-between">
          <div class="col-12 col-lg-3 col-md-6">
            <h5 class="mb-1">Order ID : #789</h5>
            <p class="mb-0">Tue, Feb 20, 2022, 8:44PM</p>
          </div>
          <div class="col-12 col-lg-3 col-md-6">
            <h5 class="mb-1"><a href="" class="text-dark" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"><i
                  class="bi bi-person-check text-success"></i>
                Sales Representative</a></h5>
            <p class="mb-0">Karthik , 9876543210</p>
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
                  <h6 class="mb"><i class="bi bi-person text-primary"></i> Retailer</h6>
                </div>
                <div class="order-invoice card-body">
                  <div class="d-flex flex-column align-items-center gap-3">

                    <div class="info">

                      <p class="mb-2"><strong>Name</strong> : Karthik <strong>(#123)</strong>
                      </p>
                      <p class="mb-2"><strong>Phone Number</strong> : 9876543210</p>
                      <p class="mb-2"><strong>Email ID</strong> : karthik@gmail.com</p>
                      <p class="mb-2"><strong>Address</strong> : 47-A, Street Name, Ashok
                        pillar, Chennai - 600083</p>
                      <p class="mb-2"><strong>State</strong> : Tamilnadu</p>
                      <p class="mb-2"><strong>Lift Available</strong> 4th floor</p>
                      <p class="mb-0 text-danger"><strong></strong>View map</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col commoncardheader">
              <div class="card border shadow-none">
                <div class="card-header">
                  <h6 class="mb"><i class="bi bi-truck text-success"></i> Distributer</h6>
                </div>
                <div class="order-invoice card-body">
                  <div class="d-flex flex-column align-items-center gap-3">

                    <div class="info agent">

                      <p class="mb-2"><strong>Name</strong> : Karthik <strong>(#123)</strong>
                      </p>
                      <p class="mb-2"><strong>Shop Name</strong> : Murugan Stores</p>
                      <p class="mb-2"><strong>Phone Number</strong> : 9876543210</p>
                      <p class="mb-2"><strong>Email ID</strong> : karthik@gmail.com</p>
                      <p class="mb-2"><strong>Address</strong> : 47-A, Street Name, Ashok
                        pillar, Chennai - 600083</p>
                      <p class="mb-2"><strong>State</strong> : Tamilnadu</p>
                      <p class="mb-0 text-danger"><strong></strong>View map</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col commoncardheader">
              <div class="card shadow-none">
                <div class="order-invoice card-body p-0">
                  <div class="row">
                    <div class="card col-lg-6 text-center shadow-none">
                      <div class="box-bg p-3 border h-100">
                        <i class="bi bi-calendar-check"></i>
                        <h6 class="mb-2 text-success mt-2">Delivery Date</h6>
                        <h6 class="mb-0">Feb 22, 2022</h6>
                        <span>8.00 PM</span>
                      </div>
                    </div>
                    <div class="card col-lg-6 text-center shadow-none">
                      <div class="box-bg p-3 border h-100">
                        <i class="bi bi-wallet2 mb-2"></i>
                        <h6 class="mb-2 text-pink">Refundable Amount</h6>
                        <h6 class="mb-0">₹450</h6>
                      </div>
                    </div>
                    <div class="card col-lg-6 text-center shadow-none">
                      <div class="box-bg p-3 border h-100">
                        <i class="lni lni-rupee mb-2"></i>
                        <h6 class="mb-2 text-orange">Payment Reference</h6>
                        <h6 class="mb-0">#123</h6>
                      </div>
                    </div>
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
                        <tr>
                          <th scope="row">1</th>
                          <td><a class="d-flex align-items-center gap-2 imgtable" href="#">
                              <div class="product-box">
                                <img src="{{asset('backend/assets/images/can.png')}}" alt="">
                              </div>
                              <div>
                                <h6 class="mb-1 product-title fw-bold">Packaged
                                  Drinking water</h6>
                                <span class="text-dark"><b> ₹125.00 </b>(31% Offer)
                                </span>
                              </div>
                            </a>
                          </td>
                          <td>2 Set</td>
                          <td> ₹60.00</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td><a class="d-flex align-items-center gap-2 imgtable" href="#">
                              <div class="product-box">
                                <img src="{{asset('backend/assets/images/can.png')}}" alt="">
                              </div>
                              <div>
                                <h6 class="mb-1 product-title fw-bold">Packaged
                                  Drinking water</h6>
                                <span class="text-dark"><b> ₹125.00 </b>(31% Offer)
                                </span>
                              </div>
                            </a>
                          </td>
                          <td>2 Set</td>
                          <td> ₹60.00</td>
                        </tr> </tbody>
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
    <div class="bg-white p-3 border-5">
      <table class="table table-bordered table-left bg-white" style="width:100%;">
        <thead>
        </thead>
        <tbody>

          <tr>
            <th>
              <h6><strong class="">Delivery Boy Name</strong></h6>
            </th>
            <td>Selva
              <!-- <Span>-</Span> -->
            </td>
          </tr>
          <tr>
            <th>
              <h6><strong>Delivery Date</strong></h6>
            </th>
            <td>15.12.2022</td>
          </tr>
          <tr>
            <th>
              <h6><strong class="">Time</strong></h6>
            </th>
            <td>6.40 pm</td>
          </tr>
          <tr>
            <th>
              <h6><strong>Remark</strong></h6>
            </th>
            <td>Customer Delay</td>
          </tr>

        </tbody>
      </table>
    </div>

  </div>
</div>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
    <div class="bg-white p-3  border-5">
      <table class="table table-bordered table-left bg-white" style="width:100%">
        <thead>
        </thead>
        <tbody>
          <tr>
            <th>
              <h6><strong>Ratings</strong></h6>
            </th>
            <td>
              <i class="bi bi-star-fill color-yellow"></i>
              <i class="bi bi-star-fill color-yellow"></i>
              <i class="bi bi-star-fill color-yellow"></i>
              <i class="bi bi-star-fill "></i>
              <i class="bi bi-star-fill "></i>
            </td>
          </tr>
          <tr>
            <th>
              <h6><strong>Comments</strong></h6>
            </th>
            <td>
              Timing too Delay to recieve</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</div>


</div>



<!--tab-1 End-->
</main>
<!--end page main-->

@endsection

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
                  <div class="row">
                    <div class="col-lg-12 mb-3">
                      <label class="form-label col-6 col-sm-5">Name :</label>
                      <span>Karthik</span>
                    </div>
                    <div class="col-lg-12 mb-3">
                      <label class="form-label col-6 col-sm-5">Mobile Numer :</label>
                      <span>9876543210</span>
                    </div>
                    <div class="col-lg-12 mb-3">
                      <label class="form-label col-6 col-sm-5">Email Id :</label>
                      <span>karthik@gmail.com</span>
                    </div>
                  </div>
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