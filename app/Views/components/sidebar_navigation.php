<?php $uri = service('uri'); ?>

<ul class="sidebar mt-4">

   <?php if(in_array(session()->get('role'), ['admin', 'superuser' ])){?>
    <li class="my-2  <?= $uri->getSegment(1) === 'clinic' ? 'sidebar__active-link': null; ?>">
        <a href="/clinic/" class="d-flex align-items-center  <?= $uri->getSegment(1) === 'clinic' ? 'sidebar__active-link': null; ?>">
        <svg viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.48218 14.593L4.48218 11.593M4.48218 11.593L14.9822 1.09302L25.4822 11.593M4.48218 11.593V26.593C4.48218 26.9908 4.64021 27.3724 4.92152 27.6537C5.20282 27.935 5.58435 28.093 5.98218 28.093H10.4822M25.4822 11.593L28.4822 14.593M25.4822 11.593V26.593C25.4822 26.9908 25.3241 27.3724 25.0428 27.6537C24.7615 27.935 24.38 28.093 23.9822 28.093H19.4822M10.4822 28.093C10.88 28.093 11.2615 27.935 11.5428 27.6537C11.8241 27.3724 11.9822 26.9908 11.9822 26.593V20.593C11.9822 20.1952 12.1402 19.8137 12.4215 19.5324C12.7028 19.2511 13.0844 19.093 13.4822 19.093H16.4822C16.88 19.093 17.2615 19.2511 17.5428 19.5324C17.8241 19.8137 17.9822 20.1952 17.9822 20.593V26.593C17.9822 26.9908 18.1402 27.3724 18.4215 27.6537C18.7028 27.935 19.0844 28.093 19.4822 28.093M10.4822 28.093H19.4822"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
            <span> Clinic </span>
        </a>
    </li>
   <?php } ?>

   <?php if(in_array(session()->get('role'), ['admin', 'superuser' ])){?>
    <li class="my-2  <?= $uri->getSegment(1) === 'reffers' ? 'sidebar__active-link': null; ?>">
        <a href="/reffers/" class="d-flex align-items-center  <?= $uri->getSegment(1) === 'reffers' ? 'sidebar__active-link': null; ?>">
            <svg  viewBox="0 0 30 34" fill="none">
            <path d="M8.66577 8.74487V22.2449C8.66577 23.14 9.02135 23.9984 9.65429 24.6314C10.2872 25.2643 11.1457 25.6199 12.0408 25.6199H22.1658M8.66577 8.74487V5.36987C8.66577 4.47477 9.02135 3.61632 9.65429 2.98339C10.2872 2.35045 11.1457 1.99487 12.0408 1.99487H19.7796C20.2272 1.99497 20.6563 2.17282 20.9727 2.48931L28.4213 9.93794C28.7378 10.2543 28.9157 10.6835 28.9158 11.131V22.2449C28.9158 23.14 28.5602 23.9984 27.9273 24.6314C27.2943 25.2643 26.4359 25.6199 25.5408 25.6199H22.1658M8.66577 8.74487H5.29077C4.39567 8.74487 3.53722 9.10045 2.90429 9.73339C2.27135 10.3663 1.91577 11.2248 1.91577 12.1199V28.9949C1.91577 29.89 2.27135 30.7484 2.90429 31.3814C3.53722 32.0143 4.39567 32.3699 5.29077 32.3699H18.7908C19.6859 32.3699 20.5443 32.0143 21.1773 31.3814C21.8102 30.7484 22.1658 29.89 22.1658 28.9949V25.6199"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Reffers </span>
        </a>
    </li>
   <?php } ?>

   <?php if(in_array(session()->get('role'), ['admin', 'superuser', 'cashier'])){?>
    <li class="my-2  <?= (($uri->getSegment(1) === 'store' && $uri->getSegment(2) === 'items' || $uri->getSegment(2) === 'additem') || $uri->getSegment(2) === 'outofstock' || $uri->getSegment(2) === 'itemsneartoend') ? 'sidebar__active-link': null; ?>">
        <a href="/store/items" class=" d-flex align-items-center  <?= (($uri->getSegment(1) === 'store' && $uri->getSegment(2) === 'items' || $uri->getSegment(2) === 'additem')  || $uri->getSegment(2) === 'outofstock' || $uri->getSegment(2) === 'itemsneartoend') ? 'sidebar__active-link': null; ?>">
        <svg width="28" height="22" viewBox="0 0 28 22" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M26.0872 12.8746L19.9418 4.09489C18.8965 2.60426 17.2324 1.80738 15.5449 1.80738C14.4856 1.80738 13.4121 2.12144 12.4746 2.7777C11.5512 3.42457 10.8949 4.3152 10.5293 5.29958C10.3934 2.51988 8.11991 0.307373 5.30739 0.307373C2.40582 0.307373 0.057373 2.65582 0.057373 5.55739V16.0574C0.057373 18.959 2.40582 21.3075 5.30739 21.3075C8.20897 21.3075 10.5574 18.959 10.5574 16.0574V9.06835C10.7121 9.47147 10.8996 9.86991 11.1574 10.2402L17.3074 19.0199C18.3481 20.5106 20.0121 21.3075 21.7043 21.3075C22.7684 21.3075 23.8372 20.9934 24.7747 20.3371C27.1981 18.6403 27.784 15.2981 26.0872 12.8746ZM7.5574 10.8074H3.05739V5.55739C3.05739 4.3152 4.0652 3.30739 5.30739 3.30739C6.54959 3.30739 7.5574 4.3152 7.5574 5.55739V10.8074ZM16.6887 12.9121L13.6137 8.51991C13.2527 8.00428 13.1121 7.37615 13.2246 6.7574C13.3324 6.13865 13.6793 5.59489 14.1949 5.23396C14.5934 4.9527 15.0621 4.80739 15.5449 4.80739C16.3184 4.80739 17.0403 5.18239 17.4809 5.81521L20.5559 10.2074L16.6887 12.9121V12.9121Z" />
        </svg>
            <span> Drugs </span>
        </a>
    </li>
   <?php } ?>

   <?php if(in_array(session()->get('role'), ['admin', 'superuser', 'lab', 'cashier']) && in_array('can_view_labtest', session()->get('permission'))){  ?>
    <li class="my-2  <?= ($uri->getSegment(2) === 'labtest' || $uri->getSegment(2) === 'addlabtest' || $uri->getSegment(2) === 'editlabtest') ? 'sidebar__active-link': null; ?>">
        <a href=" <?= base_url('store/labtest')?>" class="d-flex align-items-center  <?= ($uri->getSegment(2) === 'labtest' || $uri->getSegment(2) === 'addlabtest' || $uri->getSegment(2) === 'editlabtest') ? 'sidebar__active-link': null; ?>">
            <svg  viewBox="0 0 30 26" fill="none">
                <path d="M26.3445 18.121C25.9337 17.7101 25.4105 17.4301 24.8409 17.3162L21.329 16.6144C19.404 16.2294 17.4057 16.4971 15.6499 17.375L15.182 17.6075C13.4262 18.4854 11.4279 18.7531 9.50295 18.3681L6.66194 17.8002C6.18702 17.7053 5.69603 17.7291 5.23251 17.8695C4.769 18.0099 4.34731 18.2625 4.00485 18.605M9.5309 1.30737H21.301L19.8297 2.77863V10.388C19.8299 11.1683 20.14 11.9167 20.6919 12.4684L28.0482 19.8247C29.902 21.6785 28.5882 24.8476 25.9664 24.8476H4.86406C2.24227 24.8476 0.929909 21.6785 2.7837 19.8247L10.14 12.4684C10.6919 11.9167 11.002 11.1683 11.0022 10.388V2.77863L9.5309 1.30737Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Labtest </span>
        </a>
    </li>
    <?php } ?>

    <?php if(in_array(session()->get('role'), ['admin', 'superuser', 'cashier' ])){?>
    <li class="my-2  <?= ($uri->getSegment(2) === 'radiology' || $uri->getSegment(2) === 'addRadInvestigation')? 'sidebar__active-link': null; ?>">
        <a href="<?= base_url('store/radiology') ?>" class="d-flex align-items-center  <?= ($uri->getSegment(2) === 'radiology' || $uri->getSegment(2) === 'addRadInvestigation') ? 'sidebar__active-link': null; ?>">
            <svg  viewBox="0 0 30 34" fill="none">
            <path d="M8.66577 8.74487V22.2449C8.66577 23.14 9.02135 23.9984 9.65429 24.6314C10.2872 25.2643 11.1457 25.6199 12.0408 25.6199H22.1658M8.66577 8.74487V5.36987C8.66577 4.47477 9.02135 3.61632 9.65429 2.98339C10.2872 2.35045 11.1457 1.99487 12.0408 1.99487H19.7796C20.2272 1.99497 20.6563 2.17282 20.9727 2.48931L28.4213 9.93794C28.7378 10.2543 28.9157 10.6835 28.9158 11.131V22.2449C28.9158 23.14 28.5602 23.9984 27.9273 24.6314C27.2943 25.2643 26.4359 25.6199 25.5408 25.6199H22.1658M8.66577 8.74487H5.29077C4.39567 8.74487 3.53722 9.10045 2.90429 9.73339C2.27135 10.3663 1.91577 11.2248 1.91577 12.1199V28.9949C1.91577 29.89 2.27135 30.7484 2.90429 31.3814C3.53722 32.0143 4.39567 32.3699 5.29077 32.3699H18.7908C19.6859 32.3699 20.5443 32.0143 21.1773 31.3814C21.8102 30.7484 22.1658 29.89 22.1658 28.9949V25.6199"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Radiology </span>
        </a>
    </li>
    <?php } ?>

    <?php if(in_array(session()->get('role'), ['admin', 'superuser', 'cashier' ])){?>
    <li class="my-2  <?= ($uri->getSegment(2) === 'procedures' || $uri->getSegment(2) === 'addProcedure')? 'sidebar__active-link': null; ?>">
        <a href="<?= base_url('store/procedures') ?>" class="d-flex align-items-center  <?= ($uri->getSegment(2) === 'procedures' || $uri->getSegment(2) === 'addProcedure') ? 'sidebar__active-link': null; ?>">
            <svg  viewBox="0 0 30 34" fill="none">
            <path d="M8.66577 8.74487V22.2449C8.66577 23.14 9.02135 23.9984 9.65429 24.6314C10.2872 25.2643 11.1457 25.6199 12.0408 25.6199H22.1658M8.66577 8.74487V5.36987C8.66577 4.47477 9.02135 3.61632 9.65429 2.98339C10.2872 2.35045 11.1457 1.99487 12.0408 1.99487H19.7796C20.2272 1.99497 20.6563 2.17282 20.9727 2.48931L28.4213 9.93794C28.7378 10.2543 28.9157 10.6835 28.9158 11.131V22.2449C28.9158 23.14 28.5602 23.9984 27.9273 24.6314C27.2943 25.2643 26.4359 25.6199 25.5408 25.6199H22.1658M8.66577 8.74487H5.29077C4.39567 8.74487 3.53722 9.10045 2.90429 9.73339C2.27135 10.3663 1.91577 11.2248 1.91577 12.1199V28.9949C1.91577 29.89 2.27135 30.7484 2.90429 31.3814C3.53722 32.0143 4.39567 32.3699 5.29077 32.3699H18.7908C19.6859 32.3699 20.5443 32.0143 21.1773 31.3814C21.8102 30.7484 22.1658 29.89 22.1658 28.9949V25.6199"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Procedures </span>
        </a>
    </li>
    <?php } ?>


   <?php if(in_array(session()->get('role'), ['admin', 'superuser', 'cashier'])){?>
    <li class="my-2 <?= $uri->getSegment(1) === 'sales' ? 'sidebar__active-link': null; ?>">
    <!-- $uri->getSegment(2) === 'users' ? 'sidebar__active-link': null; -->
        <a href="/sales/items" class=" d-flex align-items-center  <?= $uri->getSegment(1) === 'sales' ? 'sidebar__active-link': null; ?>">
           <svg viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 9L8 6L11 9L15 5M6 18L10 14L14 18M1 1H19M2 1H18V13C18 13.2652 17.8946 13.5196 17.7071 13.7071C17.5196 13.8946 17.2652 14 17 14H3C2.73478 14 2.48043 13.8946 2.29289 13.7071C2.10536 13.5196 2 13.2652 2 13V1Z"  stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Sales </span>
        </a>
    </li>
    <?php } ?>

    <?php if(in_array(session()->get('role'), ['admin', 'superuser'])){?>
    <li class="my-2 <?= $uri->getSegment(1) === 'user' ? 'sidebar__active-link': null; ?>">
    <!-- $uri->getSegment(2) === 'users' ? 'sidebar__active-link': null; -->
        <a href="/user/list" class=" d-flex align-items-center  <?= $uri->getSegment(1) === 'user' ? 'sidebar__active-link': null; ?>">
            <svg viewBox="0 0 30 37" fill="none">
                <path d="M20.0122 14.2621C21.4589 12.8154 22.2717 10.8533 22.2717 8.80731C22.2717 6.76135 21.4589 4.79919 20.0122 3.35248C18.5655 1.90577 16.6033 1.09302 14.5574 1.09302C12.5114 1.09302 10.5493 1.90577 9.10255 3.35248C7.65584 4.79919 6.84309 6.76135 6.84309 8.80731C6.84309 10.8533 7.65584 12.8154 9.10255 14.2621C10.5493 15.7088 12.5114 16.5216 14.5574 16.5216C16.6033 16.5216 18.5655 15.7088 20.0122 14.2621Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5.01143 26.2614C7.54317 23.7296 10.977 22.3073 14.5574 22.3073C18.1378 22.3073 21.5716 23.7296 24.1033 26.2614C26.6351 28.7931 28.0574 32.2269 28.0574 35.8073H1.05737C1.05737 32.2269 2.47969 28.7931 5.01143 26.2614Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Users </span>
        </a>
    </li>
    <?php } ?>

    <?php if(in_array(session()->get('role'), ['admin', 'superuser'])){?>
    <li class="my-2 <?= $uri->getSegment(1) === 'ward' ? 'sidebar__active-link': null; ?>">
    <!-- $uri->getSegment(2) === 'users' ? 'sidebar__active-link': null; -->
        <a href="/ward" class=" d-flex align-items-center  <?= $uri->getSegment(1) === 'ward' ? 'sidebar__active-link': null; ?>">
            <svg viewBox="0 0 30 37" fill="none">
                <path d="M20.0122 14.2621C21.4589 12.8154 22.2717 10.8533 22.2717 8.80731C22.2717 6.76135 21.4589 4.79919 20.0122 3.35248C18.5655 1.90577 16.6033 1.09302 14.5574 1.09302C12.5114 1.09302 10.5493 1.90577 9.10255 3.35248C7.65584 4.79919 6.84309 6.76135 6.84309 8.80731C6.84309 10.8533 7.65584 12.8154 9.10255 14.2621C10.5493 15.7088 12.5114 16.5216 14.5574 16.5216C16.6033 16.5216 18.5655 15.7088 20.0122 14.2621Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5.01143 26.2614C7.54317 23.7296 10.977 22.3073 14.5574 22.3073C18.1378 22.3073 21.5716 23.7296 24.1033 26.2614C26.6351 28.7931 28.0574 32.2269 28.0574 35.8073H1.05737C1.05737 32.2269 2.47969 28.7931 5.01143 26.2614Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Ward </span>
        </a>
    </li>
    <?php } ?>

    <?php if(in_array(session()->get('role'), ['admin', 'superuser', 'cashier'])){?>
    <li class="my-2 <?= $uri->getSegment(1) === 'expense' ? 'sidebar__active-link': null; ?>">
    <!-- $uri->getSegment(2) === 'users' ? 'sidebar__active-link': null; -->
          <a href="/expense/list" class=" d-flex align-items-center  <?= $uri->getSegment(1) === 'expense' ? 'sidebar__active-link': null; ?>">
            <svg  viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 11H19M19 11V3M19 11L11 3L7 7L1 1"  stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Expense </span>
        </a>
    </li>
    <?php } ?>

    <!-- <li class="my-2">
        <a href="" class="d-flex align-items-center">
            <svg  viewBox="0 0 30 30" fill="none" >
                <path d="M15.4158 3.83837C16.2219 2.92443 17.2873 2.27764 18.4701 1.98406C19.6529 1.69049 20.897 1.76406 22.037 2.19498C23.177 2.62589 24.1587 3.39373 24.8515 4.39631C25.5443 5.3989 25.9154 6.58869 25.9154 7.80737C25.9154 9.02606 25.5443 10.2159 24.8515 11.2184C24.1587 12.221 23.177 12.9889 22.037 13.4198C20.897 13.8507 19.6529 13.9243 18.4701 13.6307C17.2873 13.3371 16.2219 12.6903 15.4158 11.7764M19.9158 28.8074H1.91577V27.3074C1.91577 24.9204 2.86398 22.6312 4.55181 20.9434C6.23964 19.2556 8.52882 18.3074 10.9158 18.3074C13.3027 18.3074 15.5919 19.2556 17.2797 20.9434C18.9676 22.6312 19.9158 24.9204 19.9158 27.3074V28.8074ZM19.9158 28.8074H28.9158V27.3074C28.916 25.7274 28.5003 24.1753 27.7105 22.8069C26.9207 21.4386 25.7845 20.3023 24.4163 19.5122C23.0481 18.7221 21.496 18.3062 19.9161 18.3061C18.3362 18.306 16.784 18.7219 15.4158 19.5119M16.9158 7.80737C16.9158 9.39867 16.2836 10.9248 15.1584 12.05C14.0332 13.1752 12.5071 13.8074 10.9158 13.8074C9.32447 13.8074 7.79835 13.1752 6.67313 12.05C5.54791 10.9248 4.91577 9.39867 4.91577 7.80737C4.91577 6.21608 5.54791 4.68995 6.67313 3.56473C7.79835 2.43951 9.32447 1.80737 10.9158 1.80737C12.5071 1.80737 14.0332 2.43951 15.1584 3.56473C16.2836 4.68995 16.9158 6.21608 16.9158 7.80737Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Patients </span>
        </a>
    </li> -->
    <!-- <li class="my-2">
        <a href="" class="d-flex align-items-center">
            <svg viewBox="0 0 28 22" fill="none">
                <path d="M26.0872 12.8746L19.9418 4.09489C18.8965 2.60426 17.2324 1.80738 15.5449 1.80738C14.4856 1.80738 13.4121 2.12144 12.4746 2.7777C11.5512 3.42457 10.8949 4.3152 10.5293 5.29958C10.3934 2.51988 8.11991 0.307373 5.30739 0.307373C2.40582 0.307373 0.057373 2.65582 0.057373 5.55739V16.0574C0.057373 18.959 2.40582 21.3075 5.30739 21.3075C8.20897 21.3075 10.5574 18.959 10.5574 16.0574V9.06835C10.7121 9.47147 10.8996 9.86991 11.1574 10.2402L17.3074 19.0199C18.3481 20.5106 20.0121 21.3075 21.7043 21.3075C22.7684 21.3075 23.8372 20.9934 24.7747 20.3371C27.1981 18.6403 27.784 15.2981 26.0872 12.8746ZM7.5574 10.8074H3.05739V5.55739C3.05739 4.3152 4.0652 3.30739 5.30739 3.30739C6.54959 3.30739 7.5574 4.3152 7.5574 5.55739V10.8074ZM16.6887 12.9121L13.6137 8.51991C13.2527 8.00428 13.1121 7.37615 13.2246 6.7574C13.3324 6.13865 13.6793 5.59489 14.1949 5.23396C14.5934 4.9527 15.0621 4.80739 15.5449 4.80739C16.3184 4.80739 17.0403 5.18239 17.4809 5.81521L20.5559 10.2074L16.6887 12.9121V12.9121Z" fill="#20243D"/>
            </svg>
            <span> Pharmacy </span>
        </a>
    </li> -->
    <!-- <li class="my-2">
        <a href="" class="d-flex align-items-center">
            <svg  viewBox="0 0 30 26" fill="none">
                <path d="M26.3445 18.121C25.9337 17.7101 25.4105 17.4301 24.8409 17.3162L21.329 16.6144C19.404 16.2294 17.4057 16.4971 15.6499 17.375L15.182 17.6075C13.4262 18.4854 11.4279 18.7531 9.50295 18.3681L6.66194 17.8002C6.18702 17.7053 5.69603 17.7291 5.23251 17.8695C4.769 18.0099 4.34731 18.2625 4.00485 18.605M9.5309 1.30737H21.301L19.8297 2.77863V10.388C19.8299 11.1683 20.14 11.9167 20.6919 12.4684L28.0482 19.8247C29.902 21.6785 28.5882 24.8476 25.9664 24.8476H4.86406C2.24227 24.8476 0.929909 21.6785 2.7837 19.8247L10.14 12.4684C10.6919 11.9167 11.002 11.1683 11.0022 10.388V2.77863L9.5309 1.30737Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Laboratory </span>
        </a>
    </li> -->
    <?php if(in_array(session()->get('role'), ['admin', 'superuser', 'pharmacy', 'cashier', 'reception', 'doctor', 'lab'])){?>
    <li class="my-2  <?= $uri->getSegment(1) === 'patient' ? 'sidebar__active-link': null; ?>">
        <a href="/patient/search" class="d-flex align-items-center  <?= $uri->getSegment(1) === 'patient' ? 'sidebar__active-link': null; ?>">
           <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                <path d="M15.4158 3.83837C16.2219 2.92443 17.2873 2.27764 18.4701 1.98406C19.6529 1.69049 20.897 1.76406 22.037 2.19498C23.177 2.62589 24.1587 3.39373 24.8515 4.39631C25.5443 5.3989 25.9154 6.58869 25.9154 7.80737C25.9154 9.02606 25.5443 10.2159 24.8515 11.2184C24.1587 12.221 23.177 12.9889 22.037 13.4198C20.897 13.8507 19.6529 13.9243 18.4701 13.6307C17.2873 13.3371 16.2219 12.6903 15.4158 11.7764M19.9158 28.8074H1.91577V27.3074C1.91577 24.9204 2.86398 22.6312 4.55181 20.9434C6.23964 19.2556 8.52882 18.3074 10.9158 18.3074C13.3027 18.3074 15.5919 19.2556 17.2797 20.9434C18.9676 22.6312 19.9158 24.9204 19.9158 27.3074V28.8074ZM19.9158 28.8074H28.9158V27.3074C28.916 25.7274 28.5003 24.1753 27.7105 22.8069C26.9207 21.4386 25.7845 20.3023 24.4163 19.5122C23.0481 18.7221 21.496 18.3062 19.9161 18.3061C18.3362 18.306 16.784 18.7219 15.4158 19.5119M16.9158 7.80737C16.9158 9.39867 16.2836 10.9248 15.1584 12.05C14.0332 13.1752 12.5071 13.8074 10.9158 13.8074C9.32447 13.8074 7.79835 13.1752 6.67313 12.05C5.54791 10.9248 4.91577 9.39867 4.91577 7.80737C4.91577 6.21608 5.54791 4.68995 6.67313 3.56473C7.79835 2.43951 9.32447 1.80737 10.9158 1.80737C12.5071 1.80737 14.0332 2.43951 15.1584 3.56473C16.2836 4.68995 16.9158 6.21608 16.9158 7.80737Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>  Patient </span>
        </a>
    </li>
    <?php } ?> 

    <?php if(in_array(session()->get('role'), ['doctor'])){?>
    <li class="my-2  <?= $uri->getSegment(1) === 'consultation' ? 'sidebar__active-link': null; ?>">
        <a href="/consultation/my_list" class="d-flex align-items-center  <?= $uri->getSegment(1) === 'my_list' ? 'sidebar__active-link': null; ?>">
           <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                <path d="M15.4158 3.83837C16.2219 2.92443 17.2873 2.27764 18.4701 1.98406C19.6529 1.69049 20.897 1.76406 22.037 2.19498C23.177 2.62589 24.1587 3.39373 24.8515 4.39631C25.5443 5.3989 25.9154 6.58869 25.9154 7.80737C25.9154 9.02606 25.5443 10.2159 24.8515 11.2184C24.1587 12.221 23.177 12.9889 22.037 13.4198C20.897 13.8507 19.6529 13.9243 18.4701 13.6307C17.2873 13.3371 16.2219 12.6903 15.4158 11.7764M19.9158 28.8074H1.91577V27.3074C1.91577 24.9204 2.86398 22.6312 4.55181 20.9434C6.23964 19.2556 8.52882 18.3074 10.9158 18.3074C13.3027 18.3074 15.5919 19.2556 17.2797 20.9434C18.9676 22.6312 19.9158 24.9204 19.9158 27.3074V28.8074ZM19.9158 28.8074H28.9158V27.3074C28.916 25.7274 28.5003 24.1753 27.7105 22.8069C26.9207 21.4386 25.7845 20.3023 24.4163 19.5122C23.0481 18.7221 21.496 18.3062 19.9161 18.3061C18.3362 18.306 16.784 18.7219 15.4158 19.5119M16.9158 7.80737C16.9158 9.39867 16.2836 10.9248 15.1584 12.05C14.0332 13.1752 12.5071 13.8074 10.9158 13.8074C9.32447 13.8074 7.79835 13.1752 6.67313 12.05C5.54791 10.9248 4.91577 9.39867 4.91577 7.80737C4.91577 6.21608 5.54791 4.68995 6.67313 3.56473C7.79835 2.43951 9.32447 1.80737 10.9158 1.80737C12.5071 1.80737 14.0332 2.43951 15.1584 3.56473C16.2836 4.68995 16.9158 6.21608 16.9158 7.80737Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span style="font-size: .8rem;"> My consultation </span>
        </a>
    </li>
    <?php } ?> 

    <!-- <?php if(in_array(session()->get('role'), ['admin', 'superuser', 'reception'])){?>
    <li class="my-2  <?= $uri->getSegment(2) === 'register' ? 'sidebar__active-link': null; ?>">
        <a href="/patient/register" class="d-flex align-items-center  <?= $uri->getSegment(2) === 'register' ? 'sidebar__active-link': null; ?>">
           <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                <path d="M15.4158 3.83837C16.2219 2.92443 17.2873 2.27764 18.4701 1.98406C19.6529 1.69049 20.897 1.76406 22.037 2.19498C23.177 2.62589 24.1587 3.39373 24.8515 4.39631C25.5443 5.3989 25.9154 6.58869 25.9154 7.80737C25.9154 9.02606 25.5443 10.2159 24.8515 11.2184C24.1587 12.221 23.177 12.9889 22.037 13.4198C20.897 13.8507 19.6529 13.9243 18.4701 13.6307C17.2873 13.3371 16.2219 12.6903 15.4158 11.7764M19.9158 28.8074H1.91577V27.3074C1.91577 24.9204 2.86398 22.6312 4.55181 20.9434C6.23964 19.2556 8.52882 18.3074 10.9158 18.3074C13.3027 18.3074 15.5919 19.2556 17.2797 20.9434C18.9676 22.6312 19.9158 24.9204 19.9158 27.3074V28.8074ZM19.9158 28.8074H28.9158V27.3074C28.916 25.7274 28.5003 24.1753 27.7105 22.8069C26.9207 21.4386 25.7845 20.3023 24.4163 19.5122C23.0481 18.7221 21.496 18.3062 19.9161 18.3061C18.3362 18.306 16.784 18.7219 15.4158 19.5119M16.9158 7.80737C16.9158 9.39867 16.2836 10.9248 15.1584 12.05C14.0332 13.1752 12.5071 13.8074 10.9158 13.8074C9.32447 13.8074 7.79835 13.1752 6.67313 12.05C5.54791 10.9248 4.91577 9.39867 4.91577 7.80737C4.91577 6.21608 5.54791 4.68995 6.67313 3.56473C7.79835 2.43951 9.32447 1.80737 10.9158 1.80737C12.5071 1.80737 14.0332 2.43951 15.1584 3.56473C16.2836 4.68995 16.9158 6.21608 16.9158 7.80737Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> New Patient </span>
        </a>
    </li>
    <?php } ?> -->

<!--
     <?php if(in_array(session()->get('role'), ['admin', 'superuser', 'cashier', 'doctor'])){?>
    <li class="my-2  <?= $uri->getSegment(1) === 'consultation' ? 'sidebar__active-link': null; ?>">
        <a href="/consultation/list" class="d-flex align-items-center  <?= $uri->getSegment(1) === 'consultation' ? 'sidebar__active-link': null; ?>">
           <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                <path d="M15.4158 3.83837C16.2219 2.92443 17.2873 2.27764 18.4701 1.98406C19.6529 1.69049 20.897 1.76406 22.037 2.19498C23.177 2.62589 24.1587 3.39373 24.8515 4.39631C25.5443 5.3989 25.9154 6.58869 25.9154 7.80737C25.9154 9.02606 25.5443 10.2159 24.8515 11.2184C24.1587 12.221 23.177 12.9889 22.037 13.4198C20.897 13.8507 19.6529 13.9243 18.4701 13.6307C17.2873 13.3371 16.2219 12.6903 15.4158 11.7764M19.9158 28.8074H1.91577V27.3074C1.91577 24.9204 2.86398 22.6312 4.55181 20.9434C6.23964 19.2556 8.52882 18.3074 10.9158 18.3074C13.3027 18.3074 15.5919 19.2556 17.2797 20.9434C18.9676 22.6312 19.9158 24.9204 19.9158 27.3074V28.8074ZM19.9158 28.8074H28.9158V27.3074C28.916 25.7274 28.5003 24.1753 27.7105 22.8069C26.9207 21.4386 25.7845 20.3023 24.4163 19.5122C23.0481 18.7221 21.496 18.3062 19.9161 18.3061C18.3362 18.306 16.784 18.7219 15.4158 19.5119M16.9158 7.80737C16.9158 9.39867 16.2836 10.9248 15.1584 12.05C14.0332 13.1752 12.5071 13.8074 10.9158 13.8074C9.32447 13.8074 7.79835 13.1752 6.67313 12.05C5.54791 10.9248 4.91577 9.39867 4.91577 7.80737C4.91577 6.21608 5.54791 4.68995 6.67313 3.56473C7.79835 2.43951 9.32447 1.80737 10.9158 1.80737C12.5071 1.80737 14.0332 2.43951 15.1584 3.56473C16.2836 4.68995 16.9158 6.21608 16.9158 7.80737Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Consultation </span>
        </a>
    </li>
    <?php } ?> -->

    <!--if(in_array('can_generate_report', session()->get('permission'))) -->
    <?php if(in_array(session()->get('role'), ['admin', 'superuser' ])){?>
    <li class="my-2  <?= $uri->getSegment(1) === 'report' ? 'sidebar__active-link': null; ?>">
        <a href="/report" class="d-flex align-items-center  <?= $uri->getSegment(1) === 'report' ? 'sidebar__active-link': null; ?>">
            <svg  viewBox="0 0 30 34" fill="none">
            <path d="M8.66577 8.74487V22.2449C8.66577 23.14 9.02135 23.9984 9.65429 24.6314C10.2872 25.2643 11.1457 25.6199 12.0408 25.6199H22.1658M8.66577 8.74487V5.36987C8.66577 4.47477 9.02135 3.61632 9.65429 2.98339C10.2872 2.35045 11.1457 1.99487 12.0408 1.99487H19.7796C20.2272 1.99497 20.6563 2.17282 20.9727 2.48931L28.4213 9.93794C28.7378 10.2543 28.9157 10.6835 28.9158 11.131V22.2449C28.9158 23.14 28.5602 23.9984 27.9273 24.6314C27.2943 25.2643 26.4359 25.6199 25.5408 25.6199H22.1658M8.66577 8.74487H5.29077C4.39567 8.74487 3.53722 9.10045 2.90429 9.73339C2.27135 10.3663 1.91577 11.2248 1.91577 12.1199V28.9949C1.91577 29.89 2.27135 30.7484 2.90429 31.3814C3.53722 32.0143 4.39567 32.3699 5.29077 32.3699H18.7908C19.6859 32.3699 20.5443 32.0143 21.1773 31.3814C21.8102 30.7484 22.1658 29.89 22.1658 28.9949V25.6199"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Reports </span>
        </a>
    </li>
    <?php } ?>

 

    <!-- <?php if(in_array(session()->get('role'), ['lab' ])){?>
    <li class="my-2  <?= $uri->getSegment(1) === 'report' ? 'sidebar__active-link': null; ?>">
        <a href="/report" class="d-flex align-items-center  <?= $uri->getSegment(1) === 'report' ? 'sidebar__active-link': null; ?>">
            <svg  viewBox="0 0 30 34" fill="none">
            <path d="M8.66577 8.74487V22.2449C8.66577 23.14 9.02135 23.9984 9.65429 24.6314C10.2872 25.2643 11.1457 25.6199 12.0408 25.6199H22.1658M8.66577 8.74487V5.36987C8.66577 4.47477 9.02135 3.61632 9.65429 2.98339C10.2872 2.35045 11.1457 1.99487 12.0408 1.99487H19.7796C20.2272 1.99497 20.6563 2.17282 20.9727 2.48931L28.4213 9.93794C28.7378 10.2543 28.9157 10.6835 28.9158 11.131V22.2449C28.9158 23.14 28.5602 23.9984 27.9273 24.6314C27.2943 25.2643 26.4359 25.6199 25.5408 25.6199H22.1658M8.66577 8.74487H5.29077C4.39567 8.74487 3.53722 9.10045 2.90429 9.73339C2.27135 10.3663 1.91577 11.2248 1.91577 12.1199V28.9949C1.91577 29.89 2.27135 30.7484 2.90429 31.3814C3.53722 32.0143 4.39567 32.3699 5.29077 32.3699H18.7908C19.6859 32.3699 20.5443 32.0143 21.1773 31.3814C21.8102 30.7484 22.1658 29.89 22.1658 28.9949V25.6199"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Report </span>
        </a>
    </li>e
    <?php } ?> -->

    <?php if(in_array(session()->get('role'), ['reception' ])){?>
    <!-- <li class="my-2  <?= $uri->getSegment(1) === 'report' ? 'sidebar__active-link': null; ?>">
        <a href="/report" class="d-flex align-items-center  <?= $uri->getSegment(1) === 'report' ? 'sidebar__active-link': null; ?>">
            <svg  viewBox="0 0 30 34" fill="none">
            <path d="M8.66577 8.74487V22.2449C8.66577 23.14 9.02135 23.9984 9.65429 24.6314C10.2872 25.2643 11.1457 25.6199 12.0408 25.6199H22.1658M8.66577 8.74487V5.36987C8.66577 4.47477 9.02135 3.61632 9.65429 2.98339C10.2872 2.35045 11.1457 1.99487 12.0408 1.99487H19.7796C20.2272 1.99497 20.6563 2.17282 20.9727 2.48931L28.4213 9.93794C28.7378 10.2543 28.9157 10.6835 28.9158 11.131V22.2449C28.9158 23.14 28.5602 23.9984 27.9273 24.6314C27.2943 25.2643 26.4359 25.6199 25.5408 25.6199H22.1658M8.66577 8.74487H5.29077C4.39567 8.74487 3.53722 9.10045 2.90429 9.73339C2.27135 10.3663 1.91577 11.2248 1.91577 12.1199V28.9949C1.91577 29.89 2.27135 30.7484 2.90429 31.3814C3.53722 32.0143 4.39567 32.3699 5.29077 32.3699H18.7908C19.6859 32.3699 20.5443 32.0143 21.1773 31.3814C21.8102 30.7484 22.1658 29.89 22.1658 28.9949V25.6199"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span> Statistic </span>
        </a>
    </li> -->
    <?php } ?>

     

</ul><!-- sidebar-nav -->