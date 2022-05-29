
<?= $this->extend('consultation/layout') ?>
<?= $this->section('consultation') ?>
   <!-- <h1> Add fee</h1> -->
   <p class="small"> <b> Consultation fee, </b> </p>
   <form method="post" action="add_fee">
            <div class="registration-space-y">   
               <!-- <label for="" class="form-label"></label> -->
               <select class="form-control" name="role_id" >
                  <option> Select role </option>
                     <?php foreach($roles as $role): ?> 
                       <option value="<?= $role['id']; ?>"> <?= $role['name']; ?> </option>
                      <?php endforeach; ?> 
                     </select>
                  </div><!-- /row -->
                  
                  <div class="registration-space-y">
                       <input type="number" step="any" name="amount" value="<?= set_value('amount') ?>" class="form-control" placeholder="Amount" aria-describedby="Amount">
                  </div>

            <div class="row mt-3">
                 <div class="col">
                     <a href="/consultation/fees" class="btn btn-warning btn-rounded"> Cancel </a>
                </div>
                 <div class="col d-flex justify-content-end">
                     <button class="btn btn-primary btn-rounded" style="width: 8rem;"> add </button>
                </div>
            </div><!-- /row -->
         </form><!-- /form -->
<?= $this->endSection() ?>