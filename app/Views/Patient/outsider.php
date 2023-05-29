<?php $this->extend('patient/patient_dashboard'); ?>

<?php $this->section('patient'); ?>

<!-- <div class="d-flex justify-content-end">
  <a  class="btn btn-success" href="/patient/register/<?= $patient_info['patient_id']; ?>">Edit Patient Info</a>
</div> -->

<!-- PATIENT INFO -->

<div class="p-info">
  <div class="row">
      <div class="col">
          PATIENT NAMES:
      </div><!-- /col -->
      <div class="col">
         <?= strtoupper($patient_profile['first_name']) . ', '. strtoupper($patient_profile['middle_name']) .' - '. strtoupper($patient_profile['sir_name']); ?>
          <!-- JOHN, JOFRET - SANGA  -->
      </div><!-- /col -->
  </div><!-- /row -->
  <div class="row">
      <div class="col">
           BIRTH DATE:
      </div><!-- /col -->
      <div class="col">
           <?= strtoupper($patient_profile['birth_date']) ?>
      </div><!-- /col -->
  </div><!-- /row -->
  <div class="row">
      <div class="col">
           GENDER:
      </div><!-- /col -->
      <div class="col">
           <?= strtoupper($patient_profile['gender']) ?>
      </div><!-- /col -->
  </div><!-- /row -->
  <div class="row">
      <div class="col">
           ADDRESS:
      </div><!-- /col -->
      <div class="col">
           <?= strtoupper($patient_profile['address']) ?>
      </div><!-- /col -->
  </div><!-- /row -->
  <div class="row">
      <div class="col">
           PHONE NUMBER:
      </div><!-- /col -->
      <div class="col">
           <?= strtoupper($patient_profile['phone_no']) ?>
      </div><!-- /col -->
  </div><!-- /row -->

  <div class="row">
      <div class="col">
        PATIENT CHARACTER:
      </div><!-- /col -->
      <div class="col">
           <span class="badge bg-info"> 
             <?= strtoupper($patient_info['patient_character']) ?>
           </span>
      </div><!-- /col -->
  </div><!-- /row -->
  <div class="row">
      <div class="col">
        FILE NUMBER:
      </div><!-- /col -->
      <div class="col">
           <span class="badge bg-success" style="padding-left:20px; padding-right: 20px;"> 
             <?= strtoupper($patient_info['file_no']) ?>
           </span>
      </div><!-- /col -->
  </div><!-- /row -->
</div><!-- /patient-info -->

<!-- /PATIENT INFO -->

<!-- <?php
   if($patient_info['status']){?>
  <h3>Patient File Number : <?= $patient_info['file_no']; ?> </h3>
<?php }else { ?>
  <h3>Patient Generated File Number : <?= $patient_info['file_no']; ?> </h3>
<?php } ?> -->


<div class="container">
  <?php
     if( $patient_info['status'] == '' || $patient_info['status'] == 'finishTreatment'){?>
        <div class="col d-flex justify-content-end align-items-center">                       
              <form method="post" action="<?= base_url('patient/outsider_start_treatment') ?>">
                <input type="hidden" name="file_id" value="<?= $patient_info['id'] ?>"/>
                <input type="hidden" name="patient_id" value="<?= $patient_info['patient_id']  ?>"/>
                <input type="hidden" name="payment_method" value="CASH"/>
                <input type="hidden" name="start_treatment" value="<?= date('Y-m-d') ?>"/>
                <input type="hidden" name="status" value="inTreatment"/>
                <input type="submit" value="START TREATMENT" class="btn btn-success btn-sm"/>
              </form>
        </div>
     <?php 
     }else{ ?>
      <div class="col d-flex justify-content-end align-items-center"> 
          <a href="<?= base_url('patientfile/attend/'.$patient_info['id'] )?>" class="btn btn-success btn-sm"> ATTEND </a> 
      </div>
    <?php }
  ?>


    
</div><!-- /container -->


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