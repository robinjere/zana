<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>
  
  <?= view_cell('\App\Libraries\AdminPanel::panelNav') ?>

  <div class="registration-layout">
      <div class="container">
        <div class="row">
            <div class="col-3">
                <!-- side bar navigation  -->
                <?= view_cell('App\Libraries\AdminPanel::sideBarNavigation') ?>
                <!-- side bar navigation  -->
            </div><!-- col-3 -->

            <div class="col-9">
                 <div class="mt-4">
                  <!-- data list  -->
                      <?= $this->renderSection('data'); ?>
                  <!-- data list  -->
                 </div> <!-- /mt-4 -->
            </div><!-- /col-9 -->

        </div><!-- /row -->
         
      </div><!-- /container -->
  </div> <!-- panel-layout -->


  <div class="position-relative">
    <?= view_cell('\App\Libraries\AdminPanel::footer') ?>
  </div>

<?= $this->endSection() ?>

