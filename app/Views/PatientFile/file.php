<?= $this->extend('./patientfile/layout') ?>
<?= $this->section('file') ?>
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
                            <span class="date"> Jan 1, 2022</span>
                     </div>
                     <div class="col d-flex justify-content-end">
                         <span class="badge bg-secondary from"> To </span>
                     </div>
                     <div class="col">
                         <span class="date"> Jan 20, 2022</span>
                     </div>
                 </div><!-- /row -->
             </div><!-- /col-8 -->
            </div><!-- file-status --> 
    </div><!-- file-header -->
   <hr class="divider"/>
    <div class="file-content">
        <!-- clinical note  -->
        <?= view_cell('\App\Libraries\PatientPanel::ClinicalNote') ?>
    </div> <!-- /file-content -->
</div><!-- /file -->
  <!-- <P>CLINICAL NOTE</P>
  <P> WORKING DIAGNOSIS </P>
  <P> FINAL DIAGNOSIS </P> -->
<?= $this->endSection() ?>