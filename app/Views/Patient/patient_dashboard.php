<?= $this->extend('Dashboard/main'); ?>
<?= $this->section('data'); ?>
   <?php $PatientPanel = '\App\Libraries\PatientPanel';  ?>
   <h2 class="data-heading mb-3">Patient</h2>

   <?= view_cell('\App\Libraries\AdminPanel::alert', ['validation'=> !empty($validation) ? $validation : '' ]) ?>

<div class="data-layout my-2 p-3 bg-white">
   <?= view_cell($PatientPanel.'::PatientNavigation'); ?>
   <?= $this->renderSection('patient'); ?>
</div>
<?= $this->endSection(); ?>