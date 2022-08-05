<?php $uri =  service('uri'); ?>

<ul class="data-nav d-flex">
     <li class="py-2 me-3 <?= $uri->getSegment(2) === 'search'? 'data-nav__active' : null ?>"> <a href="/patient/search">Search Patient</a> </li>
     <?php
        if(session()->get('role') == 'reception'){?>
           <li class="py-2 me-3 <?= $uri->getSegment(2) === 'register'? 'data-nav__active' : null ?>"> <a href="/patient/register">New Patient </a>  </li>
        <?php } ?>
</ul>