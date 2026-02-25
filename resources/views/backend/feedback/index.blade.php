@extends('backend.layouts.master')
@section('content')


  <!--start content-->
  <main class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">{{$type=="customer" ? "Customer " :"Delivery partner " }}Feedback List</div>
	
					<div class="ps-3">
						<!-- <nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>				
								<li class="breadcrumb-item active" aria-current="page">Data Table</li>
							</ol>
						</nav> -->
</div>
<!-- <div class="ms-auto">
						<a class="btn btn-primary mb-3 mb-lg-0" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"><i class="bi bi-plus-square-fill"></i>Add Customer</a>
					</div> -->
</div>
<!--end breadcrumb-->

<!-- <div class="card">
              <div class="card-body">
								<div class="row align-items-center">
									
									<div class="col-lg-9 col-xl-10">
										<form class="float-lg-end">
											<div class="row row-cols-lg-auto g-2">
												<div class="col-12">
													<a href="javascript:;" class="btn btn-light mb-3 mb-lg-0"><i class="bi bi-download"></i>Export</a>
												</div>
												<div class="col-12">
													<a href="javascript:;" class="btn btn-light mb-3 mb-lg-0"><i class="bi bi-upload"></i>Import</a>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
            </div> -->
<!-- <h6 class="mb-0 text-uppercase">DataTable Example</h6>
				<hr/> -->
<div class="card">
	<div class="card-body p-4">
	@if ($message = Session::get('success'))
                    <div class="alert alert-success">{{ $message }}</div>
                @endif
		<div class="table-responsive">
			<table id="example" class="table table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>S.no</th>
						<th>{{$type=="customer" ? "Customer " :"Delivery partner " }} Name</th>
						@if($type=="customer")
    						<th>Rating</th>
    						<th>Liked Feedback</th>
						@endif
						<th>Comments</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				  @foreach($feedbacks as $key=>$feedback)
					<tr>
						<td>{{$key + 1}}</td>
						<td>{{(!empty($feedback->users) ? $feedback->users->name : '')}}</td>
						@if($type=="customer")
    						<td>{{$feedback->rating}}</td>
    						<td>{{$feedback->most_like}}</td>
						@endif
					    <td >  
					 
					        <div class="ms-auto">
                <a class="btn btn-primary mb-3 mb-lg-0 comment" data-val="{{$feedback->explore_next}}"  href="javascript:void(0)">
                    View</a>
            </div>
					    </td>
						<td>
							<div class="table-actions d-flex align-items-center gap-3 fs-6">

								<a href="javascript:;" class="text-warning feedback_mail" data-feedback_id="{{$feedback->id}}" data-customer_id="{{(!empty($feedback->users) ? $feedback->users->id : '')}}" data-bs-toggle="tooltip"
									data-bs-placement="bottom" title="Send Mail"><i class="bi bi-envelope"
										></i></a>
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

<!--send mail-->

<!-- Modal -->
<div class="modal fade" id="send_mail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Feedback</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">
          <form id="feedback_mail">
              @csrf
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="feedback_id" id="feedback_id">
                    <input type="hidden" name="email" id="email">
                    <label>Send Feedback</label>
                    <textarea class="form-control" name="feedback_response"></textarea>
                    <span class="text-danger feedback_response"></span>
                    
                </div>

                
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send Mail</button>
      </div>
     </form>
    </div>
  </div>
</div>





<!-- Modal -->
<div class="modal fade" id="view_comments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Comments</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label>View Comment :</label>
                    <p class="comment_val"></p>
                </div>
                
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    var table =       $('#example').DataTable({

    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [5] }, 
    ]
    });
    

});

$(document).on("click",".feedback_mail",function(e){
    	$('.user_err').html('');
    $('#send_mail').modal('show');
    var id=$(this).data('feedback_id');
    var email=$(this).data('customer_id');
    $('#feedback_id').val(id);
     $('#email').val(email);
  

});

$(document).on("submit","#feedback_mail",function(e){
e.preventDefault();
	var form = $('#feedback_mail')[0];
	var formData = new FormData(form);
	var id=$('#feedback_id').val();
	$('.btn-primary').attr('disabled',true);
	$.ajax({
		url: "{{url('feedback_save')}}/"+id,
		type:'POST',
		processData: false,
		contentType: false,
		data: formData,
		success: function(data) {
		    
    	
    		    $('.btn-primary').attr('disabled',false);
    			window.location.reload();
    		
		},error: function (xhr) {
			$('.btn-primary').attr('disabled',false);
			$('.user_err').html('');
			var i=0;

			$.each(xhr.responseJSON.errors, function(key,value) {

			  //console.log(key);
	
			//console.log(key);
			replaced_key = key.replace(".", "_");
			//console.log(value[0]);
			// console.log(typeof value);
			value = value[0].replace(key,replaced_key);
			//console.log(replaced_key);
			$('.'+replaced_key).append('<div class="text-danger user_err">'+value+'</div');
			i++;
		  }); 
		 },
	});
});

$(document).on("click",".comment",function(){
    var val=$(this).data('val');
    $('#view_comments').modal('show');
    $('.comment_val').html(val);
})
</script>

@endsection