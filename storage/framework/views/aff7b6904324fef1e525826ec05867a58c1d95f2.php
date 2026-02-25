
<?php $__env->startSection('content'); ?>
    <!--start content-->
    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Sales Representative</div>
        </div>
        <!----Card Form --->

        <div class="card">
            <div class="card-body p-4">
                <form action="<?php echo e(route('sales-representative.update', $sales_edit->id)); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="mb-2">Name :</label>
                            <input class="form-control" type="text" name="name" value="<?php echo e($sales_edit->name); ?>"
                                placeholder="" aria-label="default input example">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="mb-2">Phone Number :</label>
                            <input class="form-control" type="text" name="phone" value="<?php echo e($sales_edit->phone); ?>"
                                placeholder="" aria-label="default input example">
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="mb-2">Email Id :</label>
                            <input class="form-control" type="text" name="email" value="<?php echo e($sales_edit->email); ?>"
                                placeholder="" aria-label="default input example">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="mb-2">Image</label>
                            <input class="form-control" type="file" name="image" placeholder=""
                                aria-label="default input example">
                                <?php if(!empty($sales_edit->image)): ?>
                            <img src="<?php echo e(asset($sales_edit->image)); ?>" alt="" width="150px" height="150px">
                            <?php endif; ?>
                            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="mb-2">Status :</label>
                            <select class="form-select me-3" name="status">
                                <option value="">-select-</option>
                                <option value="1" <?php echo e($sales_edit->status == '1' ? 'selected' : ''); ?>>Active</option>
                                <option value="0" <?php echo e($sales_edit->status == '0' ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
            </div>
        </div>



    </main>
    <!--end page main-->
<?php $__env->stopSection(); ?>

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
                            <input class="form-control mb-3" type="text" placeholder=""
                                aria-label="default input example" value="1">
                        </div>
                        <div class="col-lg-6">
                            <label>Name</label>
                            <input class="form-control mb-3" type="text" placeholder=""
                                aria-label="default input example" value="Karthik">
                        </div>
                        <div class="col-lg-6">
                            <label>Percentage</label>
                            <input class="form-control mb-3" type="tel" placeholder=""
                                aria-label="default input example" value="20%">
                        </div>
                        <div class="col-lg-6">
                            <label>Coupon Code</label>
                            <input class="form-control mb-3" type="email" placeholder=""
                                aria-label="default input example" value="#98765">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"></button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjalwaters/public_html/resources/views/backend/salesrepresentative/edit.blade.php ENDPATH**/ ?>