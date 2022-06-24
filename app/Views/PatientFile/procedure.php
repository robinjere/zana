<div id="procedure" class="procedures" x-data="proceduresData()" x-init="getProcedures()">
   <h5>
        <span class='icon'>
         <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M9 12H15M9 16H15M17 21H7C6.46957 21 5.96086 20.7893 5.58579 20.4142C5.21071 20.0391 5 19.5304 5 19V5C5 4.46957 5.21071 3.96086 5.58579 3.58579C5.96086 3.21071 6.46957 3 7 3H12.586C12.8512 3.00006 13.1055 3.10545 13.293 3.293L18.707 8.707C18.8946 8.89449 18.9999 9.1488 19 9.414V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
         </svg>
        </span> 
        <span>
          Procedures
        </span>  
   </h5>

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

   <!-- Assign Procedure -->
   <div><!-- procedure block -->
      <div class="d-flex justify-content-end"> <button @click="isAssign=true" type="button" class="btn btn-primary">Assign Procedure</button> </div>
      <form x-on:submit.prevent="assignProcedure()" x-show="isAssign">
          <div class="row">
             <div class="col">
                  <select x-model="selectedProcedure" class="form-select" aria-label="Select procedure">
                   <option selected> select procedure</option>
                   <template x-for="p in availableProcedures" :key="p.id">
                      <option :value="p.id" x-text="p.name"></option>
                   </template>
                   <!-- <option value="2">Two</option>
                   <option value="3">Three</option> -->
                  </select>
             </div>
             <div class="col">
                <div class="mb-3">
                  <!-- <label for="" class="form-label"></label> -->
                  <textarea class="form-control" x-model="procedureNote" placeholder="Add procedure note"></textarea>
                </div>
             </div>
          </div>
          <button type="submit" class="btn btn-primary">Submit Procedure</button>
      </form><!-- /form -->
   </div><!-- /div -->
  <!-- /Assign Procedure -->

</div><!-- /procedures -->

<script>
  function proceduresData(){
     
    return {
       isAssign : false,
       showAssignBtn: true,
       procedure: {id: '', name:'', price:0 },
       selectedProcedure: 0,
       procedureNote: '',
       availableProcedures: [{id: '', name:'', price:0 }],
       success: false, 
       message: '',
       filterProcedures(selectedProcedure){
           console.log('this invoked!')
           this.procedure = this.availableProcedures.filter(procedure => Number(procedure.id) == Number(selectedProcedure))[0]
       },
       getProcedures(){
          fetch('<?= base_url('patientFileController/ajax_getprocedures')?>', {
             headers: {Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}
          }).then(res => res.json()).then(data => {
            //  console.log('available procedure', data);
            this.availableProcedures = data
          })
       },
       assignProcedure(){
         this.filterProcedures(this.selectedProcedure);
         fetch('<?= base_url('patientFileController/ajax_assignprocedure') ?>', {
             method: 'POST',
             headers: {Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
             body: JSON.stringify({
              file_id: <?= $patient_file['id'] ?>,
              procedure_id: Number(this.procedure.id),
              doctor: <?= session()->get('id') ?>,
              procedure_note: this.procedureNote,
              amount: this.procedure.price,
             })
          }).then(res => res.json()).then(data => {
               this.success = data.success
               this.message = data.message
               this.selectedProcedure = 0
               this.procedureNote= ''
               this.showAssignBtn = true
               this.isAssign = false,
          }).catch(error => console.log('error', error))
       }
    }

  }   
</script>