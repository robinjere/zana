<?= $this->extend('dashboard/main'); ?>
<?= $this->section('data') ?>

<?php $Dashboard = '\App\Libraries\AdminPanel';  ?>

<h2 class="data-heading mb-3">Procedures</h2>

<div class="data-layout my-2 p-3 bg-white">

  <!-- display navigation  -->

    <?php $uri = service('uri'); ?>
    <ul class="data-nav d-flex">
       <?php if(in_array('can_view_procedure', session()->get('permission'))){?>
        <li class="py-2 me-3 <?= $uri->getSegment(2) === 'procedures' ? 'data-nav__active': null ?>"> <a href="procedure">PROCEDURE LIST </a>  </li>
      <?php } ?> 
    </ul>

   <div class="mt-2 d-flex justify-content-end">
    <?php if(in_array('can_add_radiology', session()->get('permission'))){?>
        <a href="<?= base_url('store/addProcedure') ?>" class="btn btn-sm btn-success">add procedure</a>
    <?php } ?>
   </div>
  <?php 
     if(in_array('can_view_labtest', session()->get('permission'))){?>
      <table id="items" class="table table-striped table-bordered">
            <thead>   
              <tr class="table-header">
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th> 
                <th scope="col" >Action</th>
                <!-- <th scope="col" >update</th> -->
              </tr>
          </thead>
      </table>

     <?php }else{ ?>
      <div class="alert alert-warning" role="alert">
        <strong>You are not allowed to view procedures</strong>
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
          url: "<?= base_url('storecontroller/ajax_getprocedures') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>
