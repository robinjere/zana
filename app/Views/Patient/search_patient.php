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

<?= $this->endSection('patient'); ?>