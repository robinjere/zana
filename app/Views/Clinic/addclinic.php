<?= $this->extend('clinic/layout'); ?>

<?= $this->section('clinic'); ?>
<?= view_cell('\App\Libraries\DashboardPanel::alert', $validation ); ?>

     <div class="clinic-form">
           <form method="post" action="<?= base_url('clinic/addclinic') ?>">
             <div class="row registration-space-y">   
               <div class="col">
                 <input type="text" name="name" required value="<?= set_value('name')?>" class="form-control" placeholder="Clinic Name" aria-describedby="Clinic Name">
                </div>
               <div class="col">
                 <input type="number" min="0"  required name="consultation_fee" value="<?= set_value('consultation_fee')?>" class="form-control" placeholder="Consultation Fee" aria-describedby="Consultation Fee">
                </div>
             </div><!-- /row -->

             <hr/>

            <div class="row mt-3">
                 <div class="col">
                     <a href="/clinic/" class="btn btn-warning btn-rounded"> Cancel </a>
                </div>
                 <div class="col d-flex justify-content-end">
                     <button class="btn btn-primary btn-rounded" style="width: 8rem;"> Save </button>
                </div>
            </div><!-- /row -->
         </form><!-- /form -->
     </div> <!-- /registration-form__form -->

<?= $this->endSection(); ?>

    
