<?= $this->extend('reffers/layout'); ?>

<?= $this->section('reffers'); ?>
<?php if(in_array(session()->get('role'), ['admin', 'superuser' ])){?>
    <table id="clinics" class="table table-striped table-bordered">
          <thead>   
            <tr class="table-header">
              <!-- <th scope="col">ID</th> -->
              <th scope="col">Date</th>
              <th scope="col">Hospital Name</th>
              <th scope="col">Hospital Type</th> 
              <!-- <th scope="col">Status</th>  -->
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
      $('#clinics').DataTable({
        "order": [],
        "serverSide": true,
        "ajax": {
          url: "<?= base_url('reffersController/ajax_reffers') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>