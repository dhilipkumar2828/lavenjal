
<?php $__env->startSection('content'); ?>
    <!--start content-->
    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
 
                    <div class="breadcrumb-title pe-3">City List</div>
                         <form action="<?php echo e(url('unavalaible_city_destroy')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('POST'); ?>
                    <input type="hidden" id="checked_lists" name="checked_lists">
                <div class="row">
                <div class="col-md-12 text-right">
                     <button type="submit" class="btn btn-danger"  style="display:none;margin-left: 55em;"  id="delete_citylists" >Delete</button>
                     

                </div>
                </div>
                </form>
            <!--<div class="ms-auto">-->
            <!--   <a class="btn btn-primary mb-3 mb-lg-0" href="<?php echo e(url('city_add')); ?>">-->
            <!--        <i class="bi bi-plus-square-fill"></i>Add City</a>-->
            <!--</div>-->
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
                                <th><input type="checkbox" class="delete_checkbox check_all"  data-type="all" ></th>
                                <th>S.no</th>
                                 <th>Customer Name</th>
                                <th>Pincode</th>
                                <th>Mobile</th>
                                
                             
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><input type="checkbox" class="delete_checkbox delete_checkbox<?php echo e($city->id); ?>" name="delete_checkbox" data-type="single" value="<?php echo e($city->id); ?>"></td>
                                <td><?php echo e($key+1); ?></td>
                                <td><?php echo e($city->name); ?></td>
                                <td><?php echo e($city->pincode); ?></td>
                                <td><?php echo e($city->mobile); ?></td>
                  
                  
                              
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
        { "bSortable": false, "aTargets": [2] }, 
    ]
    });
});

// $(".delete_checkbox").change(function () {
//     if($(this).data('type') == "all"){
//     $("input:checkbox.delete_checkbox").prop('checked',true);
//     }else{
//         $("input:checkbox.delete_checkbox").prop('checked',false);
//     }
// });

$(".delete_checkbox").click(function(){
    if($(this).data('type')=="all"){
    $('input:checkbox').not(this).prop('checked', this.checked);
    }else{
        var id=$(this).val();
        $('input:checkbox.delete_checkbox'+id).not(this).prop('checked', this.checked);
    }
    
    
    var is_checked=$('.delete_checkbox').is(':checked'); 
    if(is_checked==true){
       $('#delete_citylists').css('display','block'); 
    }else{
        $('#delete_citylists').css('display','none');
    }
    
    var arr = [];
$("input:checkbox[name='delete_checkbox']:checked").each(function(){
    arr.push($(this).val());
});
    $('#checked_lists').val(arr);
    
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjalwaters/public_html/resources/views/backend/city/unavailable_lists.blade.php ENDPATH**/ ?>