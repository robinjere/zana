<?= $this->extend('./layout/main') ?> 
<?= $this->section('content') ?>

<div class="position-relative d-flex flex-column align-items-center justify-content-center vw-100 login overflow-hidden">
  <div class="position-absolute login__bg">
    <img src="/assets/login-bg.jpg" class="login__bg--image"/> 
  </div>
    <!-- <div class="heading-block">
      <h1 class="bg-white login-heading text-uppercase text-center my-4">Welcome to <?= $clinic['name'] ?></h1>
    </div>/heading-block  -->
    <div class="mb-4 d-flex" style="z-index: 99;">
      <img src="<?= getenv('CLIENT_LOGO') ?>" alt="logo">
    </div><!-- /d-flex -->

  <div class="position-relative w-100">
    <div class="container login-layout mb-2">

        <div class="d-flex flex-column justify-start py-20 px-14 login__form">
          <div class="login__form--header login-form-space-y mb-4">
               <h4 class="text-uppercase"> login </h4>
               <span> </span>
          </div>

          <!-- form -->
          <form method="post" >
            <!-- DISPLAY SUCCESS MESSAG  -->
            <?php if(session()->get('success')): ?>
              <div class="alert alert-success" role="alert" style="max-width: 20rem;"> 
                 <?= session()->get('success'); ?>
              </div>
            <?php endif; ?>
            <!-- DISPLAY SUCCESS MESSAG  -->

            <!-- WARNING AND ERROR AREA -->
            <?php if(isset($validation)): ?>
              
              <div class="my-3 pt-3 box-alert warning-alert d-flex align-items-start" >
                <div class="icon-alert px-3"> 
                    <svg viewBox="0 0 51 50" fill="none">
                        <path d="M7.77416 42.8087C5.342 40.5119 3.40202 37.7644 2.06742 34.7266C0.732827 31.6888 0.0303434 28.4215 0.000961476 25.1155C-0.0284205 21.8094 0.615887 18.5307 1.89629 15.4707C3.17669 12.4107 5.06755 9.63062 7.45853 7.29278C9.8495 4.95493 12.6927 3.1061 15.8223 1.85415C18.9518 0.602201 22.305 -0.0277889 25.6863 0.000940109C29.0675 0.0296691 32.409 0.716541 35.5159 2.02148C38.6227 3.32641 41.4326 5.22328 43.7817 7.6014C48.4203 12.2974 50.9871 18.587 50.929 25.1155C50.871 31.6439 48.1929 37.8889 43.4715 42.5054C38.7501 47.1219 32.3631 49.7405 25.6863 49.7973C19.0094 49.854 12.5769 47.3443 7.77416 42.8087ZM40.1911 39.298C44.0137 35.5603 46.1612 30.4909 46.1612 25.2051C46.1612 19.9192 44.0137 14.8498 40.1911 11.1122C36.3685 7.37451 31.1839 5.27471 25.7779 5.27471C20.3719 5.27471 15.1873 7.37451 11.3647 11.1122C7.54211 14.8498 5.39459 19.9192 5.39459 25.2051C5.39459 30.4909 7.54211 35.5603 11.3647 39.298C15.1873 43.0356 20.3719 45.1354 25.7779 45.1354C31.1839 45.1354 36.3685 43.0356 40.1911 39.298ZM23.2314 27.695V22.7152H28.3244V37.6546H23.2314V27.695ZM23.2314 12.7555H28.3244V17.7353H23.2314V12.7555Z" fill="#FB5A77"/>
                    </svg>
                </div>
                <div class="message-alert"> 
                    <h2 class="mb-2"> Errors occurs. </h2>
                    <!-- <p> Please contact with your system admins to confirm your information </p> -->
                    <?= $validation->listErrors() ?>
                </div>
              </div><!-- box-alert -->

          <?php endif; ?>
          <!-- WARNING AND ERROR AREA -->

            <div class="login-form-space-y">
                <label for="InputEmail1" class="form-label">Your Email</label>
                <div class="input-with-icon position-relative">
                  <img src="/assets/icons/email.png" class="icon"/>   
                  <input type="email" name="email" value="<?= set_value('email'); ?>" class=" form-control" placeholder="enter your email" id="InputEmail1" aria-describedby="email">
                </div>
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <div class="login-form-space-y">
                <label for="InputPassword" class="form-label">Your Password </label>
                <div class="input-with-icon position-relative">
                  <img src="/assets/icons/password-lock.png" class="icon" style="width: 18px; top: 0.59rem !important;"/>   
                  <input type="password" name="password" value="<?= set_value('password'); ?>" class=" form-control" placeholder="enter your password" id="InputPassword" aria-describedby="password">
                </div>
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>

            <!-- <div class="login-form-space-y form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <div class="mt-4 d-flex justify-content-center align-items-center">
              <button type="submit" class="w-75 btn btn-success mt-3">Login</button>
            </div>
            <!-- <a href="/account/forgot" class="d-flex justify-content-end forgot-password-link"> 
              <div class="align-self-end form-text d-flex align-items-center">
                <p class="mb-0"> Forgot your Password? </p>
                <svg class="d-arrow pl-2" viewBox="0 0 17 16" fill="none">
                    <path d="M5.1863 1.80135L15.0316 2.83613M15.0316 2.83613L13.9968 12.6814M15.0316 2.83613L1.04294 14.1639" stroke="#0B0B0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </a> -->

            </form>
          <!-- endForm -->
        
        </div>
        <!-- creat account link  -->
          <!-- <div class="account-link">
            <div class="login__form--header login-form-space-y ">
                <h4 class="text-uppercase"> Create account </h4>
                <span> </span>
            </div>

            <h5>Don’t Have an Account yet?</h5>
            <p>Follow the link below to  create an account and Admins will able to verify your account details</p>

            <div class="mt-4 d-flex justify-content-end align-items-center">
              <a href="/account/registration" class=" btn btn-outline-white btn-rounded btn-arr">
                Register
                <svg class="d-arrow pl-2" viewBox="0 0 17 16" fill="none">
                    <path d="M5.1863 1.80135L15.0316 2.83613M15.0316 2.83613L13.9968 12.6814M15.0316 2.83613L1.04294 14.1639"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>
            </div>
          </div> -->
        <!-- creat account link  -->
    </div>  <!-- /position-relative -->

  </div>
  <p class="login-copy"> &copy; Allright reserved </p>
</div>

  <div class="position-relative">
    <?= view_cell('\App\Libraries\AdminPanel::footer') ?>
  </div>

<?= $this->endSection('content') ?>

