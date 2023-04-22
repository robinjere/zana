<?= $this->extend('./patientfile/layout') ?>
<?= $this->section('file') ?>
<?php $uri = service('uri'); ?>
<!-- hosted patient_file variable -->
<?php if(!empty($patient_file)){
    //    echo $patient_file->id;

        
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
    // print_r($patient_file);
    // exit;
?>
    
<div class="file">
    <div class="file-header"> 
        <!-- <h3>FILE NO: <?= $patient_file['file_no'] ?></h3> -->
         <div class="file-status row">
             <?php 
                if($uri->getSegment(1) !== 'history'){ ?>
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
             <?php }else{ ?>
               <p class="text-align-center mb-0"> <b> Patient History  </b></p>
             <?php } ?>

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

    
        
    <div class="mt-2 section-style">
        <div>
          <nav class="nav nav-tabs flex-row">
            <?php if(in_array(session()->get('role'), ['doctor','admin', 'superuser' ]) && session()->get('role') != 'pharmacy' ){?> 
                <a id="clinical-note" class="nav-link  <?= $uri->getSegment(2) === 'clinical-note' ? 'active': null; ?>" href="<?= base_url('history/clinical-note/'.$patient_file['id']) ?>" aria-current="page">Clinical Note</a>
            <?php }?>

            <?php if(in_array(session()->get('role'), ['admin', 'superuser' ])){?> 
            <?php }?>

            <?php if(in_array(session()->get('role'), ['admin', 'superuser' ])){?> 
            <?php }?>

            <?php if(in_array(session()->get('role'), ['admin', 'superuser' ])){?> 
            <?php }?>
             
             <?php if($patient_file['patient_character'] !== 'outsider' && session()->get('role') != 'pharmacy' ) { ?>
              <a id="" class="nav-link  <?= $uri->getSegment(2) === 'general-examination' ? 'active': null; ?>" href="<?= base_url('history/general-examination/'.$patient_file['id']) ?>">General Examination</a>
             <?php } ?>

             <?php if($patient_file['patient_character'] !== 'outsider' && session()->get('role') != 'pharmacy' ) { ?>
              <a id="diagnosis" class="nav-link  <?= $uri->getSegment(2) === 'diagnosis' ? 'active': null; ?>" href="<?= base_url('history/diagnosis/'.$patient_file['id']) ?>">Diagnosis</a>
             <?php } ?>


             <?php
               if(session()->get('role') != 'pharmacy'){ ?>
                    <a class="nav-link  <?= $uri->getSegment(2) === 'labtest' || $uri->getSegment(2) === 'outsider-labtest' ? 'active': null; ?>" href="<?= $patient_file['patient_character'] == 'outsider' ? base_url('history/outsider-labtest/'.$patient_file['id']) : base_url('history/labtest/'.$patient_file['id']) ?>">Laboratory Test</a>

                    <a class="nav-link  <?= $uri->getSegment(2) === 'radiology' || $uri->getSegment(2) === 'outsider-radiology'  ? 'active': null; ?>" href="<?=  $patient_file['patient_character'] == 'outsider' ? base_url('history/outsider-radiology/'.$patient_file['id']) : base_url('history/radiology/'.$patient_file['id']) ?>">Radiology</a>

              <?php   } ?>


             <?php if($patient_file['patient_character'] !== 'outsider') { ?>
              <a class="nav-link  <?= $uri->getSegment(2) === 'medicine' ? 'active': null; ?>" href="<?= base_url('history/medicine/'.$patient_file['id']) ?>">Medicine</a>
             <?php } ?>

       

             <?php if($patient_file['patient_character'] !== 'outsider' && session()->get('role') != 'pharmacy'  ) { ?>
              <a class="nav-link  <?= $uri->getSegment(2) === 'procedures' ? 'active': null; ?>" href="<?= base_url('history/procedures/'.$patient_file['id']) ?>">Procedures</a>
             <?php } ?>

          </nav>
          <div class="mt-2">
            <?= $this->renderSection('history') ?>
          </div>
        </div>
    
     </div><!-- /section-style -->


  </div> <!-- /file-content -->
</div><!-- /file -->
  <!-- <P>CLINICAL NOTE</P>
  <P> WORKING DIAGNOSIS </P>
  <P> FINAL DIAGNOSIS </P> -->
<?php } ?>
<?= $this->endSection() ?>