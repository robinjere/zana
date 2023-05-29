<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>

<div class="container history">

    <a href="<?= base_url('patientfile/attend/'.$patient_file->id) ?>"  class="_back">Go back</a>

    <div class="p-history" > <!-- history data --> 
        <div class="header">
           <h1> <?= $patient_file->first_name .' '. $patient_file->middle_name .' '. $patient_file->sir_name .', '. 'FILE NUMBER:'. $patient_file->file_no .', CLINIC: '. $patient_file->name .', PAYMENT METHOD: '. $patient_file->payment_method .', '. $patient_file->patient_character  ?> </h1>
        </div>
        <div>
            <p class="text-align-center">Patient History </p>
            <?php $uri = service('uri'); ?>
          <nav class="nav nav-tabs flex-row">
            <?php if(in_array(session()->get('role'), ['doctor','admin', 'superuser' ])){?> 
                <a class="nav-link  <?= $uri->getSegment(2) === 'clinical-note' ? 'active': null; ?>" href="<?= base_url('history/clinical-note/'.$patient_file->id) ?>" aria-current="page">Clinical Note</a>
            <?php }?>

            <?php if(in_array(session()->get('role'), ['admin', 'superuser' ])){?> 
            <?php }?>

            <?php if(in_array(session()->get('role'), ['admin', 'superuser' ])){?> 
            <?php }?>

            <?php if(in_array(session()->get('role'), ['admin', 'superuser' ])){?> 
            <?php }?>

            <a class="nav-link  <?= $uri->getSegment(2) === 'general-examination' ? 'active': null; ?>" href="<?= base_url('history/general-examination/'.$patient_file->id) ?>">General Examination</a>
            <a class="nav-link  <?= $uri->getSegment(2) === 'diagnosis' ? 'active': null; ?>" href="#">Diagnosis</a>
            <a class="nav-link  <?= $uri->getSegment(2) === 'laboratory-test' ? 'active': null; ?>" href="#">Laboratory Test</a>
            <a class="nav-link  <?= $uri->getSegment(2) === 'radiology' ? 'active': null; ?>" href="#">Radiology</a>
            <a class="nav-link  <?= $uri->getSegment(2) === 'medicine' ? 'active': null; ?>" href="#">Medicine</a>
            <a class="nav-link  <?= $uri->getSegment(2) === 'procedures' ? 'active': null; ?>" href="#">Procedures</a>
          </nav>
          <div class="mt-2">
            <?= $this->renderSection('history') ?>
          </div>
        </div>
    </div><!-- /history-data -->

</div><!-- /container -->

<?= $this->endSection() ?>

<?= $this->section('script') ?>

  <script>
  
    //    function findHistory(file_id, start, end){
    //         const formData = new FormData();
    //         formData.append("file_id", file_id);
    //         formData.append("start_treatment", start);
    //         formData.append("end_treatment", end);
    //         const request = new XMLHttpRequest();
    //         request.open("POST", "<?= base_url('patientfile/history')?>", true);
    //         request.send(formData);
    //         console.log(formData)
    //         // console.log(file_id)
    //         // console.log(start)
    //         // console.log(end)
    //     } 
     

  </script>

<?= $this->endSection() ?>
