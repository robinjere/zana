<?php $uri = service('uri'); ?>
<ul class="data-nav d-flex">

     <li class="py-2 me-3 <?= $uri->getSegment(2) === 'items' ? 'data-nav__active': null ?>"> 
         <a href="items">Drugs in store</a>  
      </li>

       <?php if(in_array('can_add_drug', session()->get('permission'))){?>
        <li class="py-2 me-3 <?= $uri->getSegment(2) === 'additem' ? 'data-nav__active': null ?>"> <a href="additem">Add Drug </a>  </li>
       <?php } ?>

       <?php if(in_array('can_view_drugs_out_of_stock', session()->get('permission'))){?>
        <li class="py-2 me-3 <?= $uri->getSegment(2) === 'outofstock' ? 'data-nav__active': null ?>"> <a href="outofstock">Out of stock </a>  </li>
      <?php } ?>

      <?php if(in_array('can_view_drugs_out_of_stock', session()->get('permission'))){?>
        <li class="py-2 me-3 <?= $uri->getSegment(2) === 'itemsneartoend' ? 'data-nav__active': null ?>"> <a href="itemsneartoend">ITEMS NEAR TO END </a>  </li>
      <?php } ?>

  </ul>