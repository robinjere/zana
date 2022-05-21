<?= $this->extend('dashboard/main') ?> 
<?= $this->section('data') ?>

<div class="d-flex flex-column justify-content-center align-items-center registration-layout">


  <div class="my-5 registration-form container">

     
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

<?php elseif(session()->get('success')): ?>
   <div class="alert alert-success">
      <?= session()->get('success'); ?>
   </div>

 <?php elseif(!$userInfo['is_info_confirmed']): ?>
    <!-- WARNING AND ERROR AREA -->
    <div class="my-3 pt-3 box-alert warning-alert d-flex align-items-start" >
      <div class="icon-alert px-3"> 
          <svg viewBox="0 0 51 50" fill="none">
             <path d="M7.77416 42.8087C5.342 40.5119 3.40202 37.7644 2.06742 34.7266C0.732827 31.6888 0.0303434 28.4215 0.000961476 25.1155C-0.0284205 21.8094 0.615887 18.5307 1.89629 15.4707C3.17669 12.4107 5.06755 9.63062 7.45853 7.29278C9.8495 4.95493 12.6927 3.1061 15.8223 1.85415C18.9518 0.602201 22.305 -0.0277889 25.6863 0.000940109C29.0675 0.0296691 32.409 0.716541 35.5159 2.02148C38.6227 3.32641 41.4326 5.22328 43.7817 7.6014C48.4203 12.2974 50.9871 18.587 50.929 25.1155C50.871 31.6439 48.1929 37.8889 43.4715 42.5054C38.7501 47.1219 32.3631 49.7405 25.6863 49.7973C19.0094 49.854 12.5769 47.3443 7.77416 42.8087ZM40.1911 39.298C44.0137 35.5603 46.1612 30.4909 46.1612 25.2051C46.1612 19.9192 44.0137 14.8498 40.1911 11.1122C36.3685 7.37451 31.1839 5.27471 25.7779 5.27471C20.3719 5.27471 15.1873 7.37451 11.3647 11.1122C7.54211 14.8498 5.39459 19.9192 5.39459 25.2051C5.39459 30.4909 7.54211 35.5603 11.3647 39.298C15.1873 43.0356 20.3719 45.1354 25.7779 45.1354C31.1839 45.1354 36.3685 43.0356 40.1911 39.298ZM23.2314 27.695V22.7152H28.3244V37.6546H23.2314V27.695ZM23.2314 12.7555H28.3244V17.7353H23.2314V12.7555Z" fill="#FB5A77"/>
          </svg>
      </div>
      <div class="message-alert"> 
          <h2 class="mb-2"> User account is not activated  yet. </h2>
          <p> Confirm his/her  access to the  system. </p>
      </div>
   </div>
   <!-- WARNING AND ERROR AREA -->
 <?php endif; ?>
 <!-- WARNING AND ERROR AREA -->

 <?php if(!$userInfo['is_active']): ?>
    <!-- WARNING AND ERROR AREA -->
    <div class="my-3 pt-3 box-alert warning-alert d-flex align-items-start" >
      <div class="icon-alert px-3"> 
          <svg viewBox="0 0 51 50" fill="none">
             <path d="M7.77416 42.8087C5.342 40.5119 3.40202 37.7644 2.06742 34.7266C0.732827 31.6888 0.0303434 28.4215 0.000961476 25.1155C-0.0284205 21.8094 0.615887 18.5307 1.89629 15.4707C3.17669 12.4107 5.06755 9.63062 7.45853 7.29278C9.8495 4.95493 12.6927 3.1061 15.8223 1.85415C18.9518 0.602201 22.305 -0.0277889 25.6863 0.000940109C29.0675 0.0296691 32.409 0.716541 35.5159 2.02148C38.6227 3.32641 41.4326 5.22328 43.7817 7.6014C48.4203 12.2974 50.9871 18.587 50.929 25.1155C50.871 31.6439 48.1929 37.8889 43.4715 42.5054C38.7501 47.1219 32.3631 49.7405 25.6863 49.7973C19.0094 49.854 12.5769 47.3443 7.77416 42.8087ZM40.1911 39.298C44.0137 35.5603 46.1612 30.4909 46.1612 25.2051C46.1612 19.9192 44.0137 14.8498 40.1911 11.1122C36.3685 7.37451 31.1839 5.27471 25.7779 5.27471C20.3719 5.27471 15.1873 7.37451 11.3647 11.1122C7.54211 14.8498 5.39459 19.9192 5.39459 25.2051C5.39459 30.4909 7.54211 35.5603 11.3647 39.298C15.1873 43.0356 20.3719 45.1354 25.7779 45.1354C31.1839 45.1354 36.3685 43.0356 40.1911 39.298ZM23.2314 27.695V22.7152H28.3244V37.6546H23.2314V27.695ZM23.2314 12.7555H28.3244V17.7353H23.2314V12.7555Z" fill="#FB5A77"/>
          </svg>
      </div>
      <div class="message-alert"> 
          <h2 class="mb-2"> This user account is Suspended or Blocked. </h2>
          <p> Due to allowed reason, The account can be unblocked. </p>
      </div>
   </div>
   <!-- WARNING AND ERROR AREA -->
 <?php endif; ?>
 <!-- WARNING AND ERROR AREA -->


    <div class="registration-form__heading d-flex justify-content-between align-items-center mb-3">
   
           <nav class="nav justify-content-center|justify-content-end">
             <a class="nav-link active"  href="<?= base_url() ?>/user/info/<?= $userInfo['id']; ?>"> User Information </a>  
             <?php if(in_array('can_view_user_permission', session()->get('permission'))){?>
                  <a class="nav-link not-active" href="<?= base_url() ?>/user/permission/<?= $userInfo['id']; ?>"> User Permission  </a>  
             <?php } ?>
           </nav>
      
         <div class="d-flex align-items-center">
           <a href="/user/list" class="me-2 btn btn-outline-primary btn-rounded"> Back </a>
         </div>

    </div> <!-- /registration-form__heading -->
     <div class="registration-form__form">
         <form method="POST" >
             <div class="row registration-space-y">   
               <div class="col">
                 <input type="text"  value="<?= set_value('first_name', $userInfo['first_name']); ?>" name="first_name" class="form-control" placeholder="First name" aria-describedby="firstname">
                </div>
               <div class="col">
                 <input type="text"  value="<?= set_value('last_name', $userInfo['last_name']); ?>" name="last_name" class="form-control" placeholder="Last name" aria-describedby="last name">
                </div>
             </div><!-- /row -->
             <div class="row registration-space-y">   
               <div class="col">
                 <input type="text"  value="<?= set_value('father_name', $userInfo['father_name']); ?>" name="father_name" class="form-control" placeholder="Father name" aria-describedby="father name">
                </div>
               <div class="col d-flex align-items-center">
                   <div class="form-check" style="margin-right: 19px;">
                       <label class="form-check-label">
                       <input type="radio" value="Male" <?= set_value('sex', $userInfo['sex']) === 'Male'? 'checked' : null ?> class="form-check-input" name="sex" >
                        Male
                     </label>
                   </div>
                   <div class="form-check">
                       <label class="form-check-label">
                       <input type="radio"  value="Female" <?= set_value('sex', $userInfo['sex']) === 'Female'? 'checked': null ?> class="form-check-input" name="sex" >
                        Female
                     </label>
                   </div>
                </div><!-- /check-box-group -->
            </div><!-- /row -->

            <div class="row registration-space-y">   
                <div class="col">
                    <input type="text" name="email"  value="<?= set_value('email', $userInfo['email']); ?>" class="form-control" placeholder="Email" aria-describedby="email">
                    </div>
                <div class="col">
                    <input type="text" name="phone_number"  value="<?= set_value('phone_number', $userInfo['phone_number']); ?>" class="form-control" placeholder="Phone number" aria-describedby="Phone number">
                </div>
            </div><!-- /row -->

            <div class="registration-space-y">
                 <input type="text" name="address"  value="<?= set_value('address', $userInfo['address']); ?>" class="form-control" placeholder="Address" aria-describedby="address">
            </div>

             <div class="registration-space-y">
                <label for="Inputpass" class="form-label"> Assign multiple role to this user </label>
                <span class="line"> </span>
                
                <select class="form-control" name="role" id="">
                      <option> Select role </option>
                      <?php foreach($roles as $role): ?> 
                        <option <?= set_value('role', $userRole['role_id']) == $role['id'] ? 'selected': ''; ?> value="<?= $role['id'] ?>"> <?= $role['name']; ?> </option>
                      <?php endforeach; ?> 
                  </select>
            </div> <!-- /registration-space-y -->

            <div class="row mt-3">
                 <div class="col">
                               
                     <a href="/user/list" class="btn btn-warning btn-rounded"> Cancel </a>
                </div>
                 <div class="col d-flex justify-content-end">
                   <?php if(session()->get('id') === $userInfo['id']): ?>
                      <button class="btn btn-primary btn-rounded" style="width: 8rem;"> Update </button>
                   <?php endif; ?>
                </div>
            </div><!-- /row -->
         </form><!-- /form -->
     </div> <!-- /registration-form__form -->

  </div><!-- /registration-form -->
</div><!-- /registration-layout --->

<?= $this->endSection('') ?>

