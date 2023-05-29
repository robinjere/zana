<?= $this->extend('dashboard/main'); ?>
<?= $this->section('data') ?>

<?php $Dashboard = '\App\Libraries\AdminPanel';  ?>

<h2 class="data-heading mb-3">Clinic</h2>

<?= view_cell('\App\Libraries\DashboardPanel::alert', ['validation'=> !empty($validation) ? $validation : '' ]) ?>

<div class="data-layout my-2 p-3 bg-white">

  <?= view_cell('\App\Libraries\DashboardPanel::ClinicNav') ?>

  <!-- view clinic -->
  <?= $this->renderSection('clinic'); ?>
  
 
</div> <!-- /data-layout -->
  

<?= $this->endSection() ?>

