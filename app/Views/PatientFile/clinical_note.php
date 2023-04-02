
<div id="clinical-note" class="clinical-note" x-data="$store.notesData"  x-init="getClinicalNotes()">

  <div class="d-flex justify-content-between align-items-center mb-2">
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
     <?php if(!$patient_file['ishistory'] && in_array(session()->get('role'), ['doctor']) ){ ?>
      <template x-if="usercheck"> 
         <button class="btn btn-sm btn-success add-note" @click="newNote()"> Add clinical note </button>
     </template>
     <?php }; ?>
  </div><!-- d-flex -->

  <template x-if=" current_note === false"> 
  <form x-cloak x-show=" current_note === false " @submit.prevent>
      <div  class="clinical_note_container p-3 mt-3">
        <div class="note-section main_complain">
             <span>Main complain</span>
             <textarea name="main_complain" x-model.debounce="notes[0].main_complain" x-text="notes[0].main_complain" @change="addCurrentNote()" class="form-control mb-2 pt-4" cols="30" rows="2"></textarea>
        </div> <!-- /main_complain -->
        <div class="note-section history_of_presert">  
             <span>History of present illness </span>
             <textarea name="history_of_present" x-model.debounce="notes[0].history_of_present"  x-text="notes[0].history_of_present"  @change="addCurrentNote()" class="form-control mb-2 pt-4" cols="30" rows="2"></textarea>
        </div> <!-- /history_of_presert -->
        <div class="note-section past_medical_history">  
            <span>Past medical history </span>
            <textarea name="past_medical_history" x-model.debounce="notes[0].past_medical_history" x-text="notes[0].past_medical_history" @change="addCurrentNote()" class="form-control mb-2 pt-4" cols="30" rows="2"></textarea>
        </div> <!-- /past_medical_history -->
        <div class="note-section family_social_history">  
            <span>Family social history</span>
            <textarea name="family_social_history" x-model.debounce="notes[0].family_social_history" x-text="notes[0].family_social_history" @change="addCurrentNote()" class="form-control mb-2 pt-4" cols="30" rows="2"></textarea>
        </div> <!-- /family_social_history -->
        <div class="note-section drug_allergy_history">  
            <span>Drug and allergy history  </span>
            <textarea name="drug_allergy_history"  x-model.debounce="notes[0].drug_allergy_history" x-text="notes[0].drug_allergy_history" class="form-control mb-2 pt-4" cols="30" rows="3"></textarea>
        </div> <!-- /family_social_history -->
        <div class="note-section review_complain">  
            <span>Review of other complain </span>
            <textarea name="review_complain" x-model.debounce="notes[0].review_complain" x-text="notes[0].review_complain" @change="addCurrentNote()" class="form-control mb-2 pt-4" cols="30" rows="2"></textarea>
        </div> <!-- /review_complain -->
        <div class="note-section physical_examination">  
            <span>Physical Examination </span>
            <textarea name="physical_examination"  x-model.debounce="notes[0].physical_examination" x-text="notes[0].physical_examination" class="form-control mb-2 pt-4" cols="30" rows="3"></textarea>
        </div> <!-- /review_complain -->
      </div><!-- /clinical_note_container -->
  </form>
</template>


<template x-for="(collection, index) in notes" :key="index"> 
  <form x-cloak x-show=" Number(collection.doctor) == Number(current_user_session) || is_radiology == 'radiology'" @submit.prevent="addCurrentNote(index)">
    <div  class="clinical_note_container p-3 mt-3">
        <button class="btn btn-sm btn-danger clinicalnote-delete" x-show="Number(collection.doctor) === Number(<?= json_decode(session()->get('id')); ?>)" @click="deletePrevNote(collection.id)"> 
          <span x-cloak x-show="!deleting"> delete </span> 
          <span x-cloak x-show="deleting" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
          <span x-cloak x-show="deleting"> deleting.. </span>
        </button>
        <div class="note-section main_complain">
             <span>Main complain <b style="text-transform:lowercase;" x-text="collection.main_complain ? (' | written by '+collection.first_name+' '+collection.last_name) : '' "> </b> </span>
             <textarea name="main_complain" :disabled="current_user_session != collection.doctor" @change="addCurrentNote(index)" x-model.debounce="collection.main_complain" x-text="collection.main_complain" class="form-control mb-2 pt-4" cols="30" rows="3"></textarea>
        </div> <!-- /main_complain -->
        <div class="note-section history_of_presert">  
             <span>History of present illness <b style="text-transform:lowercase;" x-text="collection.history_of_present ? (' | written by '+collection.first_name+' '+collection.last_name) : '' "> </b> </span>
             <textarea name="history_of_present" :disabled="current_user_session != collection.doctor" @change="addCurrentNote(index)" x-model.debounce="collection.history_of_present"  x-text="collection.history_of_present"  class="form-control mb-2 pt-4" cols="30" rows="3"></textarea>
        </div> <!-- /history_of_presert -->
        <div class="note-section past_medical_history">  
            <span>Past medical history <b style="text-transform:lowercase;" x-text="collection.past_medical_history ? (' | written by '+collection.first_name+' '+collection.last_name) : '' "> </b> </span>
            <textarea name="past_medical_history" :disabled="current_user_session != collection.doctor" @change="addCurrentNote(index)" x-model.debounce="collection.past_medical_history" x-text="collection.past_medical_history" class="form-control mb-2 pt-4" cols="30" rows="3"></textarea>
        </div> <!-- /past_medical_history -->
        <div class="note-section family_social_history">  
            <span>Family social history  <b style="text-transform:lowercase;" x-text="collection.family_social_history ? (' | written by '+collection.first_name+' '+collection.last_name) : '' "> </b> </span>
            <textarea name="family_social_history" :disabled="current_user_session != collection.doctor" @change="addCurrentNote(index)" x-model.debounce="collection.family_social_history" x-text="collection.family_social_history" class="form-control mb-2 pt-4" cols="30" rows="3"></textarea>
        </div> <!-- /family_social_history -->

        <div class="note-section drug_allergy_history">  
            <span>Drug and allergy history  <b style="text-transform:lowercase;" x-text="collection.drug_allergy_history ? (' | written by '+collection.first_name+' '+collection.last_name) : '' "> </b> </span>
            <textarea name="drug_allergy_history" :disabled="current_user_session != collection.doctor" @change="addCurrentNote(index)" x-model.debounce="collection.drug_allergy_history" x-text="collection.drug_allergy_history" class="form-control mb-2 pt-4" cols="30" rows="3"></textarea>
        </div> <!-- /family_social_history -->
        <div class="note-section review_complain">  
            <span>Review of other complain <b style="text-transform:lowercase;" x-text="collection.review_complain ? (' | written by '+collection.first_name+' '+collection.last_name) : '' "> </b> </span>
            <textarea name="review_complain" :disabled="current_user_session != collection.doctor" @change="addCurrentNote(index)" x-model.debounce="collection.review_complain" x-text="collection.review_complain" class="form-control mb-2 pt-4" cols="30" rows="3"></textarea>
        </div> <!-- /review_complain -->
        <div class="note-section physical_examination">  
            <span>Physical Examination <b style="text-transform:lowercase;" x-text="collection.physical_examination ? (' | written by '+collection.first_name+' '+collection.last_name) : '' "> </b> </span>
            <textarea name="physical_examination" :disabled="current_user_session != collection.doctor" @change="addCurrentNote(index)" x-model.debounce="collection.physical_examination" x-text="collection.physical_examination" class="form-control mb-2 pt-4" cols="30" rows="3"></textarea>
        </div> <!-- /review_complain -->
      </div><!-- /clinical_note_container -->
  </form>
</template>

</div><!-- clinical-note -->

<script defer>
  //store 
document.addEventListener('alpine:init', () => {
   Alpine.store('notesData', {
     start_treatment: '<?= date('Y-m-d', strtotime($patient_file['start_treatment'])) ?>',
     end_treatment: '<?= date('Y-m-d', strtotime($patient_file['end_treatment'])) ?>', 
     edit: true,
     saving: false,
     deleting: false,
     addnote:false,
     current_note: false,
     current_user_session: <?= session()->get('id') ?>, 
     is_radiology: <?= json_encode(session()->get('role')) ?>,
     notes: [
      {
        main_complain: '',
        history_of_present: '',
        past_medical_history: '',
        family_social_history: '',
        drug_allergy_history: '',
        review_complain: '',
        physical_examination: ''
      }
     ],
     success: false,
     message: '',
     usercheck: false,
     user_allowed_to_add_clinicalnote(){
        this.usercheck = false;
        console.log('called')
        
        this.notes.forEach(element => {
          this.usercheck = false;
         
          if(element.hasOwnProperty('doctor') && Number(element.doctor) == Number(this.current_user_session)){
            return this.usercheck = false;
          }else if(element.hasOwnProperty('doctor') && Number(element.doctor) != Number(this.current_user_session)){
            return this.usercheck = true;
          }
       });
   
     },
     newNote(){
      let new_copy = [{
          main_complain: '',
          history_of_present: '',
          past_medical_history: '',
          family_social_history: '',
          drug_allergy_history: '',
          review_complain: '',
          physical_examination: '',
          first_name:"",
          last_name:"",
          doctor: <?= session()->get('id') ?> 
      }].concat(this.notes)

       this.notes = new_copy;
     },
     getClinicalNotes(){
      fetch("<?= base_url('patientFileController/ajax_getclinicalnotes')?>", {
           method: 'POST',
           headers: { Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With':'XMLHttpRequest'},
           body: JSON.stringify({
             file_id:<?= $patient_file['id'] ?>, 
             start_date: this.start_treatment,
             end_date: this.end_treatment})
        }).then(res => res.json())
        .then(data => {
            // console.log('checking formality of data', data);
           if(data.empty){
            //  this.no_clinicalnote = data;
              this.current_note = false
           }else{
              this.current_note = true
              this.notes = data
              this.user_allowed_to_add_clinicalnote()
           }
          //  window.scrollTo(0,0)
         })
      },
      addCurrentNote(_index = 0){
        console.log('Object index',_index)
        fetch("<?= base_url('patientFileController/ajax_addnote') ?>", {
          method: 'POST',
          headers: {Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
          body: JSON.stringify({
            file_id: <?= $patient_file['id'] ?>, 
            doctor: <?= session()->get('id') ?>, 
            id: Number(this.notes[_index]?.id), 
            main_complain: this.notes[_index].main_complain,
            history_of_present: this.notes[_index].history_of_present,
            past_medical_history: this.notes[_index].past_medical_history,
            family_social_history: this.notes[_index].family_social_history,
            drug_allergy_history: this.notes[_index].drug_allergy_history,
            review_complain:this.notes[_index].review_complain,
            physical_examination:this.notes[_index].physical_examination
          })
       }).then(res => res.json())
       .then(data => {
            this.success = data.success
            this.message = data.message
           if(data.success){
              this.getClinicalNotes()
              // if(_index == 0){
              //   location.reload()
              // }
              this.current_note = false 
           }
       }).catch(error => console.log(error))

      //  this.notes = custom_addnote(this.current_note)
     },
     deletePrevNote(note_id){
            // this.deleting = true
            note_id = Number(note_id)
            // console.log('NOTE TO DELETE => ', note_id)
            return fetch("<?= base_url('patientFileController/ajax_deletenote') ?>", {
               method: 'POST',
               headers: {Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
               body: JSON.stringify({id: note_id })
            }).then(res => res.json())
               .then(data => {
                  // console.log('DELETING SUCCESSFUL', data);
                  if(data.success){
                     this.getClinicalNotes()
                     // return { deleting : false}
                     return true
                  }else{
                     return false
                  }
                  this.clearMessage()
               })
        }
    }) 
  })
</script>