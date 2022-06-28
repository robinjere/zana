<div id="laboratory_test" class="labtest mt-5" x-data="labtestData()">
   <h5>
        <span class='icon'>
           <svg viewBox="0 0 30 26" fill="none">
             <path d="M26.3445 18.121C25.9337 17.7101 25.4105 17.4301 24.8409 17.3162L21.329 16.6144C19.404 16.2294 17.4057 16.4971 15.6499 17.375L15.182 17.6075C13.4262 18.4854 11.4279 18.7531 9.50295 18.3681L6.66194 17.8002C6.18702 17.7053 5.69603 17.7291 5.23251 17.8695C4.769 18.0099 4.34731 18.2625 4.00485 18.605M9.5309 1.30737H21.301L19.8297 2.77863V10.388C19.8299 11.1683 20.14 11.9167 20.6919 12.4684L28.0482 19.8247C29.902 21.6785 28.5882 24.8476 25.9664 24.8476H4.86406C2.24227 24.8476 0.929909 21.6785 2.7837 19.8247L10.14 12.4684C10.6919 11.9167 11.002 11.1683 11.0022 10.388V2.77863L9.5309 1.30737Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
           </svg>
        </span> 
        <span>
          Laboratory Test
        </span>  
   </h5>
    <!-- alert message -->

     <!-- icons -->
     <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
      <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
         <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
      </symbol>
      <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
         <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
      </symbol>
      <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
         <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
      </symbol>
      </svg>
     <!-- icons -->
   <template x-if="success== true">
      <div x-cloak x-show="success== true" class="alert alert-success d-flex align-items-center" role="alert">
         <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div x-text="message"></div>
      </div>
   </template>
   <template x-if="(success == false ) && message != '' ">
   <div x-cloak x-show="(success == false ) && message != '' " class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <div x-text="message"></div>
   </div>
   </template>

   <!-- alert message -->

   <div class="d-flex justify-content-end mb-3">
     <button type="button" class="btn btn-outline-primary" x-cloak x-show="showSearchBtn" @click="showSearchInput=true">Assign LabTest</button>
     <!-- <button type="button" class="btn btn-outline-primary" @click="assignDrug()" x-cloak x-show="showAssignArea">Assign LabTest</button> -->
   </div>

   <div>
       <div class="mb-3">
           <!-- <label for="" class="form-label"></label> -->
           <input type="text" x-model="searchInput" @keyup="searchLabTest()" x-cloak x-show="showSearchInput" class="form-control" name="" id="" aria-describedby="helpId" placeholder=" Search lab test">
           <template x-if="labtests.length">
             <ul class="list-group mt-1" style="overflow-y: scroll; max-height: 170px;">
               <!-- <a href="#" class="list-group-item list-group-item-action active">Active item</a> -->
               <template x-for="test in labtests">
                 <li @click="selectLabTest(test.id)" class="list-group-item list-group-item-action" x-text="test.name.toUpperCase()">Active item</li>
               </template>

               <!-- <li href="#" class="list-group-item list-group-item-action">Item</li>
               <li href="#" class="list-group-item list-group-item-action">Item</li>
               <li href="#" class="list-group-item list-group-item-action">Item</li>
               <li href="#" class="list-group-item list-group-item-action">Item</li> -->
               <!-- <a href="#" class="list-group-item list-group-item-action disabled">Disabled item</a> -->
             </ul><!-- /ul -->
           </template>
           <!-- <small id="helpId" class="form-text text-muted">search drug </small> -->
        </div> <!-- /mb-3 -->
   </div>


</div> <!-- /labtest -->

<?= $this->section('script') ?>
<script>

  function labtestData(){
      return {
         success: false,
         message: '',
         showSearchBtn: true,
         showAssignArea: false,
         searchInput: '',
         showSearchInput: false,
         searchLabTest(){

          if(this.searchInput !== ''){
            fetch('<?= base_url('patientFileController/ajax_searchlabtest') ?>',{
                method: 'post',
                headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                searchInput: this.searchInput
                })
              }).then(res => res.json()).then(data => {
                this.labtests = data.searchLabtest
             })
            }else{
            this.labtests = []
           }
         },
         labtests: [],
         selected: '',
         selectLabTest(selected){
            this.selected = this.labtests.filter(lab => Number(lab.id) == Number(selected))[0]
            fetch('<?= base_url('patientFileController/ajax_assignlabtest') ?>',{
                method: 'post',
                headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                   labtest_id : selected,
                   price: this.selected.price,
                   doctor: <?= session()->get('id') ?>
                })
              }).then(res => res.json()).then(data => {
                       this.success = data.success
                       this.message = data.message
                       this.labtests = [];
                       this.showSearchInput = false
                    //    console.log('assignlabtest', data)
             })
         },
      }
  }

  </script>
<?= $this->endSection() ?>