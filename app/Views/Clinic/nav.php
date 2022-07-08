<?php $uri = service('uri'); ?>
<ul class="data-nav d-flex">

     <li class="py-2 me-3 <?= $uri->getSegment(2) === '' ? 'data-nav__active': null ?>"> 
         <a href="/clinic/">Clinics</a>  
      </li>     
      <li class="py-2 me-3 <?= $uri->getSegment(2) === 'addclinic' ? 'data-nav__active': null ?>"> <a href="addclinic">Add Clinic </a>  </li>
      <li class="py-2 me-3 <?= $uri->getSegment(2) === 'editclinic' ? 'data-nav__active': null ?>"> <a href="editclinic">Edit Clinic </a>  </li>

  </ul>