
<?php $__env->startSection('content'); ?>
  <!--start content-->
  <main class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Customer List</div>
					<div class="ms-auto">
                    <a class="btn btn-primary mb-3 mb-lg-0 d-none" href="<?php echo e(url('/')); ?>" data-bs-toggle="modal"
		data-bs-target="#exampleLargeModal1">
                    <i
                            class="bi bi-plus-square-fill"></i>Add Customer </a>
                </div>
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
						<a class="btn btn-primary mb-3 mb-lg-0" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"><i class="bi bi-plus-square-fill"></i>Add Customer</a>
					</div> -->
</div>
<!--end breadcrumb-->

<!-- <div class="card">
              <div class="card-body">
								<div class="row align-items-center">
									
									<div class="col-lg-9 col-xl-10">
										<form class="float-lg-end">
											<div class="row row-cols-lg-auto g-2">
												<div class="col-12">
													<a href="javascript:;" class="btn btn-light mb-3 mb-lg-0"><i class="bi bi-download"></i>Export</a>
												</div>
												<div class="col-12">
													<a href="javascript:;" class="btn btn-light mb-3 mb-lg-0"><i class="bi bi-upload"></i>Import</a>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
            </div> -->
<!-- <h6 class="mb-0 text-uppercase">DataTable Example</h6>
				<hr/> -->
<div class="card">
	<div class="card-body p-4">
	<?php if($message = Session::get('success')): ?>
                    <div class="alert alert-success"><?php echo e($message); ?></div>
                <?php endif; ?>
		<div class="table-responsive">
			<table id="example" class="table table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>S.no</th>
						<th>Name</th>
						<th>Phone Number</th>
						<th>Email</th>
						<th>Date of Registration</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				  <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($key + 1); ?></td>
						<td><?php echo e($user->name); ?></td>
						<td><?php echo e($user->phone); ?></td>
						<td><?php echo e($user->email); ?></td>
						<td><?php echo e(!empty($user->created_at)?$user->created_at->format('d-m-Y'):''); ?></td>
						<td><span class="badge  <?php echo e($user->status == '1' ? 'bg-light-success text-success' : 'bg-light-danger text-danger'); ?>"><?php echo e($user->status == '0' ? 'Inactive' : 'Active'); ?></span></td>
						<td>
							<div class="table-actions d-flex align-items-center gap-3 fs-6">
								<a href="<?php echo e(route('customer.show',$user->id)); ?>" class="text-primary" data-bs-toggle="tooltip"
									data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
								<a href="javascript:;" class="text-warning customer_edit" data-customer_id="<?php echo e($user->id); ?>" data-bs-toggle="tooltip"
									data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill bg-edit"
										></i></a>
							 <form action="<?php echo e(route('customer.destroy',$user->id)); ?>" method="post">
							  <?php echo csrf_field(); ?>
							  <?php echo method_field('DELETE'); ?>
								<button type="submit" class="text-primary" data-bs-toggle="tooltip"
									data-bs-placement="bottom" title="Delete"><i
										class="bi bi-trash-fill  bg-delete"></i></button>
							</form>
							</div>
						</td>
					</tr>
				 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



				</tbody>

			</table>
		</div>
	</div>
</div>
</main>
<!--end page main-->

<?php $__env->stopSection(); ?>

<!-- Edit -->
<div class="col">
	<!-- Modal -->
	<div class="modal fade" id="exampleLargeModal1" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
				 <form action="" id="update_customer" method="POST">
					<?php echo csrf_field(); ?>
					<?php echo method_field('PUT'); ?>
					<div class="row">
						<div class="col-lg-6">
							<label>Name</label>
							<input class="form-control mb-3" type="text" placeholder=""
								aria-label="default input example" name="name" value="Karthik" id="M_customer_name">
							<span class="text-danger name"></span>
						</div>
						<div class="col-lg-6">
							<label>Phone Number</label>
							<input class="form-control mb-3" type="tel" placeholder=""
								aria-label="default input example" name="phone" value="9876543210" id="M_phone" minlenth=10 maxlength=15 onkeypress="return isNumber(event)" >
							<span class="text-danger phone"></span>
						</div>
						<div class="col-lg-6">
							<label>Email Id</label>
							<input class="form-control mb-3" type="email" placeholder=""
								aria-label="default input example"  name="email" value="karthik@gmail.com" id="M_email">
								<span class="text-danger email"></span>
						</div>
						<div class="col-lg-6">
							<label>Status</label>
							<select name="status" id="M_status"  class="form-control">
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
						</div>

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
$(document).ready(function() {
    var table =       $('#example').DataTable({

    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [5] }, 
    ]
    });
    

});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjal/resources/views/backend/customer/index.blade.php ENDPATH**/ ?>