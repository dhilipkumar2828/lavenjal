                    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <a class="dropdown-item" href="#">
                      <div class="d-flex align-items-center">
                         <img src="<?php echo e(asset($notification->user_img)); ?>" alt="" class="rounded-circle" width="52" height="52">
                         
                         <div class="ms-3 flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0 dropdown-msg-user"><?php echo e($notification->user_name); ?> </h6>
                                <div>
                                    <button class="btn btn-primary messages close-notification" data-type="single_user" data-view_type="" data-id="<?php echo e($notification->id); ?>">x</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small style="white-space: break-spaces;" class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center"><?php echo e($notification->message); ?></small>
                                <span class="msg-time float-end text-secondary"><?php echo e(Helper::notification_timing($notification->created_at)); ?></span>
                            </div>
                           
                           
                         </div>
                      </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/lavenjalwaters/public_html/resources/views/backend/notifications.blade.php ENDPATH**/ ?>