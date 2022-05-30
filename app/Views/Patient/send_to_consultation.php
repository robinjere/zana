<?php $this->extend('patient/patient_dashboard'); ?>

<?php $this->section('patient'); ?>
<div class="d-flex justify-content-end">
  <a  class="btn btn-success" href="/patient/register/<?= $patient_info['patient_id']; ?>">Edit Patient Info</a>
</div>
<h3>Patient File Number : <?= $patient_info['file_no']; ?> </h3>

 <form method="post" action=""  class="registration-space-y" x-data="{option:null, amount:0, fees:[<?php foreach($doctors as $doctor){ echo '{doctor_id:'. $doctor->id. ', amount:'. $doctor->amount .'}'; } ?>] }">
     <div class="registration-space-y">
       <select class="form-control" name="doctor_id" x-model="Number(amount)" >
         <option> Select Doctor </option>
            <?php foreach($doctors as $doctor): ?> 
              <option value="<?= $doctor->id; ?>" amount=<?= $doctor->amount; ?> > <?= $doctor->last_name.','.$doctor->first_name .' - '. $doctor->name; ?> </option>
            <?php endforeach; ?> 
       </select>
     </div>

     <div class="registration-space-y">
       <select class="form-control" name="payment_method" @change="option = $event.target.value ">
         <option> Select Payment Method </option>
         <option value="NHIF"> NHIF </option> 
         <option value="CASH"> CASH </option> 
       </select>
     </div>

     <div class="registration-space-y" x-show="option == 'CASH'">
       <input type="number"  step="any" name="amount" x-model="fees.filter(fee => fee.amount == amount)" class="form-control" placeholder="Consultation Fee" title="Consultation Fee" aria-describedby="Consultation Fee">
     </div>

     <div class="registration-space-y" x-show="option !== 'CASH' && option !== null">
       <input type="text" name="insuarance_no" value="" class="form-control" placeholder="Enter Insuarance Number" title="Insuarance Number" aria-describedby="Insuarance Number">
     </div>


    <div class="row mt-6">
        <div class="col">
            <a href="/patient/search" class="btn btn-warning btn-rounded"> Cancel </a>
        </div>
        <div class="col d-flex justify-content-end">
            <button class="btn btn-primary btn-rounded" style="width: 8rem;"> Register </button>
       </div>
   </div><!-- /row -->

</form><!-- /form -->
<?php $this->endSection('patient'); ?>