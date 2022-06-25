<div id="medicine" class="medicine mt-5">
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

   <div class="d-flex justify-content-end mb-3">
     <button type="button" class="btn btn-outline-primary">Assign Drug</button>
   </div>
   <div>
     <div>
         <div class="mb-3">
           <!-- <label for="" class="form-label"></label> -->
           <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder=" Search drug">
           <!-- <small id="helpId" class="form-text text-muted">search drug </small> -->
         </div>
         <form >
           <div class="row">
           <div class="col">
               <label for="unit" class="form-label">Unit</label>
               <input type="text" id="unit" class="form-control" placeholder="unit" value="20"/>
           </div>
           <div class="col">
               <label for="dosage" class="form-label">Dosage</label>
               <input type="text" id="dosage" class="form-control" placeholder="unit" value="20"/>
           </div>
           <div class="col">
                <label for="frequency" class="form-label">Frequency</label>
                <select id="frequecy" class="form-control">
                  <option>2</option>
                  <option>4</option>
                  <option>11</option>
                </select>
           </div>
           <div class="col">
             <div class="mb-3">
               <label for="route" class="form-label">Route</label>
               <input type="text" class="form-control" name="" id="route" placeholder="Route">
             </div>
           </div>
           <div class="col">
             <div class="mb-3">
               <label for="days" class="form-label">Days</label>
               <input type="text" class="form-control" name="" id="days" placeholder="Days">
             </div>
           </div>
           <div class="col">
             <div class="mb-3">
               <label for="qty" class="form-label">Qty</label>
               <input type="number" class="form-control" name="" id="qty" placeholder="qty">
             </div>
           </div>
           </div> <!-- /row -->
           <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="instruction" class="form-label">Instruction</label>
                <textarea name="" id="instruction" class="form-control"> instrustion</textarea>
              </div>
            </div>
           </div><!-- /rpw -->
         </form>
     </div>
   </div>

</div>