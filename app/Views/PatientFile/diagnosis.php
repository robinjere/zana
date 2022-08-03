<div id="diagnosis" class="diagnosis mt-5" x-data="diagnosisData()">
  <div class="d-flex justify-content-between align-items-center ">
   <h5>
        <span class='icon'>
           <svg  viewBox="0 0 24 24" fill="none">
               <path d="M8 16L10.879 13.121M10.879 13.121C11.1567 13.4033 11.4876 13.6279 11.8525 13.7817C12.2174 13.9355 12.6092 14.0156 13.0052 14.0172C13.4012 14.0189 13.7936 13.9421 14.1599 13.7914C14.5261 13.6406 14.8588 13.4188 15.1388 13.1388C15.4189 12.8588 15.6408 12.5262 15.7916 12.16C15.9425 11.7938 16.0193 11.4014 16.0177 11.0054C16.0162 10.6094 15.9362 10.2176 15.7825 9.85265C15.6287 9.48768 15.4043 9.15677 15.122 8.879C14.5579 8.32389 13.7973 8.01417 13.0059 8.0173C12.2145 8.02043 11.4564 8.33615 10.8967 8.89571C10.337 9.45526 10.0211 10.2133 10.0178 11.0047C10.0145 11.7961 10.324 12.5568 10.879 13.121ZM21 12C21 13.1819 20.7672 14.3522 20.3149 15.4442C19.8626 16.5361 19.1997 17.5282 18.364 18.364C17.5282 19.1997 16.5361 19.8626 15.4442 20.3149C14.3522 20.7672 13.1819 21 12 21C10.8181 21 9.64778 20.7672 8.55585 20.3149C7.46392 19.8626 6.47177 19.1997 5.63604 18.364C4.80031 17.5282 4.13738 16.5361 3.68508 15.4442C3.23279 14.3522 3 13.1819 3 12C3 9.61305 3.94821 7.32387 5.63604 5.63604C7.32387 3.94821 9.61305 3 12 3C14.3869 3 16.6761 3.94821 18.364 5.63604C20.0518 7.32387 21 9.61305 21 12Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
           </svg>
        </span> 
        <span>
          Diagnosis
        </span>  
   </h5>
   
   <!-- Button trigger modal -->
   <?php if(session()->get('role') == 'doctor'){ ?>
     <div class="d-flex justify-content-end mb-3">
       <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#DiagnosisModelId" @click="openDiagnosisBox()">Assign Diagnosis</button>
     </div><!-- /d-flex -->
   <?php } ?>
   
   <!-- Modal -->
   <div class="modal fade" id="DiagnosisModelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Assign Diagnosis</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <form x-on:submit.prevent x-cloak x-show="showDiagnosisBox">
              <div class="mb-3">
                    <input type="text" x-model="searchInput" @keyup="searchDiagnosis()"  class="form-control" name="" id=""  placeholder="Search Diagnosis">   
                      <div class="d-flex justify-content-center align-items-center mt-2">
                        <div x-cloak x-show="loading" class="spinner-border" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div><!-- /spinner-border -->
                      </div><!-- /d-flex -->
                    <template x-show="showSearch" x-cloak x-if="diagnosis.length">
                      <ul class="w-100 list-group mt-1" style="overflow-y: scroll; max-height: 170px;">
                        <!-- <a href="#" class="list-group-item list-group-item-action active">Active item</a> -->
                        <template x-for="d in diagnosis">
                          <li @click="selectDiagnoses(d.id)" class="list-group-item list-group-item-action">
                              <span class="badge bg-success badge-sm" x-text="d.diagnosis_code.toUpperCase()"></span>, 
                              <span class="ml-2" x-text="d.diagnosis_description.toLowerCase()"></span>
                          </li>
                        </template>
                      </ul><!-- /ul -->
                    </template>
              </div> <!-- /mb-3 -->

              <div class="mb-3">
                <!-- <label for="" class="form-label"></label> -->
                <textarea class="form-control" x-model="diagnosis_note" id="" rows="3" placeholder="Clinical note on Diagnosis"></textarea>
              </div>
              
                  <!-- <template x-if="selectedDiagnos">
                      <div class="present_diagnosis">
                        <button class="btn btn-danger btn-sm close-btn" @click="selectedDiagnos=''">&#9587;</button>
                        <div classs="selectedDiagnosis p4">
                          <span class="badge bg-success badge-sm" x-text="selectedDiagnos.diagnosis_code.toUpperCase()"></span>, 
                          <span class="ml-2" x-text="selectedDiagnos.diagnosis_description.toUpperCase()"></span>
                        </div>
                        <div class="d-flex  align-items-center mt-3">
                          <button type="button" class="btn btn-sm btn-primary"  @click="assignDiagnoses('working')">working Diagnoses</button>
                          <span> - </span> <span class="badge bg-primary"> OR </span> <span> - </span> 
                          <button type="button" class="btn btn-sm btn-success"  @click="assignDiagnoses('final')">final Diagnoses</button>
                        </div>
                      </div>
                  </template> -->
              
          </form><!-- /form -->
        </div><!-- /modal-body -->
        <div class="modal-footer d-flex justify-content-between align-items-center">
          <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal" @click="assignDiagnoses('working')">working Diagnoses</button>
          <button type="button" class="btn btn-sm btn-success" data-bs-dismiss="modal" @click="assignDiagnoses('final')">final Diagnoses</button>
        </div>
      </div>
    </div><!-- /modal-dialog -->
   </div><!-- /modal -->
  <!-- /Modal -->

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

  

   

   <div class="row">
    <div class="col-6">
        <div class="working-diagnosis">
        <span class="line1"></span>
        <h4 class="py-4">Working diagnosis</h4>
            <table id="table_working_diagnosis" class="table table-striped table-bordered">
                <thead>   
                  <tr>
                      <th scope="col">Date</th>
                      <th scope="col">Diagnoses</th>
                      <th scope="col">Diagnoses Note </th>
                      <?php if(session()->get('role') == 'doctor'){?>
                        <th scope="col" >Action</th>
                      <?php } ?>
                  </tr>
                </thead>
            </table>
        </div><!-- /working-diagnosis -->
    </div><!-- /col-6 -->
    <div class="col-6">
        <div class="final-diagnosis">
        <span class="line2"></span>
        <h4 class="py-4">Final diagnosis</h4>
            <table id="table_final_diagnosis" class="table table-striped table-bordered">
                <thead>   
                  <tr>
                      <th scope="col">Date</th>
                      <th scope="col">Diagnoses</th>
                      <th scope="col">Diagnoses Note </th>
                      <?php if(session()->get('role') == 'doctor'){?>
                        <th scope="col" >Action</th>
                      <?php } ?>
                  </tr>
                </thead>
            </table>
        </div><!-- /final-diagnosis -->
    </div><!-- /col-6 -->
   </div><!-- /row -->




</div><!-- /diagnosis -->

<?= $this->section('script') ?>
<script>

  function diagnosisData(){
    return {
      loading: false,
      success: false,
      message: '', 
      showDiagnosisBox: false,
      showAssignDiagnosisBtn: true,
      searchInput: '',
      showSearch: true,
      diagnosis: [],
      selectedDiagnos: '',
      diagnosis_note: '',
      openDiagnosisBox(){
          this.showDiagnosisBox = true
          this.showAssignDiagnosisBtn = false
          this.showSearch = true
      },
      closeDiagnosisBox(){
          this.showDiagnosisBox = false
          this.showAssignDiagnosisBtn = true
          this.showSearch = false
      },
      selectDiagnoses(d_id){
        this.showSearch = false
        this.selectedDiagnos = this.diagnosis.filter(_d => Number(_d.id) == Number(d_id))[0]
        this.diagnosis = []
        this.searchInput = this.selectedDiagnos.diagnosis_description.toUpperCase()
      },
      searchDiagnosis(){
        if(this.searchInput !== ''){
          this.loading = true;
          fetch('<?= base_url('patientFileController/ajax_searchdiagnosis') ?>',{
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
              this.diagnosis = data.diagnosis
              this.loading = false;
          })
        }else{
          this.diagnosis = []
        }
      },
      assignDiagnoses(diagnoses_type){
           if(this.selectedDiagnos){
              fetch('<?= base_url('patientFileController/ajax_assigndiagnosis') ?>',{
                method: 'post',
                headers: {
                  Accept: 'application/json',
                  'Content-Type': 'application/json',
                  'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                  file_id: <?= $patient_file['id'] ?>,
                  diagnoses_id: Number(this.selectedDiagnos.id),
                  diagnoses_type:  diagnoses_type,
                  diagnoses_note: this.diagnosis_note,
                  doctor: <?= session()->get('id') ?>
                })
              }).then(res => res.json()).then(data => {
                   this.success = data.success
                   this.message = data.message
                   if(this.success){
                     switch (diagnoses_type) {
                       case 'working':
                           working_diagnoses()
                           this.selectedDiagnos = ''
                         break;
                       case 'final':
                           final_diagnoses()
                           this.selectedDiagnos = ''
                         break;
                     
                       default:
                         break;
                     }
                   }
                  this.closeDiagnosisBox()
              })
           }
        
      }
    }
  }

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
              file_id: <?= $patient_file['id'] ?>,
              start_date: '<?= $patient_file['start_treatment'] ?>',
              end_date: '<?= $patient_file['end_treatment'] ?>'
            }
          }
        });
      });
  }
  working_diagnoses()
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
              file_id: <?= $patient_file['id'] ?>,
              start_date: '<?= $patient_file['start_treatment'] ?>',
              end_date: '<?= $patient_file['end_treatment']?>'
            }
          }
        });
      });
  }
  final_diagnoses()

  function deleteDiagnose(diagnose_id, diagnose_type){
     fetch('<?= base_url('patientFileController/ajax_deleteDiagnosis') ?>',{
            method: 'post',
            headers: {
              Accept: 'application/json',
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
               id: diagnose_id
            })
          }).then(res => res.json()).then(data => {
             if(data.success){
              switch (diagnose_type) {
                       case 'working':
                           working_diagnoses()
                         break;
                       case 'final':
                           final_diagnoses()
                         break;
                     
                       default:
                         break;
                    }
             }
       })
  }
    
</script>
<?= $this->endSection() ?>