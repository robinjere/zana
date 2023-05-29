<?= $this->extend('./patient/history/layout') ?>
<?= $this->section('history') ?>
<div>
   
    <div class="labtest-table">
         <table id="table_labtest" class="table table-striped table-bordered">
            <thead>   
               <tr class="table-header">
                  <th scope="col">Date</th>
                  <th scope="col">Test</th>
                  <th scope="col">Result</th> 
                  <th scope="col">Ranges</th>
                  <th scope="col" >Unit</th>
                  <th scope="col" >Level</th>
                  <th scope="col" >doctor</th>
               </tr>
            </thead>
            <!-- <tfoot>
               <tr>
                  <th colspan="2" style="text-align:right">Total:</th>
                  <th colspan="3"></th>
               </tr>
           </tfoot> -->
        </table>
    </div><!-- /labtest-table -->
    


</div>
<?= $this->endSection('history') ?>

<?= $this->section('script') ?>
<script>
     function labTestTable(){
 
        $('#table_labtest').DataTable({
         dom: 'lBfrtip',
         buttons: [
            'print'
            // { extend: 'print', exportOptions:
            //     { columns: ':visible' }
            // }
           ],
          "order": [],
          "destroy": true,   
          "searching": false,
          "serverSide": true,
          "ordering": false,
          "ajax": {
            url: "<?= base_url('patientFileController/ajax_assignedlabtestTable') ?>",
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

   }
  //initial call
 labTestTable();

</script>
<?= $this->endSection('script') ?>