<?= $this->extend('dashboard/main'); ?>
<?= $this->section('data') ?>

<?php $Dashboard = '\App\Libraries\AdminPanel';  ?>

<h2 class="data-heading mb-3">Drugs</h2>

<div class="data-layout my-2 p-3 bg-white">

  <!-- <ul class="data-nav d-flex">
     
     <?php if(in_array('can_view_item', session()->get('permission'))){?>
      <li class="py-2 me-3"> <a href="items">Drugs in store</a>  </li>
      <?php } ?>
       <?php if(in_array('can_add_drug', session()->get('permission'))){?>
        <li class="py-2 me-3"> <a href="additem">Add Drug </a>  </li>
      <?php } ?>
       <?php if(in_array('can_view_drugs_out_of_stock', session()->get('permission'))){?>
        <li class="py-2 me-3"> <a href="outofstock">Out of stock </a>  </li>
      <?php } ?>
       <?php if(in_array('can_view_items_near_to_end', session()->get('permission'))){?>
        <li class="py-2 me-3 data-nav__active"> <a href="outofstock">ITEMS NEAR TO END </a>  </li>
      <?php } ?>
  </ul> -->
  <?= view_cell('\App\Libraries\StorePanel::storeNav') ?>

  <?php if(in_array('can_view_drugs_out_of_stock', session()->get('permission'))){?>
    <table id="items" class="table table-striped table-bordered">
          <thead>   
            <tr class="table-header">
              <th scope="col">ID</th>
              <th scope="col">Date</th>
              <th scope="col">Item name</th>
              <th scope="col">Quantity</th> 
              <th scope="col">Buying Price</th>
              <th scope="col">Selling Price</th>
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
  
 
</div> <!-- /data-layout -->
  

<?= $this->endSection() ?>

<?= $this->section('script') ?>
  <script>
    $(document).ready(function(){
      $('#items').DataTable({
        "order": [],
        "serverSide": true,
        "ajax": {
          url: "<?= base_url('storecontroller/ajax_itemsneartoend') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>
