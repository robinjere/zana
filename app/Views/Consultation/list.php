<?= $this->extend('consultation/layout') ?>
<?= $this->section('consultation') ?>
   <!-- <h1> consultation fee</h1> -->

   <?php if(in_array('can_view_consultation', session()->get('permission'))){  ?>
   <table id="fees" class="table table-striped table-bordered">
            <thead>   
              <tr>
                <th scope="col">Date</th>
                <th scope="col">Patient File</th>
                <th scope="col">Payment</th>
                <th scope="col">Doctor</th> 
                <th scope="col">Consultation Fee(Tsh)</th> 
                <th scope="col" >Action</th>
                <!-- <th scope="col" >update</th> -->
              </tr>
          </thead>
      </table>
    <?php }else{
      echo view_cell('\App\Libraries\DashboardPanel::NoPermission');
    } ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
  <script>
    $(document).ready(function(){
      $('#fees').DataTable({
        "order": [],
        "serverSide": true,
        "ajax": {
          url: "<?= base_url('consultationcontroller/ajax_getconsultation') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>