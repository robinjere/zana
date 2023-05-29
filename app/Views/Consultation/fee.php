
<?= $this->extend('consultation/layout') ?>
<?= $this->section('consultation') ?>
   <!-- <h1> consultation fee</h1> -->
   <table id="fees" class="table table-striped table-bordered">
            <thead>   
              <tr>
           
                <th scope="col">Updated at</th>
                <th scope="col">Name</th>
                <th scope="col">Amount(Tsh)</th> 
                <th scope="col" >Action</th>
                <!-- <th scope="col" >update</th> -->
              </tr>
          </thead>
      </table>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
  <script>
    $(document).ready(function(){
      $('#fees').DataTable({
        "order": [],
        "serverSide": true,
        "searching": false,
        "ajax": {
          url: "<?= base_url('consultationcontroller/ajax_getfees') ?>",
          type: "POST"
        }
      });
    });
  </script>
<?= $this->endSection() ?>