
<?php $Dashboard = '\App\Libraries\DashboardPanel';  ?>

<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>
  
  <?= view_cell($Dashboard.'::TopNavigation') ?>

  <div class="registration-layout">

      <div class="container">
        <div class="row">
            <div class="col-3">
                <!-- side bar  -->
                    <?= view_cell('\App\Libraries\PatientPanel::PatientFileNav') ?>
                <!-- side bar navigation  -->
            </div><!-- col-3 -->

            <div class="col-9">
                 <div class="mt-4">
                  <!-- patient file  -->
                   <?= $this->renderSection('file') ?>
                  <!-- patient file  -->
                 </div> <!-- /mt-4 -->
            </div><!-- /col-9 -->

        </div><!-- /row -->
         
      </div><!-- /container -->
  </div> <!-- panel-layout -->


  <div class="position-relative">
    <?= view_cell($Dashboard.'::Footer') ?>
  </div>

<?= $this->endSection() ?>

