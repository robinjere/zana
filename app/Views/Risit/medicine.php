<?php $Dashboard = '\App\Libraries\DashboardPanel';  ?>

<?= $this->extend('./layout/main') ?>

<?= $this->section('content') ?>
  
<div class="container p-risit"> 
  
  <section class="">
    
    <div class="container py-5 h-100">
      <div class="d-flex justify-content-end py-2 h-100">
        <button type="button" onclick="window.print()" class="btn btn-sm btn-success print-btn">Print</button>
      </div><!-- /d-flex -->

      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
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
                            <td><b> Risit Type</b> </td>
                            <td><b>:</b> </td>
                            <td>Medicine Risit</td>
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
  
              <p style="margin-top: 1.5rem; margin-bottom:unset;">Medicine </p>
              <hr class="my-4">
  
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Drug</th>
                    <th scope="col">Price</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                    if(!empty($medicineList)){
                      $TOTAL = 0;
                      foreach ($medicineList as $key => $med) { 
                         $TOTAL += ($med->selling_price * $med->qty);  
                      ?>
                        <tr>
                          <th scope="row"><?= ++$key ?></th>
                          <td><?= $med->name ?></td>
                          <td><?= number_format(floatval($med->selling_price)).'/='; ?></td>
                          <td><?= $med->qty; ?></td>
                          <td><?= number_format(floatval($med->selling_price * $med->qty)).'/='; ?></td>
                        </tr>
                    <?php
                      }
                    }
                  ?>
                  <tr>
                    <th colspan="4" scope="row">Sub Total</th>
                    <!-- <td colspan="2">Larry the Bird</td> -->
                    
                    <td><b><i> <?= number_format(floatval($TOTAL)) ?>/= </i></b></td>
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

