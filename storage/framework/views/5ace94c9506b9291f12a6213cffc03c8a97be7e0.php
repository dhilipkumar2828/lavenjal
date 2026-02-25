
<?php $__env->startSection('content'); ?>
    <style>
        .activeTab {
            display: block;
        }

        .dropzone {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #eff4ef;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.375rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            min-height: 120px !important;
        }
    </style>

    <!--start content-->
    <main class="page-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Edit Banner</div>
            <div class="ps-3">

            </div>

        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card p-3">
                    <div class="row">
                        
                    </div>

                    
                    <form action="<?php echo e(route('banner.update', $banner->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="mb-2">Banner Image :</label>
                                <input class="form-control" type="file" name="photo" value="<?php echo e($banner->name); ?>"
                                    placeholder="" aria-label="default input example">
                                    <img src="<?php echo e(asset($banner->photo)); ?>" height=100 width=auto alt="banner image">
                                <?php $__errorArgs = ['photo'];
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
                                 <select class="form-control" name="status" id="status">
                                     <option value="">Select Status</option>
                                     <option value="active" <?php echo e($banner->status  == 'active' ? 'selected' : ''); ?>>Active</option>
                                    <option value="inactive"  <?php echo e($banner->status  == 'inactive' ? 'selected' : ''); ?>>In Active</option>
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
                          
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                
                        </div>
                </div>
                <form>
                    

                    

                    

                    



                    
                    


                    

            </div>

            


        </div>
    </div>
</div>
    </main>
    <!--end page main-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjal/resources/views/backend/banners/edit.blade.php ENDPATH**/ ?>