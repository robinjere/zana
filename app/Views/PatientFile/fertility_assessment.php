<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>

<?php 

// echo '<pre>';
// print_r($patientFile); 
// echo '---------------------- <br/> ';
// print_r($patient);
// echo '</pre>';
// echo 'is history -> '. session()->get('phistory');

?>

<div class="container" x-data="fertility_assessment()" x-init="getFertilityData(); $watch('f_data', () => setFertilityData())">
    <div class="d-flex justify-content-end">
        <!-- <a href="<?= base_url('patientfile/attend/'.$patientFile['file_id'] ); ?>" class="btn btn-sm exit-assessment"> Exit assessment</a> -->
        <button type="button" onclick="window.print()" class="btn btn-sm exit-assessment">Print</button>
    </div>
  <div class="fertility-assessment">
    <div class="top-head">
        <h1 class="title uppercase m-0" align="center"> <?= $clinic_contacts['name'] ?> </h1>
        <p class="subtitle uppercase m-0" align="center"> <?= $clinic_contacts['address'] . ', '. $clinic_contacts['location']  ?> </p>
        <p class="subtitle uppercase m-0" align="center"> <?= $clinic_contacts['phone'] ?> </p>
    </div>
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
                    <tr>
                        <td scope="row"><b> Name: </b> <span class="data"> <?= $patient['first_name'] .' '. $patient['middle_name'] .' '. $patient['sir_name'] ?> </span> </td>
                        <td class="d-flex align-items-center"> 
                            <b class="flex-1"> Hospital Number: </b> 
                              <input type="text" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control flex-2 p-0" :class="f_data.hospital_number && 'border-none'" x-model="f_data.hospital_number" id="" aria-describedby="helpId" placeholder=""/>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row"> <b> Date of Birth: </b> <span class="data"> <?= date_format(date_create($patient['birth_date']), 'd F, Y') ?> </span> </td>
                        <td class="d-flex align-items-center">
                             <b class="flex-1"> Fertility Clinic Number: </b> 
                             <input type="text" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control flex-2 p-0" :class="f_data.clinic_number && 'border-none'" x-model="f_data.clinic_number" id="" aria-describedby="helpId" placeholder=""/>
                        </td> 
                    </tr>
                    <tr>
                        <td scope="row"> <b> Address : </b> <span class="data"> <?= $patient['address'] ?> </span> </td>
                        <td> <b> Phone Number: </b> <span class="data"> <?= $patient['phone_no'] ?> </span> </td> 
                    </tr>
                    <tr>
                        <td scope="row" class="d-flex align-items-center"> 
                            <b class="flex-1"> Occupation : </b> 
                            <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control form-control flex-2 p-0" :class="f_data.occupation && 'border-none'" x-model="f_data.occupation"></textarea>
                        </td>
                        <?php 
                           $v_date = strtotime($patientFile['start_treatment']) == strtotime($patientFile['end_treatment']) ? 'sameDay' : 'differentDay';
                        ?>
                        <td> <b> Date of Visit: </b> <span class="data"> <?= $v_date == 'sameDay' ? date_format(date_create($patientFile['start_treatment']), 'd F, Y') : date_format(date_create($patientFile['start_treatment']), 'd F, Y') . '<b> to </b> ' . date_format(date_create($patientFile['end_treatment']), 'd F, Y') ?> </span> </td> 
                    </tr>
                    <tr>
                        <td scope="row" class="d-flex align-items-center"> 
                            <b class="flex-1"> Height(cm): </b> 
                            <input type="text" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control flex-2 p-0" :class="f_data.height && 'border-none'" x-model="f_data.height" placeholder=""/>
                        </td>
                        <td> 
                            <div class="d-flex align-items-center">
                                <b class="flex-1"> Weight(kg): </b> 
                                <input type="text" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control flex-2 p-0" :class="f_data.weight && 'border-none'" x-model="f_data.weight" placeholder=""/>
                            </div>
                        </td> 
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
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_drug_allergy" value="yes" class="form-check-input check" type="radio"  x-model="f_data.is_drug_allergy"/>
                              <template x-if="f_data.is_drug_allergy == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_drug_allergy" value="no" class="form-check-input check" type="radio"  x-model="f_data.is_drug_allergy"/>
                              <template x-if="f_data.is_drug_allergy == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="f_data.is_drug_allergy == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, mention them:  
                              <span class="data"> 
                                 <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control" name="" :class="f_data.drug_allergy_mention && 'border-none'" x-model="f_data.drug_allergy_mention" ></textarea> 
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
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> value="yes" class="form-check-input check" type="radio" x-model="f_data.is_genetic_disease"/>
                              <template x-if="f_data.is_genetic_disease == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> value="no" class="form-check-input check" type="radio" x-model="f_data.is_genetic_disease"/>
                              <template x-if="f_data.is_genetic_disease == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="f_data.is_genetic_disease == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, mention them:  
                              <span class="data"> 
                                 <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control" :class="f_data.genetic_disease_mention && 'border-none'" x-model="f_data.genetic_disease_mention"></textarea> 
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
                        <th scope="col" >Gynecological history</th>
                        <th scope="col" >YES</th>
                        <th scope="col" >NO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row"> History of STIs  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> value="yes" class="form-check-input check" type="radio" x-model="f_data.is_gynecological_history"/>
                              <template x-if="f_data.is_gynecological_history == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input value="no" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-check-input check" type="radio" x-model="f_data.is_gynecological_history"/>
                              <template x-if="f_data.is_gynecological_history == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="f_data.is_gynecological_history == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, mention them:  
                              <span class="data"> 
                                 <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control" :class="f_data.gynecological_history_mention && 'border-none'" x-model="f_data.gynecological_history_mention"></textarea> 
                               </span> 
                            </td>
                        </tr>
                    </template>
                    <tr class="">
                        <td scope="row"> History of previous pelvic surgery  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> value="yes" class="form-check-input check" type="radio" x-model="f_data.is_pelvic_surgery"/>
                              <template x-if="f_data.is_pelvic_surgery == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input value="no" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-check-input check" type="radio" x-model="f_data.is_pelvic_surgery"/>
                              <template x-if="f_data.is_pelvic_surgery == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="f_data.is_pelvic_surgery == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, mention them and the indication for each operation:  
                              <span class="data"> 
                                 <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control" :class="f_data.pelvic_surgery_mention && 'border-none'" x-model="f_data.pelvic_surgery_mention"></textarea> 
                               </span> 
                            </td>
                        </tr>
                    </template>
                    <tr class="">
                        <td scope="row"> Previous contraception?  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> value="yes" class="form-check-input check" type="radio" x-model="f_data.is_contraception"/>
                              <template x-if="f_data.is_contraception == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input value="no" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-check-input check" type="radio" x-model="f_data.is_contraception"/>
                              <template x-if="f_data.is_contraception == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="f_data.is_contraception == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, mention them:  
                              <span class="data"> 
                                 <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control" :class="f_data.contraception_mention && 'border-none'" x-model="f_data.contraception_mention"></textarea> 
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
                        <th scope="col" colspan="2">Immunization History</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row" class="d-flex align-items-center"> 
                            Rubella:
                            <span class="data w-100">
                             <input <?= (session()->get('phistory'))? 'disabled': '' ?> type="text" class="form-control flex-2 p-0 w-100" :class="f_data.rubella && 'border-none'" x-model="f_data.rubella"/>
                            </span>
                        </td>
                    </tr>
                    <tr class="">
                        <td scope="row" class="d-flex align-items-center"> 
                            Hepatitis:
                            <span class="data w-100">
                             <input <?= (session()->get('phistory'))? 'disabled': '' ?> type="text" class="form-control flex-2 p-0 w-100" :class="f_data.hepatitis && 'border-none'" x-model="f_data.hepatitis"/>
                            </span>
                        </td>
                    </tr>
                    <tr class="">
                        <td scope="row" class="d-flex align-items-center"> 
                            Other:
                            <span class="data w-100">
                             <input <?= (session()->get('phistory'))? 'disabled': '' ?> type="text" class="form-control flex-2 p-0 w-100" :class="f_data.other && 'border-none'" x-model="f_data.other"/>
                            </span>
                        </td>
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
                        <th scope="col" colspan="3" >Current Menstrual History</th>
                        <th scope="col" ></th>
                        <th scope="col" >YES</th>
                        <th scope="col" >NO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row" colspan="4"> Is the menstrual cycle regular?  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> value="yes" class="form-check-input check" type="radio" x-model="f_data.is_menstrualcycle_regular"/>
                              <template x-if="f_data.is_menstrualcycle_regular == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> value="no" class="form-check-input check" type="radio" x-model="f_data.is_menstrualcycle_regular"/>
                              <template x-if="f_data.is_menstrualcycle_regular == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                        <tr class="">
                            <td scope="row">
                                <div class="d-flex align-items-center">
                                    LNMP:  
                                     <span class="data w-100"> 
                                         <input <?= (session()->get('phistory'))? 'disabled': '' ?> type="text" class="form-control flex-2 p-0 w-100" :class="f_data.lnmp && 'border-none'" x-model="f_data.lnmp"/>
                                      </span> 
                                </div>
                            </td>
                            <td scope="row">
                              <div class="d-flex align-items-center">
                                  Cycle Length:  
                                  <span class="data w-100"> 
                                      <input <?= (session()->get('phistory'))? 'disabled': '' ?> type="text" class="form-control flex-2 p-0 w-100" :class="f_data.cycle_length && 'border-none'" x-model="f_data.cycle_length"/>
                                   </span> 
                              </div>  
                            </td>
                            <td scope="row" colspan="4">
                              <div class="d-flex align-items-center">
                                  Dysmenorrhea:  
                                <span class="data w-100"> 
                                    <input <?= (session()->get('phistory'))? 'disabled': '' ?> type="text" class="form-control flex-2 p-0 w-100" :class="f_data.dysmenorrhea && 'border-none'" x-model="f_data.dysmenorrhea"/>
                                 </span> 
                              </div>
                            </td>
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
                        <th scope="col" colspan="4">Fertility History</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row" colspan="4"> 
                            <div class="d-flex align-items-center">
                                <span style="flex:1">How long have you been trying to conceive? </span>
                                <span style="flex:2" class="data w-100">
                                 <input <?= (session()->get('phistory'))? 'disabled': '' ?> type="text" class="form-control flex-2 p-0 w-100" :class="f_data.conceive && 'border-none'" x-model="f_data.conceive"/>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td scope="row" colspan="2" > 
                          <div class="d-flex align-items-center w-100">
                              <span> Months: </span>
                              <span class="data w-100">
                               <input <?= (session()->get('phistory'))? 'disabled': '' ?> type="text" class="form-control flex-2 p-0 w-100" :class="f_data.months && 'border-none'" x-model="f_data.months"/>
                              </span>
                          </div>
                        </td>
                        <td scope="row" colspan="2"> 
                          <div class="d-flex align-items-center w-100">
                              <span> Years: </span>
                              <span class="data w-100">
                               <input <?= (session()->get('phistory'))? 'disabled': '' ?> type="text" class="form-control flex-2 p-0 w-100" :class="f_data.years && 'border-none'" x-model="f_data.years"/>
                              </span>
                          </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td colspan="2">
                            Have you been pregnant before?
                        </td>
                        <td scope="row">
                           <div class="form-check d-flex w-100" style="margin-bottom:0;">
                              <label class="form-check-label" for="_yes">
                                <b> Yes: </b>
                               </label>
                               <span style="position:relative; left: 29px;">
                                   <input <?= (session()->get('phistory'))? 'disabled': '' ?> value="yes" id="_yes" class="form-check-input check" type="radio" x-model="f_data.is_pregnant"/>
                                   <template x-if="f_data.is_pregnant == 'yes'">
                                       <spain class="icon" style="left: -13px;"> &#10004; </spain>
                                   </template>
                               </span>
                            </div>
                        </td>
                        <td scope="row">
                           <div class="form-check d-flex w-100" style="margin-bottom:0;">
                              <label class="form-check-label" for="_no">
                                <b> No: </b>
                               </label>
                              <span style="position:relative; left: 28px;"> 
                                  <input <?= (session()->get('phistory'))? 'disabled': '' ?> value="no" id="_no" class="form-check-input check" type="radio" x-model="f_data.is_pregnant"/>
                                  <template x-if="f_data.is_pregnant == 'no'">
                                      <spain class="icon" style="left:-15px;"> &#10004; </spain>
                                  </template>
                              </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                       <td colspan="4">
                         <div class="d-flex">
                             <span style="margin-right:9px;"> <b> If Yes: </b> </span>
                             <input type="text" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control flex-2 p-0 w-100" :class="f_data.pregnant_mention && 'border-none'" x-model="f_data.pregnant_mention"/>
                         </div>
                       </td>            
                    </tr>
                    <tr>
                        <td colspan="4">
                         <div class="d-flex">
                             <span style="margin-right:9px;"> <b> Current relationship para: </b> </span>
                             <input type="text" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control flex-2 p-0 w-100" :class="f_data.current_relationship_para && 'border-none'" x-model="f_data.current_relationship_para"/>
                         </div>
                       </td>   
                    </tr>
                    <tr>
                        <td colspan="4">
                         <div class="d-flex">
                             <span style="margin-right:9px;"> <b> Previous relationship para: </b> </span>
                             <input type="text" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control flex-2 p-0 w-100" :class="f_data.previous_relationship_para && 'border-none'" x-model="f_data.previous_relationship_para"/>
                         </div>
                       </td>   
                    </tr>
                    <tr>
                        <td colspan="2">
                         <div class="d-flex">
                             <span style="margin-right:9px;"> Number of abortions:  </span>
                             <input type="text" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control flex-2 p-0 w-100" :class="f_data.no_of_abortions && 'border-none'" x-model="f_data.no_of_abortions"/>
                         </div>
                       </td>   
                        <td colspan="2">
                         <div class="d-flex">
                             <span style="margin-right:9px;"> <b> GA </b> at each abortion </span>
                             <input type="text" <?= (session()->get('phistory'))? 'disabled': '' ?>  class="form-control flex-2 p-0 w-100" :class="f_data.GA && 'border-none'" x-model="f_data.GA"/>
                         </div>
                       </td>   
                    </tr>
                    <tr>
                        <td colspan="4">
                         <div class="d-flex">
                             <span style="margin-right:9px;"> Number of ectopic pregnancy/ies:  </span>
                             <input type="text" <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control flex-2 p-0 w-100" :class="f_data.ectopic_pregnancy && 'border-none'" x-model="f_data.ectopic_pregnancy"/>
                         </div>
                       </td>   
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
                        <th scope="col" >Fertility Treatment</th>
                        <th scope="col" >YES</th>
                        <th scope="col" >NO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row"> History of fertility treatment?  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_fertility_treatment" value="yes" class="form-check-input check" type="radio"  x-model="f_data.is_fertility_treatment"/>
                              <template x-if="f_data.is_fertility_treatment == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_fertility_treatment" value="no" class="form-check-input check" type="radio"  x-model="f_data.is_fertility_treatment"/>
                              <template x-if="f_data.is_fertility_treatment == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="f_data.is_fertility_treatment == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, mention them:  
                              <span class="data"> 
                                 <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control" name="" :class="f_data.fertility_treatment_mention && 'border-none'" x-model="f_data.fertility_treatment_mention" ></textarea> 
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
                        <th scope="col" >Chronic diseases</th>
                        <th scope="col" >YES</th>
                        <th scope="col" >NO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row"> History of any chronic disease?  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_chronic_diseases" value="yes" class="form-check-input check" type="radio"  x-model="f_data.is_chronic_diseases"/>
                              <template x-if="f_data.is_chronic_diseases == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_chronic_diseases" value="no" class="form-check-input check" type="radio"  x-model="f_data.is_chronic_diseases"/>
                              <template x-if="f_data.is_chronic_diseases == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="f_data.is_fertility_treatment == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, mention them:  
                              <span class="data"> 
                                 <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control" name="" :class="f_data.chronic_diseases_mention && 'border-none'" x-model="f_data.chronic_diseases_mention" ></textarea> 
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
                        <th scope="col" >Current Medication</th>
                        <th scope="col" >YES</th>
                        <th scope="col" >NO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row"> Current medication?  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_current_medication" value="yes" class="form-check-input check" type="radio"  x-model="f_data.is_current_medication"/>
                              <template x-if="f_data.is_current_medication == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_current_medication" value="no" class="form-check-input check" type="radio"  x-model="f_data.is_current_medication"/>
                              <template x-if="f_data.is_current_medication == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="f_data.is_fertility_treatment == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, mention them:  
                              <span class="data"> 
                                 <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control" name="" :class="f_data.current_medication && 'border-none'" x-model="f_data.current_medication" ></textarea> 
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
                        <th scope="col" >Social History</th>
                        <th scope="col" >YES</th>
                        <th scope="col" >NO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row"> Do you smoke?  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_smoke" value="yes" class="form-check-input check" type="radio"  x-model="f_data.is_smoke"/>
                              <template x-if="f_data.is_smoke == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_smoke" value="no" class="form-check-input check" type="radio"  x-model="f_data.is_smoke"/>
                              <template x-if="f_data.is_smoke == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="f_data.is_smoke == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, how many cigarettes per day? 
                              <span class="data"> 
                                 <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control" name="" :class="f_data.cigarettes_per_day && 'border-none'" x-model="f_data.cigarettes_per_day" ></textarea> 
                               </span> 
                            </td>
                        </tr>
                    </template>

                    <tr class="">
                        <td scope="row"> Do you take alcohol?  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_alcohol" value="yes" class="form-check-input check" type="radio"  x-model="f_data.is_alcohol"/>
                              <template x-if="f_data.is_alcohol == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_alcohol" value="no" class="form-check-input check" type="radio"  x-model="f_data.is_alcohol"/>
                              <template x-if="f_data.is_alcohol == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="f_data.is_alcohol == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, how many units per week?
                              <span class="data"> 
                                 <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control" name="" :class="f_data.unit_per_week && 'border-none'" x-model="f_data.unit_per_week" ></textarea> 
                               </span> 
                            </td>
                        </tr>
                    </template>

                    <tr class="">
                        <td scope="row"> Have you ever used any recreational drugs/ anabolic steroids?  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_recreational_drugs" value="yes" class="form-check-input check" type="radio"  x-model="f_data.is_recreational_drugs"/>
                              <template x-if="f_data.is_recreational_drugs == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_recreational_drugs" value="no" class="form-check-input check" type="radio"  x-model="f_data.is_recreational_drugs"/>
                              <template x-if="f_data.is_recreational_drugs == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
                    </tr>
                    <template x-if="f_data.is_recreational_drugs == 'yes'">
                        <tr class="">
                            <td scope="row" colspan="3">  If yes, when and for how long?  
                              <span class="data"> 
                                 <textarea <?= (session()->get('phistory'))? 'disabled': '' ?> class="form-control" name="" :class="f_data.how_long && 'border-none'" x-model="f_data.how_long" ></textarea> 
                               </span> 
                            </td>
                        </tr>
                    </template>
                    <tr class="">
                        <td scope="row"> Do you currently use any recreational drugs/anabolic steroids?  </td>
                        <td> 
                            <div class="form-check" style="margin-bottom:0;">
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.currently_recreational_drugs" value="yes" class="form-check-input check" type="radio"  x-model="f_data.currently_recreational_drugs"/>
                              <template x-if="f_data.currently_recreational_drugs == 'yes'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div>
                        </td>
                        <td>
                             <div class="form-check" style="margin-bottom:0;">
                             <!-- checked -->
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.currently_recreational_drugs" value="no" class="form-check-input check" type="radio"  x-model="f_data.currently_recreational_drugs"/>
                              <template x-if="f_data.currently_recreational_drugs == 'no'">
                                  <spain class="icon"> &#10004; </spain>
                              </template>
                            </div> 
                        </td>
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
                        <th scope="col" colspan="4" >Investigations - Female</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td scope="row"><b> If regular periods: </b>  </td>
                        <td> 
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_regular_periods" class="form-control flex-2 p-0"  :class="f_data.is_regular_periods && 'border-none'" type="text"  x-model="f_data.is_regular_periods"/>
                        </td>
                        <td>
                            <b> If Irregular periods: </b> 
                        </td>
                        <td> 
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.is_irregular_periods" class="form-control flex-2 p-0"  :class="f_data.is_irregular_periods && 'border-none'" type="text"  x-model="f_data.is_irregular_periods"/>
                        </td>
                    </tr>
                    <tr class="">
                        <td scope="row"> Ultrasound  </td>
                        <td> 
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.ultrasound" class="form-control flex-2 p-0"  :class="f_data.ultrasound && 'border-none'" type="text"  x-model="f_data.ultrasound"/>
                        </td>
                        <td>
                             Ultrasound 
                        </td>
                        <td> 
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.i_ultrasound" class="form-control flex-2 p-0"  :class="f_data.i_ultrasound && 'border-none'" type="text"  x-model="f_data.i_ultrasound"/>
                        </td>
                    </tr>
                    <tr class="">
                        <td scope="row"> HSG/HSU  </td>
                        <td> 
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.HSG_HSU" class="form-control flex-2 p-0"  :class="f_data.HSG_HSU && 'border-none'" type="text"  x-model="f_data.HSG_HSU"/>
                        </td>
                        <td>
                             HSG/HSU 
                        </td>
                        <td> 
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.i_HSG_HSU" class="form-control flex-2 p-0"  :class="f_data.i_HSG_HSU && 'border-none'" type="text"  x-model="f_data.i_HSG_HSU"/>
                        </td>
                    </tr>
                    <tr class="">
                        <td scope="row"> TSH  </td>
                        <td> 
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.TSH" class="form-control flex-2 p-0"  :class="f_data.TSH && 'border-none'" type="text"  x-model="f_data.TSH"/>
                        </td>
                        <td>
                             FSH <br/>
                             LH <br/>
                             <i> (Taken between day2-4) </i>
                        </td>
                        <td> 
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.i_FSH_LH" class="form-control flex-2 p-0"  :class="f_data.i_FSH_LH && 'border-none'" type="text"  x-model="f_data.i_FSH_LH"/>
                        </td>
                    </tr>
                    <tr class="">
                        <td scope="row"> </td>
                        <td> </td>
                        <td>
                            TSH <br/>
                            Prolactin
                        </td>
                        <td> 
                              <input <?= (session()->get('phistory'))? 'disabled': '' ?> name="f_data.i_TSH" class="form-control flex-2 p-0" :class="f_data.i_TSH && 'border-none'" type="text"  x-model="f_data.i_TSH"/>
                        </td>
                    </tr>
                  
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
            f_data : {
                hospital_number: '',
                clinic_number: '',
                occupation: '',
                height: '',
                weight: '',
                is_drug_allergy:'no',
                drug_allergy_mention: '',
                is_genetic_disease: 'no',
                genetic_disease_mention: '',
                is_gynecological_history: 'no',
                gynecological_history_mention:'',
                is_pelvic_surgery:'no',
                pelvic_surgery_mention: '',
                is_contraception:'no',
                contraception_mention:'',
                rubella:'',
                hepatitis: '',
                other:'',
                is_menstrualcycle_regular: 'no',
                dysmenorrhea:''
            },
            setFertilityData(){
                fetch("<?= base_url('patientFileController/ajax_addFertility') ?>", {
                    method: 'POST',
                    headers: {Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
                    body: JSON.stringify({patient_id: <?= $patientFile['patient_id'] ?>, start_treatment: <?= json_encode($patientFile['start_treatment']) ?>, end_treatment: <?=  json_encode($patientFile['end_treatment']) ?>, fertility_data: this.f_data })
                }).then(res => res.json())
                .then(data => {
                    console.log('after set f_data', data);
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
            getFertilityData(){
                fetch("<?= base_url('patientFileController/ajax_getFertility') ?>", {
                    method: 'POST',
                    headers: {Accept: 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
                    body: JSON.stringify({patient_id: <?= $patientFile['patient_id'] ?>, start_treatment: <?= json_encode($patientFile['start_treatment']) ?>, end_treatment: <?=  json_encode($patientFile['end_treatment']) ?>})
                }).then(res => res.json())
                .then(data => {
                    console.log('initial search f_data', data);
                    this.f_data = {
                        ...data, hospital_number: <?= json_encode($patientFile['file_no']) ?>
                    }
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
            }
        }
    }
</script>


<?= $this->endSection() ?>
