<?php $Dashboard = '\App\Libraries\DashboardPanel';  ?>

<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>
  
<div class="container p-risit"> 
  
  <section class="">

  <!-- display flashdata message here  -->
  <?php
     if(session()->getFlashdata('success')){?>
      <div class="alert alert-success mt-2"> <?= session()->getFlashdata('success'); ?> </div>
   <?php } ?>
    
    <div class="container">
      <div class="d-flex justify-content-end py-2 h-100">
        <a href="/patient/search" class="btn btn-sm btn-danger print-btn" style="margin-right:1rem;">Back</a>
        <button type="button" onclick="window.print()" class="btn btn-sm btn-success print-btn">Print</button>
      </div><!-- /d-flex -->

      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
            <div class="card-body py-2 px-4 px-md-5">
  
              <p class="h1 text-center mt-3 text-primary title">
                <i class="fas fa-check-square me-1"></i>
                <u> <?= getenv('CLINIC_NAME'); ?> </u>
              </p>
              <div class="clinic-contacts d-flex justify-content-center align-items-center">
                <p>Phone: <?= strtolower(getenv('CLINIC_PHONE')); ?> | Email: <?= strtolower(getenv('CLINIC_EMAIL')); ?> </p>
              </div>
  
              <div class="pb-2">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row align-items-center">
                    
                      <table class="table table-borderless p-details" style="margin-bottom: 0;">
                        <tbody>
                          <tr>
                            <td><b> Receipt Type</b> </td>
                            <td><b>:</b> </td>
                            <td>Consultation Receipt</td>
                          </tr>
                          <tr>
                            <td><b> Full name </b> </td>
                            <td><b>:</b> </td>
                            <td><?= $patient->first_name .' '. $patient->middle_name .' '. $patient->sir_name ?> </td>
                          </tr>
                          <tr>
                            <td><b> File number </b> </td>
                            <td><b>:</b> </td>
                            <td><?= $patient->file_no ?></td>
                          </tr>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
  
              <p style="margin-top:.5rem; margin-bottom:unset;" class="about">CONSULTATION </p>
              <hr class="my-1">
  
              <table class="table data">
                <thead>
                  <tr>
                    <th scope="col">Clinic</th>
                    <th scope="col">Consultation Fee</th>
                    <th scope="col">Open File</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Doctor</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                    if(!empty($patient)){
                    //   $TOTAL = 0;
                    // print_r($patient);
                      ?>
                        <tr>
                          <td><?= $patient->name ?></td>
                          <td><?= number_format(floatval($patient->consultation_fee)).'/='; ?></td>
                          <td><?= $patient->new_patient == 0 ? ' - ' : number_format(floatval($patient->new_patient_consultation_fee)).'/='; ?></td>
                          <td><?= $patient->payment_method ?></td>
                          <td><?= $doctor['first_name'] .' '. $doctor['last_name'] ?></td>
                        </tr>
                    <?php
                    }
                  ?>
                  <tr>
                    <th colspan="" scope="row">Total</th>
                    <!-- <td colspan="2">Larry the Bird</td> -->
                    
                    <td><b> <i> <?=  $patient->new_patient == 0 ? number_format(floatval($patient->consultation_fee)) : number_format(floatval($patient->consultation_fee + $patient->new_patient_consultation_fee)) ?>/= </i> </b></td>
                  </tr>
                </tbody>
              </table>
  
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div> <!-- /container -->


  
  <div class="position-relative">
    <?= view_cell($Dashboard.'::Footer') ?>
  </div>

<?= $this->endSection() ?>

