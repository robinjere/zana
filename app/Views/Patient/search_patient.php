<?php $this->extend('Patient/patient_dashboard'); ?>

<?= $this->section('patient'); ?>

<?= view_cell('\App\Libraries\PatientPanel::PatientNavigation') ?>

<form  x-on:submit.prevent method="post" x-data="searchForm();"> 

  <div class="search_box">
    <div class="input-group">
      <!-- <select name="filter" class="form-select" aria-label="filter search">
        <option selected value="file_no"> Search by file number</option>
        <option value="name">Search by patient name</option>
      </select> -->
      <input type="search" @keyup="onSearch" x-model="searchterm" name="searchterm" placeholder="search patient .." class="form-control w-full" style="flex:2;" aria-label="Search patient"/>
      <!-- <button type="submit" class="btn btn-success" style="margin-left: 1rem;" type="button">Search  </button> -->
    </div><!-- /input-group -->
    <!-- Hover added -->
    <template x-if="patient_info.length"> 
      <div class="list-group patientSearchList">
        <template x-for="patient in patient_info" :key="patient.id">
          <form method="post" :id="'p'+patient.id" action="<?= base_url('patient/search') ?>">
            <input type="hidden" name="patient_id" :value="patient.id"/>
            <a href="#" @click="submitForm('p'+patient.id)"  class="list-group-item list-group-item-action" x-text="patient.first_name +' '+ patient.middle_name + ' '+ patient.sir_name + ' |  file number: ' + patient.file_no + ' | ' +  patient.patient_character.toUpperCase() "></a>
          </form>
        </template>
      </div>
    </template>
    <template x-if="errors !== '' ">
    <div class="my-3 pt-3 box-alert warning-alert d-flex align-items-start" >
      <div class="icon-alert px-3"> 
          <svg viewBox="0 0 51 50" fill="none">
              <path d="M7.77416 42.8087C5.342 40.5119 3.40202 37.7644 2.06742 34.7266C0.732827 31.6888 0.0303434 28.4215 0.000961476 25.1155C-0.0284205 21.8094 0.615887 18.5307 1.89629 15.4707C3.17669 12.4107 5.06755 9.63062 7.45853 7.29278C9.8495 4.95493 12.6927 3.1061 15.8223 1.85415C18.9518 0.602201 22.305 -0.0277889 25.6863 0.000940109C29.0675 0.0296691 32.409 0.716541 35.5159 2.02148C38.6227 3.32641 41.4326 5.22328 43.7817 7.6014C48.4203 12.2974 50.9871 18.587 50.929 25.1155C50.871 31.6439 48.1929 37.8889 43.4715 42.5054C38.7501 47.1219 32.3631 49.7405 25.6863 49.7973C19.0094 49.854 12.5769 47.3443 7.77416 42.8087ZM40.1911 39.298C44.0137 35.5603 46.1612 30.4909 46.1612 25.2051C46.1612 19.9192 44.0137 14.8498 40.1911 11.1122C36.3685 7.37451 31.1839 5.27471 25.7779 5.27471C20.3719 5.27471 15.1873 7.37451 11.3647 11.1122C7.54211 14.8498 5.39459 19.9192 5.39459 25.2051C5.39459 30.4909 7.54211 35.5603 11.3647 39.298C15.1873 43.0356 20.3719 45.1354 25.7779 45.1354C31.1839 45.1354 36.3685 43.0356 40.1911 39.298ZM23.2314 27.695V22.7152H28.3244V37.6546H23.2314V27.695ZM23.2314 12.7555H28.3244V17.7353H23.2314V12.7555Z" fill="#FB5A77"/>
          </svg>
      </div>
      <div class="message-alert"> 
          <h2 class="mb-2"> Errors occurs. </h2>
          <p x-text="errors"></p>
          
      </div>
    </div><!-- box-alert -->
    </template>

  </div><!-- /search_box -->

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
    // print_r($patient_info);
   ?>

    <div class="patient_search bg-white">
      <div class="detail">
        <h4>Patient Info </h4>
        <hr/>
        <div class="row">
          <div class="col">PATIENT FILE NO:</div>
          <div class="col"><?= strtoupper($patient_info->file_no); ?></div>
        </div>
        
        <div class="row">
          <div class="col">PATIENT NAME:</div>
          <div class="col"><?= strtoupper($patient_info->sir_name).', '. strtoupper($patient_info->first_name); ?></div>
        </div>
      
        <div class="row">
          <div class="col">STATUS:</div>
          <?php
             switch ($patient_info->status) {
               case 'consultation':
                 echo '<div class="col"> PATIENT WAIT FOR CONSULTATION </div>';
                 break;
               case 'finishTreatment':
                   $date = date_create($patient_info->end_treatment);
                 echo $patient_info->end_treatment !== '0000-00-00' ? '<div class="col"> FINISH TREATMENT ON '. date_format($date, 'd F, Y').'</div>' : '<div class="col"> CONSULTATION CANCELED </div>';
                 break;
               case 'inTreatment':
                 echo '<div class="col"> PATIENT IN TREATMENT  </div>';
                 break;
               
               default:
                 echo '<div class="col"> NO STATUS </div>';
                 break;
             }
          ?>
          <!-- <div class="col">IN-TREATMENT | LAST VISIT 13/6/2022 </div> -->
        </div>

        <div class="row">
          <div class="col">PATIENT CHARACTER: </div>
          <div class="col">
            <span class="badge bg-primary"><?= strtoupper($patient_info->patient_character) ?></span>
          </div>
        </div>

        <div class="row">
          <div class="col">PAYMENT METHOD:</div>
          <div class="col"><?= strtoupper($patient_info->payment_method) === '' ? 'NO PAYMENT METHOD' :  strtoupper($patient_info->payment_method); ?></div>
        </div>

        <?php         
            if(isset($consultation_payment)){
                $_PAID = $consultation_payment->payment_confirmed_by == 0 ? '<span class="badge bg-danger">NOT PAID!</span>' : '<span class="badge bg-primary"> PAID</span>';
                if($consultation_payment->payment == 'CASH'){?>
                    <div class="row">
                        <div class="col">CONSULTATION FEE:</div>
                        <div class="col"><?= $_PAID ?> </div>
                    </div>
                <?php
                }    
            }
        ?>

   
      </div> <!-- detail -->
      <div class="row navigation g-0" style="padding: 9px;">
       <?php 
         $SEND_TO_DOCTOR = '<div class="col d-flex justify-content-end align-items-center"> 
                             <a href="'.base_url('patient/send_to_consultation/'.$patient_info->id).'" class="btn btn-success btn-sm"> SEND TO DOCTOR </a> 
                            </div>';

         $ATTEND =   '<div class="col d-flex justify-content-end align-items-center"> 
                         <a href="'.base_url('patientfile/attend/'.$patient_info->file_id).'" class="btn btn-success btn-sm"> ATTEND </a> 
                      </div>';

         $CONSULT =   '<div class="col d-flex justify-content-end align-items-center"> 
                         <a href="'.base_url('patientfile/consult/'.$patient_info->file_id).'" class="btn btn-success btn-sm"> ATTEND  </a> 
                      </div>';
                      
        $CANCEL_CONSULTATION = '';
        $APPROVE_PAYMENT = '';
        $DIS_APPROVE = '';

        $START_TREATMENT = '';
    
        if(isset($consultation_payment) && $patient_info->status == 'consultation' ){

          $CANCEL_CONSULTATION = '<div class="col d-flex justify-content-end align-items-center"> 
                                     <a href="'. base_url('consultation/cancel/'.$consultation_payment->id.'/'.$consultation_payment->file_id).'" class="btn btn-danger btn-sm">CANCEL CONSULTATION </a> 
                                  </div>';
  
          $APPROVE_PAYMENT =  '<div class="col d-flex justify-content-end align-items-center"> 
                                  <a href="'.base_url('consultation/approve_payment/'.$consultation_payment->id.'/search').'" class="btn btn-success btn-sm"> APPROVE PAYMENT </a> 
                               </div>';
  
          $DIS_APPROVE =  '<div class="col d-flex justify-content-end align-items-center"> 
                              <a href="'.base_url('consultation/disapprove_payment/'.$consultation_payment->id.'/search').'" class="btn btn-danger btn-sm"> CANCEL PAYMENT </a> 
                         </div>';
        }


        //  $role = in_array(session()->get('role'), ['specialist_doctor','general_doctor']) ? 'doctor' :  session()->get('role');
        //  print_r('-----------------'.session()->get('role').'---------------');
         switch (strtolower(session()->get('role'))) {

           case 'pharmacy' : 
              if ($patient_info->status == 'inTreatment') {
                 echo $ATTEND;
              }

            break;
           case 'reception':
              echo '<div class="col d-flex align-items-center"> <a href="'.base_url('/patient/edit/'. $patient_info->patient_id).'" class="btn btn-outline-success btn-sm">EDIT PATIENT INFO</a> </div>';
            //if patient sent to consultation
             if(isset($consultation_payment) && $patient_info->status == 'consultation' ){
              if($consultation_payment->payment_confirmed_by == 0){
                echo $CANCEL_CONSULTATION;
               }
             }elseif ($patient_info->status == '' && $patient_info->patient_character !== 'outsider') {
              echo $SEND_TO_DOCTOR;
             }elseif ($patient_info->status == 'inTreatment' && $patient_info->patient_character == 'outsider') {
              echo $ATTEND;
             }elseif ($patient_info->status == 'finishTreatment') {
              echo $SEND_TO_DOCTOR;
             }elseif ($patient_info->status == '' || $patient_info->status == 'finishTreatment') {   ?>
             <div class="col d-flex justify-content-end align-items-center">                       
              <form method="post" action="<?= base_url('patient/outsider_start_treatment') ?>">
                <input type="hidden" name="file_id" value="<?=$patient_info->file_id ?>"/>
                <input type="hidden" name="patient_id" value="<?= $patient_info->patient_id  ?>"/>
                <input type="hidden" name="payment_method" value="CASH"/>
                <input type="hidden" name="start_treatment" value="<?= date('Y-m-d') ?>"/>
                <input type="hidden" name="status" value="inTreatment"/>
                <input type="submit" value="START TREATMENT" class="btn btn-success btn-sm"/>
              </form>
             </div>

          <?php  }
             break;

           case 'cashier': 
                echo '<div class="col"> </div>';
                  if(isset($consultation_payment) && $patient_info->status == 'consultation' ){
                    // print_r($consultation_payment);
                    echo $consultation_payment->payment_confirmed_by == 0 ? $APPROVE_PAYMENT : $DIS_APPROVE;
                  }elseif ($patient_info->status == 'inTreatment') {
                    echo $ATTEND;
                  }

               break;

           case 'doctor': 
                  echo '<div class="col"> </div>';
                  if(isset($consultation_payment) && $patient_info->status == 'consultation' ){
                    // print_r($consultation_payment);
                    if( $consultation_payment->payment_confirmed_by != 0) {
                      echo $CONSULT;
                    }
                  }elseif ($patient_info->status == 'inTreatment' && $patient_info->patient_character !== 'outsider') {
                    echo $ATTEND;
                  }

                  break;

           case 'lab': 
             echo '<div class="col"> </div>';
              // print_r($consultation_payment);
              if(isset($consultation_payment) &&  $consultation_payment->payment_confirmed_by != 0 ){
                // print_r($consultation_payment);
                  echo $ATTEND;;
              }elseif ($patient_info->status == 'inTreatment') {
                  echo $ATTEND;;
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

<?= $this->section('script'); ?>
<script>
    function searchForm(){
      return {
         searchterm: '',
         errors: '',
         patient_info: '',
         onSearch(){
          if(this.searchterm == ''){
            return;
          }
            fetch("<?= base_url('patient/ajax_search') ?>", {
                method: 'POST',
                headers: {Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
                body: JSON.stringify({searchterm: this.searchterm })
            }).then(res => res.json())
            .then(data => {
              console.log('from search', data)
                  if(data.success){
                     this.patient_info = data.patient_info;
                     this.errors = '';
                  }else{
                    this.errors = data.errors;
                    this.patient_info = '';
                  }
            }).catch(error => console.log(error))
         },
         submitForm(formId){
           const form = document.getElementById(formId)
           form.submit()
         }
      };
    }
</script>
<?= $this->endSection('script'); ?>

