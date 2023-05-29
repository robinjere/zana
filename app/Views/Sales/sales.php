<?= $this->extend('dashboard/main'); ?>
<?= $this->section('data') ?>

<?php $Dashboard = '\App\Libraries\AdminPanel';  ?>

<?php if(session()->get('success')): ?>
              <div class="alert alert-success" role="alert" style="max-width: 20rem;"> 
                 <?= session()->get('success'); ?>
              </div>
 <?php endif; ?>

<h2 class="data-heading mb-3">Sales</h2>

<div class="data-layout my-2 p-3 bg-white">

  <ul class="data-nav d-flex">
     <li class="py-2 me-3 data-nav__active"> <a href="items">Sales</a>  </li>
     <?php if(in_array('can_sale_drug', session()->get('permission'))){?>
     <li class="py-2 me-3"> <a href="searchsale">Sale a Drug </a>  </li>
     <?php } ?>
     <li class="py-2 me-3"> <a href="#">WholeSale </a>  </li>
  </ul>
  <?php if(in_array('can_view_sales', session()->get('permission'))){?>

    <table id="items" class="table table-striped table-bordered">
        <thead>   
          <tr class="table-header">
            <th scope="col">Date</th>
            <th scope="col">Item name</th>
            <th scope="col">Quantity</th> 
            <th scope="col">Dose</th>
            <th scope="col">Price</th>
            <th scope="col" >discount</th>
            <!-- <th scope="col" >update</th> -->
          </tr>
      </thead>
  </table>
  <?php } else { ?>
    <div class="alert alert-warning" role="alert">
        <strong>You are not allowed to view </strong>
      </div>
   <?php } ?>

  
 
</div> <!-- /data-layout -->
  

<?= $this->endSection() ?>

<?= $this->section('script') ?>
  <script>
    $(document).ready(function(){
      $('#items').DataTable({
        "order": [],
        "serverSide": true,
        "ajax": {
          url: "<?= base_url('storecontroller/ajax_sales') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>
