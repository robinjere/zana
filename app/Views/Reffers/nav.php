<?php $uri = service('uri'); ?>
<ul class="data-nav d-flex">

     <li class="py-2 me-3 <?= $uri->getSegment(2) === '' ? 'data-nav__active': null ?>"> 
         <a href="<?= base_url('reffers')?> ">Hospital Refers</a>  
      </li> 

      <?php
         if($uri->getSegment(2) === 'edit'){
             echo '<li class="py-2 me-3 data-nav__active"> <a href="#">Edit Clinic </a> </li>';
         }else{ ?>
            <li class="py-2 me-3 <?= $uri->getSegment(2) === 'addreffers' ? 'data-nav__active': null ?>"> <a href="<?= base_url('reffers/addreffers')?>">Add Hospital Refers </a></li>
      <?php
         }
      ?>

  </ul>