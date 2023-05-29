<?= $this->extend('./patient/history/layout') ?>
<?= $this->section('history') ?>
<div>
   
      <div class="procedure-table">
         <table id="table_procedures" class="table table-striped table-bordered">
            <thead>   
               <tr class="table-header">
               <!-- 'created_at', 'name', 'amount','procedure_note' -->
                  <th scope="col">Date</th>
                  <th scope="col">Procedure</th>
                  <th scope="col">Procedure note</th>
                  <!-- <th scope="col">Amount</th>  -->
                  <!-- <th scope="col">Status</th>  -->
                  <th scope="col">Doctor</th>
                 
                     <!-- <th scope="col" >Action</th> -->
                 
                  <!-- <th scope="col" >update</th> -->
               </tr>
            </thead>
            <!-- <tfoot>
               <tr>
                  <th colspan="3" style="text-align:right">Total:</th>
                  <th colspan="4"></th>
               </tr>
           </tfoot> -->
        </table>
      </div><!-- /procedure-table -->
    


</div>
<?= $this->endSection('history') ?>

<?= $this->section('script') ?>
<script>
     
   function proceduresTable(){
      $(document).ready(function(){
        $('#table_procedures').DataTable({
          "ordering": false,
          "destroy": true,   
          "searching": false,
          "serverSide": true,
          "ajax": {
            url: "<?= base_url('patientFileController/ajax_assignedprocedureResult') ?>",
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
               .column(3)
               .data()
               .reduce(function (a, b) {
                     return intVal(a) + intVal(b);
               }, 0);

            // Total over this page
            pageTotal = api
               .column(3, { page: 'current' })
               .data()
               .reduce(function (a, b) {
                     return intVal(a) + intVal(b);
               }, 0);

            // Update footer
            $(api.column(3).footer()).html('Tsh' + total.toLocaleString('en-IN') + '/=  ');
          }
        });
      });
   }

   // initial request procedures
   proceduresTable()

</script>
<?= $this->endSection('script') ?>