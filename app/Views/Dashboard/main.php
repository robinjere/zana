
<?php $Dashboard = '\App\Libraries\DashboardPanel';  ?>

<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>
  
  <?= view_cell($Dashboard.'::TopNavigation') ?>

  <div class="registration-layout">
       <?php
           if(session()->get('no_out_of_stock') || session()->get('itemsNearToEnd') ){ ?>
                <div class="alert alert-danger text-center">
                  <?php if(session()->get('no_out_of_stock')){ ?>
                    <p class="mb-0"> <small>Hey!, </small> There are <?= session()->get('no_out_of_stock') ?> items out of stock <b class="text-danger"> <a  href="/store/outofstock">view here</a> </b> </p>
                    
                    <?php  } ?>
                    <?php if(session()->get('itemsNearToEnd')){ ?>
                      <p class="mb-0"> <small>Hey!, </small> There are <?= session()->get('itemsNearToEnd') ?> items going to finish <b class="text-danger"> <a  href="/store/itemsneartoend">view here</a> </b> </p>

                   <?php  } ?>
                </div>
       <?php }  ?>

      <div class="container">
        <div class="row">
            <div class="col-2">
                <!-- side bar navigation  -->
                <?= view_cell($Dashboard.'::SideBarNavigation') ?>
                <!-- side bar navigation  -->
            </div><!-- col-3 -->

            <div class="col-10">
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
    <?= view_cell($Dashboard.'::Footer') ?>
  </div>

<?= $this->endSection() ?>

