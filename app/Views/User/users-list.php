<?= $this->extend('dashboard/main'); ?>
<?= $this->section('data') ?>

<h2 class="data-heading mb-3">Users</h2>

<?php if(!isset($count_users) && $count_users <= 0): ?>
    <?= view_cell('\App\Libraries\AdminPanel::noData') ?>
<?php else: ?>
<div class="data-layout my-2 p-3 bg-white">

  <ul class="data-nav d-flex">
     <li class="py-2 me-3 data-nav__active"> <a href="users">Users list</a>  </li>
     <?php if(in_array('can_register_user', session()->get('permission'))){?>
      <li class="py-2 me-3"> <a href="registration">Register user </a>  </li>
     <?php } ?>
     
  </ul>
   

  <?php if(in_array('can_view_users_list', session()->get('permission'))){?>
    <table id="user_table" class="table table-striped table-bordered">
      <thead>   
          <tr>
            <th scope="col">ID</th>
            <th scope="col">First name</th>
            <th scope="col">Last name</th>
            <th scope="col">Position</th>
            <th scope="col">Status</th> 
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

<?php endif; ?>
  

<?= $this->endSection() ?>

<?= $this->section('script') ?>
  <script>
    $(document).ready(function(){
      $('#user_table').DataTable({
        "order": [],
        "serverSide": true,
        "ajax": {
          url: "<?= base_url('user/ajax_getUsers') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>
