
<?php $__env->startSection('content'); ?>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p>Please Add Delivery Agent</p>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



  <!--start content-->
  <main class="page-content">
				<!--breadcrumb-->
	<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">Retailer List</div>
		<div class="ms-auto">
			<a class="btn btn-primary mb-3 mb-lg-0" href="<?php echo e(url('retailer/create')); ?>"  >
			<i class="bi bi-plus-square-fill"></i>Add Retailer </a>
		</div>
	</div>

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
										<th>QR Code</th>
										<th>Shop Details</th>
										<th>Retailer Id</th>
										<th>Phone Number</th>
										<th>Email</th>
										<th>User Status</th>
										<th>Shop Status</th>
										<th>Actions</th>
									</tr>
								</thead>

							<tbody>
							 <?php $__currentLoopData = $retailers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$retailer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
							    	<td><?php echo e($key + 1); ?></td>
							    	<?php $txtpassword = Helper::encrypt_decrypt('encrypt', $retailer->u_id); ?>
							    	<td> <?php echo QrCode::size(100)->generate(url('QrCode_cartView').'/'.$txtpassword); ?></td>
                                    <td>
                                        <h6><strong><?php echo e($retailer->name); ?></strong></h6>
                                        <h6 class="mb-0"><i class='bx bxs-store'></i><?php echo e(!empty($retailer->name_of_shop) ? $retailer->name_of_shop : ''); ?></h6>
                                        <h6 class="mb-0"><span><i class='bx bx-map'></i> <?php echo e(!empty($retailer->full_address) ? $retailer->full_address : ''); ?></span></h6>
                                    </td>
                                    <td><?php echo e($retailer->u_id); ?></td>
                                    <td><?php echo e($retailer->phone); ?></td>
                                    <td><?php echo e($retailer->email); ?></td>
                                    <td>
                                        <input type="checkbox" data-name="Retailer" data-user_id="<?php echo e($retailer->u_id); ?>" class="user_status btn" data-toggle="toggle" data-on="Active" data-off="In Active" data-onstyle="success" data-offstyle="danger"  <?php echo e($retailer->user_status==1 ? 'checked' : ''); ?>  <?php echo e(empty($retailer->assigned_distributor) ? 'disabled  data-toggle=modal data-target=#exampleModal' : ''); ?>>
                                        
                                    </td>
									<!--<td class="badge bg-light <?php echo e($retailer->status == 1 ? '-success text-success' : '-danger text-danger'); ?>"><?php echo e($retailer->status == 1 ?'Active' :  'Inactive'); ?></td>-->
									<td>
							<span class="badge  <?php echo e($retailer->status=='1' ?'bg-light-success text-success' : 'bg-light-danger text-danger'); ?>"><?php echo e($retailer->status=='1' ?'Active':'Inactive'); ?></span>
									</td>
									<td>
										<div class="table-actions d-flex align-items-center gap-3 fs-6">
											<a href="<?php echo e(route('retailer.show',$retailer->o_id)); ?>" class="text-primary" data-bs-toggle="tooltip"
												data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a>
											<a href="<?php echo e(route('retailer.edit',$retailer->o_id)); ?>" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"
												title="Edit"><i class="bi bi-pencil-fill bg-edit"></i></a>
                                            <form action="<?php echo e(route('retailer.destroy',$retailer->o_id)); ?>" method="POST">
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

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
$(document).ready(function() {
        $('#example').DataTable({
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [8] }, 
    ]
    });
});
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjalwaters/public_html/resources/views/backend/retailer/index.blade.php ENDPATH**/ ?>