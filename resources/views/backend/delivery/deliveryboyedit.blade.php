@extends('backend.layouts.master')
@section('content')

   <!--start content-->
   <main class="page-content cuustomerinfo">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">  
              <div class="breadcrumb-title pe-3">Add Delivery Boy</div>
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
                                <h6><strong>Name of the Shop</strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control" type="text" placeholder=""
                                        aria-label="default input example" value="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Nature of the shop</strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control" type="text" placeholder=""
                                        aria-label="default input example" value="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Ownership status</strong></h6>
                            </th>
                            <td>
                                <div>
                                <div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
  <label class="form-check-label" for="flexRadioDefault1">
  Sole Proprietorship
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
  <label class="form-check-label" for="flexRadioDefault2">
Partnership
  </label>
</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Name of the owner</strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control" type="text" placeholder=""
                                        aria-label="default input example" value="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Contact No</strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control" type="text" placeholder=""
                                        aria-label="default input example" value="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Email Id</strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control" type="text" placeholder=""
                                        aria-label="default input example" value="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Pincode</strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control" type="text" placeholder=""
                                        aria-label="default input example" value="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Delivery facility</strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control" type="text" placeholder=""
                                        aria-label="default input example" value="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>No of delivery persons</strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control" type="text" placeholder=""
                                        aria-label="default input example" value="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Aadhaar Number</strong></h6>
                            </th>
                            <td>
                                <div>
                                    <input class="form-control" type="text" placeholder=""
                                        aria-label="default input example" value="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>GST Registration certificate</strong></h6>
                            </th>
                            <td>
                                <form class="dropzone needsclick file-upload" id="demo-upload" action="/upload">
                                    <div class="dz-message needsclick">
                                        <i class="bi bi-download"></i>
                                        <span class="d-block">Upload File</span>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Any Govt Registration certificate</strong></h6>
                            </th>
                            <td>
                                <form class="dropzone needsclick file-upload" id="demo-upload" action="/upload">
                                    <div class="dz-message needsclick">
                                        <i class="bi bi-download"></i>
                                        <span class="d-block">Upload File</span>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h6><strong>Photo of the shop name board with GSTIN</strong></h6>
                            </th>
                            <td>
                                <!-- <img src="{{asset('backend/assets/images/avatars/avatar-1.png')}}" alt=""> -->
                                <form class="dropzone needsclick file-upload" id="demo-upload" action="/upload">
                                    <div class="dz-message needsclick">
                                        <i class="bi bi-download"></i>
                                        <span class="d-block">Upload Image</span>
                                    </div>
                                </form>
                            </td>
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
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-left" style="width:100%">
                            <tbody>
                                <tr>
                                    <th>
                                        <h6><strong>Landmark near the shop</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Area of the shop in sq ft</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Storage capacity of the water jars</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>What brands of 20 Ltrs are sold now</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>How many jars are being sold per week</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>What brands of pet bottles are sold now</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>How far can he deliver</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>How old is the shop</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Geo tagging of the shop in google map</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Agreement date</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Any special requests</strong></h6>
                                    </th>
                                    <td>
                                        <div>
                                            <input class="form-control" type="text" placeholder=""
                                                aria-label="default input example" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Assign Sales Representative</strong></h6>
                                    </th>
                                    <td>
                                     <div class=" select2-sm">
										
										<select class="single-select">
											<option value="United States">Select Representative</option>
											<option value="United Kingdom">Karthick</option>
											<option value="Afghanistan">Ram</option>
											<option value="Aland Islands">Aland </option>
										</select>
									</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h6><strong>Status</strong></h6>
                                    </th>
                                    <td>
                                        <select class="form-select me-2">
                                            <option>Active</option>
                                            <option>Inactive</option>
                                            <option>Pending</option>
                                        </select>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary float-right"> Submit</button>

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
                                            <input class="form-control mb-3" type="tel" placeholder="" aria-label="default input example"></div> -->
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
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<!--end page main-->

@endsection