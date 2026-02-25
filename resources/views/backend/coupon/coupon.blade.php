@extends('backend.layouts.master')
@section('content')

  <!--start content-->
  <main class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Coupon</div>
				</div>
				<div class="card">
					<div class="card-body p-4">
						<div class="table-responsive">
							<table id="example" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
									<th>S.no</th>
										<th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Coupon Percentage</th>
                                        <th>Coupon Code</th>
                                        <!-- <th>Actions</th> -->
									</tr>
								</thead>
								<tbody>
									<tr>
									<td>1</td>
										<td><h6><strong>Karthik</strong></h6></td>
										<td>1234567890</td>
                                        <td>20%</td>
                                        <td>#98765</td>
                                        <!-- <td>
                                        <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a href="{{url('/delivery-view')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                        </div>
                                        </td> -->
									</tr>
									
									<tr>
									<td>2</td>
										<td><h6><strong>Pandian</strong></h6></td>
										<td>740143906</td>
                                        <td>20%</td>
                                        <td>#98765</td>
                                        <!-- <td>
                                        <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a href="{{url('/delivery-view')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                        </div>
                                        </td> -->
									</tr>
									
									<tr>
									<td>3</td>
										<td><h6><strong>Kiruthiga</strong></h6></td>
										<td>8577692136</td>
                                        <td>20%</td>
                                        <td>#98765</td>
                                        <!-- <td>
                                        <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a href="{{url('/delivery-view')}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
                                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"></i></a>
                                        </div>
                                        </td> -->
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</main>
       <!--end page main-->
      
@endsection