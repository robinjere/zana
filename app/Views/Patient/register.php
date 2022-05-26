<?= $this->extend('Dashboard/main'); ?>
<?= $this->section('data'); ?>
   <?php $PatientPanel = '\App\Libraries\PatientPanel';  ?>
   <h2 class="data-heading mb-3">Patient</h2>

<div class="data-layout my-2 p-3 bg-white">
   <?= view_cell($PatientPanel.'::PatientNavigation'); ?>

   <div class="registration-form__form">
           <form method="post">
          
             <div class="row registration-space-y">   
               <div class="col">
                 <input type="text" name="first_name" value="<?= set_value('first_name')?>" class="form-control" placeholder="First name" aria-describedby="firstname">
                </div>
               <div class="col">
                 <input type="text" name="last_name" value="<?= set_value('last_name')?>" class="form-control" placeholder="Last name" aria-describedby="last name">
                </div>
             </div><!-- /row -->
             <div class="row registration-space-y">   
               <div class="col">
                 <input type="text" name="father_name" value="<?= set_value('father_name')?>" class="form-control" placeholder="Father name" aria-describedby="father name">
                </div>
               <div class="col d-flex align-items-center">
                   <div class="form-check" style="margin-right: 19px;">
                       <label class="form-check-label">
                       <input type="radio" class="form-check-input" name="sex" value="Male" <?= set_value('sex') == 'Male'? 'checked': '' ?> />
                        Male
                     </label>
                   </div>
                   <div class="form-check">
                       <label class="form-check-label">
                       <input type="radio" class="form-check-input" name="sex" value="Female" <?= set_value('sex') == 'Female'? 'checked': '' ?> />
                        Female
                     </label>
                   </div>
                </div><!-- /check-box-group -->
            </div><!-- /row -->

            <div class="row registration-space-y">   
                <div class="col">
                    <input type="text" name="email" value="<?= set_value('email') ?>"  class="form-control" placeholder="Email" aria-describedby="email">
                    </div>
                <div class="col">
                    <input type="text" name="phone_number" value="<?= set_value('phone_number') ?>" class="form-control" placeholder="Phone number" aria-describedby="Phone number">
                </div>
            </div><!-- /row -->

            <div class="registration-space-y">
                 <input type="text" name="address" value="<?= set_value('address') ?>" class="form-control" placeholder="Address" aria-describedby="address">
            </div>

            <div class="registration-space-y">   
                  <!-- <label for="" class="form-label"></label> -->
                  <select class="form-control" name="role" id="">
                      <option> Select role </option>
                  </select>
             </div><!-- /row -->

            <div class="registration-space-y">
                <label for="Inputpass" class="form-label">Your account Password</label>
                <!-- <span class=line""> </span> -->
                <div class="row"> 
                    <div class="col">
                      <input type="password" id="Inputpass" name="password" class=" form-control" placeholder="enter your password"  aria-describedby="password">
                    </div>
                    <div class="col">
                      <input type="password" name="password_confirm" class=" form-control" placeholder="confirm your password"  aria-describedby="confirm password">
                    </div>
                </div>
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div> <!-- /registration-space-y -->

            <div class="row mt-3">
                 <div class="col">
                     <a href="/user/list" class="btn btn-warning btn-rounded"> Cancel </a>
                </div>
                 <div class="col d-flex justify-content-end">
                     <button class="btn btn-primary btn-rounded" style="width: 8rem;"> Save </button>
                </div>
            </div><!-- /row -->
         </form><!-- /form -->
     </div> <!-- /registration-form__form -->

</div>
<?= $this->endSection(); ?>