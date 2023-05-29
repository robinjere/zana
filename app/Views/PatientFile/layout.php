
<?php $Dashboard = '\App\Libraries\DashboardPanel';  ?>

<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>

<?php if(!empty($patient_file)){
  
    //change array data to stdClass object.
    $patient_file = json_decode( json_encode($patient_file));
    // print_r($patient_file);
    // exit;
    
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

  
  <?= view_cell($Dashboard.'::TopNavigation') ?>


  <div class="registration-layout">
    <?= view_cell('\App\Libraries\PatientPanel::PatientFileTopMenu', $patient_file) ?>
    
      <div class="container" style="padding-left:0; padding-right:0;">
           <?= $this->renderSection('file') ?>         
      </div><!-- /container -->
  </div> <!-- panel-layout -->

  
  <div class="position-relative">
    <?= view_cell($Dashboard.'::Footer') ?>
  </div>

<?= $this->endSection() ?>

<?php } ?>