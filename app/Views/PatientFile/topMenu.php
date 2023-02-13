<?php

// print_r($patient_file);
// exit;
// if(!empty($patient_file)){ 
// $patient_file = [
//    'id' => $patient_file->id,
//    'file_no' => $patient_file->file_no,
//    'patient_id' => $patient_file->patient_id,
//    'name' => isset($patient_file->name) ? $patient_file->name : '',
//    'payment_method' => $patient_file->payment_method,
//    'insuarance_no' => $patient_file->insuarance_no,
//    'start_treatment' => $patient_file->start_treatment,
//    'end_treatment' => $patient_file->end_treatment,
//    'status' => $patient_file->status,
//    'patient_character' => $patient_file->patient_character,
//    'first_name' => $patient_file->first_name,
//    'middle_name' => $patient_file->middle_name,
//    'sir_name' => $patient_file->sir_name,
//    'birth_date' => $patient_file->birth_date,
//    'gender' => $patient_file->gender,
//    'history' => isset($history) ? $history : 'Current treatment',
//    'ishistory' => isset($history) ? true : false

// ];

// }

?>

<div class="py-3 container file-top-menu" x-data="top_nav()" >
   <div class="d-flex justify-content-between">
      <button class="btn btn-default" class="nav" @click="open = !open">
         <svg width="18" height="14" viewBox="0 0 18 14" fill="none">
            <path d="M1 13H8M1 1H17H1ZM1 7H17H1Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
         </svg>
      </button>

      <div class="file-side-nav" :class="{'open-menu':open }">
       <?= view_cell('\App\Libraries\PatientPanel::PatientFileNav') ?>
     </div> <!-- /file-side-nav -->

      <div class="d-flex justify-content-end items-center button-nav">
       <div class="sendtoward" x-data="wardData()">
         <?php if(in_array(session()->get('role'), ['doctor'])){ ?> 
            <!-- Modal trigger button -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalId" @click="getWard()">
               SEND TO WARD
            </button>

            <form action="" method="post">
            <!-- Modal Body -->
            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
            <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
               <div style="z-index:999;" class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Send this patient to ward</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                        
                        <template x-if="ward.length">
                           <div class="mb-3">
                              <label for="ward" class="form-label">select ward</label>
                              <select class="form-select form-select-md" name="ward" id="ward">
                                 <option class="">SELECT WARD</option>
                                 <template x-for="wards in ward" :key="wards.id">
                                    <option :value="wards.id" x-text="wards.name + ' - ' + wards.status ">PRIVATE WARD</option>
                                 </template>
                              </select>
                           </div>
                        </template>

                        <div class="d-flex justify-content-center align-items-center">
                           <div x-cloak x-show="loading" class="mt-2 spinner-border" role="status">
                                 <span class="visually-hidden">Loading...</span>
                           </div><!-- /spinner-border -->
                        </div> <!-- /d-flex -->
                        
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-sm">SEND</button>
                     </div>
                  </div>
               </div>
            </div><!-- /modal fade -->
            </form><!-- form -->
         
            <!-- <a  href="<?= base_url('patientfile/sendtoward/'.$patient_file['id']); ?>" class="btn btn-success"> SEND TO WARD </a> -->

         <?php } ?>
         </div> <!-- sendtoward -->

         <?php if(in_array(session()->get('role'), ['doctor'])){ ?> 
            
               <form target="_blanck" action="<?= base_url('patientfile/fertility-assessment') ?>" method="post" style="margin-left:5px;">
                  <input type="hidden" name="start_treatment" value="<?= $patient_file['start_treatment'] ?>"/>
                  <input type="hidden" name="end_treatment" value="<?= $patient_file['end_treatment'] ?>"/>
                  <input type="hidden" name="patient_id" value="<?= $patient_file['patient_id'] ?>"/>
                  <input type="hidden" name="file_no" value="<?= $patient_file['file_no'] ?>"/>
                  <input type="hidden" name="file_id" value="<?= $patient_file['id'] ?>"/>
                  <button type="submit" class="btn btn-success"> FERTILITY ASSESSMENT </button>
               </form>
            
         <?php } ?>

         <?php if(in_array(session()->get('role'), ['doctor'])){ ?> 
            
               <form target="_blanck" action="<?= base_url('reffers/reffersto') ?>" method="post" style="margin-left:5px;">
                  <input type="hidden" name="start_treatment" value="<?= $patient_file['start_treatment'] ?>"/>
                  <input type="hidden" name="end_treatment" value="<?= $patient_file['end_treatment'] ?>"/>
                  <input type="hidden" name="patient_id" value="<?= $patient_file['patient_id'] ?>"/>
                  <input type="hidden" name="file_no" value="<?= $patient_file['file_no'] ?>"/>
                  <input type="hidden" name="file_id" value="<?= $patient_file['id'] ?>"/>
                  <button type="submit" class="btn btn-success"> REFFERS </button>
               </form>
            
         <?php } ?>
         <?php if(in_array(session()->get('role'), ['doctor'])){ ?> 
            <button type="button" class="btn btn-success"> SEND TO OTHER CLINIC </button>
         <?php } ?>

         <?php if(in_array(session()->get('role'), ['pharmacy']) && $patient_file['status'] !== 'finishTreatment' ){?> 
            <!-- $patient_file['id'] -->
             <a type="button" href="<?= base_url('patientfile/finish/'. $patient_file['id'])?>" class="btn btn-success"> FINISH TREATMENT </a>
         <?php } ?>
         
         <a href="<?= base_url('patientfile/history/'.$patient_file['id']) ?>" class="btn btn-success"> PATIENT HISTORY </a>
       
      </div>
   </div><!-- /d-flex> -->
</div> <!-- /PY -->

<?= $this->section('script') ?>
<script>  

   //  Optional: Place to the bottom of scripts     
   const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)


   function wardData(){
      return {
         loading: false,
         success: false,
         ward: [],
         getWard(){
            this.loading = true;
            this.ward = [];
            fetch('<?= base_url('patientFileController/ajax_getward') ?>',{
                method: 'post',
                headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
                }
               //  body: JSON.stringify({
               //     searchInput: this.searchInput
               //  })
              }).then(res => res.json()).then(data => {
                if(data.ward){
                   this.ward = data.ward
                   this.loading = false
                }
                console.log('ward list :', data)
               //  console.log('this radiology:', this.radiology)
             })
         }
      }
   }


  function top_nav(){
   return {
      open: false,
      close(e){
         this.open = false
         // if (this.hash !== "") {
            // Prevent default anchor click behavior
            // e.preventDefault();

            // Store hash
            // var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            // $('html, body').animate({
            // scrollTop: $(hash).offset().top
            // }, 800, function(){

            // // Add hash (#) to URL when done scrolling (default click behavior)
            // window.location.hash = hash;
            // });
         // }
   }
  }
  }
</script>
<?= $this->endSection() ?>