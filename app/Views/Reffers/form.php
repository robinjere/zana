<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>

<div class="container" x-data="reffers_info();" x-init="getReffersData(); $watch('r_data', () => setReffersData())" >
    
  <div class="fertility-assessment reffers">
    <div class="top-head">
        <h1 class="title uppercase m-0" align="center"> <?= $clinic_contacts['name'] ?> </h1>
        <p class="subtitle uppercase m-0" align="center"> <?= $clinic_contacts['address'] . ', '. $clinic_contacts['location']  ?> </p>
        <p class="subtitle uppercase m-0" align="center"> <?= $clinic_contacts['phone'] ?> </p>
    </div>

    <div class="head">
        <h2>HOSPITAL INFORMATION</h2>
    </div>

    <div class="position">
        <div class="subhead mb-2">
           <h2> <span style="display: inline-block; min-width: 6rem;">Referral to </span>
            <select <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-select form-select-sm" name="hospital_reffers" x-model="r_data.hospital_reffers">
                <option selected>Select hospital</option>
                <?php
                   foreach ($hospital as $key => $hosp) {?>
                    <option value="<?= $hosp['id']; ?>"> <?= $hosp['hospital_name'];  ?> </option>
                  <?php } 
                ?>
            </select>
            <!-- <span>Hospital </span> -->
          </h2>
        </div><!-- /subhead -->
    </div>


    <div class="personal-info mt-2 file_number">
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tbody>
                    <tr>
                        <td style="flex:2;"></td>
                        <td style="border: 0 !important; outline: none; border-width: unset; padding: 8px;"><b> PATIENT FILE NO: </b> <span class="data" x-text="r_data.patient_file"> </span> </td>                
                    </tr>
                </tbody>
            </table>
        </div><!-- /table-responsive -->
    </div><!-- /personal-info -->

    <div class="personal-info mt-2">
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tbody>
                    <tr>
                        <td scope="row"><b> NAME OF PATIENT: </b> <span class="data" x-text="r_data.patient_name"> </span> </td>
                        <td scope="row"><b> AGE: </b> <span class="data" x-text="r_data.age"> </span> </td>                
                    </tr>
                    <tr>
                        <td scope="row"><b> ADDRESS OF PATIENT: </b> <span class="data" x-text="r_data.address"> </span> </td>
                        <td scope="row"><b> TEL NO: </b> <span class="data" x-text="r_data.tel_no"> </span> </td>                
                    </tr>
                    <tr>
                        <td scope="row"><b> RELATIVE NAME: </b> <span class="data" x-text="r_data.relative_name"> </span> </td>
                        <td scope="row"><b> TEL NO: </b> <span class="data" x-text="r_data.relative_tel_no"> </span> </td>                
                    </tr>
                </tbody>
            </table>
        </div><!-- /table-responsive -->
    </div><!-- /personal-info -->

    <div class="personal-information mt-2">
        <div class="mb-3">
          <label for="" class="form-label">REASONS FOR REFERRAL</label>
          <textarea class="form-control" <?= (session()->get('phistory'))? 'disabled': '' ?> x-model="r_data.reasons_reffers" rows="3"></textarea>
        </div>
    </div>

    <div class="personal-information mt-2">
        <div class="mb-3">
          <label for="" class="form-label">DEPT TO: </label>
          <input type="text" class="form-control" <?= (session()->get('phistory'))? 'disabled': '' ?> x-model="r_data.department" aria-describedby="helpId" placeholder=""/>
          <!-- <small id="helpId" class="form-text text-muted">Help text</small> -->
        </div>
    </div>

    <div class="personal-information mt-2">
        <div class="mb-3">
          <label for="" class="form-label">PATIENT CLINIC HISTORY</label>
          <textarea class="form-control" <?= (session()->get('phistory'))? 'disabled': '' ?> x-model="r_data.history" rows="3"></textarea>
        </div>
    </div>

    <div class="personal-information mt-2">
        <div class="mb-3">
          <label for="" class="form-label">TREATMENT / OBSERVATION </label>
          <textarea class="form-control" <?= (session()->get('phistory'))? 'disabled': '' ?> name="" x-model="r_data.observation" rows="3"></textarea>
        </div>
    </div>

    <div class="personal-info mt-2 signature">
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tbody>
                    <tr>
                        <td scope="row" style="flex:2;"><b> DATE: </b> <span class="data" x-text="r_data.date"> </span> </td>
                        <td scope="row" style="padding: 5px 15px;"><b> DR SIGNATURE: </b> <i><span class="data" style="text-transform:lowercase;" x-text="r_data.doctor_signature"> </span></i> </td>                
                    </tr>
                    <tr>
                        <td scope="row" style="flex:2;"></td>
                        <td scope="row" style="padding: 5px 15px;"><b> DR NAME: </b> <span class="data" x-text="r_data.doctor_name"> </span> </td>                
                    </tr>
                
                </tbody>
            </table>
        </div><!-- /table-responsive -->
    </div>

    <div class="d-flex justify-content-end">
        <!-- <a href="<?= base_url('patientfile/attend/'.$patientFile['file_id'] ); ?>" class="btn btn-sm exit-assessment"> Exit assessment</a> -->
        <button type="button" onclick="window.print()" class="btn btn-sm exit-assessment">Print</button>
    </div>

  </div><!-- /fertility-assessment -->
</div><!-- /container -->
               
<!-- </div> -->

<div class="position-relative">
    <?= view_cell('\App\Libraries\DashboardPanel::Footer') ?>
  </div>
<?= $this->endSection('content') ?>


<?= $this->section('script') ?>
<script>
    function reffers_info(){
        return {
            r_data : {
                hospital_reffers: '',
                patient_file: '',
                patient: '',
                patient_name: '',
                age: '',
                address: '',
                tel_no: '',
                relative_name: '',
                relative_tel_no: '',
                reasons_reffers: '',
                department: '',
                history: '',
                observation:'',
                date:'',
                doctor: '',
                doctor_name: '',
                doctor_signature: ''
            },
            setReffersData(){
                const data_to = this.r_data
                fetch("<?= base_url('reffersController/ajax_addreffers') ?>", {
                    method: 'POST',
                    headers: {Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
                    body: JSON.stringify({
                        patient_id: <?= $patientFile['patient_id'] ?>, 
                        start_treatment: <?= json_encode($patientFile['start_treatment']) ?>,
                        end_treatment: <?=  json_encode($patientFile['end_treatment']) ?>, 
                        reffers_data: data_to })
                }).then(data => data.json())
                .then(data => {
                    console.log('after set r_data', data);
                    console.log('Is watching r_data')
                    //     this.success = data.success
                    //     this.message = data.message
                    // if(data.success){
                    //     this.getClinicalNotes()
                    //     this.current_note = ''
                    //     this.addnote = false
                    // }
                    //  this.notes = data
                    //  this.addnote = false
                    // 
                }).catch(error => console.log(error))
            },
            getReffersData(){
                fetch("<?= base_url('reffersController/ajax_getReffers') ?>", {
                    method: 'POST',
                    headers: {Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
                    body: JSON.stringify({patient_id: <?= $patientFile['patient_id'] ?>, start_treatment: <?= json_encode($patientFile['start_treatment']) ?>, end_treatment: <?=  json_encode($patientFile['end_treatment']) ?>})
                }).then(res => res.json())
                .then(data => {
                    // console.log('initial search r_data', data);
                    if(data){
                        const curr_d = this.r_data;
                        this.r_data = {
                            ...curr_d, ...data 
                        }
                    }
                    // 
                }).catch(error => console.log(error))
            }
        }
    }
</script>


<?= $this->endSection() ?>
