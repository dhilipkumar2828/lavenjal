
    setTimeout(()=>{
      $('.alert-success').css('display','none');
    },3000)


$('.product_view').click(function(){
    $('#product_modal').modal('show');
    var id= $(this).data('id');
    // alert(id);
    var token=$('meta[name="csrf-token"]').attr('content');
    var path=$('meta[name="base_url"]').attr('content')+'/products/'+id;
    // alert(token);
    // alert(path);
    $.ajax({
        url:path,
        method:"GET",
        data:{_token:token, id:id},
        success:function(data){
            // console.log(data.value);
            $('.product_title').text(data.product['name']);
            $('.product_price').text(data.product['customer_price']);
            $('.product_size').text(data.product['size']);
           
            if(data.product['status']=="active"){
                   var html= '<span class="badge bg-light-success text-success product_status">Active</span>';
            }else{
                  var html= '<span class="badge bg-light-danger text-danger product_status">Inactive</span>';
            }
             $('.product_status').html(html);
        }

    });
})

$('.salesrep_view').click(function(){
    $('#salesrep_modal').modal('show');
    var id = $(this).data('id');
             $('.salesrep_name').text("");
            $('.salesrep_phone').text("");
            $('.salesrep_email').text("");
            $('.salesrep_image').attr('src',"");
            $('.salesrep_id').text("");
    var token=$('meta[name="csrf-token"]').attr('content');
    var path=$('meta[name="base_url"]').attr('content')+'/sales-representative/'+id;
    $.ajax({
        url:path,
        method:'GET',
        data:{_token:token, id:id},
        success:function(data){
            // console.log(data.details);
            $('.salesrep_name').text(data.sales['name']);
            $('.salesrep_phone').text(data.sales['phone']);
            $('.salesrep_email').text(data.sales['email']);
            $('.salesrep_image').attr('src',data.sales['image']);
            $('.salesrep_id').text(data.sales['id']);
        }
    });

})

$(document).on("click",".customer_edit",function(){

    var customer_id=$(this).data('customer_id');
    var token=$('meta[name="csrf-token"]').attr('content');
    var path=$('meta[name="base_url"]').attr('content')+'/customer/'+customer_id+'/edit';
    var update_customerurl=$('meta[name="base_url"]').attr('content')+'/customer/'+customer_id;


    $.ajax({
        url:path,
        method:'GET',
        data:{_token:token, customer_id:customer_id},
        success:function(data){
            $('#exampleLargeModal1').modal('show');
            $('#M_customer_name').val(data.user.name);
            $('#M_phone').val(data.user.phone);
            $('#M_email').val(data.user.email);
            $('#M_status').val(data.user.status);
            $('#update_customer').attr('data-customer_id',customer_id);
            $('#update_customer').attr('action',update_customerurl)
        }
    });
})


$(document).on("submit","#update_customer",function(e){
    e.preventDefault();
    var customer_id=$(this).data('customer_id');
    var token=$('meta[name="csrf-token"]').attr('content');
    // var path=$(this).attr('action');
    var path=$('meta[name="base_url"]').attr('content')+'/customer/'+customer_id;
    var redirect_url=$('meta[name="base_url"]').attr('content')+'/customer';

    $.ajax({
        url:path,
        method:'PUT',
        data:{_token:token, customer_id:customer_id,name:$('#M_customer_name').val(),phone:$('#M_phone').val(),email:$('#M_email').val(),status:$('#M_status').val()},
        success:function(data){
       
            if(data.success==true){
              window.location=redirect_url;
            }
        },error: function (xhr) {
            $('.err').html('');
            $.each(xhr.responseJSON.errors, function(key,value) {
              $('.'+key).append('<div class="text-danger err">'+value+'</div');
          });
         },
    });
})

  
    $(document).on('change','.user_status',function(){
    var token=$('meta[name="csrf-token"]').attr('content');
    // var path=$(this).attr('action');
    var path=$('meta[name="base_url"]').attr('content')+'/update_status';
    var user_id=$(this).data('user_id');
    var name=$(this).data('name');
    $.ajax({
        url:path,
        method:'POST',
        data:{_token:token, user_id:user_id,name:name},
        success:function(data){
            
        }
    });  
    })
    
    
    
        $(document).on('change','.pincode_status',function(){
            var token=$('meta[name="csrf-token"]').attr('content');
            // var path=$(this).attr('action');
            var path=$('meta[name="base_url"]').attr('content')+'/pincode_status';
            var pincode_id=$(this).data('pincode_id');
        $.ajax({
            url:path,
            method:'POST',
            data:{_token:token, pincode_id:pincode_id},
            success:function(data){
                
            }
        });  
    })
    
    
            $(document).on('change','.city_status',function(){
            var token=$('meta[name="csrf-token"]').attr('content');
            // var path=$(this).attr('action');
            var path=$('meta[name="base_url"]').attr('content')+'/city_status';
            var city_id=$(this).data('city_id');
        $.ajax({
            url:path,
            method:'POST',
            data:{_token:token, city_id:city_id},
            success:function(data){
                
            }
        });  
    })
    
    
    
        $(document).on('change','.banner_status',function(){
    var token=$('meta[name="csrf-token"]').attr('content');
    // var path=$(this).attr('action');
    var path=$('meta[name="base_url"]').attr('content')+'/banner_status';
    var banner_id=$(this).data('banner_id');
    $.ajax({
        url:path,
        method:'POST',
        data:{_token:token,banner_id:banner_id},
        success:function(data){
            
        }
    });  
    })
            $(document).on('click','.ordertabs',function(){
            var token=$('meta[name="csrf-token"]').attr('content');
            var path=$('meta[name="base_url"]').attr('content')+'/order_details';
            var order_status=$(this).data('order_status');
            var user_type=$(this).data('user_type');
            var customer_orderurl=$('meta[name="base_url"]').attr('content')+'/customer-orders';
         $.ajax({
              url:path,
              method:'POST',
              data:{
                  _token:token,
                  order_status:order_status,
                  start_date:$('#start_date').val(),
                  end_date:$('#end_date').val(),
                  time_slot:$('#time_slot').val(),
                  user_type:user_type
                  },
              success:function(data){
                       var order_count=data.orders.length;
            //console.log(data.candidates);
               $('.order_table').empty("");
            for(var i=0; i<order_count;i++)
            {
           
                var filter = '<tr class="candidate_row"><td>'+(i+1)+'</td><td> <div><a href='+customer_orderurl+"/"+data.orders[i]['order_id']+'><h6 class="mb-0">#'+data.orders[i]['order_id']+'</h6></a><p class="opacity-50 mb-0">Order Date : '+data.orders[i]['created_at']+'</p></div></td><td>'+data.orders[i]['name']+'</td><td><a href='+customer_orderurl+"/"+data.orders[i]['order_id']+' class="text-danger">'+data.orders[i]['assigned_delivery']+'</a></td><td><span class="">'+data.orders[i]['delivery_date']+' / '+data.orders[i]['delivery_time']+'</span></td><td><a href='+customer_orderurl+' class="text-danger"><span class="badge status-orderplace">'+data.orders[i]['order_status']+'</span></a> </td><td><div class="table-actions d-flex align-items-center gap-3 fs-6"><a href='+customer_orderurl+"/"+data.orders[i]['order_id']+' class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill bg-view"></i></a></div> </td></tr>';
                $('.order_table').append(filter);
            }
              }
          }); 
          })

$(document).on("click",".search_data",function(){
               var token=$('meta[name="csrf-token"]').attr('content');
            var path=$('meta[name="base_url"]').attr('content')+'/get_reportlists';
            var user_type=$(this).data('user_type');

         $.ajax({
              url:path,
              method:'POST',
              data:{
                  _token:token,
                  user_type:user_type,
                  start_date:$('#start_date').val(),
                  end_date:$('#end_date').val(),
                  time_slot:$('#time_slot').val(),
                  },
              success:function(data){
                $('.table_render').html(data.table);
              }
          });  
})




