<?php $this->extend('patient/patient_dashboard'); ?>

<?php $this->section('patient'); ?>
<!-- <div class="d-flex justify-content-end">
  <a  class="btn btn-success" href="/patient/register/<?= $patient_info['patient_id']; ?>">Edit Patient Info</a>
</div> -->
<?php
   if($patient_info['status']){?>
  <h3>Patient File Number : <?= $patient_info['file_no']; ?> </h3>
<?php }else { ?>
  <h3>Patient Generated File Number : <?= $patient_info['file_no']; ?> </h3>
<?php } ?>

<div>
   <?php print_r($patient_info); ?> 
</div>

 <form method="post" action="/patient/send_to_consultation/<?= $patient_info['patient_id']; ?>"  class="registration-space-y" x-data="{option:null, amount:0, fees:[<?php foreach($doctors as $doctor){ echo '{doctor_id:'. $doctor->id. ', amount:'. $doctor->amount .'}'; } ?>] }">
    <input type="hidden" name="file_no" value="<?= $patient_info['file_no']; ?>">
    <input type="hidden" name="file_id" value="<?= $patient_info['id']; ?>">
    <div class="registration-space-y">
       <select class="form-control" <?= set_value('doctor_id') ?> name="doctor_id" x-model.number="amount">
       <!-- @change="amount = $event.target.getAttribute('amount')" -->
         <option value=""> Select Doctor </option>
            <?php foreach($doctors as $doctor): ?> 
              <option value="<?= $doctor->id; ?>" amount=<?= $doctor->amount; ?> > <?= $doctor->last_name.','.$doctor->first_name .' - '. $doctor->name; ?> </option>
            <?php endforeach; ?> 
       </select>
     </div>

     <div class="registration-space-y">
       <select class="form-control" <?= set_value('payment_method') ?> name="payment_method" @change="option = $event.target.value">
         <option> Select Payment Method </option>
         <option value="NHIF"> NHIF </option> 
         <option value="CASH"> CASH </option> 
       </select>
     </div>

     <div class="registration-space-y" x-show="option == 'CASH'">
       <input type="number" disabled <?= set_value('amount') ?>  step="any" name="amount" x-model="fees.filter(fee => fee.doctor_id == amount)[0].amount" class="form-control" placeholder="Consultation Fee" title="Consultation Fee" aria-describedby="Consultation Fee">
      </div>
      <input type="hidden" disabled <?= set_value('amount') ?> name="amount" x-model="fees.filter(fee => fee.doctor_id == amount)[0].amount"/>

     <div class="registration-space-y" x-show="option !== 'CASH' && option !== null">
       <input type="text" <?= set_value('insuarance_no') ?> name="insuarance_no" value="" class="form-control" placeholder="Enter Insuarance Number" title="Insuarance Number" aria-describedby="Insuarance Number">
     </div>


    <div class="row mt-6">
        <div class="col">
            <a href="/patient/search" class="btn btn-warning btn-rounded"> Cancel </a>
        </div>
        <div class="col d-flex justify-content-end">
            <button class="btn btn-primary btn-rounded"> Send to Consultation </button>
       </div>
   </div><!-- /row -->

</form><!-- /form -->
<?php $this->endSection('patient'); ?>