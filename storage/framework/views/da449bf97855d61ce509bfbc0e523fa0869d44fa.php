<!doctype html>
<html lang="en" class="semi-dark">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
  <meta name="base_url" content="<?php echo e(url('/')); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo e(asset('backend/assets/images/favicon-32x32.png')); ?>" type="image/png" />
  <!--plugins-->
  <link href="<?php echo e(asset('backend/assets/plugins/simplebar/css/simplebar.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/metismenu/css/metisMenu.min.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/select2/css/select2.min.css')); ?>"  rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/plugins/select2/css/select2-bootstrap4.css')); ?>"  rel="stylesheet" />
	<!-- <link href="assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" /> -->
  <!-- Bootstrap CSS -->
  <link href="<?php echo e(asset('backend/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/css/bootstrap-extended.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/css/style.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('backend/assets/css/icons.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('backend/assets/css/dropzone.css')); ?>" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link href="<?php echo e(asset('backend/assets/css/noty.css')); ?>" rel="stylesheet" />
  <!-- loader-->
	<link href="<?php echo e(asset('backend/assets/css/pace.min.css')); ?>" rel="stylesheet" />

  <!--Theme Styles-->
  <link href="<?php echo e(asset('backend/assets/css/semi-dark.css')); ?>" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" integrity="sha512-WWc9iSr5tHo+AliwUnAQN1RfGK9AnpiOFbmboA0A0VJeooe69YR2rLgHw13KxF1bOSLmke+SNnLWxmZd8RTESQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"
      rel="stylesheet"
    />

    
    <link href="<?php echo e(asset('backend/assets/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <title>Lavenjal : SLV Beverages </title>
</head>
<style>
    /* Preloder */
#preloder {
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999999;
    background:#ffffffbd;
}

.loader {
    width: 50px;
    height: 50px;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -20px;
    margin-left: -20px;
    border-radius: 60px;
    animation: loader 0.8s linear infinite;
    -webkit-animation: loader 0.8s linear infinite;
}

@keyframes loader {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
        border: 4px solid #056d4d;      
        /* border: 4px solid #f44336; */
        border-left-color: transparent;
    }
    50% {
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
        border: 4px solid #056d4d;
        /* border: 4px solid #673ab7; */
        border-left-color: transparent;
    }
    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
        border: 4px solid #056d4d;
        border-left-color: transparent;
    }
}

@-webkit-keyframes loader {
    0% {
        -webkit-transform: rotate(0deg);
        border: 4px solid #056d4d;
        border-left-color: transparent;
    }
    50% {
        -webkit-transform: rotate(180deg);
        border: 4px solid #056d4d;
        border-left-color: transparent;
    }
    100% {
        -webkit-transform: rotate(360deg);
        border: 4px solid #056d4d;
        border-left-color: transparent;
    }
}

       .bootstrap-tagsinput .tag {
      margin-right: 2px;
      color: white !important;
      background-color: #0d6efd;
      padding: 0.2rem;
    } 
    .bootstrap-tagsinput input{
        width:100em !important;
    }
    
</style>
<body>
    		<div id="preloder">
			<div class="loader"></div>
		</div>
      <!--start wrapper-->
  <div class="wrapper login-section">
<?php if(\Route::currentRouteName() != 'login' && \Route::currentRouteName() != 'sales-login'): ?>
<?php echo $__env->make('backend.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>


<?php echo $__env->yieldContent('content'); ?>
 <!-- Bootstrap bundle JS -->
 <script src="<?php echo e(asset('backend/assets/js/bootstrap.bundle.min.js')); ?>"></script>
  <!--plugins-->
  <script src="<?php echo e(asset('backend/assets/js/jquery.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/simplebar/js/simplebar.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/metismenu/js/metisMenu.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/easyPieChart/jquery.easypiechart.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/peity/jquery.peity.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/pace.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')); ?>"></script>
	<script src="<?php echo e(asset('backend/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/apexcharts-bundle/js/apexcharts.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/datatable/js/jquery.dataTables.min.js')); ?>"></script>
	<script src="<?php echo e(asset('backend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')); ?>"></script>
	<script src="<?php echo e(asset('backend/assets/js/table-datatable.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/icons-feather-icons.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/plugins/select2/js/select2.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/form-select2.js')); ?>"></script>
  <!--app-->
  <script src="<?php echo e(asset('backend/assets/js/app.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/index2.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/dropzone.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/dropzone-script.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/assets/js/main.js')); ?>"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker-standalone.css" integrity="sha512-wT6IDHpm/cyeR3ASxyJSkBHYt9oAvmL7iqbDNcAScLrFQ9yvmDYGPZm01skZ5+n23oKrJFoYgNrlSqLaoHQG9w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  
  <script src="<?php echo e(asset('backend/assets/js/bootstrap-datetimepicker.min.js')); ?>"></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
     <!--<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCCX4rxZW4aRNvLsIuI_8fr7IL4XBjzBkQ&libraries=places" ></script>-->
     <!--<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDTSBZf-ou394xq5d-d6yehNxuTMDqt9W4&libraries=places"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
 <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="<?php echo e(asset('backend/assets/js/noty.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/assets/js/custom.js')); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
   <script src="https://maps.google.com/maps/api/js?key=AIzaSyAMWBCScrGIa5WPe9VB39Kiz_ER7M363uM" 
          type="text/javascript"></script>
<?php echo $__env->yieldContent('scripts'); ?>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function(){
  setTimeout(()=>{

    },3000)
})
    $(document).on("click",".messages",function(){
$("#preloder").fadeIn();
         $.ajax({
            url: "<?php echo e(url('update_notifications')); ?>",
            type: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                type:$(this).data('type'),
                id:$(this).data('id'),
                view_type:$(this).data('view_type'),
            },
            success: function (response) {
                $("#preloder").fadeOut();
                if(view_type==""){
                      $('.show_notifications').html("");
               
              var html='';
              for(var i=0;i<response.notifications.length;i++){
              html+='<a class="dropdown-item" href="#"><div><div class="d-flex align-items-center">';
              html+='<img src='+response.notifications[i]['user_img']+' alt="" class="rounded-circle" width="52" height="52"><div class="ms-3 flex-grow-1"><div class="d-flex justify-content-between">';
              html+='<div><h6 class="mb-0 dropdown-msg-user">'+response.notifications[i]['user_name']+' </h6><small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center" style="white-space: break-spaces;">'+response.notifications[i]['message']+'</small></div><button class="btn btn-primary messages close-notification" data-view_type="" data-type="single_user" data-id='+response.notifications[i]['id']+'>x</button>';
              html+='</div></div></div></a><hr>';
            }
      
            $('.show_notifications').html(html);
                }
            },
        });
    })
    
    
    $(document).on("click",".view_all",function(){
        $("#preloder").fadeIn();
        $.ajax({
            url: "<?php echo e(url('view_notifications')); ?>",
            type: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
            },
            success: function (response) {
                $("#preloder").fadeOut();
              $('#notification_model').modal('show');
              $('.show_notifications').html("");
               var url="<?php echo e(asset('/')); ?>";
              var html='';
              for(var i=0;i<response.notifications.length;i++){
                  if(response.notifications[i]['message']!=null){
                      var msg=response.notifications[i]['message'];

                  }else{
                     
                      var msg="";
                  }
              html+='<a class="dropdown-item" href="#"><div><div class="d-flex align-items-center">';
              html+='<img src='+url+response.notifications[i]['user_img']+' alt="" class="rounded-circle" width="52" height="52"><div class="ms-3 flex-grow-1"><div class="d-flex justify-content-between">';
              html+='<div><h6 class="mb-0 dropdown-msg-user">'+response.notifications[i]['user_name']+' </h6><small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center" style="white-space: break-spaces;">'+msg+'</small></div><button class="btn btn-primary messages close-notification" data-view_type="" data-type="single_user" data-id='+response.notifications[i]['id']+'>x</button>';
              html+='</div></div></div></a><hr>';
            }
      
            $('.show_notifications').html(html);
        },
    })
 })
</script>

  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('3cb8fd24827957fe7f59', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {

  
        
         $.ajax({
            url: "<?php echo e(url('pusher_notifications')); ?>",
            type: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
            },
            success: function (response) {
                
                $('.notification_render').html(response.notification_render);
                  $('.show_notifications').html("");
                
              var html='';
              for(var i=0;i<response.notifications.length;i++){
                  if(response.notifications[i]['message']!=null){
                      var msg=response.notifications[i]['message'];
                  }else{
                      var msg="";
                  }
              html+='<a class="dropdown-item" href="#"><div><div class="d-flex align-items-center">';
              html+='<img src='+response.notifications[i]['user_img']+' alt="" class="rounded-circle" width="52" height="52"><div class="ms-3 flex-grow-1"><div class="d-flex justify-content-between">';
              html+='<div><h6 class="mb-0 dropdown-msg-user">'+response.notifications[i]['user_name']+' </h6><small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">'+msg+'</small></div><button class="btn btn-primary messages close-notification" data-view_type="" data-type="single_user" data-id='+response.notifications[i]['id']+'>x</button>';
              html+='</div></div></div></a><hr>';
            }
      
            $('.show_notifications').html(html);
                $('.notification_count').html(response.count_noty);
                
                
            },
        });
    });
    
    $(document).on("click",".modal_close",function(){
        $('#notification_model').modal('hide');
    })
    
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
  </script>
  
  
  </body>
  </html>
<?php /**PATH /home/lavenjalwaters/public_html/resources/views/backend/layouts/master.blade.php ENDPATH**/ ?>