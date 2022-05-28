<?= $this->extend('Dashboard/main'); ?>
<?= $this->section('data'); ?>
   <?php $PatientPanel = '\App\Libraries\ConsultationPanel';  ?>
   <h2 class="data-heading mb-3">Patient</h2>

<div class="data-layout my-2 p-3 bg-white">
   <?= view_cell($PatientPanel.'::ConsultationNavigation'); ?>
   <?= $this->renderSection('consultation'); ?>
</div>
<?= $this->endSection(); ?>