<?php include(__DIR__ . '/../../partial/header.php'); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-xl-7"><img class="bg-img-cover bg-center" src="<?=BASE_PATH?>assets/images/login/2.jpg" alt="loginpage"></div>
    <div class="col-xl-5 p-0">
      <div class="login-card">
        <div>
          <div><a class="logo text-start" href="index.php"><img class="img-fluid for-light" src="<?=BASE_PATH?>assets/images/logo/login.png" alt="loginpage"><img class="img-fluid for-dark" src="<?=BASE_PATH?>assets/images/logo/logo_dark.png" alt="loginpage"></a></div>
          <div class="login-main">
            <form class="theme-form" method="POST">
              <h4>Sign in to account</h4>
              <p>Enter your email & password to login</p>
              <div class="form-group">
                <label class="col-form-label">Email Address</label>
                <input class="form-control" type="email" required="" name="email" placeholder="Test@gmail.com">
              </div>
              <div class="form-group">
                <label class="col-form-label">Password</label>
                <div class="form-input position-relative">
                  <input class="form-control" type="password" name="password" required="" placeholder="*********">
                  <div class="show-hide"><span class="show">                         </span></div>
                </div>
              </div>
              <div class="form-group mb-0">
                <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
              </div>
              <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2" href="sign-up">Create Account</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include(__DIR__ . '/../../partial/scripts.php'); ?>
<?php include(__DIR__ . '/../../partial/footer-end.php'); ?>