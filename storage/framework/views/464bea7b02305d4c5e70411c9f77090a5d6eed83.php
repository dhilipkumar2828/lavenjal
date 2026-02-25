
<?php $__env->startSection('content'); ?>
    <!--start content-->
    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Banner Lists</div>
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
                <a class="btn btn-primary mb-3 mb-lg-0" href="<?php echo e(route('banner.create')); ?>">
                    <i class="bi bi-plus-square-fill"></i>Add Banner</a>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">
                    <?php if($message = Session::get('success')): ?>
                        
                        <div class="alert alert-success"><?php echo e($message); ?></div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Banner Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><img src="<?php echo e(asset($banner->photo)); ?>" width=auto height=100/></td>
                                        <td><input type="checkbox" data-banner_id="<?php echo e($banner->id); ?>" class="banner_status" data-toggle="toggle" data-on="Active" data-off="In Active" data-onstyle="success" data-offstyle="danger"  <?php echo e($banner->status=='active' ? 'checked' : ''); ?> ></td>
                                        </td>
                                        <td>
                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                       
                                                <a href="<?php echo e(route('banner.edit', $banner->id)); ?>"   data-bs-toggle="tooltip" data-bs-placement="bottom" class="bg-edit"
                                                    title="Edit"><i class="bi bi-pencil-fill"
                                                        data-bs-target="#exampleLargeModal1"></i></a>
                                                <form action="<?php echo e(route('banner.destroy', $banner->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-primary"   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i
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
    </main>
    <!--end page main-->
<?php $__env->stopSection(); ?>

<!-- View -->
<div class="col">
    <!-- Modal -->
    <div class="modal fade" id="product_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="product_title">Lavenjal 20L Jar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col commoncardheader">
                        <div class="card shadow-none">
                            <!-- <div class="card-header">
                                <h6 class="mb">Customer</h6>
                                </div> -->
                            <div class="order-invoice card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <!-- <div class="icon-box bg-light-primary border-0">
                                <i class="bi bi-person text-primary"></i>
                              </div> -->
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label col-6 col-sm-5 ">Size :</label>
                                            <span class="product_size"></span>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label col-6 col-sm-5 ">Price :</label>
                                            <span class="product_price"></span>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label col-6 col-sm-5 product_status">Status :</label>
                                            <span class="badge bg-light-success text-success product_status"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Submit</button> -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>

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
        { "bSortable": false, "aTargets": [3] }, 
    ]
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mithra/Downloads/lavenjal_backup/resources/views/backend/banners/index.blade.php ENDPATH**/ ?>