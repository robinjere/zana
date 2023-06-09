
<?php   $uri = service('uri');

$patient_file = [
  'id' => $id,
  'file_no' => $file_no,
  'patient_id' => $patient_id,
  'name' => $name,
  'payment_method' => $payment_method,
  'insuarance_no' => $insuarance_no,
  'start_treatment' => $start_treatment,
  'end_treatment' => $end_treatment,
  'status' => $status,
  'patient_character' => $patient_character,
  'first_name' => $first_name,
  'middle_name' => $middle_name,
  'sir_name' => $sir_name,
  'birth_date' => $birth_date,
  'gender' => $gender,
  'history' => $history,
  'ishistory' => $ishistory

];

// print_r($patient_file);

?>

<!-- on change submit -->

<div class="file-nav-container">
<!-- <form action="" class="treatment-history">
<label for="treatment-history" class="form-label"> Current Treatment</label>
<select class="form-select" id="treatment-history" aria-label="Default select example">
  <optgroup label="Current Treatment">
    <option selected> Jun 1, 2022 to Jun 19, 2022 </option>
  </optgroup>
  <optgroup label=" Treatment History">
    <option > May 15, 2022 to May 20, 2022 </option>
    <option > Jan 7, 2022 to Jan 9, 2022 </option>
  </optgroup>
</select>
</form> -->
<?php if($uri->getSegment(1) !== 'history'){ ?>
<ul class="file-nav">
<?php if(in_array(session()->get('role'), ['doctor'])){ ?>
    <li><a href="#clinical-note" @click="close()">
        <span class='icon'>
            <svg  viewBox="0 0 24 24" fill="none" >
              <path d="M11 4.99999H6C5.46957 4.99999 4.96086 5.21071 4.58579 5.58578C4.21071 5.96085 4 6.46956 4 6.99999V18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20H17C17.5304 20 18.0391 19.7893 18.4142 19.4142C18.7893 19.0391 19 18.5304 19 18V13M17.586 3.58599C17.7705 3.39497 17.9912 3.24261 18.2352 3.13779C18.4792 3.03297 18.7416 2.9778 19.0072 2.97549C19.2728 2.97319 19.5361 3.02379 19.7819 3.12435C20.0277 3.22491 20.251 3.37342 20.4388 3.5612C20.6266 3.74899 20.7751 3.97229 20.8756 4.21809C20.9762 4.46388 21.0268 4.72724 21.0245 4.9928C21.0222 5.25836 20.967 5.5208 20.8622 5.7648C20.7574 6.00881 20.605 6.2295 20.414 6.41399L11.828 15H9V12.172L17.586 3.58599Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
        <span class="link-title">Clinical Note</span> 
    </a></li>
  <?php } ?>

<?php if(in_array(session()->get('role'), ['doctor'])){?>
    <li><a href="#diagnosis" @click="close()">
        <span class="icon">
          <svg  viewBox="0 0 24 24" fill="none">
               <path d="M8 16L10.879 13.121M10.879 13.121C11.1567 13.4033 11.4876 13.6279 11.8525 13.7817C12.2174 13.9355 12.6092 14.0156 13.0052 14.0172C13.4012 14.0189 13.7936 13.9421 14.1599 13.7914C14.5261 13.6406 14.8588 13.4188 15.1388 13.1388C15.4189 12.8588 15.6408 12.5262 15.7916 12.16C15.9425 11.7938 16.0193 11.4014 16.0177 11.0054C16.0162 10.6094 15.9362 10.2176 15.7825 9.85265C15.6287 9.48768 15.4043 9.15677 15.122 8.879C14.5579 8.32389 13.7973 8.01417 13.0059 8.0173C12.2145 8.02043 11.4564 8.33615 10.8967 8.89571C10.337 9.45526 10.0211 10.2133 10.0178 11.0047C10.0145 11.7961 10.324 12.5568 10.879 13.121ZM21 12C21 13.1819 20.7672 14.3522 20.3149 15.4442C19.8626 16.5361 19.1997 17.5282 18.364 18.364C17.5282 19.1997 16.5361 19.8626 15.4442 20.3149C14.3522 20.7672 13.1819 21 12 21C10.8181 21 9.64778 20.7672 8.55585 20.3149C7.46392 19.8626 6.47177 19.1997 5.63604 18.364C4.80031 17.5282 4.13738 16.5361 3.68508 15.4442C3.23279 14.3522 3 13.1819 3 12C3 9.61305 3.94821 7.32387 5.63604 5.63604C7.32387 3.94821 9.61305 3 12 3C14.3869 3 16.6761 3.94821 18.364 5.63604C20.0518 7.32387 21 9.61305 21 12Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
           </svg>
        </span>
        <span class="link-title"> Diagnosis </span>
    </a></li>
<?php } ?>

<?php if(in_array(session()->get('role'), ['doctor', 'lab', 'cashier'])){?>
    <li><a href="#laboratory-test" @click="close()">
         <span class="icon">
            <svg viewBox="0 0 30 26" fill="none">
             <path d="M26.3445 18.121C25.9337 17.7101 25.4105 17.4301 24.8409 17.3162L21.329 16.6144C19.404 16.2294 17.4057 16.4971 15.6499 17.375L15.182 17.6075C13.4262 18.4854 11.4279 18.7531 9.50295 18.3681L6.66194 17.8002C6.18702 17.7053 5.69603 17.7291 5.23251 17.8695C4.769 18.0099 4.34731 18.2625 4.00485 18.605M9.5309 1.30737H21.301L19.8297 2.77863V10.388C19.8299 11.1683 20.14 11.9167 20.6919 12.4684L28.0482 19.8247C29.902 21.6785 28.5882 24.8476 25.9664 24.8476H4.86406C2.24227 24.8476 0.929909 21.6785 2.7837 19.8247L10.14 12.4684C10.6919 11.9167 11.002 11.1683 11.0022 10.388V2.77863L9.5309 1.30737Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
         </span>
         <span class="link-title"> Laboratory Test </span>
    </a></li>
<?php } ?>

<?php if(in_array(session()->get('role'), ['doctor','reception', 'cashier'])){?>
    <li><a href="#radiology" @click="close()">
         <span class="icon">
            <svg viewBox="0 0 30 26" fill="none">
             <path d="M26.3445 18.121C25.9337 17.7101 25.4105 17.4301 24.8409 17.3162L21.329 16.6144C19.404 16.2294 17.4057 16.4971 15.6499 17.375L15.182 17.6075C13.4262 18.4854 11.4279 18.7531 9.50295 18.3681L6.66194 17.8002C6.18702 17.7053 5.69603 17.7291 5.23251 17.8695C4.769 18.0099 4.34731 18.2625 4.00485 18.605M9.5309 1.30737H21.301L19.8297 2.77863V10.388C19.8299 11.1683 20.14 11.9167 20.6919 12.4684L28.0482 19.8247C29.902 21.6785 28.5882 24.8476 25.9664 24.8476H4.86406C2.24227 24.8476 0.929909 21.6785 2.7837 19.8247L10.14 12.4684C10.6919 11.9167 11.002 11.1683 11.0022 10.388V2.77863L9.5309 1.30737Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
         </span>
         <span class="link-title"> Radiology </span>
    </a></li>
<?php } ?>

<?php if(in_array(session()->get('role'), ['doctor', 'cashier'])){?>
    <li><a href="#medicine" @click="close()">
         <span class="icon">
             <svg viewBox="0 0 28 22" fill="none" >
               <path d="M26.0872 12.8746L19.9418 4.09489C18.8965 2.60426 17.2324 1.80738 15.5449 1.80738C14.4856 1.80738 13.4121 2.12144 12.4746 2.7777C11.5512 3.42457 10.8949 4.3152 10.5293 5.29958C10.3934 2.51988 8.11991 0.307373 5.30739 0.307373C2.40582 0.307373 0.057373 2.65582 0.057373 5.55739V16.0574C0.057373 18.959 2.40582 21.3075 5.30739 21.3075C8.20897 21.3075 10.5574 18.959 10.5574 16.0574V9.06835C10.7121 9.47147 10.8996 9.86991 11.1574 10.2402L17.3074 19.0199C18.3481 20.5106 20.0121 21.3075 21.7043 21.3075C22.7684 21.3075 23.8372 20.9934 24.7747 20.3371C27.1981 18.6403 27.784 15.2981 26.0872 12.8746ZM7.5574 10.8074H3.05739V5.55739C3.05739 4.3152 4.0652 3.30739 5.30739 3.30739C6.54959 3.30739 7.5574 4.3152 7.5574 5.55739V10.8074ZM16.6887 12.9121L13.6137 8.51991C13.2527 8.00428 13.1121 7.37615 13.2246 6.7574C13.3324 6.13865 13.6793 5.59489 14.1949 5.23396C14.5934 4.9527 15.0621 4.80739 15.5449 4.80739C16.3184 4.80739 17.0403 5.18239 17.4809 5.81521L20.5559 10.2074L16.6887 12.9121V12.9121Z" fill="#20243D"/>
             </svg>
          </span> 
         <span class="link-title">Medicine</span>
    </a></li>
<?php } ?>



<?php if(in_array(session()->get('role'), ['doctor', 'cashier'])){?>
    <li><a href="#procedure" @click="close()">
        <span class="icon">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M9 12H15M9 16H15M17 21H7C6.46957 21 5.96086 20.7893 5.58579 20.4142C5.21071 20.0391 5 19.5304 5 19V5C5 4.46957 5.21071 3.96086 5.58579 3.58579C5.96086 3.21071 6.46957 3 7 3H12.586C12.8512 3.00006 13.1055 3.10545 13.293 3.293L18.707 8.707C18.8946 8.89449 18.9999 9.1488 19 9.414V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
        <span class="link-title">
            Procedure 
        </span>
    </a></li>
</ul>
<?php }  ?>
<?php } ?>

  <div class="file-exit">
    <?php $patient_url = $patient_file['ishistory'] ? 'patientfile/attend/'.$patient_file['id'] : 'patient/search' ?>
    
      <?php if($uri->getSegment(1) !== 'history'){ ?>
        <a href="<?= base_url($patient_url) ?>">
          <span class="icon">
             <svg width="20" height="10" viewBox="0 0 20 10" fill="none">
               <path d="M1 5H19M5 9L1 5L5 9ZM1 5L5 1L1 5Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
             </svg>
           </span> <!-- /span -->
           <span class="link-title">
             Exit File
           </span>
        </a>
    
      <?php }else { ?>
        <a href="<?= base_url('patientfile/attend/'.$patient_file['id']) ?> ">
          <span class="icon">
             <svg width="20" height="10" viewBox="0 0 20 10" fill="none">
               <path d="M1 5H19M5 9L1 5L5 9ZM1 5L5 1L1 5Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
             </svg>
           </span> <!-- /span -->
           <span class="link-title">
             Exit Patient History
           </span>
        </a>
      <?php } ?>
  </div><!-- /file-exit -->

  </div><!-- file-nav-container -->