<?php $this->extend('Patient/patient_dashboard'); ?>

<?= $this->section('patient'); ?>
<form method="post"> 
<div class="input-group">
  <select name="filter" class="form-select" aria-label="filter search">
    <option selected value="file_no"> Search by file number</option>
    <option value="name">Search by patient name</option>
  </select>
  <input type="search" name="searchterm" placeholder="search patient .." class="form-control w-full" style="flex:2;" aria-label="Search patient"/>
  <button type="submit" class="btn btn-success" type="button">Search</button>
</div>
<!-- genereate file no when register a patient  -->
<!-- if patient is  -->
<!-- <select class="form-select" aria-label="filter">
  <option selected> In-patient</option>
  <option value="1">Out-Patient</option>
  <option value="2">Out-Sider</option>
</select> -->

</form>

<?php

   if(isset($patient_info)){
     print_r($patient_info);
     echo $search_by; 
     echo '<br/>  ----------------------------------------------------------------  <br/>';
     
     ?>

    <div class="patient_search">
      <div class="detail">
        <h4>Available patient | Info </h4>
        <hr/>
        <div class="row">
          <div class="col">PATIENT FILE NO:</div>
          <div class="col"><?= strtoupper($patient_info->file_no); ?></div>
        </div>
        <?php if($search_by == 'name'){?>
        <div class="row">
          <div class="col">PATIENT NAME:</div>
          <div class="col"><?= strtoupper($patient_info->sir_name).', '. strtoupper($patient_info->first_name); ?></div>
        </div>
        <?php } ?>
        <div class="row">
          <div class="col">STATUS:</div>
          <?php
             switch ($patient_info->status) {
               case 'consultation':
                 echo '<div class="col"> PATIENT WAIT FOR CONSULTATION </div>';
                 break;
               case 'finishTreatment':
                 echo $patient_info->end_treatment !== '0000-00-00' ? '<div class="col"> FINISH TREATMENT | '.$patient_info->end_treatment.'</div>' : '<div class="col"> CONSULTATION CONCELLEAD </div>';
                 break;
               case 'inTreatment':
                 echo '<div class="col"> PATIENT WAIT FOR CONSULTATION </div>';
                 break;
               
               default:
                 # code...
                 break;
             }
          ?>
          <!-- <div class="col">IN-TREATMENT | LAST VISIT 13/6/2022 </div> -->
        </div>

        <div class="row">
          <div class="col">PATIENT CHARACTER: </div>
          <div class="col">
            <span class="badge bg-primary"><?= strtoupper($patient_info->patient_character) ?>!</span>
          </div>
        </div>

        <div class="row">
          <div class="col">PAYMENT METHOD:</div>
          <div class="col"><?= strtoupper($patient_info->payment_method); ?></div>
        </div>

      </div> <!-- detail -->
      <div class="row navigation g-0">
         <?php 
         $SEND_TO_DOCTOR = '<div class="col"> 
                             <a href="'.base_url('patient/send_to_consultation/'.$patient_info->id).'" class="doctor"> SEND TO DOCTOR </a> 
                            </div>';
         switch (session()->get('role')) {
           case 'reception':
              echo '<div class="col"> <a href="#" class="history">EDIT PATIENT INFO</a> </div>';
            //if patient sent to consultation
             if(isset($consultation_payment) && $patient_info->status == 'consultation' ){
              if($consultation_payment->payment_confirmed_by == 0){
                echo '<div class="col"> 
                        <a href="'. base_url('consultation/cancel/'.$consultation_payment->id.'/'.$consultation_payment->file_id).'" class="consultation-remove">CANCEL CONSULTATION </a> 
                      </div>';
               }
             }elseif ($patient_info->status == '') {
              echo $SEND_TO_DOCTOR;
             }elseif ($patient_info->status == 'inTreatment') {
              echo '<div class="col"> 
                      <a href="#" class="consultation-remove"> ATTEND </a> 
                    </div>';
             }elseif ($patient_info->status == 'finishTreatment') {
              echo $SEND_TO_DOCTOR;
             }
             break;
           
           default:
             # code...
             break;
         }
              
      ?>
        <!-- <div class="col"> <a href="#" class="history">PATIENT HISTORY</a> </div>
         
        <div class="col"> 
          <a href="#" class="doctor">SEND TO DOCTOR </a> 
        </div> -->
      </div>
    </div><!-- /patient_search -->

   <?php } ?>


<?= $this->endSection('patient'); ?>