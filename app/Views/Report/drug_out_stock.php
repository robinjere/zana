
<style>
    
    table, tr, td{
      border: 1px solid #D3D3D3;
    }

    table{
      border-collapse: collapse;
    }
    
    .risitBody{
      display: flex;
      justify-content:center;
      align-items:center;
    }
    .risit{
      /* display: flex; justify-content:center; align-items:center; flex-flow:column; */
      /* max-width: 45rem; */
      /* border: .5px solid #7a7979;;
      border-right: 25px solid #e78f8f; */
    }

    .risit__body{
      /* margin-right: 20px;
      margin-left: 20px; */
    }
    .uppercase{ text-transform: uppercase; }
    .risit__title{
        font-weight: 700; font-size: .8rem; padding: 0;  margin: 0;
    }
    th{ font-size: .8rem; }
    .risit__subtitle{
        font-weight: 500; font-size: .8rem;
        margin: 8px 0;
    }
    td{font-size: .8rem;}

    .separater{
      border-bottom: 2px solid #7a7979;
    }
    .ptable{ width: 100%; }
    .ptable thead th, .ptable tbody tr { padding: 10px; text-align: center; }
    .total{
      width: 100%;
      /* padding-left: 3rem;
      padding-top: 1rem; */
    }
    .risit-print{
     width:100%;
     display: flex;
     justify-content:end;
     align-items:center;
     /* padding: 2rem; */
    }    

</style>

<div class="risitBody">

<div class="risit"> 
    
<!-- <div class="risit-print">
  <a href="#" onclick="javascript:window.print();" title="Print Ticket"><span class="glyphicon glyphicon-print"></span></a>
</div>/risit-print -->

<div class="risit__body">

<h1 class="risit__title uppercase" align="center"> <?= $clinic_contacts['name'] ?> </h1>
<p class="risit__subtitle uppercase" align="center"> <?= $clinic_contacts['address'] . ', '. $clinic_contacts['location']  ?> </p>
<p class="risit__subtitle uppercase" align="center"> <?= $clinic_contacts['phone'] ?> </p>

<div class="separater"></div>
 <p class="risit__subtitle uppercase" align="center"> Drugs out of  Stock </p>
 <p> Report generated at: <?= date("Y-m-d") ?> </p>
<div class="separater"></div>

<div>
  <table border-styles="dashed" class="table table-striped table-bordered table-hover" table-striped table-bordered width="100%" cellspacing="5" cellpadding="5" style="margin-top:15px;">
          <tr>
            <th>NO</th>
            <th>Date</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Buying Price </th>
            <th>Selling Price </th>
            <th>Expected Profit</th>
          </tr>
        <?php
          $total = 0;
          $total_profit = 0;
          if(!empty($items)) {
            foreach ($items as $key => $item) { 
             $total += $item['selling_price'];
             $total_profit += ($item['selling_price'] - $item['buying_price']);
             ?>
              <tr>
                  <td><?= ++$key ?></td>
                  <td><?= $item['updated_at'] ?></td>
                  <td><?= $item['name'] ?> </td>
                  <td><?= $item['qty'] ?> </td>
                  <td><?= $item['buying_price'] ?> </td>
                  <td><?= $item['selling_price'] ?> </td>
                  <td><?= ($item['selling_price'] - $item['buying_price']) ?> </td>
              </tr>
          <?php }
         }  
        ?>

        <tr>
          <td colspan="3"></td>
          <td>
              <p align="right"> <b class="risit__title">Total Price: </b>  </p>
          </td>
           <td>
              <p><b> <?= $total ?>/= </b> </p>
           </td>
          <td>
              <p align="right"> <b class="risit__title">Total Profit: </b>  </p>
          </td>
           <td>
              <p><b> <?= $total_profit ?>/= </b> </p>
           </td>
        </tr>
    
  </table>
</div>

<!-- <div class="total">
  <p align="right"> <b class="risit__title">Total: <?= $total ?>/= </b>  </p>
</div> -->

<!-- <div class="separater"></div> -->

<div lign="center" class="ticket__comp" style="margin-top:10px; margin-bottom:0;">
  <p align="center" > <b class="risit__subtitle" >@<?= $clinic_contacts['techBy'] ?> - Technologies </b>  </p>
</div>
<div class="ticket__bottom " style="margin-top: 0;">
  <p align="center"> <b class="risit__subtitle">*********************** * * ****************** </b>  </p>
</div>


</div> <!-- /risit__body --> 

</div><!-- /risit -->
</div><!-- /risitBody -->

  <script>
    // $(function () {
    //   $('#panelTab a:first').tab('show')
    // })
    $(document).ready(function(){
        function currentDate(){
            let d = new Date();
            d_full = d.getDate() + '-' + d.getMonth() + '-' + d.getFullYear()
            $('#sale_date').html(d_full)
        }
        currentDate()
    })
  </script>
</div>

