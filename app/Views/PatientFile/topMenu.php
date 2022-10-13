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
         <?php if(in_array(session()->get('role'), ['doctor'])){ ?> 
             <button type="button" class="btn btn-success"> SEND TO WARD </button>
         <?php } ?>
         <?php if(in_array(session()->get('role'), ['doctor'])){ ?> 
            <button type="button" class="btn btn-success"> FERTILITY ASSESSMENT </button>
         <?php } ?>
         <?php if(in_array(session()->get('role'), ['doctor'])){ ?> 
            <button type="button" class="btn btn-success"> SEND TO OTHER CLINIC </button>
         <?php } ?>
         <?php if(in_array(session()->get('role'), ['pharmacy'])){?> 
            <!-- $patient_file['id'] -->
           
             <a type="button" href="<?= base_url('patientfile/finish/'. $patient_file['id'])?>" class="btn btn-success"> FINISH TREATMENT </a>
         <?php } ?>
         <?php if(in_array(session()->get('role'), ['doctor', 'radiology', 'pharmacy'])){?> 
           <button type="button" class="btn btn-success"> PATIENT HISTORY </button>
         <?php } ?>
      </div>
   </div><!-- /d-flex> -->
</div> <!-- /PY -->

<?= $this->section('script') ?>
<script>  
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