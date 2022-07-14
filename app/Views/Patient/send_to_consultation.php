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

 <form method="post" action="/patient/send_to_consultation/<?= $patient_info['patient_id']; ?>"  class="registration-space-y" x-data="Data()">
    <input type="hidden" name="file_no" value="<?= $patient_info['file_no']; ?>">
    <input type="hidden" name="file_id" value="<?= $patient_info['id']; ?>">
    <div class="registration-space-y">
       <select @change="getDoctors()" class="form-control" <?= set_value('clinic') ?> name="clinic" x-model="selectedClinic" >
       <!-- @change="amount = $event.target.getAttribute('amount')" -->
         <option value=""> Select Clinic </option>
            <?php foreach($clinics as $c): ?> 
              <option :value="<?= $c['id'];  ?>"> <?= $c['name']; ?> </option>
            <?php endforeach; ?> 
       </select>
     </div>
    
      
      <div x-cloak x-show="doctors.length" class="registration-space-y">
         <select class="form-control" <?= set_value('doctor_id') ?> name="doctor_id" @change = "checkConsultationFee()" x-model="selectedDoctor">
         <!-- @change="amount = $event.target.getAttribute('amount')" -->
           <option value=""> Select Doctor </option>
                <template x-for="doc in doctors" :key="doc.id">
                  <option :value="doc.id" x-text="doc.last_name +', '+ doc.first_name">  </option>
                </template>
         </select>
       </div>
  

     <div class="registration-space-y" x-cloak x-show="selectedDoctor">
       <select class="form-control" x-model="selectPayment" <?= set_value('payment_method') ?> name="payment_method" >
         <option> Select Payment Method </option>
         <option value="NHIF"> NHIF </option> 
         <option value="CASH"> CASH </option> 
       </select>
     </div>
    
     <template x-if="selectPayment === 'CASH'">
       <div class="registration-space-y" >
         <input type="number" :value="amount" disabled <?= set_value('amount') ?>  step="any" name="amount"  class="form-control" placeholder="Consultation Fee" title="Consultation Fee" aria-describedby="Consultation Fee">
        </div>
      </template>
      <input type="hidden" :value="amount" <?= set_value('amount') ?> name="amount"/>

     <template x-if="selectPayment !== 'CASH' && selectPayment !== '' ">
       <div class="registration-space-y" >
         <input type="text" <?= set_value('insuarance_no') ?> name="insuarance_no" value="" class="form-control" placeholder="Enter Insuarance Number" title="Insuarance Number" aria-describedby="Insuarance Number">
       </div>
    </template>

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

<?php $this->section('script'); ?>
<script>
  function Data(){
    return {
      option:null, 
      amount:0, 
      doctors : '',
      selectedDoctor: '',
      clinics: <?= json_encode($clinics); ?>,
      selectedClinic: '',
      selectPayment:'',
      fees:'',
      getDoctors(){
        fetch('<?= base_url('clinicController/ajax_getDoctors') ?>', {
              method: 'POST',
              headers: { Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
              body: JSON.stringify({
               clinic_id: this.selectedClinic
              })
           }).then(res => res.json()).then(data => {
                //  console.log('doctors', data);
                 this.doctors = data;
           }).catch(error => console.log('error', error))
      },
      checkConsultationFee(){
        this.amount =  this.clinics.filter(c => c.id === this.selectedClinic)[0].consultation_fee;
      }
     }
  } 
</script>
<?php $this->endSection(); ?>