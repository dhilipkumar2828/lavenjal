
<?php $__env->startSection('content'); ?>
    <!--start content-->
    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Distributor List</div>
                         <div class="ms-auto">
                <form action="<?php echo e(url('import_distributor_data')); ?>" class="d-flex justify-content-end" method="POST" enctype="multipart/form-data">
                           <?php echo csrf_field(); ?>
                    <input type="file" name="file" class="custom-file-input" id="customFile">
                    <button type="submit" class="btn btn-primary mb-3 mb-lg-0">Import Distributor</button> 
                </form>
            </div>
            <div class="ms-auto">
                <form action="<?php echo e(url('get_distributor_data')); ?>" class="d-flex justify-content-end" method="POST">
                           <?php echo csrf_field(); ?>
                    <button class="btn btn-primary mb-3 mb-lg-0">Export Distributors</button> 
                </form>
            </div>
            <div class="ms-auto">
                <a class="btn btn-primary mb-3 mb-lg-0" href="<?php echo e(route('distributor.create')); ?>">
                    <i class="bi bi-plus-square-fill"></i>Add Distributor </a>
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
                                <th>Shop Details</th>
                                <th>Distributor ID</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>User Status</th>
                                <th>Shop Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $distributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$distributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td>
                                    <h6><strong><?php echo e($distributor->name); ?></strong></h6>
                                    <h6 class="mb-0"><i class='bx bxs-store'></i><?php echo e(!empty($distributor->name_of_shop) ? $distributor->name_of_shop : ''); ?></h6>
                                    <h6 class="mb-0"><span class="d-flex"><i class='bx bx-map'></i> <p style="width: 300px; white-space: pre-wrap;"><?php echo e(!empty($distributor->full_address) ? $distributor->full_address : ''); ?></p> </span></h6>
                                </td>
                                <td><?php echo e($distributor->u_id); ?></td>
                                <td><?php echo e($distributor->phone); ?></td>
                                <td><?php echo e($distributor->email); ?></td>
                                <td><input type="checkbox" data-name="Distributor" data-user_id="<?php echo e($distributor->u_id); ?>" class="user_status" data-toggle="toggle" data-on="Active" data-off="In Active" data-onstyle="success" data-offstyle="danger"  <?php echo e($distributor->user_status==1 ? 'checked' : ''); ?> ></td>
                                <td>
                                   <span class="badge  <?php echo e($distributor->status == '1' ? 'bg-light-success text-success' : 'bg-light-danger text-danger'); ?>"><?php echo e($distributor->status == '0' ? 'Inactive' : 'Active'); ?></span>
                                </td>
                                <td>
                      
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <a href="<?php echo e(route('distributor.show',$distributor->o_id)); ?>" class="text-primary"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i
                                                class="bi bi-eye-fill bg-view"></i></a>
                                        <a href="<?php echo e(route('distributor.edit',$distributor->o_id)); ?>" class="text-warning"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i
                                                class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal"></i></a>
                                        <form action="<?php echo e(route('distributor.destroy',$distributor->o_id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Delete"><i class="bi bi-trash-fill  bg-delete"></i></button>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          

                          

                        </tbody>
       
                    </table>

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
        { "bSortable": false, "aTargets": [7] }, 
    ]
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjal/resources/views/backend/distributor/index.blade.php ENDPATH**/ ?>