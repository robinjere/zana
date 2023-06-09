<?= $this->extend('dashboard/main') ?> 
<?= $this->section('data') ?>

<div class="d-flex justify-content-center align-items-center registration-layout">

  <div class=" mb-5 registration-form container">
    
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
    
    <div class="registration-form__heading">
       <h2> Generate report </h2>
    </div> <!-- /registration-form__heading -->
     <div class="registration-form__form" x-data="reportData()">
           <form method="post" action="/report/generate" target="_blank">
            
            <div class="registration-space-y">   
                  <!-- <label for="" class="form-label"></label> -->
                  <select required class="form-control"  x-model="report_type" name="report_type" id="report_type">
                      <option> Select type of report you want </option>
                      <option value="consultation"> Consultation </option>
                      <option value="procedure"> Procedure </option>
                      <option value="labtest"> Lab test </option>
                      <option value="medicine"> Medicine </option>
                      <option value="sales"> Sales </option>
                      <option value="sales-drug"> Sales drug </option>
                      <option value="expenses"> Expenses </option>
                      <option value="items_in_stock"> Drugs in Stock </option>
                      <option value="items_out_stock"> Drugs out of Stock </option>
                      <option value="items_expected_to_expire"> Drugs expected to expire </option>
                  </select>
             </div><!-- /row -->

            <template x-if="report_type == 'sales' || report_type == 'sales-drug' ">
                <div class="registration-space-y">
                        <select class="form-select " name="cashier_id" style="text-transform: uppercase;">
                            <option value="" selected>Sales by cashier?</option>
                            <?php foreach ($salesBy as $key => $sale_by) {?>
                                <option value="<?= $sale_by->id ?>"> <?= $sale_by->first_name.' '. $sale_by->last_name ?></option>
                            <?php } ?>
                            <!-- <option value="">Istanbul</option>
                            <option value="">Jakarta</option> -->
                        </select>
                </div><!-- /registration-space-y -->
            </template>

            <template x-if="report_type == 'consultation' || report_type == 'procedure' || report_type == 'medicine'">
                <div class="registration-space-y">
                        <select class="form-select " name="doctor_id" style="text-transform: uppercase;">
                            <option value="" selected>Select doctor</option>
                            <?php foreach ($doctors as $key => $doctor) {?>
                                <option value="<?= $doctor->id ?>"> <?= $doctor->first_name.' '. $doctor->last_name ?></option>
                            <?php } ?>
                            <!-- <option value="">Istanbul</option>
                            <option value="">Jakarta</option> -->
                        </select>
                </div><!-- /registration-space-y -->
            </template>

             <div class="row registration-space-y">   
               <div class="col">
                   <label for="start_date"> Start Date </label>
                 <input type="date" required name="start_date" id="start_date" value="<?= set_value('start_date')?>" class="form-control" placeholder="Start date" aria-describedby="start date">
                </div>
               <div class="col">
                  <label for="end_date"> End Date </label>
                 <input type="date" required name="end_date" id="end_date" value="<?= set_value('start_date')?>" class="form-control" placeholder="End date" aria-describedby="end date">
                </div>
             </div><!-- /row -->


            <div class="row mt-3">
                 <div class="col">
                     <a href="/store/items" class="btn btn-warning btn-rounded"> Cancel </a>
                </div>
                 <div class="col d-flex justify-content-end">
                     <button class="btn btn-primary btn-rounded" style="width: 8rem;"> Generate </button>
                </div>
            </div><!-- /row -->
         </form><!-- /form -->
     </div> <!-- /registration-form__form -->

  </div><!-- /registration-form -->
</div><!-- /registration-layout --->

<?= $this->endSection('content') ?>
<?= $this->section('script') ?>
<script>
     function reportData(){
        return {
            report_type: '',
        }
     }
</script>
<?= $this->endSection('script') ?>

