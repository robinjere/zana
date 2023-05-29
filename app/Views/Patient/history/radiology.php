<?= $this->extend('./patient/history/layout') ?>
<?= $this->section('history') ?>
<div>
   
<div class="labtest-table">
         <table id="table_radiology" class="table table-striped table-bordered">
            <thead>   
               <tr class="table-header">
                  <th scope="col">Date</th>
                  <th scope="col">Test name</th>
                  <th scope="col">Result</th> 
                  <th scope="col">Attachment</th> 
                  <th scope="col">Doctor</th>
                 
               </tr>
            </thead>
<!-- 
            <tfoot>
               <tr>
                  <th colspan="2" style="text-align:right">Total:</th>
                  <th colspan="3"></th>
               </tr>
           </tfoot> -->
        </table>
    </div><!-- /radiology-table -->
    


</div>
<?= $this->endSection('history') ?>

<?= $this->section('script') ?>
<script>
      function radiologyTable(){
      $(document).ready(function(){
        $('#table_radiology').DataTable({
          "ordering": false,
          "destroy": true,   
          "searching": false,
          "serverSide": true,
          "ajax": {
            url: "<?= base_url('patientFileController/ajax_assignedRadiologyResult') ?>",
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
               .column(2)
               .data()
               .reduce(function (a, b) {
                     return intVal(a) + intVal(b);
               }, 0);

            // Total over this page
            pageTotal = api
               .column(2, { page: 'current' })
               .data()
               .reduce(function (a, b) {
                     return intVal(a) + intVal(b);
               }, 0);

            // Update footer
            $(api.column(2).footer()).html('Tsh' + total.toLocaleString('en-IN') + '/=  ');
          }
        });
      });
   }
  //initial call
  radiologyTable()

</script>
<?= $this->endSection('script') ?>