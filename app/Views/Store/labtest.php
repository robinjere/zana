<?= $this->extend('dashboard/main'); ?>
<?= $this->section('data') ?>

<?php $Dashboard = '\App\Libraries\AdminPanel';  ?>

<h2 class="data-heading mb-3">Labtest</h2>

<div class="data-layout my-2 p-3 bg-white">

  <!-- display navigation  -->

  <?= view_cell('\App\Libraries\StorePanel::storeNav') ?>
   <div class="mt-2 d-flex justify-content-end">
     <a href="<?= base_url('store/addlabtest') ?>" class="btn btn-sm btn-success"> add labtest</a>
   </div>
  <?php 
     if(in_array('can_view_labtest', session()->get('permission'))){?>
      <table id="items" class="table table-striped table-bordered">
            <thead>   
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Labt Test</th>
                <th scope="col">Price</th> 
                <th scope="col">Description</th>
                <th scope="col" >Action</th>
                <!-- <th scope="col" >update</th> -->
              </tr>
          </thead>
      </table>

     <?php }else{ ?>
      <div class="alert alert-warning" role="alert">
        <strong>You are not allowed to view labtest</strong>
      </div>
      
     <?php }; ?>
  
 
</div> <!-- /data-layout -->
  

<?= $this->endSection() ?>

<?= $this->section('script') ?>
  <script>
    $(document).ready(function(){
      $('#items').DataTable({
        "order": [],
        "serverSide": true,
        "ajax": {
          url: "<?= base_url('storecontroller/ajax_getlabtest') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>
