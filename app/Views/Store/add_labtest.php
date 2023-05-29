<?= $this->extend('dashboard/main'); ?>
<?= $this->section('data') ?>

<?php $Dashboard = '\App\Libraries\AdminPanel';  ?>

<h2 class="data-heading mb-3">Labtest</h2>
 
 <!-- WARNING AND ERROR AREA -->
 <?php if(!empty(session()->getFlashdata('validation'))): ?>
  
  <div class="my-3 pt-3 box-alert warning-alert d-flex align-items-start" >
    <div class="icon-alert px-3"> 
        <svg viewBox="0 0 51 50" fill="none">
            <path d="M7.77416 42.8087C5.342 40.5119 3.40202 37.7644 2.06742 34.7266C0.732827 31.6888 0.0303434 28.4215 0.000961476 25.1155C-0.0284205 21.8094 0.615887 18.5307 1.89629 15.4707C3.17669 12.4107 5.06755 9.63062 7.45853 7.29278C9.8495 4.95493 12.6927 3.1061 15.8223 1.85415C18.9518 0.602201 22.305 -0.0277889 25.6863 0.000940109C29.0675 0.0296691 32.409 0.716541 35.5159 2.02148C38.6227 3.32641 41.4326 5.22328 43.7817 7.6014C48.4203 12.2974 50.9871 18.587 50.929 25.1155C50.871 31.6439 48.1929 37.8889 43.4715 42.5054C38.7501 47.1219 32.3631 49.7405 25.6863 49.7973C19.0094 49.854 12.5769 47.3443 7.77416 42.8087ZM40.1911 39.298C44.0137 35.5603 46.1612 30.4909 46.1612 25.2051C46.1612 19.9192 44.0137 14.8498 40.1911 11.1122C36.3685 7.37451 31.1839 5.27471 25.7779 5.27471C20.3719 5.27471 15.1873 7.37451 11.3647 11.1122C7.54211 14.8498 5.39459 19.9192 5.39459 25.2051C5.39459 30.4909 7.54211 35.5603 11.3647 39.298C15.1873 43.0356 20.3719 45.1354 25.7779 45.1354C31.1839 45.1354 36.3685 43.0356 40.1911 39.298ZM23.2314 27.695V22.7152H28.3244V37.6546H23.2314V27.695ZM23.2314 12.7555H28.3244V17.7353H23.2314V12.7555Z" fill="#FB5A77"/>
        </svg>
    </div>
    <div class="message-alert"> 
        <h2 class="mb-2"> Errors occurs. </h2>
        <!-- <p> Please contact with your system admins to confirm your information </p> -->
        <?php
           foreach (session()->getFlashdata('validation') as $key => $error) {
              echo '<p>'. $error .'</p>';
           }
        ?>
    </div>
  </div><!-- box-alert -->

<?php endif; ?>
<!-- WARNING AND ERROR AREA -->

<?php
  if(session()->get('success')){?>
      <div class="alert alert-success"> <?= session()->get('success'); ?> </div>
<?php } ?>
<div class="data-layout my-2 p-3 bg-white">

  <!-- <ul class="data-nav d-flex">
     <li class="py-2 me-3 "> <a href="items">Drugs in store</a>  </li>
     <li class="py-2 me-3 data-nav__active"> <a href="additem">Add Drug </a>  </li>
  </ul> -->

  <?php $uri = service('uri'); ?>
    
  <ul class="data-nav d-flex">
       <?php if(in_array('can_add_labtest', session()->get('permission'))){?>
        <li class="py-2 me-3 <?= $uri->getSegment(2) === 'addlabtest' ? 'data-nav__active': null ?>"> <a href="addlabtest">LAB TEST FORM  </a>  </li>
      <?php } ?> 
  </ul>

<div class="mb-3 registration-form"  x-data="labtestData()" x-init="labtestData()">
 
  <div class="registration-form__heading">
     <h2 style="padding: 0 57px;"> Add lab test </h2>
  </div > <!-- /registration-form__heading -->
   <div class="registration-form__form" style="padding: 25px 57px;">
         <form method="post" action="addlabtest">
           <!-- <div class="row registration-space-y">    -->
           <div class="registration-space-y">
               <div class="row">
                    <div class="col">
                        <input type="text"  required name="name" value="<?= set_value('name') ?>" class="form-control" placeholder="Test name" aria-describedby="Test name"/>
                    </div>
                    <div class="col">
                        <input type="number" required  min="0" step="0.01" name="price" value="<?= set_value('price')?>" class="form-control" placeholder="Price" aria-describedby="Price"/>
                    </div>
               </div><!-- /row -->
          </div><!-- /registration-space-y -->

          <div class="row registration-space-y">  
              <div class="col">
                <template x-for="(labtest, index) in labtests" :key="index">
                  <fieldset class="row mt-2 gx-0">
                    <div class="col-11">
                      <input type="text" x-model="labtest.range" required class="form-control" placeholder="add range" :value="labtest.range" :name="`range[${index}]`"/>
                    </div>
                    <div class="col-1">
                      <template x-if="labtest.range !== ''">
                        <input type="button" class="btn-sm btn-danger" style="margin-left:3px;" @click="$event.target.prevent; removeLabtest(index)" value="&minus;">
                      </template>
                    </div>
                  </fieldset>
                </template>
                <div class="mt-2 d-flex justify-content-end">
                   <input type="button" class="btn-sm btn-success" @click="$event.target.prevent; addLabtest()" value="&plus;"/> 
                </div>
              </div> 
              <div class="col">
                  <textarea name="description" row="2" col="4" value="<?= set_value('description') ?>" class="form-control" placeholder="Description"></textarea>
              </div>
          </div><!-- /row -->


          <div class="row mt-5">
               <div class="col">
                   <a href="labtest" class="btn btn-warning btn-rounded"> Cancel </a>
              </div>
               <div class="col d-flex justify-content-end">
                   <input type="submit" class="btn btn-primary btn-rounded" style="width: 8rem;" value="Save" />
               </div>
          </div><!-- /row -->
       </form><!-- /form -->
   </div> <!-- /registration-form__form -->


</div><!-- /registration-layout --->

  
 
</div> <!-- /data-layout -->
  

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
   function labtestData(){
       return {
        labtests: [
          { 
            range: ''
          }
        ],
        addLabtest(){
          this.labtests.push({ 
            range: ''
          });
        },
        removeLabtest(id){
            this.labtests = this.labtests.filter((lab, index) => index !== id)
        }
       }
   }
</script>
<?= $this->endSection('script') ?>





