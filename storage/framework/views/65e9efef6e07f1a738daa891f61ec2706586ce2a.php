
<?php $__env->startSection('content'); ?>
    <!--start content-->
    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Pincode List</div>

                        
            <div class="ms-auto">
                <form action="<?php echo e(url('import_pincode_data')); ?>" class="d-flex justify-content-end" method="POST" enctype="multipart/form-data">
                           <?php echo csrf_field(); ?>
                    <input type="file" name="import_pincode" class="custom-file-input" id="customFile">
                    <button type="submit" class="btn btn-primary mb-3 mb-lg-0">Import Pincode</button> 
                </form>
            </div>
            
            <!--<div class="ms-auto">-->
            <!--    <form action="<?php echo e(url('get_pincode_data')); ?>" class="d-flex justify-content-end" method="POST">-->
            <!--               <?php echo csrf_field(); ?>-->
            <!--        <button class="btn btn-primary mb-3 mb-lg-0">Export Pincode</button> -->
            <!--    </form>-->
            <!--</div>-->
            
            <div class="ms-auto">
               <a class="btn btn-primary mb-3 mb-lg-0" href="<?php echo e(url('pincode_add')); ?>">
                    <i class="bi bi-plus-square-fill"></i>Add Pincode</a>
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
                                <th>City</th>
                                <th>Pincode</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $pincodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$pincode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><?php echo e(!empty($pincode->cities->city) ? $pincode->cities->city : ''); ?></td>
                                <td><?php echo e($pincode->pincode); ?></td>
                                <td><input type="checkbox" data-pincode_id="<?php echo e($pincode->id); ?>" data-name="Pincode" class="pincode_status" data-toggle="toggle" data-on="Active" data-off="In Active" data-onstyle="success" data-offstyle="danger"  <?php echo e($pincode->status=='active' ? 'checked' : ''); ?> ></td>
                  
                                <td>
                                
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
       
                                        <a href="<?php echo e(url('pincode_edit',$pincode->id)); ?>" class="text-warning"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i
                                                class="bi bi-pencil-fill bg-edit" data-bs-toggle="modal"></i></a>
                                        <form action="<?php echo e(url('pincode_destroy',$pincode->id)); ?>" method="POST">
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
                        <!-- <tfoot>
             <tr>
              <th>Name</th>
              <th>Position</th>
              <th>Office</th>
              <th>Age</th>
              <th>Start date</th>
              <th>Salary</th>
             </tr>
            </tfoot> -->
                    </table>
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
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Name</label>
                            <input class="form-control mb-3" type="text" placeholder=""
                                aria-label="default input example" value="Karthik">
                        </div>
                        <div class="col-lg-6">
                            <label>Shop Name</label>
                            <input class="form-control mb-3" type="text" placeholder=""
                                aria-label="default input example" value="Lavenjal">
                        </div>
                        <div class="col-lg-6">
                            <label>Phone Number</label>
                            <input class="form-control mb-3" type="tel" placeholder=""
                                aria-label="default input example" value="9876543210">
                        </div>
                        <div class="col-lg-6">
                            <label>Email Id</label>
                            <input class="form-control mb-3" type="email" placeholder=""
                                aria-label="default input example" value="karthik@gmail.com">
                        </div>
                        <div class="col-lg-6">
                            <label>Aadhaar Number</label>
                            <input class="form-control mb-3" type="tel" placeholder=""
                                aria-label="default input example" value="1234 5678 9012">
                        </div>
                        <div class="col-lg-6">
                            <label>Shop Address</label>
                            <textarea class="form-control mb-3">Ashok Pillar, Chennai.</textarea>
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
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
$(document).ready(function() {
        $('#example').DataTable({
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [4] }, 
    ]
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjal/resources/views/backend/pincode/index.blade.php ENDPATH**/ ?>