<?php $uri =  service('uri'); ?>

<ul class="data-nav d-flex">
     <li class="py-2 me-3 <?= $uri->getSegment(2) === 'list'? 'data-nav__active' : null ?>"> <a href="/consultation/list">Consultation list</a> </li>
     <li class="py-2 me-3 <?= $uri->getSegment(2) === 'fees'? 'data-nav__active' : null ?>"> <a href="/consultation/fees">Consultation fee </a>  </li>
     <li class="py-2 me-3 <?= $uri->getSegment(2) === 'add_fee'? 'data-nav__active' : null ?>"> <a href="/consultation/add_fee">Add fee </a>  </li>
</ul>