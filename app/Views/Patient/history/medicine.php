<?= $this->extend('./patient/history/layout') ?>
<?= $this->section('history') ?>
<div>
   
<div class="medicine-table">
         <table id="table_medicine" class="table table-striped table-bordered">
            <thead>   
               <tr class="table-header">
                  <th scope="col">Date</th>
                  <th scope="col">Drug</th>
                  <th scope="col">Dosage </th>
                  <th scope="col">Route</th> 
                  <th scope="col">Frequency</th>
                  <th scope="col">Days</th>
                  <th scope="col">Qty</th>
                  <th scope="col">Instruction</th>
                  <?php
                  //   if(!session()->get('phistory')){ ?>

                        <th scope="col">Paid</th>
                        <th scope="col">Price/Qty</th>

                  <?php //}
                  ?>
                      <th scope="col" >Action</th>
                   
               </tr>
            </thead>
            <!-- <tfoot>
               <tr>
                  <th colspan="9" style="text-align:right">Total:</th>
                  <th colspan="2"></th>
               </tr>
           </tfoot> -->
        </table>
    </div><!-- /medicine-table -->
    


</div>
<?= $this->endSection('history') ?>

<?= $this->section('script') ?>
<script>
    
  function medicineTable(){
      $(document).ready(function(){
        $('#table_medicine').DataTable({
          "ordering":false,
          "destroy": true,   
          "searching": false,
          "serverSide": true,
          "ajax": {
            url: "<?= base_url('patientFileController/ajax_assignedmedicine') ?>",
            type: "POST",
            data: {
              file_id: <?= $patient_file->id ?>,
              start_date: '',
              end_date: ''
            }
          },
          footerCallback(){
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
               // console.log('before: i is -> ', i);
               let n = typeof i === 'string' ? i.replace(/[,\/=]/g, '') * 1 : typeof i === 'number' ? i : 0;
               // console.log('after: i is -> ', n);
               return n;
            };

            // Total over all pages
            total = api
               .column(9)
               .data()
               .reduce(function (a, b) {
                     return intVal(a) + intVal(b);
               }, 0);

            // Total over this page
            pageTotal = api
               .column(9, { page: 'current' })
               .data()
               .reduce(function (a, b) {
                     return intVal(a) + intVal(b);
               }, 0);

            // Update footer
            $(api.column(9).footer()).html('Tsh' + total.toLocaleString('en-IN') + '/=  ');
          }
        });
      });
   }
  //initial call
 medicineTable()


</script>
<?= $this->endSection('script') ?>