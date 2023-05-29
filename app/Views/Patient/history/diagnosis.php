<?= $this->extend('./patient/history/layout') ?>
<?= $this->section('history') ?>
<div>
    


    <div class="row">
    <div class="col-6">
        <div class="working-diagnosis">
        <!-- <span class="line1"></span> -->
        <h4 class="py-4">Working diagnosis</h4>
            <table id="table_working_diagnosis" class="table table-striped table-bordered">
                <thead>   
                  <tr class="table-header">
                      <th scope="col">Date</th>
                      <th scope="col">Diagnoses</th>
                      <th scope="col">Diagnoses Note </th>
                      <?php if(session()->get('role') == 'doctor' && !session()->has('phistory')){?>
                        <th scope="col" >Action</th>
                      <?php } ?>
                  </tr>
                </thead>
            </table>
        </div><!-- /working-diagnosis -->
    </div><!-- /col-6 -->

    <div class="col-6">
          <div class="final-diagnosis">
          <!-- <span class="line2"></span> -->
          <h4 class="py-4">Final diagnosis</h4>
              <table id="table_final_diagnosis" class="table table-striped table-bordered">
                  <thead>   
                    <tr class="table-header">
                        <th scope="col">Date</th>
                        <th scope="col">Diagnoses</th>
                        <th scope="col">Diagnoses Note </th>
                        <?php if(session()->get('role') == 'doctor' && !session()->has('phistory')){?>
                          <th scope="col" >Action</th>
                        <?php } ?>
                    </tr>
                  </thead>
              </table>
          </div><!-- /final-diagnosis -->
      </div><!-- /col-6 -->

    </div><!-- /row -->
    


</div>
<?= $this->endSection('history') ?>

<?= $this->section('script') ?>
<script>
     function working_diagnoses(){
      $(document).ready(function(){
        $('#table_working_diagnosis').DataTable({
          "order": [],
          "destroy": true,   
          "searching": false,
          "serverSide": true,
          "ajax": {
            url: "<?= base_url('patientFileController/ajax_workingDiagnoses') ?>",
            type: "POST",
            data: {
              file_id: <?= $patient_file->id ?>,
              start_date: '',
              end_date: ''
            }
          }
        });
      });
    }
    working_diagnoses();

      function final_diagnoses(){
      $(document).ready(function(){
        $('#table_final_diagnosis').DataTable({
          "order": [],
          "destroy": true,   
          "searching": false,
          "serverSide": true,
          "ajax": {
            url: "<?= base_url('patientFileController/ajax_finalDiagnoses') ?>",
            type: "POST",
            data: {
              file_id: <?= $patient_file->id ?>,
              start_date: '',
              end_date: ''         
            }
          }
        });
      });
    }
    final_diagnoses();
</script>
<?= $this->endSection('script') ?>