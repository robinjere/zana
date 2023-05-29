<?= $this->extend('./patient/history/layout') ?>
<?= $this->section('history') ?>
<div>
    
<?php if(empty($generalExamination)){?>
    <p> No general examination </p>
<?php }else{ 
    foreach ($generalExamination as $key => $value) {?>
    <p class="mb-0 mt-3"> - Added by <?= strtoupper( $value->first_name .' '. $value->last_name) .' | '. date_format(date_create($value->updated_at), 'd-m-Y')  ?></p>
    <form disabled action="" method="post" class="examination-form mt-2" style="margin-top: 0.7rem !important; padding: 10px; background: #e9ecef;">
    
    <div class="row mb-2">
      <div class="col-6">
        <label for="pressureInp" class="form-label">Pressure:(mmHg)</label>
        <input type="text" class="form-control" disabled id="pressureInp" aria-describedby="helpId" placeholder="Pressure" value="<?= $value->pressure ?>"/>
      </div><!-- /col-6 -->
      <div class="col-6">
      <label for="temperatureInp" class="form-label">Temperature (oC)</label>
      <input type="text" class="form-control" disabled id="temperatureInp" aria-describedby="helpId" placeholder="Temperature" value="<?= $value->temperature ?>"/>
      </div><!--- /col-6 -->
    </div><!-- /row -->
    
    <div class="row mb-2">
      <div class="col-6">
        <label for="pulseRateInp" class="form-label">Pulse rate: <span class="unit">(b/min)</span> </label>
        <input type="text" class="form-control" disabled  id="pulseRateInp"  placeholder="Pulse rate" value="<?= $value->pulse_rate ?>"/>
      </div><!-- /col-6 -->
      <div class="col-6">
      <label for="weightInp" class="form-label">Weight: <span class="unit">(Kg)</span></label>
      <input type="text" class="form-control" disabled id="weightInp" placeholder="Weight" value="<?= $value->weight ?>"/>
      </div><!--- /col-6 -->
    </div><!-- /row -->
    
    <div class="row mb-2">
      <div class="col-6">
        <label for="heightInp" class="form-label">Height: <span class="unit">(cm)</span> </label>
        <input type="text" class="form-control" disabled  id="heightInp"  placeholder="Height" value="<?= $value->height ?>"/>
      </div><!-- /col-6 -->
      <div class="col-6">
        <label for="bodyMassInp" class="form-label">Body mass Index: <span class="unit">(Kg/n)</span></label>
        <input type="text" class="form-control" disabled id="bodyMassInp" placeholder="Body mass Index" value="<?= $value->body_mass ?>"/>
      </div><!--- /col-6 -->
    </div><!-- /row -->
    
    <div class="row mb-2">
      <div class="col-6">
        <label for="bodySurfaceInp" class="form-label">Body surface area: <span class="unit">(cmkg)</span> </label>
        <input type="text" class="form-control" disabled  id="bodySurfaceInp"  placeholder="Body surface area" value="<?= $value->body_surface_area ?>"/>
      </div><!-- /col-6 -->
      <div class="col-6">
        <label for="body_mass_comment" class="form-label">Body Mass Index Comment: <span class="unit">(Kg/n)</span></label>
        <input type="text" class="form-control" disabled  id="body_mass_comment" placeholder="Body Mass Index Comment" value="<?= $value->body_mass_comment ?>"/>
      </div><!--- /col-6 -->
    </div><!-- /row -->
    
    <div class="row mb-2">
      <div class="col-6">
        <label for="saturation_of_oxygen" class="form-label">Saturation of Oxygen: <span class="unit">(%)</span> </label>
        <input type="text" class="form-control" disabled  id="saturation_of_oxygen"  placeholder="Saturation of Oxygen" value="<?= $value->saturation_of_oxygen ?>"/>
      </div><!-- /col-6 -->
      <div class="col-6">
        <label for="respiratory_rate" class="form-label">Respiratory Rate: <span class="unit">(cycles/min)</span></label>
        <input type="text" class="form-control" disabled  id="respiratory_rate" placeholder="Respiratory Rate" value="<?= $value->respiratory_rate ?>"/>
      </div><!--- /col-6 -->
    </div><!-- /row -->
    
    <div class="">
      <!-- <label for="" class="form-label"></label> -->
      <textarea class="form-control" disabled  rows="3" placeholder="Description"><?= $value->description ?></textarea>
    </div>
    <div class="d-flex justify-content-end align-items-center">
    </div>
    
    </form>
  <?php } ?>
<?php } ?>
</div>
<?= $this->endSection('history') ?>