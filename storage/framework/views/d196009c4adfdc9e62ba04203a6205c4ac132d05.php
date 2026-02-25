
<?php $__env->startSection('content'); ?>

   <!--start content-->
   <main class="page-content cuustomerinfo">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Edit Delivery Partner</div>
              <div class="ms-auto">
    <!--  <div class="btn-group align-items-center">-->
    <!--    <label class="pe-2">-->
    <!--        <h6><strong>Status: </strong></h6>-->
    <!--    </label>-->
    <!--    <select class="form-select me-3">-->
    <!--        <option>Pending</option>-->
    <!--        <option>Approved</option>-->

    <!--    </select>-->

    <!--    <button type="type" class="btn btn-primary">Submit</button>-->
    <!--</div>-->
</div>
</div>
<div class="row">
    <div class="col-xl-6 mx-auto">
    <form  enctype="multipart/form-data" id="delivery_form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
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
                                <h6><strong>Name of the Shop <span class="text-danger">*</span></strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control mb-3" type="text" placeholder=""
                                        aria-label="default input example" value="<?php echo e($delivery_edit->name_of_shop); ?>" id="name_of_shop" name="name_of_shop" >
                                    
                                    
                                </div>
                            <span class="name_of_shop"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Nature of the shop <span class="text-danger">*</span></strong></h6>
                            </th>
                            <td>
                                <div>
                                    <!--<input class="form-control mb-3" type="text" value="<?php echo e($delivery_edit->nature_of_shop); ?> " placeholder=""-->
                                    <!--    aria-label="default input example" name="nature_of_shop" >-->
                                    
                                    <select class="form-control" name="nature_of_shop">
                                        <option value="">Select nature</option>
                                        <option value="Super Market" <?php echo e(($delivery_edit->nature_of_shop || old('nature_of_shop')) == "Super Market" ? 'selected' : ''); ?> >Super Market</option>
                                        <option value="General Store" <?php echo e(($delivery_edit->nature_of_shop || old('nature_of_shop')) == "General Store" ? 'selected' : ''); ?>>General Store</option>
                                        <option value="Bakery" <?php echo e($delivery_edit->nature_of_shop == "Bakery" ? 'selected' : ''); ?>>Bakery</option>
                                        <option value="Others" <?php echo e($delivery_edit->nature_of_shop == "Others" ? 'selected' : ''); ?>>Others</option>
                                    </select>
                                </div>
                              <span class="nature_of_shop"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Ownership status <span class="text-danger">*</span></strong></h6>
                            </th>
                            <td>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"  name="ownership_type"
                                            id="flexRadioDefault1" value="Proprietorship"   <?php echo e(($delivery_edit->ownership_type || old('ownership_type')) == 'Proprietorship' ? 'checked' : ''); ?>>
                                            
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Sole Proprietorship
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"  name="ownership_type"
                                            id="flexRadioDefault2" value="Partnership" <?php echo e($delivery_edit->ownership_type == 'Partnership' ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Partnership
                                        </label>
                                    </div>
                                </div>
                           <span class="ownership_type"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Name of the owner <span class="text-danger">*</span></strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('name_of_owner'))?$delivery_edit->name_of_owner : old('name_of_owner')); ?>"  name="name_of_owner" placeholder=""
                                        aria-label="default input example" value="">
                                </div>
                              <span class="name_of_owner"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Contact No <span class="text-danger">*</span></strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('owner_contact_no'))?$delivery_edit->owner_contact_no :old('owner_contact_no')); ?> " name="owner_contact_no" placeholder=""
                                        aria-label="default input example" value="" onkeypress="return isNumber(event)" >
                                </div>
                               <span class="owner_contact_no"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Email Id <span class="text-danger">*</span></strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('owner_email'))?$delivery_edit->owner_email : old('owner_email')); ?> " name="owner_email" placeholder=""
                                        aria-label="default input example" value="">
                                </div>
                               <span class="owner_email"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Address <span class="text-danger">*</span></strong></h6>
                            </th>
                            <td>
                                <div>
                                    <textarea class="form-control mb-3" type="text" placeholder=""
                                        aria-label="default input example" rows="3" name="full_address" cols="3"><?php echo e(empty(old('full_address'))?$delivery_edit->full_address :old('full_address')); ?> </textarea>
                                </div>
                                <span class="full_address"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Pincode <span class="text-danger">*</span></strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('pincode'))?$delivery_edit->pincode :old('pincode')); ?>" name="pincode" placeholder=""
                                        aria-label="default input example" onkeypress="return isNumber(event)" >
                                </div>
                                     <span class="pincode"></span>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <h6><strong>Aadhar Number </strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('aadhar_number'))?$delivery_edit->aadhar_number :old('aadhar_number')); ?>" name="aadhar" placeholder=""
                                        aria-label="default input example" onkeypress="return isNumber(event)" >
                                </div>
                               <span class="aadhar_number"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Delivery facility </strong></h6>
                            </th>
                            <td>
                                <div>
                                    <!--<input class="form-control mb-3" type="text" value="<?php echo e($delivery_edit->delivery_type); ?> " name="delivery_type" placeholder=""-->
                                    <!--    aria-label="default input example" value="">-->
                                    
                                       <select class="form-control" name="delivery_type">
                                        <option value="">Select facility</option>
                                        <option value="2 Wheeler" <?php echo e(($delivery_edit->delivery_type || old('delivery_type'))== "2 Wheeler" ? 'selected' : ''); ?>>2 Wheeler</option>
                                        <option value="3 Wheeler" <?php echo e(($delivery_edit->delivery_type || old('delivery_type') )== "3 Wheeler" ? 'selected' : ''); ?>>3 Wheeler</option>
                                    </select>
                                </div>
                                <span class="delivery_type"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>No of delivery persons </strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('no_of_delivery_boys'))?$delivery_edit->no_of_delivery_boys:old('no_of_delivery_boys')); ?>" name="no_of_delivery_boys" placeholder=""
                                        aria-label="default input example" >
                                </div>
                               <span class="no_of_delivery_boys"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>GST No </strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('gst_no'))?$delivery_edit->gst_no:old('gst_no')); ?> " name="gst_no" placeholder=""
                                        aria-label="default input example" >
                                </div>
                               <span class="gst_no"></span>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <h6><strong>GST Registration certificate (Pdf,Docx)</strong></h6>
                            </th>
                            <td>
                                
                                    <div class="dz-message needsclick">
                                        <!--<i class="bi bi-download"></i>-->
                                        <input type="file" name="gst_certificate" id="" class="form-control">
                                        <span class="file_name"><?php echo e(!empty($delivery_edit->gst_certificate)?$delivery_edit->gst_certificate:''); ?></span>
                                    </div>
                                
                                <span class="gst_certificate"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Any Govt Registration certificate (Pdf,Docx)</strong></h6>
                            </th>
                            <td>
                                
                                    <div class="dz-message needsclick">
                                     
                                        <input type="file" name="govt_certificate" id="" class="form-control">
                                         <span class="file_name"><?php echo e(!empty($delivery_edit->govt_certificate)?$delivery_edit->govt_certificate:''); ?></span>
                                    </div>
                                
                               <span class="govt_certificate"></span>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <h6><strong>Business certificate  (jpeg,jpg,png,gif)</strong></h6>
                            </th>
                            <td>
                                
                                    <div class="dz-message needsclick">
                                        
                                        <input type="file" name="business_certificate" id="" class="form-control">
                                        <span class="file_name"><?php echo e(!empty($delivery_edit->business_certificate)?$delivery_edit->business_certificate:''); ?></span>
                                    </div>
                                
                                <span class="business_certificate"></span>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <h6><strong>Photo of the shop name board with GSTIN</strong></h6>
                            </th>
                            <td>
                                <!-- <img src="<?php echo e(asset('backend/assets/images/avatars/avatar-1.png')); ?>" alt=""> -->
                                
                                    <div class="dz-message needsclick">
                                   
                                        <input type="file" name="shop_photo" id="">
                                        <span class="d-block">Upload Image</span>
                                        <img src="<?php echo e(asset($delivery_edit->shop_photo)); ?>" style="display:<?php echo e(!empty($delivery_edit->shop_photo)   ? 'block' : 'none'); ?>" alt="" width="150px" height="150px">
                                    </div>
                                
                               <span class="shop_photo"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!--<h5><strong>Location</strong></h5>-->
              
                <!--<iframe-->
                <!--    src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d1993030.0832575762!2d77.80102632908333!3d12.671797327266264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e6!4m3!3m2!1d13.0332923!2d80.2166202!4m5!1s0x3bae695041dc81e3%3A0x99d75f960756b006!2slavenjal!3m2!1d12.779202!2d77.6436244!5e0!3m2!1sen!2sin!4v1671011057797!5m2!1sen!2sin"-->
                <!--    width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy"-->
                <!--    referrerpolicy="no-referrer-when-downgrade" ></iframe>-->
            </div>
        </div>
    </div>
    <div class="col-xl-6 mx-auto">

        <div class="card">
            <div class="card-header">
                <h6 class="mb">Other Information</h6>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-left" style="width:100%">
                            <tbody>
                                <tr>
                                    <th>
                                        <h6><strong>Latitude <span class="text-danger">*</span></strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" type="text" name="lat" placeholder=""
                                                aria-label="default input example" id="lat" value="<?php echo e(empty(old('lat'))?$delivery_edit->lat : old('lat')); ?>">
                                        </div>
                                         <span class="lat"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Longitude</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" type="text" name="lang" placeholder=""
                                                aria-label="default input example" id="lang" value="<?php echo e(empty(old('lang'))?$delivery_edit->lang : old('lang')); ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Landmark near the shop </strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" type="text" name="landmark" value="<?php echo e(empty(old('landmark'))?$delivery_edit->landmark:old('landmark')); ?> " placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                       <span class="landmark"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Area of the shop in sq ft </strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('area_sqft'))?$delivery_edit->area_sqft:old('area_sqft')); ?> " name="area_sqft" placeholder=""
                                                aria-label="default input example" >
                                        </div>
                                        <span class="area_sqft"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Storage capacity of the water jars </strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('storage_capacity'))?$delivery_edit->storage_capacity : old('storage_capacity')); ?>" name="storage_capacity" placeholder=""
                                                aria-label="default input example" >
                                        </div>
                                        <span class="storage_capacity"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>What brands of 20 Ltrs are sold now </strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" type="text"  value="<?php echo e(empty(old('twenty_ltres_sold_now'))?$delivery_edit->twenty_ltres_sold_now:old('twenty_ltres_sold_now')); ?> "name="twenty_ltres_sold_now" placeholder=""
                                                aria-label="default input example">
                                        </div>
                                        <span class="twenty_ltres_sold_now"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>How many jars are being sold per week </strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('selling_jars_weekly'))?$delivery_edit->selling_jars_weekly:old('selling_jars_weekly')); ?>" name="selling_jars_weekly" placeholder=""
                                                aria-label="default input example">
                                        </div>
                                        <span class="selling_jars_weekly"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>What brands of pet bottles are sold now </strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('pet_bottle_sold_now'))?$delivery_edit->pet_bottle_sold_now:old('pet_bottle_sold_now')); ?>" name="pet_bottle_sold_now" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                       <span class="pet_bottle_sold_now"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>How far can he deliver </strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" type="text" value="<?php echo e(empty(old('delivery_range'))?$delivery_edit->delivery_range:old('delivery_range')); ?> " name="delivery_range" placeholder=""
                                                aria-label="default input example">
                                        </div>
                                         <span class="delivery_range"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>How old is the shop </strong></h6>
                                    </th>
                                    <?php $shop_started_at = date_create($delivery_edit->shop_started_at); ?>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" name="shop_started_at" type="date" placeholder=""
                                                aria-label="default input example" value="<?php echo e(date_format($shop_started_at,"Y-m-d")); ?>">
                                        </div>
                                           <span class="shop_started_at"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Geo tagging of the shop in google map</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Agreement date </strong></h6>
                                    </th>
                                    <?php $agreement_date = date_create($delivery_edit->agreement_date); ?>
                                    <td>
                                        <div id="">
                                            <input class="form-control mb-3" type="date" name="agreement_date" placeholder=""
                                                aria-label="default input example" value="<?php echo e(date_format($agreement_date,'Y-m-d')); ?>">
                                        </div>
                                       <span class="agreement_date"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Any special requests </strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control mb-3" type="text" name="additional_info" placeholder=""
                                                aria-label="default input example" value="<?php echo e(empty(old('additional_info'))?$delivery_edit->additional_info: old('additional_info')); ?> ">
                                        </div>
                                       <span class="additional_info"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Assign Sales Representative <span class="text-danger">*</span></strong></h6>
                                    </th>
                                    <td>
                                     <div class="mb-3 select2-sm">

										<select class="single-select" name="assign_sales_rep">
                                            <option value="">-select-</option>
											<?php $__currentLoopData = $sales_rep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($sale->id); ?>" <?php echo e($delivery_edit->assign_sales_rep  == $sale->id ? 'selected' :''); ?>><?php echo e($sale->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
									</div>
                                     <span class="assign_sales_rep"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        <h6><strong>Assign Distributor <span class="text-danger">*</span></strong></h6>
                                    </th>
                                    <td>
                                     <div class="mb-3 select2-sm">

										<select class="single-select" name="assigned_distributor">
                                            <option value="">-select-</option>
											<?php $__currentLoopData = $distributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($distributor->id); ?>" <?php echo e($delivery_edit->assigned_distributor == $distributor->id ? 'selected' :''); ?>><?php echo e($distributor->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>

									</div>
                                     <span class="assigned_distributor"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        <h6><strong>Status <span class="text-danger">*</span></strong></h6>
                                    </th>
                                    <td>
                                        <select class="form-select me-2" name="status">
                                            <option value="">-select-</option>
                                            <option value="1" <?php echo e($delivery_edit->status == '1' ? 'selected' : ''); ?>>Active</option>
                                            <option value="0" <?php echo e($delivery_edit->status == '0' ? 'selected' : ''); ?>>Inactive</option>
                                            
                                        </select>
                                        <span class="status"></span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary float-right"> Update</button>

                        <!-- <label class="mb-3">Complete address of the shop</label>
                                            <textarea class="form-control mb-3"></textarea></div>
                                            <div class="col-lg-12">
                                            <label class="mb-3">Landmark near the shop</label>
                                            <input class="form-control mb-3" type="text" placeholder="" aria-label="default input example"></div> -->
                        <!-- <div class="col-lg-12">
                                            <label class="mb-3">Area of the shop in sq ft</label>
                                            <input class="form-control mb-3" type="tel" placeholder="" aria-label="default input example"></div> -->
                        <!-- <div class="col-lg-12">
                                            <label class="mb-3">Storage capacity of the water jars</label>
                                            <input class="form-control mb-3" type="text" placeholder="" aria-label="default input example"></div> -->
                        <!-- <div class="col-lg-12">
                                            <label class="mb-3">What brands of 20 Ltrs are sold now</label>
                                            <input class="form-control mb-3" type="tel" placeholder=                            "" aria-label="default input example"></div> -->
                        <!-- <div class="col-lg-12">
                                            <label class="mb-3">How many jars are being sold per week</label>
                                            <input class="form-control mb-3" type="text" placeholder="" aria-label="default input example"></div> -->
                        <!-- <div class="col-lg-12">
                                            <label class="mb-3">What brands of pet bottles are sold now</label>
                                            <input class="form-control mb-3" type="tel" placeholder="" aria-label="default input example"></div> -->
                        <!-- <div class="col-lg-12">
                                            <label class="mb-3">How far can he deliver</label>
                                            <input class="form-control mb-3" type="text" placeholder="" aria-label="default input example"></div> -->
                        <!-- <div class="col-lg-12">
                                            <label class="mb-3">How old is the shop</label>
                                            <input class="form-control mb-3" type="text" placeholder="" aria-label="default input example"></div> -->
                        <!-- <div class="col-lg-12">
                                            <label class="mb-3">Geo tagging of the shop in google map</label>
                                            <input class="form-control mb-3" type="tel" placeholder="" aria-label="default input example"></div> -->
                        <!-- <div class="col-lg-12">
                                            <label class="mb-3">Agreement date</label>
                                            <input type="date" class="form-control mb-3"></div> -->
                        <!-- <div class="col-lg-12">
                                            <label class="mb-3">Any special requests</label>
                                            <textarea class="form-control mb-3"></textarea>
                                            <button type="submit" class="btn btn-primary">Submit</button> -->
                    </div>
                </form>
                     
                </div>
            </div>
                 
        </div>
    <div id="map" style="width: 500px; height: 400px;"></div>
    </div>
   
</div>


</main>
<!--end page main-->

<?php $__env->stopSection(); ?>
   

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">

$(document).ready(function(){

})
    $(function() {
      $('#datetimepicker2').datetimepicker({
        language: 'en',
        pick12HourFormat: true
      });
    });
    
        $('#delivery_form').submit(function(e){
    e.preventDefault();
     var form = $('#delivery_form')[0];
        var formData = new FormData(form);
        $.ajax({
            url: "<?php echo e(route('delivery_agent.update',$delivery_edit->id)); ?>",
            type:'POST',
              processData: false,
            contentType: false,
            data: formData,
            success: function(data) {
                window.location.href="<?php echo e(url('delivery_agent')); ?>"
            },error: function (xhr) {
    
                $('.user_err').html('');
                $.each(xhr.responseJSON.errors, function(key,value) {
                  $('.'+key).append('<div class="text-danger user_err">'+value+'</div');
              }); 
             },
        });
})


// function initMap() {
      

// var name=$('#name_of_shop').val();
//  const myLatLng = { lat: lat, lng:lang };
//  //  const myLatLng = { lat: 12.8765806, lng: 77.6392533 };
//   const map = new google.maps.Map(document.getElementById("map"), {
//     zoom: 18,
//      center: myLatLng,
//   });

//   new google.maps.Marker({
//     position: myLatLng,
//     map,
//     title: name,
//   });
// }
// ;
// window.initMap = initMap;

  </script>
 <script type="text/javascript">
 var lat=Number($('#lat').val());
 var name=$('#name_of_shop').val();
var lang=Number($('#lang').val());
    var locations = [
      ['Bondi Beach', lat,lang, 4]
    ];
    
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 20,
      center: new google.maps.LatLng(lat, lang),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    
    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    
    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        title: name,
      });
      
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjal/resources/views/backend/delivery/edit.blade.php ENDPATH**/ ?>