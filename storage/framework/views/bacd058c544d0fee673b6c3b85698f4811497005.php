
<?php $__env->startSection('content'); ?>
<main class="page-content">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card mt-3">
                <div class="card-body">
                    <?php if(session('status')): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo e(session('status')); ?>

                    </div>
                    <?php endif; ?>
                    <form action="<?php echo e(route('send.web-notification')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label>Message Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Message Body</label>
                            <textarea class="form-control" name="body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                            <button type="button" onclick="startFCM()" class="btn btn-danger btn-flat startFCM">Allow notification
                </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>            
<!-- The core Firebase JS SDK is always required and must be listed first -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
  const firebaseConfig = {
    apiKey: "AIzaSyBgHf2b1scHNT9SjpUcPrNfKdHc6VGrfvU",
    authDomain: "lavenjal-1a0f1.firebaseapp.com",
    projectId: "lavenjal-1a0f1",
    storageBucket: "lavenjal-1a0f1.appspot.com",
    messagingSenderId: "288696626576",
    appId: "1:288696626576:web:c354bcaf3b79c0c8ad5715",
    measurementId: "G-KE920V3D87"
  };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    function startFCM() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '<?php echo e(route("store.token")); ?>',
                    type: 'POST',
                    data: {
                        token: response
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Token stored.');
                    },
                    error: function (error) {
                        alert(error);
                    },
                });
            }).catch(function (error) {
                alert(error);
            });
    }
    messaging.onMessage(function (payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjal/resources/views/backend/push_notification.blade.php ENDPATH**/ ?>