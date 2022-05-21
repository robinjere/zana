<?= $this->extend('dashboard/main'); ?>
<?= $this->section('data') ?>


<?php if(session()->get('success')): ?>
              <div class="alert alert-success" role="alert" style="max-width: 20rem;"> 
                 <?= session()->get('success'); ?>
              </div>
 <?php endif; ?>

<h2 class="data-heading mb-3">Expense</h2>


<div class="data-layout my-2 p-3 bg-white">

  <ul class="data-nav d-flex">
     <li class="py-2 me-3 data-nav__active"> <a href="list">Expense list</a>  </li>
     <?php if(in_array('can_add_expenses', session()->get('permission'))){?>
     <li class="py-2 me-3"> <a href="add">Add expense </a>  </li>
     <?php } ?>
  </ul>

  <?php if(in_array('can_view_expenses', session()->get('permission'))){?>
    <table id="user_table" class="table table-striped table-bordered">
      <thead>   
          <tr>
            <th scope="col">Date</th>
            <th scope="col">Description</th>
            <th scope="col">Amount</th>
            <th scope="col">Added By</th> 
            <th scope="col">Action</th>
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
      $('#user_table').DataTable({
        "order": [],
        "serverSide": true,
        "ajax": {
          url: "<?= base_url('expensecontroller/ajax_expenses') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>
