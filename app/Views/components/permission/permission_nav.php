
<ul class="nav flex-column" >
  <li class="nav-item">
    <a class="nav-link " :class="{'p_active': isActive == 'user'}"  aria-current="page"  @click="isActive='user'" href="#">User</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" :class="{'p_active': isActive == 'sale'}" href="#" @click="isActive='sale'">Sale</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" :class="{'p_active': isActive == 'drug'}" href="#" @click="isActive='drug'">Drugs</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" :class="{'p_active': isActive == 'labtest'}" href="#" @click="isActive='labtest'">Lab test</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" :class="{'p_active': isActive == 'radiology'}" href="#" @click="isActive='radiology'">Radiology</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" :class="{'p_active': isActive == 'procedure'}" href="#" @click="isActive='procedure'">Procedure</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" :class="{'p_active': isActive == 'expenses'}" href="#" @click="isActive='expenses'">Expenses</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" :class="{'p_active': isActive == 'report'}" href="#" @click="isActive='report'">Report</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" :class="{'p_active': isActive == 'patient'}" href="#" @click="isActive='patient'">Patient</a>
  </li>
  <!-- <li class="nav-item">
    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
  </li> -->
</ul>

