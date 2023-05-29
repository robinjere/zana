<?= $this->extend('dashboard/main'); ?>
<?= $this->section('data') ?>

<?php if(!isset($overview)): ?>
    <?= view_cell('\App\Libraries\AdminPanel::noData') ?>
<?php else: ?>
<div class="data-layout my-2 bg-white">
   <p> overview based on user role will be displayed here </p>
</div> <!-- /data-layout -->
<?php endif; ?>

<?= $this->endSection() ?>
