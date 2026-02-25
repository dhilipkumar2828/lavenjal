@extends('backend.layouts.master')
@section('content')

  <!--start content-->
  <main class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Wallet</div>
                <div class="ps-3">
                    <!-- <nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Data Table</li>
							</ol>
						</nav> -->
                </div>
        <!-- <div class="ms-auto">
                    <a class="btn btn-primary mb-3 mb-lg-0" href="{{url('/coupon-add')}}">
                    <i
                            class="bi bi-plus-square-fill"></i>Add Coupon</a>
                </div> -->
            </div>
				<div class="card">
					<div class="card-body p-4">
						<div class="table-responsive">
                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                    <tr>
                                       <th>S.no</th>
									    <th>Order Id</th>
										<th>User</th>
                                        <th>Payment Id</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Action</th>
									</tr>
                            </thead>
                            <tbody>
                            <tr>  
                                         <td>1</td>
									    <td>     <a href="{{url('/orders-view')}}" class="" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="View">001</a></td>
                                        <td> <div>Karthik</div> 
                                        <div> <span class="badge bg-secondary">Delivery Boy</span></div>
                                        </td>
                                        <td>#98765</td>
                                        <td>Lorem ispsum</td>
                                        <td>450</td>
                                        <td>
                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a href="{{url('/orders-view')}}" class="bg-view" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="View"><i
                                                    class="bi bi-eye-fill"></i></a>
                                           </div>
                                        </td>
									</tr>

                                    <tr>
                                        <td>2</td>
                                        <td>
                                            <a href="{{url('/orders-view')}}"  data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="View">002</a></td>
                                      <td> <div>  Krishna</div> 
                                        <div> <span class="badge bg-secondary">Customer </span></div>
                                        </td>
                                        <td>#13579</td>
                                        <td>Lorem ispsum</td>
                                        <td>458</td>
                                        <td>
                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a href="{{url('/orders-view')}}" class="bg-view" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="View"><i
                                                    class="bi bi-eye-fill"></i></a>
                                            </div>
                                        </td>
									</tr>

                                    <tr>
                                    <td>3</td>
                                    <td>     <a href="{{url('/orders-view')}}" class="" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="View">003</a></td>
                                        <td>
                                        <div>  Pandian</div> 
                                        <div> <span class="badge bg-secondary">Retailer </span></div>
                                        </td>
                                        <td>#67891</td>
                                        <td>Lorem ispsum</td>
                                        <td>505</td>
                                        <td>
                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a href="{{url('/orders-view')}}" class="bg-view" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="View"><i
                                                    class="bi bi-eye-fill"></i></a>
                                           </div>
                                        </td>
									</tr>

                            </tbody>

                        </table>
						</div>
					</div>
				</div>
			</main>
       <!--end page main-->

        @endsection

        <!-- Edit -->
        <div class="col">
            <!-- Modal -->
            <div class="modal fade" id="exampleLargeModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Order No</label>
                                    <input class="form-control mb-3" type="text" placeholder=""
                                        aria-label="default input example" value="1">
                                </div>
                                <div class="col-lg-6">
                                    <label>User</label>
                                    <input class="form-control mb-3" type="text" placeholder=""
                                        aria-label="default input example" value="Karthik">
                                </div>
                                <div class="col-lg-6">
                                    <label>Payment Id</label>
                                    <input class="form-control mb-3" type="tel" placeholder=""
                                        aria-label="default input example" value="#98765">
                                </div>
                                <div class="col-lg-6">
                                    <label>LOrem ispus</label>
                                    <input class="form-control mb-3" type="email" placeholder=""
                                        aria-label="default input example" value="10">
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>