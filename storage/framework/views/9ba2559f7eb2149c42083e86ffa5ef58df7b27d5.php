
<?php $__env->startSection('content'); ?>

   <!--start content-->
   <main class="page-content cuustomerinfo">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">View Delivery Agent</div>
<!--              <div class="ms-auto">-->
<!--  <div class="btn-group align-items-center">-->
<!--    <label class="pe-2">-->
<!--      <h6><strong>Status</strong></h6>-->
<!--    </label>-->
<!--    <select class="form-select me-2">-->
<!--      <option>Active</option>-->
<!--      <option>Inactive</option>-->
<!--      <option>Pending</option>-->
<!--    </select>-->
<!--    <button type="button" class="btn btn-primary radius-none">Submit</button>-->
<!--  </div>-->
<!--</div>-->
</div>
<div class="row">
  <div class="col-xl-6 mx-auto">

    <div class="card">
      <div class="card-header">
        <h6 class="mb">Basic Information</h6>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-left" style="width:100%">
          <thead>
          </thead>
          <tbody>
          <tr>
                <th>
                  <h6><strong>Distributor ID</strong></h6>
                </th>
                <td><?php echo e($delivery_view->user_id); ?></td>
              </tr>
            <tr>
              <th>
                <h6><strong>Name of the Shop</strong></h6>
              </th>
              <td><?php echo e($delivery_view->name_of_shop); ?></td>
            </tr>
            <tr>
              <th>
                <h6><strong>Nature of the shop</strong></h6>
              </th>
              <td><?php echo e($delivery_view->nature_of_shop); ?></td>
            </tr>
            <tr>
                <th>
                  <h6><strong>Ownership Status</strong></h6>
                </th>
                <td><?php echo e($delivery_view->ownership_type); ?></td>
              </tr>
            <tr>
              <th>
                <h6><strong>Name of the owner</strong></h6>
              </th>
              <td><?php echo e($delivery_view->name_of_owner); ?></td>
            </tr>
            <tr>
              <th>
                <h6><strong>Contact No</strong></h6>
              </th>
              <td><?php echo e($delivery_view->owner_contact_no); ?></td>
            </tr>
            <tr>
              <th>
                <h6><strong>Email Id</strong></h6>
              </th>
              <td><?php echo e($delivery_view->owner_email); ?></td>
            </tr>
            <tr>
              <th>
                <h6><strong>Pincode</strong></h6>
              </th>
              <td><?php echo e($delivery_view->pincode); ?></td>
            </tr>
            <tr>
              <th>
                <h6><strong>Delivery facility</strong></h6>
              </th>
              <td><?php echo e($delivery_view->delivery_type); ?></td>
            </tr>
            <tr>
              <th>
                <h6><strong>No of delivery persons</strong></h6>
              </th>
              <td><?php echo e($delivery_view->no_of_delivery_boys); ?></td>
            </tr>
            <!-- <tr>
                              <th><h6><strong>Aadhaar Number</strong></h6></th>
                              <td>1234 5678 9012</td>
                            </tr> -->
            <tr>
              <th>
                <h6><strong>GST Registration certificate</strong></h6>
              </th>
              <td>
              <form action="<?php echo e(url('download_file').'/'.$delivery_view->id); ?>" method="GET">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" value="gst_registration" name="type">
                   <button type="submit" class="btn btn-outline-info"><i
                    class="bi bi-cloud-arrow-down-fill"></i>Download</button>
              </form>
              </td>
            </tr>
            <tr>
              <th>
                <h6><strong>Any Govt Registration certificate</strong></h6>
              </th>
              <td>
                <form action="<?php echo e(url('download_file').'/'.$delivery_view->id); ?>" method="GET">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" value="govt_registration" name="type">
                   <button type="submit" class="btn btn-outline-info"><i
                    class="bi bi-cloud-arrow-down-fill"></i>Download</button>
                </form>
              </td>
            </tr>
            <tr>
              <th>
                <h6><strong>Photo of the shop name board with GSTIN</strong></h6>
              </th>
              <td><img src="<?php echo e(asset($delivery_view->shop_photo)); ?>" alt="" width=150></td>
            </tr>
          </tbody>
        </table>
        <h5><strong>Location</strong></h5>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d1993030.0832575762!2d77.80102632908333!3d12.671797327266264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e6!4m3!3m2!1d13.0332923!2d80.2166202!4m5!1s0x3bae695041dc81e3%3A0x99d75f960756b006!2slavenjal!3m2!1d12.779202!2d77.6436244!5e0!3m2!1sen!2sin!4v1671011057797!5m2!1sen!2sin"
          width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>
  <div class="col-xl-6 mx-auto">

    <div class="card">
      <div class="card-header">
        <h6 class="mb">Other Information</h6>
      </div>
      <div class="card-body px-4">
        <div class="row">
          <table class="table table-bordered table-left" style="width:100%">
            <thead>
            </thead>
            <tbody>
              <tr>
                <th>
                  <h6><strong>Complete address of the shop</strong></h6>
                </th>
                <td><?php echo e($delivery_view->full_address); ?></td>
              </tr>
              <tr>
                <th>
                  <h6><strong>Landmark near the shop</strong></h6>
                </th>
                <td><?php echo e($delivery_view->landmark); ?></td>
              </tr>
              <tr>
                <th>
                  <h6><strong>Area of the shop in sq ft</strong></h6>
                </th>
                <td><?php echo e($delivery_view->area_sqft); ?></td>
              </tr>
              <tr>
                <th>
                  <h6><strong>Storage capacity of the water jars</strong></h6>
                </th>
                <td><?php echo e($delivery_view->storage_capacity); ?></td>
              </tr>
              <tr>
                <th>
                  <h6><strong>What brands of 20 Ltrs are sold now</strong></h6>
                </th>
                <td><?php echo e($delivery_view->twenty_ltres_sold_now); ?></td>
              </tr>
              <tr>
                <th>
                  <h6><strong>How many jars are being sold per week</strong></h6>
                </th>
                <td><?php echo e($delivery_view->selling_jars_weekly); ?></td>
              </tr>
              <tr>
                <th>
                  <h6><strong>What brands of pet bottles are sold now</strong></h6>
                </th>
                <td><?php echo e($delivery_view->pet_bottle_sold_now); ?></td>
              </tr>
              <tr>
                <th>
                  <h6><strong>How far can he deliver</strong></h6>
                </th>
                <td><?php echo e($delivery_view->delivery_range); ?></td>
              </tr>
              <tr>
                <th>
                  <h6><strong>How old is the shop</strong></h6>
                </th>
                <td>10Year</td>
              </tr>
              <tr>
                <th>
                  <h6><strong>Geo tagging of the shop in google map</strong></h6>
                </th>
                <td>Location</td>
              </tr>
              <tr>
                <th>
                  <h6><strong>Agreement date</strong></h6>
                </th>
                <td>
                  20-12-2022
                </td>
              </tr>
              <tr>
                <th>
                  <h6><strong>Sales Representative</strong></h6>
                </th>
                <td>
                    <?php echo e($delivery_view->assign_sales_rep); ?>

                </td>
              </tr>
              <tr>
                <th>
                  <h6><strong>Any special requests</strong></h6>
                </th>
                <td>
                    <?php echo e($delivery_view->additional_info); ?>

                </td>
              </tr>  </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</main>
<!--end page main-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjal/resources/views/backend/delivery/view.blade.php ENDPATH**/ ?>