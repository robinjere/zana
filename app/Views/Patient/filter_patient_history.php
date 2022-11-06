<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>

<div class="container history">

<a href="<?= base_url('patientfile/attend/'.$patient_file->id) ?>"  class="_back">Go back</a>

<?php if(!empty($patient_file) && isset($patient_file)){ ?>
<form action="/patientfile/history/<?= $patient_file->id ?>" method="post" class="history-form">
    <div class="header mb-4">
        <h4>Filter treatment history for <?= $patient_file->first_name .' '. $patient_file->middle_name .' '. $patient_file->sir_name ?></h4>
    </div>
    <h5 class="mb-3">File number: <?= $patient_file->file_no?> </h5>
    <div class="row">
        <div class="col">
            <label for="s_history" class="form-label">Start treatment</label>
            <input type="date" required class="form-control" name="start_treatment" value="<?= set_value('start_treatment') ?>" id="s_history" aria-describedby="s_history" placeholder="start_treatment"/>      
        </div>
        <div class="col">
            <label for="e_history" class="form-label">End treatment</label>
            <input type="date" required class="form-control" name="end_treatment" value="<?= set_value('end_treatment') ?>" id="e_history" aria-describedby="e_history" placeholder="end_treatment"/>      
        </div>
        <div class="col-2 d-flex  align-items-end ">
            <button type="submit" class="btn btn-success btn-sm" style="margin-bottom: 5px;">Search</button>
        </div>
    </div><!-- /row -->
</form>

<div id="p-history" > <!-- history data --> 
<?php if (isset($patient_history) && !empty($patient_history)) { ?>
    <div class="visits">
        <h5> Available visits history from <?= date_format(date_create($start), 'd F Y') ?>  to <?= date_format(date_create($end), 'd F Y') ?>  </h5>
        <!-- Hover added -->
        <div class="list-group visit">
            <?php
              foreach ($patient_history as $key => $history) {?>
                <form target="_blanck" method="post" action="<?= base_url('patientfile/history') ?>">
                  <input type="hidden" name="file_id" value="<?= $patient_file->id ?>"/>
                  <input type="hidden" name="start_treatment" value="<?= $history->start_treatment ?>"/>
                  <input type="hidden" name="end_treatment" value="<?= $history->end_treatment ?>"/>
                  <input type="hidden" name="clinic" value="<?= $history->clinic ?>"/>
                  <input type="hidden" name="payment_method" value="<?= $history->payment_method ?>"/>
                  <input type="hidden" name="consultation_fee" value="<?= $history->consultation_fee ?>"/>
                  <input type="submit" class="list-group-item list-group-item-action" value="Visit <?= ++$key ?> :  <?= date_format(date_create($history->start_treatment), 'd F Y') ?> to  <?= date_format(date_create($history->end_treatment), 'd F Y') ?>, Treatment done by <?= $history->payment_method ?>"/>
                  <!-- <a href="#" onclick='findHistory(<?= $patient_file->id ?>, <?= json_encode(date_format(date_create($history->start_treatment), "Y-m-d")) ?>, <?= json_encode(date_format(date_create($history->end_treatment), "Y-m-d")) ?>)' class="list-group-item list-group-item-action"> Start treatment on <?= date_format(date_create($history->start_treatment), 'd/m/Y') ?>, End treatment on <?= date_format(date_create($history->end_treatment), 'd/m/Y') ?>, Treatment done by <?= $history->payment_method ?> </a> -->
                </form>
              <?php }
            ?>
            <!-- <a href="#" class="list-group-item list-group-item-action"> Start treatment on 9/10/2022, End treatment on 10/10/2022, Treatment done by CASH </a>
            <a href="#" class="list-group-item list-group-item-action"> Start treatment on 9/10/2022, End treatment on 10/10/2022, Treatment done by CASH </a>
            <a href="#" class="list-group-item list-group-item-action"> Start treatment on 9/10/2022, End treatment on 10/10/2022, Treatment done by CASH </a>
            <a href="#" class="list-group-item list-group-item-action"> Start treatment on 9/10/2022, End treatment on 10/10/2022, Treatment done by CASH </a> -->
        </div>
    </div><!-- /visits -->
<?php }else if(isset($patient_history) && empty($patient_history)){ ?>

     <div class="my-3 pt-3 box-alert warning-alert d-flex align-items-start" >
     <div class="icon-alert px-3"> 
         <svg viewBox="0 0 51 50" fill="none">
             <path d="M7.77416 42.8087C5.342 40.5119 3.40202 37.7644 2.06742 34.7266C0.732827 31.6888 0.0303434 28.4215 0.000961476 25.1155C-0.0284205 21.8094 0.615887 18.5307 1.89629 15.4707C3.17669 12.4107 5.06755 9.63062 7.45853 7.29278C9.8495 4.95493 12.6927 3.1061 15.8223 1.85415C18.9518 0.602201 22.305 -0.0277889 25.6863 0.000940109C29.0675 0.0296691 32.409 0.716541 35.5159 2.02148C38.6227 3.32641 41.4326 5.22328 43.7817 7.6014C48.4203 12.2974 50.9871 18.587 50.929 25.1155C50.871 31.6439 48.1929 37.8889 43.4715 42.5054C38.7501 47.1219 32.3631 49.7405 25.6863 49.7973C19.0094 49.854 12.5769 47.3443 7.77416 42.8087ZM40.1911 39.298C44.0137 35.5603 46.1612 30.4909 46.1612 25.2051C46.1612 19.9192 44.0137 14.8498 40.1911 11.1122C36.3685 7.37451 31.1839 5.27471 25.7779 5.27471C20.3719 5.27471 15.1873 7.37451 11.3647 11.1122C7.54211 14.8498 5.39459 19.9192 5.39459 25.2051C5.39459 30.4909 7.54211 35.5603 11.3647 39.298C15.1873 43.0356 20.3719 45.1354 25.7779 45.1354C31.1839 45.1354 36.3685 43.0356 40.1911 39.298ZM23.2314 27.695V22.7152H28.3244V37.6546H23.2314V27.695ZM23.2314 12.7555H28.3244V17.7353H23.2314V12.7555Z" fill="#FB5A77"/>
         </svg>
     </div>
     <div class="message-alert"> 
         <h2 class="mb-2"> Errors occurs. </h2>
         <p> no patient history for this dates </p>
     </div>
   </div><!-- box-alert -->
   
<?php } ?>

</div><!-- /history-data -->

<?php } ?>
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
