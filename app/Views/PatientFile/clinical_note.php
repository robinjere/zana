
<div id="clinical-note" class="clinical-note" x-data="$store.notesData">

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
      <button class="btn btn-sm btn-success add-note" @click="addnote = true"> Add clinical note </button>
     <?php }; ?>
  </div><!-- d-flex -->

  <form action="">
      <div class="clinical_note_container p-3 mt-3">
        <div class="note-section main_complain">
             <span>Main complain</span>
             <textarea name="main_complain" class="form-control mb-2 pt-4" cols="30" rows="2"></textarea>
        </div> <!-- /main_complain -->
        <div class="note-section history_of_presert">  
             <span>History of present illness </span>
             <textarea name="history_of_presert" class="form-control mb-2 pt-4" cols="30" rows="2"></textarea>
        </div> <!-- /history_of_presert -->
        <div class="note-section past_medical_history">  
            <span>Past medical history </span>
            <textarea name="past_medical_history" class="form-control mb-2 pt-4" cols="30" rows="2"></textarea>
        </div> <!-- /past_medical_history -->
        <div class="note-section family_social_history">  
            <span>Family social history</span>
            <textarea name="family_social_history" class="form-control mb-2 pt-4" cols="30" rows="2"></textarea>
        </div> <!-- /family_social_history -->
        <div class="note-section review_complain">  
            <span>Review of other complain </span>
            <textarea name="review_complain" class="form-control mb-2 pt-4" cols="30" rows="2"></textarea>
        </div> <!-- /review_complain -->
      </div><!-- /clinical_note_container -->
  </form>

</div><!-- clinical-note -->

<script defer>
  //store 
document.addEventListener('alpine:init', () => {
   Alpine.store('notesData', {
     start_treatment: '<?= date('Y-m-d', strtotime($patient_file['start_treatment'])) ?>',
     end_treatment: '<?= date('Y-m-d', strtotime($patient_file['end_treatment'])) ?>', 
     addnote:false,
     current_note: '',
     notes: [],
     success: false,
     message: '',
    }) 
  })
</script>