<?= $this->extend('dashboard/main'); ?>

<?= $this->section('module-css') ?>
  <link rel="stylesheet" href="/ward.css" />
<?= $this->endSection() ?> <!-- /module css -->

<?= $this->section('data') ?>

<?php $Dashboard = '\App\Libraries\AdminPanel';  ?>

<h2 class="data-heading mb-3">Ward</h2>

<div class="data-layout my-2 p-3 bg-white">

  <!-- display navigation  -->


<?php $uri = service('uri'); ?>

<ul class="data-nav d-flex">

     <!-- <li class="py-2 me-3 <?= $uri->getSegment(2) === 'ward' ? 'data-nav__active': null ?>"> 
         <a href="<?= base_url('ward') ?> ">Ward</a>  
      </li> -->

       <?php if(in_array('can_add_drug', session()->get('permission'))){?>
        <!-- <li class="py-2 me-3 <?= $uri->getSegment(2) === 'additem' ? 'data-nav__active': null ?>"> <a href="<?= base_url('store/additem') ?>">Add Drug </a>  </li> -->
       <?php } ?>

       <?php if(in_array('can_view_drugs_out_of_stock', session()->get('permission'))){?>
        <!-- <li class="py-2 me-3 <?= $uri->getSegment(2) === 'outofstock' ? 'data-nav__active': null ?>"> <a href="<?= base_url('store/outofstock') ?>">Out of stock </a>  </li> -->
      <?php } ?>

      <?php if(in_array('can_view_drugs_out_of_stock', session()->get('permission'))){?>
        <!-- <li class="py-2 me-3 <?= $uri->getSegment(2) === 'itemsneartoend' ? 'data-nav__active': null ?>"> <a href="<?= base_url('store/itemsneartoend') ?>">DRUGS NEAR TO END </a>  </li> -->
      <?php } ?>

      <!-- <?php if(in_array('can_view_labtest', session()->get('permission'))){?>
        <li class="py-2 me-3 <?= $uri->getSegment(2) === 'labtest' ? 'data-nav__active': null ?>"> <a href="labtest">LAB TEST </a>  </li>
      <?php } ?> -->

  </ul>

  <!-- Add ward section  -->
  <div class="ward-section mb-5">
    <fieldset>
        <label class="mb-2"> Add ward </label>
        <form action="" method="post" class="pt-2">
        <div class="mb-3 row">
            <div class="col">
                <label for="_ward" class="form-label">Select Ward</label>
                <select class="form-select " name="ward" id="_ward">
                    <option selected>Select one</option>
                    <option value="PRIVATE">Private</option>
                    <option value="GENERAL">General</option>
                </select>
            </div><!-- /col -->
            <div class="col">
                <label for="_status" class="form-label">Status</label>
                <select class="form-select " name="status" id="_status">
                    <option selected>Select one</option>
                    <option value="MALE">Male</option>
                    <option value="FEMALE">Female</option>
                </select>
            </div><!-- /col -->
            <div class="col">
                 <label for="_price" class="form-label">Price</label>
                 <input type="number"
                 min="0" steps="0.1"
                   class="form-control sm" name="price" id="_price" placeholder="Price">
            </div><!-- /col -->
            <div class="d-flex justify-content-end align-items-center mt-2">
                <button type="submit" class="btn btn-sm btn-success">ADD WARD</button>
            </div>
            
        </div>
        </form><!-- post add ward -->
    </fieldset>
  </div> <!-- /ward-section -->

  <p class="ward-list-title">Available wards</p>
  
  <?php 
     if(in_array('can_view_drug', session()->get('permission'))){?>
      <table id="wardList" class="table table-striped table-bordered">
            <thead>   
              <tr class="table-header">
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Name of ward</th>
                <th scope="col">Status</th> 
                <th scope="col">Price</th>
                <th scope="col">Room No</th>
                <th scope="col" >Action</th>
                <!-- <th scope="col" >update</th> -->
              </tr>
          </thead>
      </table>

     <?php }else{ ?>
      <div class="alert alert-warning" role="alert">
        <strong>You are not allowed to view wards</strong>
      </div>
      
     <?php }; ?>
  
 
</div> <!-- /data-layout -->
  

<?= $this->endSection() ?>

<?= $this->section('script') ?>
  <script>
    $(document).ready(function(){
      $('#wardList').DataTable({
        "order": [],
        "serverSide": true,
        "ajax": {
          url: "<?= base_url('wardcontroller/ajax_getWards') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>
