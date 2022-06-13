<?php $this->extend('Patient/patient_dashboard'); ?>

<?= $this->section('patient'); ?>
<form> 
<div class="input-group">
  <select class="form-select" aria-label="filter search">
    <option selected> Search by file number</option>
    <option value="1">Search by patient name</option>
  </select>
  <input type="search" placeholder="search patient .." class="form-control w-full" style="flex:2;" aria-label="Search patient">
  <button class="btn btn-success" type="button">Search</button>
</div>
<!-- genereate file no when register a patient  -->
<!-- if patient is  -->
<!-- <select class="form-select" aria-label="filter">
  <option selected> In-patient</option>
  <option value="1">Out-Patient</option>
  <option value="2">Out-Sider</option>
</select> -->

</form>

<div class="patient_search">
  <div class="detail">
    <h4>Available patient | Info </h4>
    <div class="row">
      <div class="col">PATIENT FILE NO:</div>
      <div class="col">IMC/2020/12</div>
    </div>
    <div class="row">
      <div class="col">PATIENT NAME:</div>
      <div class="col">JOHN, KIMWEL</div>
    </div>
    <div class="row">
      <div class="col">STATUS:</div>
      <div class="col">IN-TREATMENT | LAST VISIT 13/6/2022 </div>
    </div>

    <div class="row">
      <div class="col"></div>
      <div class="col">
        <span class="badge bg-primary">Out Patient!</span>
      </div>
    </div>

  </div> <!-- detail -->
  <div class="row navigation g-0">
    <div class="col"> <a href="#" class="history">PATIENT HISTORY</a> </div>
    <div class="col"> <a href="#" class="doctor">SEND TO DOCTOR </a> </div>
  </div>
</div><!-- /patient_search -->

<?= $this->endSection('patient'); ?>