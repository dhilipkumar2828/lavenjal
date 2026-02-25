@extends('backend.layouts.master')
@section('content')
    <!--start content-->
    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Sales Representative</div>
            
                        <div class="ms-auto">
                <form action="{{url('import_sales_data')}}" class="d-flex justify-content-end" method="POST" enctype="multipart/form-data">
                           @csrf
                    <input type="file" name="file" class="custom-file-input" id="customFile">
                    <button type="submit" class="btn btn-primary mb-3 mb-lg-0">Import Sales Rep</button> 
                </form>
            </div>
            <div class="ms-auto">
                <form action="{{url('get_sales_data')}}" class="d-flex justify-content-end" method="POST">
                           @csrf
                    <button class="btn btn-primary mb-3 mb-lg-0">Export Sales Rep</button> 
                </form>
            </div>
            
            <div class="ms-auto">
                <a class="btn btn-primary mb-3 mb-lg-0" href="{{ url('sales-representative/create') }}">
                    <i class="bi bi-plus-square-fill"></i>Add Sales Rep</a>
            </div>


        </div>


        <!----Card Form --->
        <div class="card">
            <div class="card-body p-4">
                <div class="">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">{{ $message }}</div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="example" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Name</th>
                                <th>Sales Representative Id</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $key => $sale)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>

                                        <a class="d-flex align-items-center gap-2 imgtable"
                                            >
                                            <div class="product-box">
                                                <img src="{{ asset($sale->image) }}" alt="">
                                            </div>
                                            <div>
                                                <h6 class="mb-0 product-title fw-bold">{{ $sale->name }}</h6>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="disabled">{{ $sale->id }}</td>
                                    <td>{{ $sale->phone }}</td>
                                    <td>{{ $sale->email }}</td>
                                    <td><span class="badge  {{$sale->status == '1' ? 'bg-light-success text-success' : 'bg-light-danger text-danger'}}">{{$sale->status == '2' ? 'Inactive' : 'Active'}}</span>
                                    </td>
                                    <td>
                                        <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a class="text-primary salesrep_view" data-id="{{ $sale->id }}"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i
                                                    class="bi bi-eye-fill bg-view" data-bs-toggle="modal"></i></a>
                                            <a href="{{ route('sales-representative.edit', $sale->id) }}"
                                                class="text-warning" title="Edit" data-bs-toggle="tooltip" data-bs-placement="bottom" ><i
                                                    class="bi bi-pencil-fill bg-edit"></i></a>
                                            <form action="{{ route('sales-representative.destroy', $sale->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-primary " data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Delete"><i
                                                        class="bi bi-trash-fill  bg-delete"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>


    </main>
    <!--end page main-->
@endsection

<!-- Edit -->
<div class="col">
    <!-- Modal -->
    <div class="modal fade" id="salesrep_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sales Representative View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Sales Representative Id</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a class="d-flex align-items-center gap-2 imgtable"
                                           >
                                            <div class="product-box">
                                                <img class="salesrep_image" src="" alt="">
                                            </div>
                                            <div>
                                                <h6 class="mb-0 product-title fw-bold salesrep_name">Karthik</h6>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="disabled salesrep_id"></td>
                                    <td class="salesrep_phone"></td>
                                    <td class="salesrep_email"></td>
                                </tr>
                            </tbody>
                        </table>
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
@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
        $('#example').DataTable({
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [6] }, 
    ]
    });
});
</script>

@endsection