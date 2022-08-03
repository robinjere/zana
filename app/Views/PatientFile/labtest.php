<div id="laboratory-test" class="labtest mt-5" x-data="labtestData()">
   <div class="d-flex justify-content-between align-items-center">
      <h5>
           <span class='icon'>
              <svg viewBox="0 0 30 26" fill="none">
                <path d="M26.3445 18.121C25.9337 17.7101 25.4105 17.4301 24.8409 17.3162L21.329 16.6144C19.404 16.2294 17.4057 16.4971 15.6499 17.375L15.182 17.6075C13.4262 18.4854 11.4279 18.7531 9.50295 18.3681L6.66194 17.8002C6.18702 17.7053 5.69603 17.7291 5.23251 17.8695C4.769 18.0099 4.34731 18.2625 4.00485 18.605M9.5309 1.30737H21.301L19.8297 2.77863V10.388C19.8299 11.1683 20.14 11.9167 20.6919 12.4684L28.0482 19.8247C29.902 21.6785 28.5882 24.8476 25.9664 24.8476H4.86406C2.24227 24.8476 0.929909 21.6785 2.7837 19.8247L10.14 12.4684C10.6919 11.9167 11.002 11.1683 11.0022 10.388V2.77863L9.5309 1.30737Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
           </span> 
           <span>
             Laboratory Test
           </span>  
      </h5>

      <div class="d-flex justify-content-end mb-3">
            <button type="button" onclick="labTestResults()" class="btn btn-outline-primary" style="margin-right: 9px;" data-bs-toggle="modal" data-bs-target="#lab_Results">
                        View Result
            </button>

        <?php if(session()->get('role') == 'doctor'){ ?>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#customLabTest" @click="showSearchInput=true">Assign LabTest</button>
          <!-- <button type="button" class="btn btn-outline-primary" @click="assignDrug()" x-cloak x-show="showAssignArea">Assign LabTest</button> -->
        <?php } ?>
   </div>
      
      <!-- Modal -->
      <div class="modal fade" id="customLabTest" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Assign Lab Test</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                     <div class="mb-3">
                           <input type="text" x-model="searchInput" @keyup="searchLabTest()" x-cloak x-show="showSearchInput" class="form-control" name="" id="" aria-describedby="helpId" placeholder=" Search lab test">
                           <div class="d-flex justify-content-center align-items-center mt-2">
                              <div x-cloak x-show="loading" class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                              </div><!-- /spinner-border -->
                           </div><!-- /d-flex -->

                           <template x-if="labtests.length">
                              <ul class="w-100 list-group mt-1" style="overflow-y: scroll; max-height: 170px;">
                                 <!-- <a href="#" class="list-group-item list-group-item-action active">Active item</a> -->
                                 <template x-for="test in labtests">
                                 <li @click="selectLabTest(test.id)" data-bs-dismiss="modal" class="list-group-item list-group-item-action" x-text="test.name.toUpperCase()">Active item</li>
                                 </template>
                              </ul><!-- /ul -->
                           </template>
                     </div> <!-- /mb-3 -->
               </div><!-- modal-body -->
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>      
    <!-- /End-Modal -->

    <!-- Modal -->
    <div class="modal fade" id="lab_Results" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                  <div class="modal-dialog" style="max-width: 82%;" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title">Patient Result</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <div class="labtest-table">
                              <table id="table_labtestResult" class="table table-striped table-bordered">
                                       <thead>   
                                          <tr>
                                             <th scope="col">Test name</th>
                                             <th scope="col">Result</th>
                                             <th scope="col">Ranges</th> 
                                             <th scope="col">Unit</th>
                                             <th scope="col">Level</th>
                                             <th scope="col">Attachment</th>
                                             <th scope="col">Ordered on</th>
                                             <?php if(session()->get('role')== 'lab'){ ?>
                                                <th scope="col" >Action</th>
                                             <?php } ?>
                                          </tr>
                                       </thead>
                                 </table>
                              </div><!-- /procedure-table -->
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                           <!-- <button type="button" class="btn btn-primary">Save</button> -->
                        </div>
                     </div>
                  </div>
               </div><!-- modal -->
               <!-- End Modal -->
      
   </div><!-- /d-flex -->
    <!-- alert message -->

     <!-- icons -->
     <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
      <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
         <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
      </symbol>
      <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
         <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
      </symbol>
      <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
         <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
      </symbol>
      </svg>
     <!-- icons -->
   <template x-if="success== true">
      <div x-cloak x-show="success== true" class="alert alert-success d-flex align-items-center" role="alert">
         <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div x-text="message"></div>
      </div>
   </template>
   <template x-if="(success == false ) && message != '' ">
   <div x-cloak x-show="(success == false ) && message != '' " class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <div x-text="message"></div>
   </div>
   </template>

   <!-- alert message -->


   <div class="labtest-table">
         <table id="table_labtest" class="table table-striped table-bordered">
            <thead>   
               <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Test</th>
                  <th scope="col">Price</th> 
                  <th scope="col">Status</th>
                  <th scope="col" >Action</th>
               </tr>
            </thead>
        </table>
    </div><!-- /procedure-table -->

    <!-- add or updated  labtest result  -->

    <!-- Button trigger modal -->
    
    <!-- Modal -->
    <div class="modal fade mt-3" id="addLabtestResult_" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Add or Update Labtest Result </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <div class="d-flex justify-content-center align-items-center mt-2">
                <div x-cloak x-show="loading" class="spinner-border" role="status">
                      <span class="visually-hidden">Loading...</span>
                </div><!-- /spinner-border -->
              </div><!-- /d-flex -->
              <template x-if="!loading && labtestResult.id != ''">  
               
               <form @submit.prevent="submitResult()" method="post" enctype="multipart/form-data" >           
                 <div class="mb-3">
                   <label for="result_" class="form-label">Result</label>                 
                    <textarea class="form-control" x-model="labtestResult.result" id="result_" rows="3"></textarea>
                 </div>
                 <div class="mb-3">
                   <label for="_ranges" class="form-label">Ranges</label>
                   <select x-model="labtestResult.ranges"  class="form-control" name="" id="_ranges" placeholder="Ranges">
                     <option value="62.00 - 115.00 (µmol/L)">62.00 - 115.00 (µmol/L)</option>
                     <option value="44.20 - 107.00 (µmol/L)">44.20 - 107.00 (µmol/L)</option>
                   </select>
                 </div>
                 <div class="mb-3">
                   <label for="_unit" class="form-label"> Unit</label>
                   <input type="text" class="form-control" x-model="labtestResult.unit" id="_unit"  placeholder="Unit" />
                 </div>
                 <div class="mb-3">
                   <label for="_level" class="form-label">Level</label>
                   <select x-model="labtestResult.level" class="form-control" id="_level" placeholder="Level" >
                     <option value="high"> High </option>
                     <option value="medium"> Medium </option>
                     <option value="low"> Low </option>
                   </select>
                 </div>
                 <div class="mb-3">
                  <label for="attachment_" class="form-label">Attachment</label>
                  <input type="file" class="form-control" x-model="labtestResult.attachment" id="attachment_" placeholder="Attachment" aria-describedby="attachementHelp">
                  <div id="attachementHelp" class="form-text">upload file here</div>
                </div>
                </form> <!-- /form-post -->
              </template>
            </div><!-- /modal-body -->
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary">Verify Result</button>
            </div>
         </div>
      </div>
    </div>
    
    
    <!-- end -> add or updated  labtest result  -->


</div> <!-- /labtest -->

<?= $this->section('script') ?>
<script>

  function labtestData(){
      return {
         loading: false,
         success: false,
         message: '',
         showSearchBtn: true,
         showAssignArea: false,
         searchInput: '',
         showSearchInput: false,
         searchLabTest(){

          if(this.searchInput !== ''){
            this.loading = true;
            fetch('<?= base_url('patientFileController/ajax_searchlabtest') ?>',{
                method: 'post',
                headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                searchInput: this.searchInput
                })
              }).then(res => res.json()).then(data => {
                this.labtests = data.searchLabtest
                this.loading = false
             })
            }else{
            this.labtests = []
           }
         },
         labtests: [],
         selected: '',
         selectLabTest(selected){
            this.selected = this.labtests.filter(lab => Number(lab.id) == Number(selected))[0]
            fetch('<?= base_url('patientFileController/ajax_assignlabtest') ?>',{
                method: 'post',
                headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                   labtest_id : selected,
                   file_id: <?= $patient_file['id'] ?>,
                   price: this.selected.price,
                   doctor: <?= session()->get('id') ?>
                })
              }).then(res => res.json()).then(data => {
                       if(data.success){
                          labTestTable()
                       }
                       this.success = data.success
                       this.message = data.message
                       this.labtests = [];
                       this.showSearchInput = false
                    //    console.log('assignlabtest', data)
                   
             })
         },
         labtestResult: {
            id: '',
            result: '',
            ranges: '',
            unit: '',
            level: '',
            attachment: '',
         },
         getLabTestResult(labtestId){
              this.success = false;
              this.loading = true;
              fetch('<?= base_url('patientFileController/ajax_getLabtestResult') ?>',{
                method: 'post',
                headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                   labtest_id : labtestId
                })
              }).then(res => res.json()).then(data => {
                       data = data.result
                       console.log('result ----> data', data); 
                       this.loading = false;
                       this.labtestResult.id = data.id 
                       this.labtestResult.result = data.result
                       this.labtestResult.ranges = data.ranges
                       this.labtestResult.unit = data.unit
                       this.labtestResult.level = data.level
                       this.labtestResult.attachment = data.attachment
                     //   console.log('labtest result after', data);
             })
         },
         addLabTestResult(){

         }
      }
  }

  
  function labTestTable(){
      $(document).ready(function(){
        $('#table_labtest').DataTable({
          "order": [],
          "destroy": true,   
          "searching": false,
          "serverSide": true,
          "ajax": {
            url: "<?= base_url('patientFileController/ajax_assignedlabtest') ?>",
            type: "POST",
            data: {
              file_id: <?= $patient_file['id'] ?>,
              start_date: '<?= $patient_file['start_treatment'] ?>',
              end_date: '<?= $patient_file['end_treatment'] ?>'
            }
          }
        });
      });
   }
  //initial call
 labTestTable()

 function deleteAssignedLabtest(assignedLabtest){
  fetch('<?= base_url('patientFileController/ajax_deleteAssginedLabtest') ?>',{
            method: 'post',
            headers: {
              Accept: 'application/json',
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
               assignedLabtest: assignedLabtest
            })
          }).then(res => res.json()).then(data => {
             if(data.success){
               labTestTable()
             }
          })
 }

 function labTestResults(){
      $(document).ready(function(){
        $('#table_labtestResult').DataTable({
          "order": [],
          "destroy": true,   
          "searching": false,
          "serverSide": true,
          "ajax": {
            url: "<?= base_url('patientFileController/ajax_labtestResults') ?>",
            type: "POST",
            data: {
              file_id: <?= $patient_file['id'] ?>,
              start_date: '<?= $patient_file['start_treatment'] ?>',
              end_date: '<?= $patient_file['end_treatment'] ?>'
            }
          }
        });
      });
   }

   function addLabTestResult(labtestId){

   }

  </script>
<?= $this->endSection() ?>