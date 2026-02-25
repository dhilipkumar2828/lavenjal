@extends('backend.layouts.master')
@section('content')

  <!--start content-->
  <main class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Coupon</div>
                <div class="ps-3">
                    <!-- <nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Data Table</li>
							</ol>
						</nav> -->
                </div>
                <div class="ms-auto">
                    <a class="btn btn-primary mb-3 mb-lg-0" href="{{url('/coupon-add')}}">
                    <i
                            class="bi bi-plus-square-fill"></i>Add Coupon</a>
                </div>
            </div>
				<div class="card">
					<div class="card-body p-4">
						<div class="table-responsive">
							<table id="example" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
									<th>S.no</th>
									
                                        <!-- <th>Phone Number</th> -->
                                        <th>Percentage</th>
                                        <th>Coupon Code</th>
                                        <th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr>
									<td>1</td>
									
										<!-- <td>1234567890</td> -->
                                        <td>20%</td>
                                        <td>#98765</td>
                                        <td>
                                        <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
											<a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="bi bi-trash bg-delete" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                        </div>
                                        </td>
									</tr>
									
									<tr>
									<td>2</td>
									
										<!-- <td>740143906</td> -->
                                        <td>20%</td>
                                        <td>#98765</td>
                                        <td>
                                        <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
											<a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="bi bi-trash bg-delete" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                        </div>
                                        </td>
									</tr>
									
									<tr>
									<td>3</td>
									
										<!-- <td>8577692136</td> -->
                                        <td>20%</td>
                                        <td>#98765</td>
                                        <td>
                                        <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
											<a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="bi bi-trash bg-delete" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
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
                                <label>S.No</label>
                                <input class="form-control mb-3" type="text" placeholder="" aria-label="default input example" value="1"></div>
                                <div class="col-lg-6">
                                <label>Name</label>
                                <input class="form-control mb-3" type="text" placeholder="" aria-label="default input example" value="Karthik"></div>
                                <div class="col-lg-6">
                                <label>Percentage</label>
                                <input class="form-control mb-3" type="tel" placeholder="" aria-label="default input example" value="20%"></div>
                                <div class="col-lg-6">
                                <label>Coupon Code</label>
                                <input class="form-control mb-3" type="email" placeholder="" aria-label="default input example" value="#98765"></div>
                                
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
	