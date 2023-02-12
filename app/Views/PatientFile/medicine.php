<div id="medicine" class="medicine" x-data="medicineData()">
  <div class="d-flex justify-content-between align-items-center mb-2">
   <h5>
        <span class='icon'>
             <svg viewBox="0 0 28 22" fill="none" >
               <path d="M26.0872 12.8746L19.9418 4.09489C18.8965 2.60426 17.2324 1.80738 15.5449 1.80738C14.4856 1.80738 13.4121 2.12144 12.4746 2.7777C11.5512 3.42457 10.8949 4.3152 10.5293 5.29958C10.3934 2.51988 8.11991 0.307373 5.30739 0.307373C2.40582 0.307373 0.057373 2.65582 0.057373 5.55739V16.0574C0.057373 18.959 2.40582 21.3075 5.30739 21.3075C8.20897 21.3075 10.5574 18.959 10.5574 16.0574V9.06835C10.7121 9.47147 10.8996 9.86991 11.1574 10.2402L17.3074 19.0199C18.3481 20.5106 20.0121 21.3075 21.7043 21.3075C22.7684 21.3075 23.8372 20.9934 24.7747 20.3371C27.1981 18.6403 27.784 15.2981 26.0872 12.8746ZM7.5574 10.8074H3.05739V5.55739C3.05739 4.3152 4.0652 3.30739 5.30739 3.30739C6.54959 3.30739 7.5574 4.3152 7.5574 5.55739V10.8074ZM16.6887 12.9121L13.6137 8.51991C13.2527 8.00428 13.1121 7.37615 13.2246 6.7574C13.3324 6.13865 13.6793 5.59489 14.1949 5.23396C14.5934 4.9527 15.0621 4.80739 15.5449 4.80739C16.3184 4.80739 17.0403 5.18239 17.4809 5.81521L20.5559 10.2074L16.6887 12.9121V12.9121Z" fill="#20243D"/>
             </svg>
        </span> 
        <span>
          Medicine
        </span>  
   </h5>

   <!-- Button trigger modal -->
   <?php if(session()->get('role') == 'doctor' && !$patient_file['ishistory']){ ?>
    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#MedicineModelId" @click="showSearchInput=true">Search Drug</button>
   <?php } ?>

   <?php if(session()->get('role') == 'cashier'){ ?>
            <template x-if="itermsForPrinting.length"> 
               <form target="_blank" action="<?= base_url()?>/generaterisit" method="post">
                  <input type="hidden" name="risitType" value="medicine"/>
                  <input type="hidden" name="fileId" value="<?= $patient_file['id'] ?>"/>
                  <input type="hidden" name="fileNo" value="<?= $patient_file['file_no'] ?>"/>
                  <input type="hidden" name="fullName" value="<?= $patient_file['first_name'].' '.$patient_file['middle_name'] .', '. $patient_file['sir_name'] ?>"/>
                  <input type="hidden" name="start_treatment" value="<?= $patient_file['start_treatment'] ?>"/>
                  <input type="hidden" name="end_treatment" value="<?= $patient_file['end_treatment'] ?>"/>
                  <input type="hidden" name="printList" :value=" JSON.stringify(itermsForPrinting); "/>
                  <button type="submit" class="btn btn-sm btn-success">
                              Generate risit
                  </button>
               </form>
            </template>
     <?php } ?>
   
   <!-- Modal -->
   <div class="modal fade" id="MedicineModelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 48%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Assign Drug</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" @click="clearSearch()" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="">
               <div class="d-flex justify-content-center align-items-center">
                 <input type="text" x-model="searchInput" @keyup="searchDrug()" class="form-control" name="" id="" aria-describedby="helpId" placeholder=" Search drug">
               </div><!-- /d-flex -->
              
              <div class="d-flex justify-content-center align-items-center mt-2">
                <div x-cloak x-show="loading" class="spinner-border" role="status">
                      <span class="visually-hidden">Loading...</span>
                </div><!-- /spinner-border -->
              </div><!-- /d-flex -->

              <div class="d-flex justify-content-center align-items-center">
                <template x-if="searchItems.length">
                  <ul class="list-group mt-1 w-100" style="overflow-y: scroll; max-height: 170px;">
                    <!-- <a href="#" class="list-group-item list-group-item-action active">Active item</a> -->
                    <template x-for="drug in searchItems">
                      <li @click="selectDrug(drug.id)" class="list-group-item list-group-item-action" x-text="`${drug.name.toUpperCase()} - ${drug.drug_kind.toUpperCase()}` ">Active item</li>
                    </template>
                  </ul><!-- /ul -->
                </template>
              </div><!-- /d-flex -->
          </div> <!-- /mb-3 -->

          <form  x-on:submit.prevent x-cloak x-show="showAssignArea">
           <div class="row">
           <div class="col">
               <label for="unit" class="form-label">Unit</label>
               <input type="text" disabled x-model="unit" id="unit" class="form-control" placeholder="unit" />
           </div>
           <div class="col">
               <label for="dosage" class="form-label">Dosage</label>
               <input type="text" x-model="dosage" id="dosage" class="form-control" placeholder="dosage" />
           </div>
           <div class="col">
                <label for="frequency" class="form-label">Frequency</label>
                <select x-model="frequency" id="frequecy" class="form-control">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                </select>
           </div>
           <div class="col">
             <div class="mb-3">
               <label for="route" class="form-label">Route</label>   
                 <template x-if="route != ''">              
                   <input type="text" x-model="route" disabled class="form-control" name="" aria-describedby="" placeholder="">
                 </template>              
                 <template x-if="route == ''">
                   <select x-model="route" class="form-control">
                      <option>IV</option>
                      <option>IM</option>
                      <option>ORAL</option>
                      <option>SC</option>
                      <option>Topical</option>
                      <option>Drops</option>
                      <option>Per Rectal</option>
                      <option>Per Vaginal</option>
                    </select>
                 </template>
             </div>
           </div>
           <div class="col">
             <div class="mb-3">
               <label for="days" class="form-label">Days</label>
               <input type="text" x-model="days" class="form-control" name="" id="days" placeholder="Days">
             </div>
           </div>
           <div class="col">
             <div class="mb-3">
               <label for="qty" class="form-label">Qty</label>
               <input type="number" x-model="qty" class="form-control" name="" id="qty" placeholder="qty">
             </div>
           </div>
           </div> <!-- /row -->
           <div class="row">
            <div class="col">
              
                <label for="instruction" class="form-label">Instruction</label>
                <textarea name="" x-model="instruction" id="instruction" class="form-control"> instrustion</textarea>
              
            </div>
           </div><!-- /rpw -->
        </form>
          
        </div><!-- /modal-body -->
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
          <button type="button" class="btn btn-sm btn-outline-success" data-bs-dismiss="modal" @click="assignDrug()">Assign Drug</button>
          <!-- <button type="button" class="btn btn-primary">Save</button> -->
        </div>
      </div>
    </div>
   </div>
    <!-- Modal -->

  </div><!-- /d-flex -->
   

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

   <!-- <div class="d-flex justify-content-end mb-3">
    
   </div> -->
   <!-- <div>
     <div>

     </div>
   </div> -->

   <div class="medicine-table">
         <table id="table_medicine" class="table table-striped table-bordered">
            <thead>   
               <tr class="table-header">
                  <th scope="col">Date</th>
                  <th scope="col">Drug</th>
                  <th scope="col">Dosage </th>
                  <th scope="col">Route</th> 
                  <th scope="col">Frequency</th>
                  <th scope="col">Days</th>
                  <th scope="col">Qty</th>
                  <th scope="col">Instruction</th>
                  <th scope="col">Paid</th>
                  <th scope="col">Price/Qty</th>
                  <?php
                    if(!session()->has('phistory')){?>
                      <th scope="col" >Action</th>
                   <?php } ?>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th colspan="9" style="text-align:right">Total:</th>
                  <th colspan="2"></th>
               </tr>
           </tfoot>
        </table>
    </div><!-- /procedure-table -->

</div>


<?= $this->section('script') ?>
<script>

  function medicineData(){
    return {
      loading: false,
      success: false,
      message: '',
      searchItems:[],
      showSearchBtn: true,
      showSearchInput: false,
      searchInput: '',
      showAssignArea: false,
      unit: 2,
      dosage: '',
      frequency: '',
      route: 'IV',
      days: 0,
      qty: 0,
      instruction: '',
      id: 0,
      amount: 0,
      alertTime: '',
      searchDrug(){
        // console.log('search input typed', this.searchInput)
        if(this.searchInput !== ''){
          this.loading = true;
          fetch('<?= base_url('patientFileController/ajax_searchdrug') ?>',{
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
              this.loading = false;
              this.searchItems = data.searchItem
              // console.log('searched drug', data.searchItem)
          })
        }else{
          this.searchItems = []
        }
      },
     selectDrug(drug_id){ 
        let available_drug = ''
        available_drug = this.searchItems.filter(drug => Number(drug.id) == Number(drug_id))[0]
        //  console.log('selected drug', available_drug);
          this.unit = Number(available_drug.qty)
          this.dosage = ''
          this.frequency = 1,
          this.route = available_drug.drug_kind
          this.days = 0
          this.qty = 0
          this.instruction = ''
          this.id = Number(available_drug.id)
          this.amount = Number(available_drug.selling_price)
        
        //clear search 
        this.searchItems = []
        this.showAssignArea = true;
        this.showSearchBtn = false

        // available_drug = JSON.parse(JSON.stringify(available_drug))
        console.log('True scope drug ->', available_drug)
        this.searchInput = available_drug.name.toUpperCase()
    
        // this.drug = _drug
        // console.log('drug available', this.drug)
        
     },
     clearSearch(){
          this.searchInput = ''
          this.unit = ''
          this.dosage = ''
          this.frequency = ''
          this.route = ''
          this.days = ''
          this.qty = ''
          this.instruction = ''
          this.id = ''
          this.amount = ''
          this.showAssignArea = false;
     },
     assignDrug(){

              let _unit = this.unit
              let _dosage = this.dosage  
              let _frequecy = this.frequency
              let _route = this.route
              let _days = this.days 
              let _qty = this.qty
              let _instruction = this.instruction
              let _id = this.id
              let _amount = this.amount

        if(Number(this.unit) < Number(this.qty) || Number(this.qty) < 0 ){

                this.success = false,
                this.message = Number(this.qty) < 0 ? 'Qty could never be negative!' : 'Qty is greater than unit!'
                this.clearMessage()
                  
                return
        }

      fetch('<?= base_url('patientFileController/ajax_assigndrug') ?>',{
            method: 'post',
            headers: {
              Accept: 'application/json',
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                unit : _unit,
                dosage: _dosage,  
                frequency: _frequecy,
                route: _route,
                days: _days,
                qty: _qty,
                instruction: _instruction,
                drug_id: _id,
                amount: _amount,
                file_id: <?= $patient_file['id'] ?>,
                doctor: <?= session()->get('id') ?>
            })
          }).then(res => res.json()).then(data => {
            if(data.success){
              this.message = data.message
              this.success = data.success

              this.clearMessage()

              //hide search drug and assign drug inputs,
              this.showSearchBtn = true
              this.showSearchInput = false
              this.searchInput =  ''
              this.showAssignArea = false
              medicineTable()
            }else{
              this.message = data.message
              this.success = data.success
              this.clearMessage()
            }
          })
     },
     clearMessage(){
             clearTimeout(this.alertTime)
              this.alertTime = setTimeout(() => {
                this.message = ''
                this.success = false
              }, 3000);
     },
     taken(medicineId){
            fetch('<?= base_url('patientFileController/takenMedicine') ?>',{
                     method: 'post',
                     headers: {
                     Accept: 'application/json',
                     'Content-Type': 'application/json',
                     'X-Requested-With': 'XMLHttpRequest'
                     },
                     body: JSON.stringify({
                        id: medicineId,
                        taken: true
                     })
                  }).then(res => res.json()).then(data => {
                     if(data.success){
                      medicineTable()
                        this.addItemToPrint(medicineId)
                     }
                  })
         },
         nottaken(medicineId){
            fetch('<?= base_url('patientFileController/takenMedicine') ?>',{
                     method: 'post',
                     headers: {
                     Accept: 'application/json',
                     'Content-Type': 'application/json',
                     'X-Requested-With': 'XMLHttpRequest'
                     },
                     body: JSON.stringify({
                        id: medicineId,
                        taken: false
                     })
                  }).then(res => res.json()).then(data => {
                     if(data.success){
                      medicineTable()
                        this.addItemToPrint(medicineId)
                     }
                  })
         },
     confirmPaymentMedicine(medicineId){
            fetch('<?= base_url('patientFileController/confirmPaymentMedicine') ?>',{
                     method: 'post',
                     headers: {
                     Accept: 'application/json',
                     'Content-Type': 'application/json',
                     'X-Requested-With': 'XMLHttpRequest'
                     },
                     body: JSON.stringify({
                        id: medicineId,
                        confirmed_by: <?= session()->get('id') ?>
                     })
                  }).then(res => res.json()).then(data => {
                     if(data.success){
                      medicineTable()
                        this.addItemToPrint(medicineId)
                     }
                  })
         },
         unconfirmPaymentMedicine(medicineId){
            fetch('<?= base_url('patientFileController/confirmPaymentMedicine') ?>',{
                     method: 'post',
                     headers: {
                     Accept: 'application/json',
                     'Content-Type': 'application/json',
                     'X-Requested-With': 'XMLHttpRequest'
                     },
                     body: JSON.stringify({
                        id: medicineId,
                        confirmed_by: 0
                     })
                  }).then(res => res.json()).then(data => {
                     if(data.success){
                      medicineTable()
                        this.removeItemToPrint(medicineId)
                     }
                  })
         },

         itermsForPrinting: [],

         //add item in print list 
         addItemToPrint(ItemId){
            if(Array.isArray(this.itermsForPrinting) && !this.itermsForPrinting.length){
               this.itermsForPrinting.push(ItemId)
            }else{
               this.itermsForPrinting.map((element, index, arr) => {
                  // console.log('each element', element);
                  // console.log('each index', index);
                  // console.log('each arr', arr);
                  if(arr[index] !== ItemId){
                     this.itermsForPrinting.push(ItemId)
                  }
               });
            }
            
            // console.log('items added to print list', this.itermsForPrinting)
         },

         //remove item in print list
         removeItemToPrint(ItemId){
            if(Array.isArray(this.itermsForPrinting)){
               this.itermsForPrinting = this.itermsForPrinting.filter(iterm => (iterm !== ItemId))
            }
         // console.log('items to print after one iterm removed', this.itermsForPrinting)
         }
    }
  }

  function medicineTable(){
      $(document).ready(function(){
        $('#table_medicine').DataTable({
          "ordering":false,
          "destroy": true,   
          "searching": false,
          "serverSide": true,
          "ajax": {
            url: "<?= base_url('patientFileController/ajax_assignedmedicine') ?>",
            type: "POST",
            data: {
              file_id: <?= $patient_file['id'] ?>,
              start_date: '<?= $patient_file['start_treatment'] ?>',
              end_date: '<?= $patient_file['end_treatment'] ?>'
            }
          },
          footerCallback(){
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
               // console.log('before: i is -> ', i);
               let n = typeof i === 'string' ? i.replace(/[,\/=]/g, '') * 1 : typeof i === 'number' ? i : 0;
               // console.log('after: i is -> ', n);
               return n;
            };

            // Total over all pages
            total = api
               .column(9)
               .data()
               .reduce(function (a, b) {
                     return intVal(a) + intVal(b);
               }, 0);

            // Total over this page
            pageTotal = api
               .column(9, { page: 'current' })
               .data()
               .reduce(function (a, b) {
                     return intVal(a) + intVal(b);
               }, 0);

            // Update footer
            $(api.column(9).footer()).html('Tsh' + total.toLocaleString('en-IN') + '/=  ');
          }
        });
      });
   }
  //initial call
 medicineTable()

 function deleteMedicine(medicine_id){
  fetch('<?= base_url('patientFileController/ajax_deleteMedicine') ?>',{
            method: 'post',
            headers: {
              Accept: 'application/json',
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
               medicine_id: medicine_id
            })
          }).then(res => res.json()).then(data => {
             if(data.success){
               medicineTable()
             }
          })
 }

</script>
<?= $this->endSection() ?>