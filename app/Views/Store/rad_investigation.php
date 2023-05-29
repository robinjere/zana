<?= $this->extend('dashboard/main'); ?>
<?= $this->section('data') ?>

<?php $Dashboard = '\App\Libraries\AdminPanel';  ?>

<h2 class="data-heading mb-3">Rad Investigation</h2>

<div class="data-layout my-2 p-3 bg-white">

  <!-- display navigation  -->

    <?php $uri = service('uri'); ?>
    <ul class="data-nav d-flex">
       <?php if(in_array('can_view_radiology', session()->get('permission'))){?>
        <li class="py-2 me-3 <?= $uri->getSegment(2) === 'radiology' ? 'data-nav__active': null ?>"> <a href="labtest">RADIOLOGY LIST </a>  </li>
      <?php } ?> 
    </ul>

   <div class="mt-2 d-flex justify-content-end">
    <?php if(in_array('can_add_radiology', session()->get('permission'))){?>
        <a href="<?= base_url('store/addRadInvestigation') ?>" class="btn btn-sm btn-success">add radiology</a>
    <?php } ?>
   </div>
  <?php 
     if(in_array('can_view_labtest', session()->get('permission'))){?>
      <table id="items" class="table table-striped table-bordered">
            <thead>   
              <tr class="table-header">
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Test name</th>
                <th scope="col">Price</th> 
                <th scope="col" >Action</th>
                <!-- <th scope="col" >update</th> -->
              </tr>
          </thead>
      </table>

     <?php }else{ ?>
      <div class="alert alert-warning" role="alert">
        <strong>You are not allowed to view radiology</strong>
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
          url: "<?= base_url('storecontroller/ajax_getradiology') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>
