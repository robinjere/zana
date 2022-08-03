<?= $this->extend('./patientfile/layout') ?>
<?= $this->section('file') ?>

<?php if(!empty($patient_file)){ 
//if end date is null then set to current date
//    print_r(date('Y-m-d'));
//    echo 'Today date |>';
//    echo 'and app time zone: ';
   
//    echo app_timezone();
 
//   print_r($patient_file); 

                $patient_file = [
                    'id' => $patient_file->id,
                    'file_no' => $patient_file->file_no,
                    'patient_id' => $patient_file->patient_id,
                    'name' => $patient_file->name,
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
                    'gender' => $patient_file->gender
                ];


   $patient_file['end_treatment'] = $patient_file['end_treatment'] == '0000-00-00' ? date('Y-m-d') : $patient_file['end_treatment'];
?>
    
<div class="file">
    <div class="file-header"> 
        <!-- <h3>FILE NO: <?= $patient_file['file_no'] ?></h3> -->
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
             <!-- -->
             <p class="file-info">
                <?= strtoupper($patient_file['first_name']) .' '. strtoupper($patient_file['middle_name']) .' '. strtoupper($patient_file['sir_name']) ?>, FILE NUMBER:  <?= $patient_file['file_no'] ?>, AGE: <?= (date('Y') - date('Y', strtotime($patient_file['birth_date']))). 'YEARS'  ?>, CLINIC: <?= strtoupper($patient_file['name']) ?>, PAYMENT METHOD: <?= $patient_file['payment_method'] ?>
             </p>
    </div><!-- file-header -->
   <hr class="divider" style="margin: 0!important; "/>
    <div class="file-content">

        <div class="mt-2 section-style">
            <div class="row">
                <div class="col-6">
                    <!-- clinical note  -->
                    <?= view_cell('\App\Libraries\PatientPanel::ClinicalNote', $patient_file) ?>
                    <!-- clinical note -->
                </div><!-- /col-6 -->
                <div class="col-6">
                    <!-- clinical note  -->
                    <?= view_cell('\App\Libraries\PatientPanel::GeneralExamination', $patient_file) ?>
                    <!-- clinical note -->
                </div><!-- /col-6 -->
            </div>
        </div>

        <div class="mt-2 section-style">
            <!-- labtest -->
            <?= view_cell('\App\Libraries\PatientPanel::Diagnoses', $patient_file) ?> 
            <!-- labtest -->
        </div>
        
        <div class="mt-2 section-style">
            <!-- labtest -->
            <?= view_cell('\App\Libraries\PatientPanel::Labtest', $patient_file) ?> 
            <!-- labtest -->
        </div>

        <div class="mt-2 section-style">
            <!-- labtest -->
            <?= view_cell('\App\Libraries\PatientPanel::Radiology', $patient_file) ?> 
            <!-- labtest -->
        </div>


        <div class="mt-2 section-style">
            <!-- Medicine -->
            <?= view_cell('\App\Libraries\PatientPanel::Medicine', $patient_file) ?> 
            <!-- Medicine -->
        </div>

        <div class="mt-2 section-style">
            <!-- Procedures -->
            <?= view_cell('\App\Libraries\PatientPanel::Procedures', $patient_file) ?>
            <!-- Procedures -->
        </div>

    </div> <!-- /file-content -->
</div><!-- /file -->
  <!-- <P>CLINICAL NOTE</P>
  <P> WORKING DIAGNOSIS </P>
  <P> FINAL DIAGNOSIS </P> -->

<?php } ?>
<?= $this->endSection() ?>