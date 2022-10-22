<div id="general-examination" class="clinical-note"
  x-data="$store.generalExamination"
  x-init="initialExamination()"
>
   <h5>
        <span class='icon'>
            <svg  viewBox="0 0 24 24" fill="none" >
              <path d="M11 4.99999H6C5.46957 4.99999 4.96086 5.21071 4.58579 5.58578C4.21071 5.96085 4 6.46956 4 6.99999V18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20H17C17.5304 20 18.0391 19.7893 18.4142 19.4142C18.7893 19.0391 19 18.5304 19 18V13M17.586 3.58599C17.7705 3.39497 17.9912 3.24261 18.2352 3.13779C18.4792 3.03297 18.7416 2.9778 19.0072 2.97549C19.2728 2.97319 19.5361 3.02379 19.7819 3.12435C20.0277 3.22491 20.251 3.37342 20.4388 3.5612C20.6266 3.74899 20.7751 3.97229 20.8756 4.21809C20.9762 4.46388 21.0268 4.72724 21.0245 4.9928C21.0222 5.25836 20.967 5.5208 20.8622 5.7648C20.7574 6.00881 20.605 6.2295 20.414 6.41399L11.828 15H9V12.172L17.586 3.58599Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span> 
        <span>
          General Examination
        </span>  
   </h5>

   <form x-on:submit.prevent action="" method="post" class="examination-form mt-2" style="margin-top: 1.7rem !important; padding: 10px; background: #e9ecef;">

      <div class="row mb-2">
        <div class="col-6">
          <label for="pressureInp" class="form-label">Pressure:(mmHg)</label>
          <input type="text" class="form-control" :disabled="canEdit" x-model="examination.pressure" id="pressureInp" aria-describedby="helpId" placeholder="Pressure"/>
        </div><!-- /col-6 -->
        <div class="col-6">
        <label for="temperatureInp" class="form-label">Temperature (oC)</label>
        <input type="text" class="form-control" :disabled="canEdit" x-model="examination.temperature" id="temperatureInp" aria-describedby="helpId" placeholder="Temperature"/>
        </div><!--- /col-6 -->
      </div><!-- /row -->

      <div class="row mb-2">
        <div class="col-6">
          <label for="pulseRateInp" class="form-label">Pulse rate: <span class="unit">(b/min)</span> </label>
          <input type="text" class="form-control" :disabled="canEdit" x-model="examination.pulse_rate" id="pulseRateInp"  placeholder="Pulse rate"/>
        </div><!-- /col-6 -->
        <div class="col-6">
        <label for="weightInp" class="form-label">Weight: <span class="unit">(Kg)</span></label>
        <input type="text" class="form-control" :disabled="canEdit" x-model="examination.weight" id="weightInp" placeholder="Weight"/>
        </div><!--- /col-6 -->
      </div><!-- /row -->

      <div class="row mb-2">
        <div class="col-6">
          <label for="heightInp" class="form-label">Height: <span class="unit">(cm)</span> </label>
          <input type="text" class="form-control" :disabled="canEdit" x-model="examination.height" id="heightInp"  placeholder="Height"/>
        </div><!-- /col-6 -->
        <div class="col-6">
          <label for="bodyMassInp" class="form-label">Body mass Index: <span class="unit">(Kg/n)</span></label>
          <input type="text" class="form-control" :disabled="canEdit" x-model="examination.body_mass" id="bodyMassInp" placeholder="Body mass Index"/>
        </div><!--- /col-6 -->
      </div><!-- /row -->

      <div class="row mb-2">
        <div class="col-6">
          <label for="bodySurfaceInp" class="form-label">Body surface area: <span class="unit">(cmkg)</span> </label>
          <input type="text" class="form-control" :disabled="canEdit" x-model="examination.body_surface_area" id="bodySurfaceInp"  placeholder="Body surface area"/>
        </div><!-- /col-6 -->
        <div class="col-6">
          <label for="body_mass_comment" class="form-label">Body Mass Index Comment: <span class="unit">(Kg/n)</span></label>
          <input type="text" class="form-control" :disabled="canEdit" x-model="examination.body_mass_comment" id="body_mass_comment" placeholder="Body Mass Index Comment"/>
        </div><!--- /col-6 -->
      </div><!-- /row -->

      <div class="row mb-2">
        <div class="col-6">
          <label for="saturation_of_oxygen" class="form-label">Saturation of Oxygen: <span class="unit">(%)</span> </label>
          <input type="text" class="form-control" :disabled="canEdit" x-model="examination.saturation_of_oxygen" id="saturation_of_oxygen"  placeholder="Saturation of Oxygen"/>
        </div><!-- /col-6 -->
        <div class="col-6">
          <label for="respiratory_rate" class="form-label">Respiratory Rate: <span class="unit">(cycles/min)</span></label>
          <input type="text" class="form-control" :disabled="canEdit" x-model="examination.respiratory_rate" id="respiratory_rate" placeholder="Respiratory Rate"/>
        </div><!--- /col-6 -->
      </div><!-- /row -->

      <div class="">
        <!-- <label for="" class="form-label"></label> -->
        <textarea class="form-control" :disabled="canEdit" x-model="examination.description" rows="3" placeholder="Description"></textarea>
      </div>
      <div class="d-flex justify-content-end align-items-center">
       <?php if(!$patient_file['ishistory']){ ?>
        <button @click="assignGeneralExamination()" class="btn btn-success btn-sm  mt-2"> Save </button>
        <?php } ?>
      </div>

   </form>

</div><!-- /general-examination -->


<?= $this->section('script') ?>
<script defer> 
//store 
document.addEventListener('alpine:init', () => {
   Alpine.store('generalExamination', {
      loading: false,
      success: false,
      message: '', 
      canEdit: <?= json_encode(in_array(session()->get('role'), ['doctor', 'nurse']) ? !true : !false ) ?>,
      start_treatment: <?= json_encode($patient_file['start_treatment']) ?>,
      end_treatment: <?= json_encode($patient_file['end_treatment']) ?>,

      examination: {
        pressure:'',
        temperature:'',
        pulse_rate:'',
        weight:'',
        height:'',
        body_mass:'',
        body_surface_area:'',
        body_mass_comment:'',
        saturation_of_oxygen:'',
        respiratory_rate:'',
        description:''
      },
      assignGeneralExamination(){
        fetch('<?= base_url('patientFileController/ajax_assignExamination') ?>', {
                  method: 'post',
                  headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                  },
                  body: JSON.stringify({
                    patient_file: <?= $patient_file['id'] ?>,
                    start_treatment: this.start_treatment,
                    end_treatment: this.end_treatment,
                    added_by: <?= session()->get('id') ?>,
                    pressure:this.examination.pressure,
                    temperature:this.examination.temperature,
                    pulse_rate:this.examination.pulse_rate,
                    weight:this.examination.weight,
                    height:this.examination.height,
                    body_mass:this.examination.body_mass,
                    body_surface_area:this.examination.body_surface_area,
                    body_mass_comment:this.examination.body_mass_comment,
                    saturation_of_oxygen:this.examination.saturation_of_oxygen,
                    respiratory_rate:this.examination.respiratory_rate,
                    description:this.examination.description
                  })
         }).then(res => res.json()).then(data => {
          // console.log('examination after sent', data);
            if(data){
              this.examination.pressure = data.pressure,
              this.examination.temperature = data.temperature,
              this.examination.pulse_rate = data.pulse_rate,
              this.examination.weight = data.weight,
              this.examination.height = data.height,
              this.examination.body_mass = data.body_mass,
              this.examination.body_surface_area = data.body_surface_area,
              this.examination.body_mass_comment = data.body_mass_comment,
              this.examination.saturation_of_oxygen = data.saturation_of_oxygen,
              this.examination.respiratory_rate = data.respiratory_rate,
              this.examination.description = data.description
            }
         })
      },
      initialExamination(){
        fetch('<?= base_url('patientFileController/ajax_Examination') ?>', {
                  method: 'post',
                  headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                  },
                  body: JSON.stringify({
                    patient_file: <?= $patient_file['id'] ?>,
                    start_treatment: this.start_treatment,
                    end_treatment: this.end_treatment
                  })
         }).then(res => res.json()).then(data => {
              // console.log('available examination', data);
              // console.log('examination To UPDATE!', this.examination);
              if(data){
                this.examination.pressure = data.pressure,
                this.examination.temperature = data.temperature,
                this.examination.pulse_rate = data.pulse_rate,
                this.examination.weight = data.weight,
                this.examination.height = data.height,
                this.examination.body_mass = data.body_mass,
                this.examination.body_surface_area = data.body_surface_area,
                this.examination.body_mass_comment = data.body_mass_comment,
                this.examination.saturation_of_oxygen = data.saturation_of_oxygen,
                this.examination.respiratory_rate = data.respiratory_rate,
                this.examination.description = data.description
              }
         })
      }
      
    })
 })
</script>
<?= $this->endSection('script') ?>