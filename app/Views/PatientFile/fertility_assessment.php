<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>

<?php 

// echo '<pre>';
// print_r($patientFile); 
// echo '---------------------- <br/> ';
// print_r($patient);
// echo '</pre>';

?>

<div class="container" x-data="fertility_assessment()">
    <a href="<?= base_url('patientfile/attend/'.$patientFile['file_id'] ); ?>" class="btn btn-sm exit-assessment"> Exit assessment</a>
  <div class="fertility-assessment">
    <div class="head">
        <h2>Fertility Assessment</h2>
        <h3><?= $patient['gender'] ?></h3>
    </div>

    <div class="personal-info mt-2">
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th scope="col" colspan="2">Personal Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row"><b> Name: </b> <span class="data"> <?= $patient['first_name'] .' '. $patient['middle_name'] .' '. $patient['sir_name'] ?> </span> </td>
                        <td> <b> Hospital Number: </b> </td>
                    </tr>
                    <tr class="">
                        <td scope="row"> <b> Date of Birth: </b> <span class="data"> <?= date_format(date_create($patient['birth_date']), 'd F, Y') ?> </span> </td>
                        <td> <b> Fertility Clinic Number: </b> </td> 
                    </tr>
                    <tr class="">
                        <td scope="row"> <b> Address : </b> <span class="data"> <?= $patient['address'] ?> </span> </td>
                        <td> <b> Phone Number: </b> <span class="data"> <?= $patient['phone_no'] ?> </span> </td> 
                    </tr>
                    <tr class="">
                        <td scope="row"> <b> Occupation : </b> </td>
                        <?php 
                           $v_date = strtotime($patientFile['start_treatment']) == strtotime($patientFile['end_treatment']) ? 'sameDay' : 'differentDay';
                        ?>
                        <td> <b> Date of Visit: </b> <span class="data"> <?= $v_date == 'sameDay' ? date_format(date_create($patientFile['start_treatment']), 'd F, Y') : date_format(date_create($patientFile['start_treatment']), 'd F, Y') . '<b> to </b> ' . date_format(date_create($patientFile['end_treatment']), 'd F, Y') ?> </span> </td> 
                    </tr>
                    <tr class="">
                        <td scope="row"> <b> Height(cm): </b> </td>
                        <td> <b> Weight(kg): </b> </td> 
                    </tr>
                </tbody>
            </table>
        </div><!-- /table-responsive -->
    </div><!-- /personal-info -->

    <div class="personal-info mt-2">
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th scope="col" >Drug allergy</th>
                        <th scope="col" >YES</th>
                        <th scope="col" >NO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row"> History of any drug allergy?  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input name="is_drug_allergy" value="yes" class="form-check-input check" type="radio"  x-model="is_drug_allergy"/>
                              <template x-if="is_drug_allergy == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input name="is_drug_allergy" value="no" class="form-check-input check" type="radio"  x-model="is_drug_allergy"/>
                              <template x-if="is_drug_allergy == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="is_drug_allergy == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, mention them:  
                              <span class="data"> 
                                 <textarea class="form-control" name="" x-model="drug_allergy_mention" ></textarea> 
                               </span> 
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div><!-- /table-responsive -->
    </div><!-- /personal-info -->

    <div class="personal-info mt-2">
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th scope="col" >Genetics disease in the Family</th>
                        <th scope="col" >YES</th>
                        <th scope="col" >NO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row"> History of any genetic disease in the family?  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input  value="yes" class="form-check-input check" type="radio" x-model="is_genetic_disease"/>
                              <template x-if="is_genetic_disease == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input value="no" class="form-check-input check" type="radio" x-model="is_genetic_disease"/>
                              <template x-if="is_genetic_disease == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="is_genetic_disease == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, mention them:  
                              <span class="data"> 
                                 <textarea class="form-control" x-model="genetic_disease_mention"></textarea> 
                               </span> 
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div><!-- /table-responsive -->
    </div><!-- /personal-info -->

  </div><!-- /fertility-assessment -->
</div><!-- /container -->

<div class="position-relative">
    <?= view_cell('\App\Libraries\DashboardPanel::Footer') ?>
  </div>
<?= $this->endSection('content') ?>

<?= $this->section('script') ?>
<script>
    function fertility_assessment(){
        return {
            occupation: '',
            height: '',
            weight: '',
            is_drug_allergy:'no',
            drug_allergy_mention: '',
            is_genetic_disease: 'no',
            genetic_disease_mention: ''
        }
    }
</script>


<?= $this->endSection() ?>
