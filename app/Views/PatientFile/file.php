<?= $this->extend('./patientfile/layout') ?>
<?= $this->section('file') ?>

<!-- hosted patient_file variable -->
<?php if(!empty($patient_file)){
    //    echo $patient_file->id;
    //     print_r($patient_file);
    //     exit;
        
    $patient_file = [
            'id' => $patient_file->id,
            'file_no' => $patient_file->file_no,
            'patient_id' => $patient_file->patient_id,
            'name' => isset($patient_file->name) ? $patient_file->name : '',
            'payment_method' => $patient_file->payment_method,
            'insuarance_no' => $patient_file->insuarance_no,
            'start_treatment' => $patient_file->start_treatment,
            'end_treatment' => $patient_file->end_treatment,
            'status' => $patient_file->status,
            'patient_character' => $patient_file->patient_character,
            'first_name' => $patient_file->first_name,
            'middle_name' => $patient_file->middle_name,
            'sir_name' => $patient_file->sir_name,
            'birth_date' => $patient_file->birth_date,
            'gender' => $patient_file->gender,
            'history' => isset($history) ? $history : 'Current treatment',
            'ishistory' => isset($history) ? true : false
    
    ];
    $patient_file['end_treatment'] = $patient_file['end_treatment'] == '0000-00-00' ? date('Y-m-d') : $patient_file['end_treatment'];    
    
?>
    
<div class="file">
    <div class="file-header"> 
        <!-- <h3>FILE NO: <?= $patient_file['file_no'] ?></h3> -->
         <div class="file-status row">
             <div class="col-4">
                <!-- <span class="badge bg-secondary"> current treatment </span> -->
                <b> <?= $patient_file['history'] ?> </b>
             </div> <!-- /col-4 -->
             <div class="col-8">
                 <div class="row">
                     <div class="col d-flex justify-content-end">
                         <span class="badge bg-warning from"> From </span>
                     </div>
                     <div class="col">
                            <span class="date"> <?= date('F j, Y', strtotime($patient_file['start_treatment'])) ?></span>
                     </div>
                     <div class="col d-flex justify-content-end">
                         <span class="badge bg-warning from"> To </span>
                     </div>
                     <div class="col">
                         <span class="date"> <?= $patient_file['end_treatment'] == '0000-00-00'? date('F j, Y'): date('F j, Y', strtotime($patient_file['end_treatment'])) ?> </span>
                     </div>
                 </div><!-- /row -->
             </div><!-- /col-8 -->
            </div><!-- file-status --> 
             <!-- -->
             <p class="file-info">
                <?php  $birthdate = $patient_file['birth_date'];
                 $birthdate = new DateTime($birthdate);
                 $today = new DateTime();
                 $interval = $today->diff($birthdate);
                 $years = $interval->y;
                 $months = $interval->m;
                 $days = $interval->d;
                ?>
                <?= strtoupper($patient_file['first_name']) .' '. strtoupper($patient_file['middle_name']) .' '. strtoupper($patient_file['sir_name']) ?>, FILE NUMBER:  <?= $patient_file['file_no'] ?>, AGE: <?= $years . 'YEARS' .' '. $months .'MONTHS' .' '. $days .'DAYS'  ?>,  CLINIC: <?= strtoupper($patient_file['name']) ?>, PAYMENT METHOD: <?= $patient_file['payment_method'] ?>,    <b style="color:#dc3545;"><?= strtoupper($patient_file['patient_character']) ?> </b>
             </p>
    </div><!-- file-header -->
   <hr class="divider" style="margin: 0 !important; "/>
    <div class="file-content">

    

    <?php if(in_array(session()->get('role'), ['doctor'])){?>
        
        <div class="mt-2 section-style">

            <div class="row">
                <div class="col-6">
                    <!-- clinical note  -->
                    <?= view_cell('\App\Libraries\PatientPanel::ClinicalNotes', $patient_file) ?>
                    <!-- clinical note -->
                </div><!-- /col-6 -->
                <?php if(in_array(session()->get('role'), ['doctor'])){ ?>
                    <div class="col-6">
                    <!-- clinical note  -->
                        <?= view_cell('\App\Libraries\PatientPanel::GeneralExamination', $patient_file) ?>
                    <!-- clinical note -->
                    </div><!-- /col-6 -->
                <?php } ?>
           
            </div>
        </div>

    <?php } ?>

    <?php if(in_array(session()->get('role'), ['radiology'])){?>
        
        <div class="mt-2 section-style">
        <!-- RADIOLOGY UI LIST  -->
        <div class="row">
            <div class="col-6">
            <?= view_cell('\App\Libraries\PatientPanel::ClinicalNotes', $patient_file) ?>
            </div>
            <div class="col-6">
            <?= view_cell('\App\Libraries\PatientPanel::Radiology', $patient_file) ?> 
            </div>
        </div>
        <!-- RADIOLOGY UI LIST  -->
        </div>

    <?php } ?>

   <?php if(in_array(session()->get('role'), ['doctor' , 'radiology'])){?>
        <div class="mt-2 section-style">
            <!-- labtest -->
            <?= view_cell('\App\Libraries\PatientPanel::Diagnoses', $patient_file) ?> 
            <!-- labtest -->
        </div>
    <?php } ?>
        
    
    <div class="mt-2 section-style">
        <div class="row">
            <div class="col-6"> 
                
                <?php if(in_array(session()->get('role'), ['doctor', 'lab', 'cashier', 'reception'])){?>
                    
                        <!-- labtest -->
                        <?= view_cell('\App\Libraries\PatientPanel::Labtest', $patient_file) ?> 
                        <!-- labtest -->
                       <?php } ?>
            
               </div><!-- /col-6 -->
                <div class="col-6"> 
                    <?php if(in_array(session()->get('role'), ['doctor', 'reception', 'cashier'])){?>
                    
                            <!-- labtest -->
                            <?= view_cell('\App\Libraries\PatientPanel::Radiology', $patient_file) ?> 
                            <!-- labtest -->
                    
                    <?php } ?>
                </div> <!-- /col-6 -->
        </div><!-- ./row -->
     </div><!-- /section-style -->
        
        <?php if(in_array(session()->get('role'), ['doctor', 'pharmacy', 'cashier']) && $patient_file['patient_character'] !== 'outsider'){?>
            <div class="mt-2 section-style">
                <!-- Medicine -->
                <?= view_cell('\App\Libraries\PatientPanel::Medicine', $patient_file) ?> 
                <!-- Medicine -->
            </div>
        <?php } ?>
        
    <?php if(in_array(session()->get('role'), ['doctor', 'cashier']) && $patient_file['patient_character'] !== 'outsider'){?>
        <div class="mt-2 section-style">
            <!-- Procedures -->
            <?= view_cell('\App\Libraries\PatientPanel::Procedures', $patient_file) ?>
            <!-- Procedures -->
        </div>
    <?php } ?>

  </div> <!-- /file-content -->
</div><!-- /file -->
  <!-- <P>CLINICAL NOTE</P>
  <P> WORKING DIAGNOSIS </P>
  <P> FINAL DIAGNOSIS </P> -->
<?php } ?>
<?= $this->endSection() ?>