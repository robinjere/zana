<?php $Dashboard = '\App\Libraries\DashboardPanel';  ?>

<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>
  
<div class="container p-risit"> 
  
  <section class="">
    
    <div class="container">
      <div class="d-flex justify-content-end py-2 h-100">
        <button type="button" onclick="window.print()" class="btn btn-sm btn-success print-btn">Print</button>
      </div><!-- /d-flex -->

      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card" id="list1" style="border-radius: .75rem;">
            <div class="card-body py-4 px-4 px-md-5">
  
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
                            <td><b> Report Type</b> </td>
                            <td><b>:</b> </td>
                            <td>Labtest Result</td>
                          </tr>
                          <tr>
                            <td><b> Full name </b> </td>
                            <td><b>:</b> </td>
                            <td><?= $full_name ?> </td>
                          </tr>
                          <tr>
                            <td><b> File number </b> </td>
                            <td><b>:</b> </td>
                            <td><?= $file_no ?></td>
                          </tr>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
  
              <p style="margin-top: .5rem; margin-bottom:unset;" class="about">RESULTS </p>
              <hr class="my-1">
  
              <table class="table data">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Test</th>
                    <th scope="col">Result</th>
                    <th scope="col">Ranges</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Level</th>
                    <th scope="col">Verified by</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                    if(!empty($labresult)){
                      $TOTAL = 0;
                      foreach ($labresult as $key => $test) { 
                  
                      ?>
                        <tr>
                          <th scope="row"><?= ++$key ?></th>
                          <td><?= $test->name ?></td>
                          <td><?= $test->result ?></td>
                          <td><?= $test->ranges ?></td>
                          <td><?= $test->unit ?></td>
                          <td><?= $test->level ?></td>
                          <td><?= $test->first_name .' '. $test->last_name ?></td>
                     
                        </tr>
                    <?php
                      }
                    }
                  ?>
                  <tr>
                     <th colspan="2" scope="row">Signature: </th> 
                     <td colspan="2"></td>
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

