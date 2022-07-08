<?= $this->extend('clinic/layout'); ?>

<?= $this->section('clinic'); ?>
<?php if(in_array('can_view_drugs_out_of_stock', session()->get('permission'))){?>
    <table id="items" class="table table-striped table-bordered">
          <thead>   
            <tr>
              <!-- <th scope="col">ID</th> -->
              <th scope="col">Date</th>
              <th scope="col">Name</th>
              <th scope="col">Consultation Fee</th> 
              <!-- <th scope="col">Buying Price</th>
              <th scope="col">Selling Price</th> -->
              <th scope="col" >Action</th>
              <!-- <th scope="col" >update</th> -->
            </tr>
        </thead>
    </table>
    <?php }else{ ?>
      <div class="alert alert-warning" role="alert">
        <strong>You are not allowed to view </strong>
      </div>

    <?php } ?>

<?= $this->endSection(); ?>

    
<?= $this->section('script') ?>
  <script>
    $(document).ready(function(){
      $('#items').DataTable({
        "order": [],
        "serverSide": true,
        "ajax": {
          url: "<?= base_url('cliniccontroller/ajax_clinics') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>