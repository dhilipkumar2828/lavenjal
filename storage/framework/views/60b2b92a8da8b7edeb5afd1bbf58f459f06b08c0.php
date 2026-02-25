<?php $__env->startSection('content'); ?>

<style>
  .login-section{
    height: 100%;
  }
  </style>

<!--start content-->
<main class="authentication-content">
        <div class="container">
            <!-- <div class="card rounded-0 overflow-hidden shadow-none border mb-5 mb-lg-0 p-5"> -->
              <div class="row g-0">
                <div class="col-12 order-1 col-xl-6 d-flex align-items-center justify-content-center border-end">
                  <img src="<?php echo e(asset('assets/images/banner/01.png')); ?>" alt="">
                </div>
                <div class="col-12 col-xl-6 order-xl-2">
                  <div class="card-body p-5 p-sm-5">
                    <a class="app-logo">
                      <center>
                    <img src="<?php echo e(asset('assets/images/lavenjal-logo.png')); ?>" class="logo-icon me-2 text-center" alt="logo icon"></center>
                    </a>
                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                      
                        <div class="row g-3">
                          <div class="col-12">
                            <label for="inputEmailAddress" class="form-label mb-3">Email Address</label>
                            <div class="ms-auto position-relative">
                              <div class="position-absolute top-50 translate-middle-y search-icon px-3 mb-3"><i class="bi bi-envelope-fill"></i></div>
                       

                              <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> radius-30 ps-5" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus placeholder="Email">

                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>
                          </div>
                          <div class="col-12">
                            <label for="inputChoosePassword" class="form-label mb-3">Enter Password</label>
                            <div class="ms-auto position-relative">
                              <div class="position-absolute top-50 translate-middle-y search-icon px-3 mb-3"><i class="bi bi-lock-fill"></i></div>
                 

                              <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> radius-30 ps-5 p-2" name="password" required autocomplete="current-password" placeholder="Password">

                              <input type="hidden" name="user_type" value="admin">

                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked="">
                              <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                            </div>
                            <div class="col-6">
                                <?php if(Route::has('password.request')): ?>
                                        <a class="btn btn-link form-control" href="<?php echo e(route('password.request')); ?>">
                                            <?php echo e(__('Forgot Your Password?')); ?>

                                        </a>
                                    <?php endif; ?>
                            </div>
                          </div>
                          <!-- <div class="col-6 text-end">	<a href="authentication-forgot-password.html">Forgot Password ?</a>
                          </div> -->
                          <div class="col-12">
                            <div class="d-grid">
                              <button type="submit" class="btn btn-primary radius-30 p-2">Login</button>
                            </div>
                          </div>

                          <div class="col-12">
                            <div class="login-separater text-center">
                            </div>
                          </div>
                          <div class="col-12">
                            <!-- <div class="d-flex align-items-center gap-3 justify-content-center">
                              <button type="button" class="btn btn-white text-danger"><i class="bi bi-google me-0"></i></button>
                              <button type="button" class="btn btn-white text-primary"><i class="bi bi-linkedin me-0"></i></button>
                              <button type="button" class="btn btn-white text-info"><i class="bi bi-facebook me-0"></i></button>
                            </div> -->
                          </div>
                          <div class="col-12 text-center">
                            <!-- <p class="mb-0">Don't have an account yet? <a href="authentication-signup-with-header-footer.html">Sign up here</a></p> -->
                          </div>
                        </div>
                    </form>
                 </div>
                </div>
              </div>
            <!-- </div> -->
        </div>
       </main>
        
       <!--end page main-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lavenjalwaters/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>