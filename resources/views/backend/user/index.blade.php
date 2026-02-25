@extends('backend.layouts.master')
@section('content')

  <!--start content-->
  <main class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User Panel</div>
					<div class="ps-3">
					</div>
            	</div>
				<div class="card">
					<div class="card-body p-4">
				<div class="row">
					<div class="col-lg-6 mb-3">
                    <label class="mb-2">Name :</label>
                    <input class="form-control" type="text" placeholder="" aria-label="default input example"></div>

                    <div class="col-lg-6 mb-3">
                    <label class="mb-2">Phone Number :</label>
                    <input class="form-control" type="text" placeholder="" aria-label="default input example"></div>

                    <div class="col-lg-6 mb-3">
                    <label class="mb-2">Email Id :</label>
                    <input class="form-control" type="text" placeholder="" aria-label="default input example"></div>
					<div class="col-lg-6 mb-3">
                    <label class="mb-2">Password :</label>
                    <input class="form-control" type="password" placeholder="" aria-label="default input example"></div>

                    <div class="col-lg-6 mb-3">
                    <label class="mb-2">Confirm Password :</label>
                    <input class="form-control" type="password" placeholder="" aria-label="default input example"></div>
					<div class="col-lg-12">
					<button type="button" class="btn btn-primary">Submit</button></div>
                </div>
			</div>
			</div>
			<div class="card">
					<div class="card-body p-4">
						<div class="table-responsive">
							<table id="example" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
									<th>Pages</th>
										<th>View</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
									</tr>
								</thead>
								<tbody>
									<tr>
									<td>Retailer</td>
                                        <td><div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault"></label>
								</div></td>
                                        <td>
                                        <div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault"></label>
								</div>
                                        </td>
                                        <td>
                                        <div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault"></label>
								</div>
                                        </td>
									</tr>
                                    <tr>
									<td>Distributor</td>
                                        <td><div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault"></label>
								</div></td>
                                        <td>
                                        <div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault"></label>
								</div>
                                        </td>
                                        <td>
                                        <div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault"></label>
								</div>
                                        </td>
									</tr>
                                    <tr>
									<td>User</td>
                                        <td><div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault"></label>
								</div></td>
                                        <td>
                                        <div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault"></label>
								</div>
                                        </td>
                                        <td>
                                        <div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault"></label>
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
	