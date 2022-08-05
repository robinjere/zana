
<?php $Dashboard = '\App\Libraries\DashboardPanel';  ?>

<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>
  
  <?= view_cell($Dashboard.'::TopNavigation') ?>


  <div class="registration-layout">
    <?= view_cell('\App\Libraries\PatientPanel::PatientFileTopMenu') ?>
    
      <div class="container" style="padding-left:0; padding-right:0;">
           <?= $this->renderSection('file') ?>         
      </div><!-- /container -->
  </div> <!-- panel-layout -->

  
  <div class="position-relative">
    <?= view_cell($Dashboard.'::Footer') ?>
  </div>

<?= $this->endSection() ?>

