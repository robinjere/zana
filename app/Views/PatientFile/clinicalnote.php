<div id="clinical-note" class="clinical-note"
  x-data="notesData()"
>
   <h5>
        <span class='icon'>
            <svg  viewBox="0 0 24 24" fill="none" >
              <path d="M11 4.99999H6C5.46957 4.99999 4.96086 5.21071 4.58579 5.58578C4.21071 5.96085 4 6.46956 4 6.99999V18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20H17C17.5304 20 18.0391 19.7893 18.4142 19.4142C18.7893 19.0391 19 18.5304 19 18V13M17.586 3.58599C17.7705 3.39497 17.9912 3.24261 18.2352 3.13779C18.4792 3.03297 18.7416 2.9778 19.0072 2.97549C19.2728 2.97319 19.5361 3.02379 19.7819 3.12435C20.0277 3.22491 20.251 3.37342 20.4388 3.5612C20.6266 3.74899 20.7751 3.97229 20.8756 4.21809C20.9762 4.46388 21.0268 4.72724 21.0245 4.9928C21.0222 5.25836 20.967 5.5208 20.8622 5.7648C20.7574 6.00881 20.605 6.2295 20.414 6.41399L11.828 15H9V12.172L17.586 3.58599Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span> 
        <span>
          Clinical Note
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
   <form x-on:submit.prevent >
      <div class="my-3 note-box">
         <div class="d-flex justify-content-end mb-2">
            <button class="btn btn-sm btn-success add-note" @click="addnote = true"> add clinical note </button>
         </div>
         <div class="input-note" x-cloak x-show="addnote" >
            <div class="clinical-btn">
               <button class="btn btn-sm btn-success" x-show="current_note.length" @click="addCurrentNote()"> save </button>
               <!-- <button class="btn btn-sm btn-success"> edit </button> -->
               <!-- <a href="" class="btn btn-sm btn-danger"> delete</a> -->
            </div> <!-- /clinical-btn -->
           <!-- <label for="note" class="form-label note-desc">Added by doctor Juma</label> -->
           <label for="note" class="form-label note-desc">Add note here</label>
           <textarea class="form-control pt-5 pb-3" id="note" x-model="current_note" placeholder="Type .." ></textarea>
         </div><!-- /input-note -->
     </div><!-- /my-3 -->
   </form>

   <!-- <div x-init="$nextTick(getClinicalNotes())">

   </div> -->

</div><!-- /clinical-note -->

<script defer>
   //note data state
   function notesData(){
    return {
     start_treatment: <?= date('Y-m-d', strtotime($patient_file['start_treatment'])) ?>,
     end_treatment: <?= date('Y-m-d', strtotime($patient_file['end_treatment'])) ?>, 
     addnote:false,
     current_note: '',
     notes: [],
     success: false,
     message: '',
     addCurrentNote(){
        fetch("<?= base_url('patientFileController/ajax_addnote') ?>", {
          method: 'POST',
          headers: {Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
          body: JSON.stringify({file_id: <?= $patient_file['id'] ?>, doctor: <?= session()->get('id') ?>, note: this.current_note })
       }).then(res => res.json())
       .then(data => {
            this.success = data.success
            this.message = data.message
           if(data.success){
                this.current_note = ''
                this.addnote = false
           }
         //  this.notes = data
         //  this.addnote = false
         // 
       }).catch(error => console.log(error))

      //  this.notes = custom_addnote(this.current_note)
     },
     getClinicalNotes(){
        fetch("<?= base_url('patientFileController/ajax_getclinicalnotes')?>", {
           method: 'POST',
           headers: { Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With':'XMLHttpRequest'},
           body: JSON.stringify({file_id:<?= $patient_file['id'] ?>, start_date: this.start_treatment, end_date: this.end_treatment})
        }).then(res => res.json())
        .then(data => {
           this.notes = data
        })
     }
   }
}

   // add clinical note 
 const custom_addnote = async(note='') => {
    if(note == '') window.alert('Please type on clinical note')
   let data = ''
   try {

      const response = await fetch(
      "<?= base_url('patientFileController/addnote') ?>",
       {
          method: 'POST',
          headers: {Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
          body: JSON.stringify({file_id: '', doctor: '', note: note })
       }
    );
    return await response.json()
   } catch (error) {
      console.log('error occur ->', error)
   }

   //   return $.post("<?= base_url('patientFileController/addnote') ?>", {file_id: '', doctor: '', note: note }, function(data){
   //          data = JSON.parse(data);
   //          console.log('added clinical note', data);
   //          return data;
   //   })

     console.log('file loaded..', data);
  }
  
</script>



