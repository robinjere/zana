<?= $this->extend('dashboard/main'); ?>
<?= $this->section('data') ?>

<style>
  .list-group-item:hover {
    z-index: 2;
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
   }
</style>

<?php $Dashboard = '\App\Libraries\DashboardPanel';  ?>

<h2 class="data-heading mb-3">Sales</h2>
 
 <!-- WARNING AND ERROR AREA -->
 <?php if(!empty(session()->getFlashdata('error'))): ?>
  
  <div class="my-3 pt-3 box-alert warning-alert d-flex align-items-start" >
    <div class="icon-alert px-3"> 
        <svg viewBox="0 0 51 50" fill="none">
            <path d="M7.77416 42.8087C5.342 40.5119 3.40202 37.7644 2.06742 34.7266C0.732827 31.6888 0.0303434 28.4215 0.000961476 25.1155C-0.0284205 21.8094 0.615887 18.5307 1.89629 15.4707C3.17669 12.4107 5.06755 9.63062 7.45853 7.29278C9.8495 4.95493 12.6927 3.1061 15.8223 1.85415C18.9518 0.602201 22.305 -0.0277889 25.6863 0.000940109C29.0675 0.0296691 32.409 0.716541 35.5159 2.02148C38.6227 3.32641 41.4326 5.22328 43.7817 7.6014C48.4203 12.2974 50.9871 18.587 50.929 25.1155C50.871 31.6439 48.1929 37.8889 43.4715 42.5054C38.7501 47.1219 32.3631 49.7405 25.6863 49.7973C19.0094 49.854 12.5769 47.3443 7.77416 42.8087ZM40.1911 39.298C44.0137 35.5603 46.1612 30.4909 46.1612 25.2051C46.1612 19.9192 44.0137 14.8498 40.1911 11.1122C36.3685 7.37451 31.1839 5.27471 25.7779 5.27471C20.3719 5.27471 15.1873 7.37451 11.3647 11.1122C7.54211 14.8498 5.39459 19.9192 5.39459 25.2051C5.39459 30.4909 7.54211 35.5603 11.3647 39.298C15.1873 43.0356 20.3719 45.1354 25.7779 45.1354C31.1839 45.1354 36.3685 43.0356 40.1911 39.298ZM23.2314 27.695V22.7152H28.3244V37.6546H23.2314V27.695ZM23.2314 12.7555H28.3244V17.7353H23.2314V12.7555Z" fill="#FB5A77"/>
        </svg>
    </div>
    <div class="message-alert"> 
        <h2 class="mb-2"> Errors occurs. </h2>
        <p> <?= session()->getFlashdata('error'); ?> </p>
    </div>
  </div><!-- box-alert -->

<?php endif; ?>
<!-- WARNING AND ERROR AREA -->

<?php
  if(session()->get('success')){?>
      <div class="alert alert-success"> <?= session()->get('success'); ?> </div>
<?php } ?>

<div class="data-layout my-2 p-3 bg-white">

  <ul class="data-nav d-flex">
     <li class="py-2 me-3 "> <a href="items">Sales </a>  </li>
     <li class="py-2 me-3 data-nav__active"> <a href="searchsale">Sale a Drug </a>  </li>
  </ul>
  

<div class="mb-3 registration-form" >
 
  <div class="registration-form__heading">
     <h2 > Search a drug from store </h2>
  </div > <!-- /registration-form__heading -->
   <div class="registration-form__form" style="padding: 25px 0;">
         <form action=""> 
            <div class="registration-space-y">
               <input type="search" id="searchInput"  required name="search_item" value="<?= set_value('name') ?>" class="form-control" placeholder="Search Drug" aria-describedby="Search Drug">
               <div id="searchedItem" class="list-group mt-1">
                    <!-- <a href="#" class="list-group-item list-group-item-action">Active item</a>
                    <a href="#" class="list-group-item list-group-item-action">Item</a>
                    <a href="#" class="list-group-item list-group-item-action">Disabled item</a> -->
               </div>
            </div>
       </form><!-- /form -->

   </divd> <!-- /registration-form__form -->

   <div id="itemBlock"> <!-- item -->

        <div style="padding: 10px;">
           <b id="prod_desc"> </b>
        </div>
        <div class="registration-form__heading" style="">
          <h2  class="mb-4"> Add Drug Dose, price and Instruction to this sale. </h2>
          <!-- <a href="<?= base_url('/sales/searchsale')?>" class="badge bg-primary">Back</a> -->
        </div > <!-- /registration-form__heading -->

        <div class="registration-form__form" style="padding: 25px 0;">
         <form method="post" action="<?= base_url('/sales/addsale') ?>" id="formAddSale"> 
              <table class="table">
                  <input type="hidden" name="item_id" id="item_id" >
                  <tbody>
                      <tr>
                          <td scope="row">
                              <div class="mb-3">
                                <label for="qty" class="form-label"> Qty </label>
                                <input type="number"
                                  class="form-control" name="quantity" id="qty" value="" aria-describedby="helpId" placeholder="Quantity">
                              </div>
                          </td>
                          <td>
                             <div class="mb-3">
                                <label for="dose" class="form-label"> Dose </label>
                                <input type="text"
                                  class="form-control" name="dose" id="dose" value="" aria-describedby="helpId" placeholder="Dose">
                              </div>
                          </td>
                          <td>
                            <div class="mb-3">
                                <label for="price" class="form-label"> Price </label>
                                <input type="number" min="0" step="0.01"
                                  class="form-control" disabled name="price" id="price" value="" aria-describedby="helpId" placeholder="Price">
                                  <input type="hidden" name="price" id="hidden_price">

                              </div>
                          </td>
                          <td>
                            <div class="mb-3">
                                <label for="price" class="form-label"> Discount </label>
                                <input type="number" min="0" step="0.01"
                                  class="form-control" name="discount" id="discount" value="" aria-describedby="helpId" placeholder="Discount">
                              </div>
                          </td>
                      </tr>
                      <tr>
                          <td colspan="3" >
                              <div class="mb-3">
                                <label for="price" class="form-label"> Description </label>
                                <input type="text"
                                  class="form-control" name="description" id="description" value="" aria-describedby="helpId" placeholder="Description">
                              </div>
                          </td>
                          <td style="text-align:center;">
                              <button type="submit" class="btn btn-primary" style="margin-top: 30px;"> Save </button>
                          </td> 
                          <!-- <td scope="row"></td>
                          <td></td>
                          <td></td> -->
                      </tr>
                  </tbody>
              </table>
       </form><!-- /form -->
     </divd> <!-- /registration-form__form -->
    </div> <!-- /itemBlock --> 
   </div><!-- /item -->

   <div class="p-5 bg-light mb-2">
       <h1 class="display-3">Sales</h1>
       <hr class="my-2">
   </div>
  <!-- current sales will be displayed here -->

  <form action="<?= base_url('report/risit') ?>" method="post">
    <div class="d-flex mb-4 justify-content-end">
      <button type="submit" class="btn btn-info text-white" id="generate_risit">Generate Risit</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th></th>
          <th>Item name</th>
          <th>Quantity</th>
          <th>Dose</th>
          <th>Price</th>
          <th>Discount</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="sales_table">
        <!-- <tr>
          <td><input type="hidden" name="sales_id[]"></td>
          <td scope="row"></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td scope="row"></td>
          <td></td>
          <td></td>
        </tr> -->
      </tbody>
    </table>
  </form>

  
</div><!-- /registration-layout --->
 
</div> <!-- /data-layout -->
  

<?= $this->endSection() ?>

<?= $this->section('script') ?>
  <script>
    $(document).ready(function(){

      //=== form generate risit
        // $('#FormGenerateRisit').on('submit', function(e){
        //     e.preventDefault()
        //    let submit_url = $(this).attr('action')
        //    let current_table = $(this).find('#sales_table')
        //    let row_list = current_table.find('tr')
        //    for (const row of row_list){
        //       //  let row_input = row.find('input[name="sales_id[]"]').val()
        //        console.log('input value in row : ', row);
        //    }
        //    console.log('list of rows:', row_list)
        // })
      //=== endForm generate risit

       var searchInput = $('input[type="search"]');
       var searchedItems = $('#searchedItem');

       searchInput.on('keyup', function(e){
        //    e.preventDefault();
           var typedInSearch = $(this).val();

           $.post("<?= base_url('storecontroller/ajax_searchItem') ?>", { item: typedInSearch }, function(data){
            
             data = JSON.parse(data);
             let markup = '';
             for(const Dataitem of data){
              //  console.log('expect single object data:', Dataitem);
                markup += '<a  href="'+Dataitem.id+'" class="single-item list-group-item list-group-item-action">'+Dataitem.name+'</a>'
             }
             if(typedInSearch === ''){
              searchedItems.html('')
             }else{
              searchedItems.html(markup)
              addEventOn()
             }
           })
       })

       $(document).ready(function(){
        $('#recent_sales').DataTable({
          "order": [],
          "serverSide": true,
          "ajax": {
            url: "<?= base_url('storecontroller/ajax_today_sales') ?>",
            type: "POST"
          }
        });
      });

      /**
      *Item box
       */
       let itemBlock = $('#itemBlock')
       itemBlock.hide();
       let formAddSale = $('#formAddSale')

       function addEventOn(){
          let singleItem = $('.single-item')
          singleItem.on('click', function(e){
            e.preventDefault()

            let item_id_in_href = $(this).attr('href');
            $.post("<?= base_url('storecontroller/ajax_getItem')  ?>", { item_id: item_id_in_href }, function(data){
                  data = JSON.parse(data)
                  // console.log('item Data:', data)
                  fillItemOnForm(data)
                  //add item to search input
                 let search =  $('#searchInput')
                //  console.log('search input', search)
                 search.val(data.name)
                 set_item_name(search.val())

            })

            //clear the searched list
            $('#searchedItem').html('');

          })
       }
        
      let item_name = ''
       function set_item_name(name=''){
         if(name === ''){
            return item_name;
         }else{
           return item_name = name;
         }
       }

       /**
       fill searchable item on form
        */
        function fillItemOnForm(data){
          itemBlock.show();
          qty = itemBlock.find('#qty')
          dose = itemBlock.find('#dose')
          price = itemBlock.find('#price')
          discount = itemBlock.find('#discount')
          description = itemBlock.find('#description')

          //------- clear values first
          qty.val('')
          dose.val('')
          price.val('')
          discount.val('')
          description.val('')
          //----------

          //--- clear events
          qty.off()
          dose.off()
          price.off()
          discount.off()
          description.off()


          itm_id = itemBlock.find('#item_id')
          itm_id.val(data.id)
          //set values
          // qty.val(data.qty)
          //  console.log('data  to fill on form : ', data);
          //identify product in stock.
          $('#prod_desc').html(` ${data.name} are ${data.qty} qty in stock.`)

          // price.val(data.selling_price)
          calculations(data.selling_price, data.qty)
          
        }

      

        /**
        ------------- Calculation on form ------------------------------
        ----------------------------------------------------------------
         **/
        // let expected_selling_price = Number(selling_price)*Number(quantity);

        // let discount = 0;
        // let quantityDom = $('#qty'), priceDom = $('#price'), discountDom = $('#discount');

        // //calculate price according to change of quantity and considered discount amount 
        // quantityDom.on('change', function(){
        //   if(Number($(this).val()) < 1 || Number($(this).val()) > quantity ){
        //     console.log('compare quantity entered:', typeof $(this).val())
        //     console.log('compare the quantity:', typeof quantity)
        //     window.alert('No such amount of quantity you are trying to enter!')
        //   }else{
        //     setPrice( (selling_price * Number($(this).val())) - Number(discountDom.val())) 
        //   }
        // })

        //   //calculate price according to change of discount and considered quantity of items 
        // discountDom.on('change', function(){
        //   if(Number($(this).val()) == selling_price || Number($(this).val()) >=  selling_price){
        //     window.alert('No such of discount allowed!')
        //   }else{
        //     setPrice( (selling_price * Number(quantityDom.val())) - Number($(this).val())) 
        //   }
        // })

        // setPrice( (Number(priceDom.val()) * Number(quantityDom.val())) - Number(discountDom.val())) 

        // function setPrice(Amount){
        //   priceDom.val(Amount) 
        //   $('#hidden_price').val(Amount)
        // }

        /**
        -------------  END OF CALCULATION FORM  ------------------------------
        ----------------------------------------------------------------------
         **/


        function calculations(
          selling_price,
          quantity,
        ){

            let expected_selling_price = Number(selling_price)*Number(quantity);

            let discount = 0;
            let quantityDom = $('#qty'), priceDom = $('#price'), discountDom = $('#discount');
            
            //calculate price according to change of quantity and considered discount amount 
            quantityDom.on('change', function(){
              if(Number($(this).val()) < 1 || Number($(this).val()) > quantity ){
                // console.log('compare quantity entered:', typeof $(this).val())
                // console.log('compare the quantity:', typeof quantity)
                window.alert('No such amount of quantity you are trying to enter!')
              }else{
                setPrice( (selling_price * Number($(this).val())) - Number(discountDom.val())) 
              }
            })

              //calculate price according to change of discount and considered quantity of items 
            discountDom.on('change', function(){
              //calculate price
                let selling_p = Number(quantityDom.val()) * Number(selling_price)
              if(Number($(this).val()) >= selling_p){
                console.log('entered discount', )
                window.alert('No such discount allowed!')
              }else{
                setPrice( (selling_price * Number(quantityDom.val())) - Number($(this).val())) 
              }
            })

            setPrice( (Number(priceDom.val()) * Number(quantityDom.val())) - Number(discountDom.val())) 
       
            function setPrice(Amount){
              priceDom.val(Amount) 
              $('#hidden_price').val(Amount)
            }

        }
     
       formAddSale.on('submit', function(e){
         e.preventDefault()
        //  let formInput = $(this).serialize()
         let _formData = new FormData(e.target)
         let item = {
           item_id: _formData.get('item_id'),
           quantity:  _formData.get('quantity'),
           dose: _formData.get('dose') ,
           price: _formData.get('price'),
           discount: _formData.get('discount'),
           description: _formData.get('description')
         }

        //  console.log('form data', item)

        $.post("<?= base_url('/storecontroller/ajax_add_sale') ?>", item, function(data){
              //  console.log('befor parsed:::', data);
               data = JSON.parse(data)
              //  console.log('data to add in Table list', data)
               if(data.success){

                addSalesToTable(data.sale)
                //clear search item
                $('#searchInput').val('');
                itemBlock.hide();
               }if(data.error){
                 console.error(data.error)
                 window.alert(data.error)
               }
        }) 

      })
      
      let _sales = [];
      function addSalesToTable(item){
        
          item.name = set_item_name()
          _sales.push(item)
          let _markup = ''
          let sales_table =  $('#sales_table')
          // console.log('items', _sales)
         
          for(let _sale of _sales){
            _markup += `<tr>
                <td><input type="hidden" name="sales_id[]" value="${_sale.id}"></td>
                <td scope="row">${_sale.name}</td>
                <td>${_sale.qty}</td>
                <td>${_sale.dose}</td>
                <td>${_sale.amount}</td>
                <td>${_sale.discount}</td>
                <td> <button class="btn btn-sm btn-danger btn_remove" id="" sale="${_sale.id}">REMOVE</button> </td>
            </tr>`
          }

         sales_table.html(_markup)
         if(sales_table.children().length < 0){
             console.log('less than zero elements in table')
           $('#generate_risit').hiden()
         }else{
           console.log('Greater than zero elements in table..')
          $('#generate_risit').show()
         }
         let button_remove = sales_table.find('.btn_remove')
         button_remove.on('click', function(e){
            e.preventDefault()
            let sale = $(this).attr('sale')
            let this_button  = $(this)
            console.log('attribute button', sale)
            // console.log('Button Removed!')
            $.post("<?= base_url('sales/removesale') ?>", {sale_id:sale }, function(data){
              console.log('returned data:', data)
              data = JSON.parse(data)
              if(data.hasOwnProperty('success')){
                   this_button.parent().parent().hide()
                   //remove single sale in array.
                  _sales = _sales.filter(function(_sale){
                     return _sale.id !== sale   
                   })
              }else{
                  console.log('Error Occured!');
              }
            })
         }) 
      }
    });
  </script>
<?= $this->endSection() ?>





