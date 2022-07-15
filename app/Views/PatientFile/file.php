<?= $this->extend('./patientfile/layout') ?>
<?= $this->section('file') ?>

<?php if(!empty($patient_file)){ 
   //if end date is null then set to current date
//    print_r(date('Y-m-d'));
//    echo 'Today date |>';
//    echo 'and app time zone: ';
   
//    echo app_timezone();

   $patient_file['end_treatment'] = $patient_file['end_treatment'] == '0000-00-00' ? date('Y-m-d') : $patient_file['end_treatment'];
?>
    
<div class="file">
    <div class="file-header"> 
        <h3>FILE NO: IMC/2022/22 </h3>
         <div class="file-status row">
             <div class="col-4">
                <!-- <span class="badge bg-secondary"> current treatment </span> -->
                <b> Current treatment </b>
             </div> <!-- /col-4 -->
             <div class="col-8">
                 <div class="row">
                     <div class="col d-flex justify-content-end">
                         <span class="badge bg-secondary from"> From </span>
                     </div>
                     <div class="col">
                            <span class="date"> <?= date('F j, Y', strtotime($patient_file['start_treatment'])) ?></span>
                     </div>
                     <div class="col d-flex justify-content-end">
                         <span class="badge bg-secondary from"> To </span>
                     </div>
                     <div class="col">
                         <span class="date"> <?= $patient_file['end_treatment'] == '0000-00-00'? date('F j, Y'): date('F j, Y', strtotime($patient_file['end_treatment'])) ?> </span>
                     </div>
                 </div><!-- /row -->
             </div><!-- /col-8 -->
            </div><!-- file-status --> 
            <!-- <?php print_r($patient_file); ?> -->
    </div><!-- file-header -->
   <hr class="divider"/>
    <div class="file-content">
        <!-- clinical note  -->
        <?= view_cell('\App\Libraries\PatientPanel::ClinicalNote', $patient_file) ?>
        <!-- clinical note -->
        
        <!-- labtest -->
        <?= view_cell('\App\Libraries\PatientPanel::Diagnoses', $patient_file) ?> 
        <!-- labtest -->

        <!-- labtest -->
        <?= view_cell('\App\Libraries\PatientPanel::Labtest', $patient_file) ?> 
        <!-- labtest -->

        <!-- Medicine -->
        <?= view_cell('\App\Libraries\PatientPanel::Medicine', $patient_file) ?> 
        <!-- Medicine -->

        <!-- Procedures -->
        <?= view_cell('\App\Libraries\PatientPanel::Procedures', $patient_file) ?>
        <!-- Procedures -->


    </div> <!-- /file-content -->
</div><!-- /file -->
  <!-- <P>CLINICAL NOTE</P>
  <P> WORKING DIAGNOSIS </P>
  <P> FINAL DIAGNOSIS </P> -->

<?php } ?>
<?= $this->endSection() ?>