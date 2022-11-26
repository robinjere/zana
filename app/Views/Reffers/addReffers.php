<?= $this->extend('reffers/layout'); ?>

<?= $this->section('reffers'); ?>
<?= view_cell('\App\Libraries\DashboardPanel::alert', $validation ); ?>

     <div class="clinic-form">
           <form method="post" action="<?= base_url('reffers/addreffers') ?>">
             <div class="row registration-space-y">   
               <div class="col">
                 <input type="text" name="hospital_name" required value="<?= set_value('hospital_name', $reffers['hospital_name'])?>" class="form-control" placeholder="Hospital Name" aria-describedby="Hospital Name">
                </div>
               <div class="col">
                 <input type="text" required name="hospital_type" value="<?= set_value('hospital_type', $reffers['hospital_type'])?>" class="form-control" placeholder="Hospital Type" aria-describedby="Hospital Type">
                </div>
             </div><!-- /row -->

             <hr/>

            <div class="row mt-3">
                 <div class="col">
                     <a href="<?= base_url('reffers')?>" class="btn btn-warning btn-rounded"> Cancel </a>
                </div>
                 <div class="col d-flex justify-content-end">
                     <button class="btn btn-primary btn-rounded" style="width: 8rem;"> Save </button>
                </div>
            </div><!-- /row -->
         </form><!-- /form -->
     </div> <!-- /registration-form__form -->

<?= $this->endSection(); ?>

    
