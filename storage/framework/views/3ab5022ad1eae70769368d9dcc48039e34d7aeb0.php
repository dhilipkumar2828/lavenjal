
<?php $__env->startSection('content'); ?>
    <!--start content-->
    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Delivery Agent Maps</div>

        </div>
        
        <div id="map" style="width: 900px; height: 400px;"></div>

 
        </main>
        
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>


 <script type="text/javascript">
 
 
 
  
  

    var lat_lang= <?php echo json_encode($delivery_lists); ?>;
    var base_url=$('meta[name="base_url"]').attr('content');
    for(var j=0;j<lat_lang.length;j++){

    var locations = [
      ['Bondi Beach', lat_lang[j]['lat'],lat_lang[j]['lang'], 4],
    ];
    
    
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(lat_lang[j]['lat'], lat_lang[j]['lang']),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    }
    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    for (i = 0; i < lat_lang.length; i++) {  
        //console.log(lat_lang[i]['user_type']=="distributor");
          if(lat_lang[i]['user_type']=="distributor"){
          
          //  var map_icon=base_url+"/backend/assets/images/pin.png"; 
           var map_icon="http://maps.google.com/mapfiles/ms/icons/pink-dot.png";
        }
        else{
            var map_icon="http://maps.google.com/mapfiles/ms/icons/red-dot.png";
        }

    



//   const infowindow = new google.maps.InfoWindow({
//     content: contentString,
//     ariaLabel: "Uluru",
//   });
  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng( lat_lang[i]['lat'],  lat_lang[i]['lang']),
        map: map,
        icon: {
              url:map_icon, 
            }, 
        title:lat_lang[i]['shop_name'],
        
        
      });
      
      infoWindow = new google.maps.InfoWindow({
    content: "<i class='fa fa-spinner fa-spin fa-lg' style='color: #FFA46B;' title='Loading...'></i> Loading..."
});

      
     var mkID=lat_lang[i]['id'];
google.maps.event.addListener(marker, 'click', (function(marker, infoWindow, mkID) {
    return function() {
        if(infoWindow) {
            infoWindow.close();
        }
        infoWindow.open(map, marker);
        infoWindowAjax(mkID, function(data) {
            infoWindow.setContent(data);
        });
    };
})(marker, infoWindow, mkID));
      

  
    }
  function infoWindowAjax(mkID, callback) {

    return $.ajax({
        url: "<?php echo e(url('get_kms/')); ?>/"+mkID,
        
    })
    .done(callback)
    .fail(function(jqXHR, textStatus, errorThrown) {
        alert(errorThrown);
    });
}  
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjal/resources/views/backend/delivery/map.blade.php ENDPATH**/ ?>