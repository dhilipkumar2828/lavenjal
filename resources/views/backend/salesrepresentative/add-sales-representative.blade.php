@extends('backend.layouts.master')
@section('content')
    <!--start content-->
    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Sales Representative</div>
        </div>

        <!----Card Form --->

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('sales-representative.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="mb-2">Name :</label>
                            <input class="form-control" type="text" name="name" value="{{ old('name') }}"
                                placeholder="" aria-label="default input example">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="mb-2">Phone Number :</label>
                            <input class="form-control" type="text" name="phone" value="{{ old('phone') }}"
                                placeholder="" aria-label="default input example">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="mb-2">Email Id :</label>
                            <input class="form-control" type="text" name="email" value="{{ old('email') }}"
                                placeholder="" aria-label="default input example">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="mb-2">Image</label>
                            <input class="form-control" type="file" name="image" placeholder=""
                                aria-label="default input example">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="mb-2">Status :</label>
                            <select class="form-select me-3" name="status">
                                <option value="">-select-</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
            </div>
        </div>



    </main>
    <!--end page main-->
@endsection

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
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
