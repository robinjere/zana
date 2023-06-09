<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use monken\TablesIgniter;
use App\Models\ItemModel;
use App\Models\SalesModel;
use App\Models\LabtestModel;
use App\Models\RadInvestigationModel;
use App\Models\ProceduresModel;
use App\Models\LabRangesModel;

class StoreController extends BaseController
{
    public function index()
    {
        // return view('dashboard/main');
        return redirect()->to('/store/items');
    }

    public function listItems(){
        return view('store/items');
    }

    public function listLabtest(){
        return view('store/labtest');
    }

    public function get_clinic_info(){
        return array(
            'name' => getenv('CLINIC_NAME'),
            'address' => getenv('CLINIC_ADDRESS'),
            'phone' => getenv('CLINIC_PHONE'),
            'location' => getenv('CLINIC_LOCATION'),
            'techBy' => getenv('APP_BY')
        );
    }

    public function ajax_getItems(){
        // $db = db_connect();
        $itemModel = new ItemModel();

        $data_table = new TablesIgniter();
        $data_table->setTable($itemModel->noticeTable())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['name'])
                   ->setOrder(['id', 'updated_at', 'name','qty', 'drug_kind', 'buying_price', 'selling_price'])
                   ->setOutput(['id', $itemModel->itemDateFormat(), 'name', 'qty','drug_kind',$itemModel->formatBuyingPrice() , $itemModel->formatSellingPrice(),
                                $itemModel->actionButtons()
                               ]);

        return $data_table->getDatatable();
    }

    public function addLabtest(){
        helper('form');
        $labtestModel = new LabtestModel;
        $labRangesModel = new LabRangesModel;

        $data = [];
        if($this->request->getMethod() == 'post'){
            $labtestDetails = $this->request->getVar();
            // print_r($labtestDetails);
            // exit;
            // foreach ($labtestDetails['range'] as $key => $value) {
            //     //remove empty ranges 
            //     if($value != ''){
            //         $labtestDetails['range'] = $value;
            //     }
            // }
            $labtestDetails['added_by'] = session()->get('id');
            if($labtestModel->save([
                'name' => $labtestDetails['name'],
                'price' =>  $labtestDetails['price'],
                'description' =>  $labtestDetails['description']
            ]) == false){
                session()->setFlashdata('validation', $itemModel->errors());
            }else{
                // print($labtestModel->getInsertID() );
                // exit;
                $multipleRanges = [];
                foreach ($labtestDetails['range'] as $key => $value) {
                    if($value != ''){
                        $multipleRanges[]= [ 'range' => $value, 'labtest_id' => $labtestModel->getInsertID()];
                    }
                }
                //insert ranges ..
                if($labRangesModel->saveMultipleRange($multipleRanges)){
                    return redirect()->to('store/labtest')->with('success', 'Lab test successful added');
                }else{
                    return redirect()->to('store/labtest')->with('error', 'Failed to save lab ranges');
                }

            }
        }
        return view('store/add_labtest', $data);
    }



    public function add_edit_radInvestigation($rad_id = ''){
        helper('form');
        $radInvestigationModel = new RadInvestigationModel;
        $data = [];
        $data['radiology'] = ['test_name' => '', 'price' => ''];

        if($rad_id){
          $data['radiology'] = $radInvestigationModel->where('id', $rad_id)->first();
        }

        if($this->request->getMethod() == 'post'){
            $radDetails = $this->request->getVar();
            $radDetails['user_id'] = session()->get('id');
            if($rad_id){
                $radDetails['id'] = $rad_id;
            }
            if($radInvestigationModel->save($radDetails) == false){
                session()->setFlashdata('validation', $itemModel->errors());
            }else{
                $__mssg = $rad_id == '' ? 'radiology successful added' : 'radiology successful edited';
                return redirect()->to('store/radiology')->with('success', $__mssg);
            }
        }
        return view('store/add_rad_investigation', $data);
    }

    public function deleteRadInvestigation(Int $rad_id){
        $radInvestigationModel = new RadInvestigationModel;
        $radInvestigationModel->where('id', $rad_id)->delete();
        return redirect()->to('store/radiology')->with('success', 'radiology successful deleted');
    }

    public function listRadiology(){
        return view('store/rad_investigation');
    }

    public function ajax_getradiology(){
        $radInvestigationModel = new RadInvestigationModel();

        $data_table = new TablesIgniter();
        $data_table->setTable($radInvestigationModel->getRadiologyList())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['test_name'])
                   ->setOrder(['id', 'updated_at', 'test_name','price'])
                   ->setOutput(['id', $radInvestigationModel->radDateFormat(), 'test_name', $radInvestigationModel->formatPrice(), $radInvestigationModel->actionButtons()]);

        return $data_table->getDatatable();
    }

    public function procedures(){
        return view('store/procedures');
    }

    public function add_or_edit_procedure($procedure_id = ''){
            helper('form');
            $proceduresModel = new ProceduresModel();
            $data = [];
            $data['procedure'] = ['name' => '', 'price' => ''];
            if($procedure_id){
              $data['procedure'] =  $proceduresModel->where('id', $procedure_id)->first();   
            }
            if($this->request->getMethod() == 'post'){
                $procedureDetails = $this->request->getVar();
                $procedureDetails['user_id'] = session()->get('id');
                if($procedure_id != ''){
                    $procedureDetails['id'] = $procedure_id;
                }
                if($proceduresModel->save($procedureDetails) == false){
                    session()->setFlashdata('validation', $itemModel->errors());
                }else{
                    $_mssg = $procedure_id != '' ? 'procedure successful edited' : 'procedure successful added';
                    return redirect()->to('store/procedures')->with('success', $_mssg);
                }
            }
            return view('store/add_procedure', $data);    
    }

    public function deleteProcedure(Int $procedure_id){
        $proceduresModel = new ProceduresModel();
        $proceduresModel->where('id', $procedure_id)->delete();
        return redirect()->to('store/procedures')->with('success', 'Procedure successful deleted');
    }

    public function ajax_getprocedures(){
    
        $proceduresModel = new ProceduresModel();

        $data_table = new TablesIgniter();
        $data_table->setTable($proceduresModel->getProcedures())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['name'])
                   ->setOrder(['id', 'updated_at', 'name','price'])
                   ->setOutput(['id', $proceduresModel->procedureDateFormat(), 'name', $proceduresModel->formatPrice(), $proceduresModel->actionButtons()]);

        return $data_table->getDatatable();
    }

    public function editlabtest(Int $labtestID){
        helper('form');
        $labtestModel = new LabtestModel;
        $labRangesModel = new LabRangesModel;
        $data = [];
        $data['labtest'] = $labtestModel->where('id', $labtestID)->first();
        $data['ranges'] = $labRangesModel->where('labtest_id', $labtestID)->findAll();
        if($this->request->getMethod() == 'post'){
            $labtestDetails = $this->request->getVar();
            // print_r($labtestDetails);
            // exit;
            // $labtestDetails['added_by'] = session()->get('id');
            // $labtestDetails['id'] = 
            if($labtestModel->save([
                'id' => $labtestID,
                'name' => $labtestDetails['name'],
                'price' => $labtestDetails['price'],
                'description' => $labtestDetails['description'],
                'added_by' => session()->get('id')
            ]) == false){
                session()->setFlashdata('validation', $itemModel->errors());
            }else{
                $labRangesModel = new LabRangesModel;
                if($labRangesModel->where('labtest_id', $labtestID)->delete()){
                    $multipleRanges = [];
                    foreach ($labtestDetails['range'] as $key => $value) {
                        if($value != ''){
                            $multipleRanges[]= [ 'range' => $value, 'labtest_id' => $labtestID];
                        }
                    }
                    //insert ranges ..
                    if($labRangesModel->saveMultipleRange($multipleRanges)){
                        return redirect()->to('store/labtest')->with('success', 'Lab test successful edited');
                    }else{
                        return redirect()->to('store/labtest')->with('error', 'Failed to edit lab ranges');
                    }
                };


                // return redirect()->to('store/labtest')->with('success', 'Lab test successful edited!');
            }
        }
        return view('store/edit_labtest', $data);
    }

    public function deleteLabtest(Int $labtestID ){
        $labtestModel = new LabtestModel;
        $labRangesModel = new LabRangesModel;
        $labtestModel->where('id', $labtestID)->delete();
        $labRangesModel->where('labtest_id', $labtestID)->delete();
        return redirect()->to('store/labtest')->with('success', 'Lab test deleted!');
    }

    public function ajax_getlabtest(){
        $labtestModel = new LabtestModel;

        $data_table = new TablesIgniter();
        $data_table->setTable($labtestModel->getLabTest())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['name'])
                   ->setOrder(['id', 'updated_at', 'name','price', 'description'])
                   ->setOutput(['id', $labtestModel->formatDate(), 'name', $labtestModel->formatPrice(), 'description',
                                $labtestModel->actionButtons()
                               ]);

        return $data_table->getDatatable();
    }

    public function OutOfStock(){
        $itemModel = new ItemModel;
        $count = $itemModel->where('qty =', 0)->countAll();
        $data['count_out_stock'] = $count;
        return view('store/outofstock', $data);
    }

    public function ItemsNearToEnd(){
        $itemModel = new ItemModel;
        $count = $itemModel->where(['qty >' => 0, 'qty <' => 10 ])->countAll();
        $data['itemsNearToEnd'] = $count;
        return view('store/itemsNearToEnd', $data);
    }
    
    public function ajax_outofstock(){
        // $db = db_connect();
        $itemModel = new ItemModel();

        $data_table = new TablesIgniter();
        $data_table->setTable($itemModel->outOfStockTable())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['name'])
                   ->setOrder(['id', 'updated_at', 'name','qty', 'buying_price', 'selling_price'])
                   ->setOutput(['id', $itemModel->itemDateFormat(), 'name', 'qty',$itemModel->formatBuyingPrice() , $itemModel->formatSellingPrice(),
                                $itemModel->actionButtons()
                               ]);

        return $data_table->getDatatable();
    }
    public function ajax_itemsneartoend(){
        // $db = db_connect();
        $itemModel = new ItemModel();

        $data_table = new TablesIgniter();
        $data_table->setTable($itemModel->itemsNeartoEndTable())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['name'])
                   ->setOrder(['id', 'updated_at', 'name','qty', 'buying_price', 'selling_price'])
                   ->setOutput(['id', $itemModel->itemDateFormat(), 'name', 'qty',$itemModel->formatBuyingPrice() , $itemModel->formatSellingPrice(),
                                $itemModel->actionButtons()
                               ]);

        return $data_table->getDatatable();
    }



    public function addItem(){
        helper('form');
        $itemModel = new ItemModel;
        $data = [];
        if($this->request->getMethod() == 'post'){
            $itemDetails = $this->request->getVar();
            $itemDetails['user_id'] = session()->get('id');
            if($itemModel->save($itemDetails) == false){
                session()->setFlashdata('validation', $itemModel->errors());
            }else{
                return redirect()->to('store/additem')->with('success', 'Item added to the store successful');
            }
        }
        return view('store/add_item', $data);
    }

    public function updateItem($item_id=null){
        helper('form');
        $itemModel = new ItemModel;
        $data = [];

        $data['item'] = $itemModel->find($item_id);

        if($this->request->getMethod() == 'post'){

            $save_item = $this->request->getVar();
    
            if($itemModel->updateItem($save_item,$item_id) == false){
                session()->setFlashdata('validation', $itemModel->errors());
            }else{
                return redirect()->to('/store/items')->with('success', 'Item updated!');
            }
        }
        return view('store/update_item', $data);
    }


    public function ajax_sales(){
        $salesModel = new SalesModel;

        $data_table = new TablesIgniter();

        $data_table->setTable($salesModel->noticeTable())
                //    ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['name'])
                   ->setOrder([ 'updated_at', 'name', 'qty', 'dose', 'amount', 'discount'])
                   ->setOutput([ $salesModel->itemDateFormat(),'name', 'qty', 'dose', 'amount', 'discount'
                                // $itemModel->updateButtonItem(),
                                // $itemModel->deleteButtonItem()
                               ]);

        return $data_table->getDatatable();
    }

    public function deleteItem($item_id=null){
        $item = new ItemModel();
        $item->where('id', $item_id)->delete();
        return redirect()->to('/store/items')->with('success', 'Item deleted!');
    }

    public function ajax_today_sales(){
        $salesModel = new SalesModel;

        $data_table = new TablesIgniter();

        // echo '<pre> ----- Available sales:: ';
        //      print_r($salesModel->TodaySales());
        // echo '</pre>';
        // exit;
        // $date = date('d-m-Y', strtotime('-1 days'));
        // $curr_date = $date;
        // echo 'yesterday date ---> '. $curr_date;
        $salesModel->TodaySales();

        $data_table->setTable($salesModel->TodaySales())
                //    ->setDefaultOrder('name', 'ASC')
                   ->setSearch(['name'])
                   ->setOrder([ 'updated_at', 'name', 'qty', 'dose', 'amount', 'discount'])
                   ->setOutput([ $salesModel->itemDateFormat(),'name', 'qty', 'dose', 'amount', 'discount'
                                // $itemModel->updateButtonItem(),
                                // $itemModel->deleteButtonItem()
                               ]);

        return $data_table->getDatatable();
    }

    public function salesItems(){
        return view('sales/sales.php');
    }
    public function searchSale(){
        helper('form');
        return view('sales/search_sale.php');
    }
    public function ajax_searchItem(){
        $item = $this->request->getVar('item');
        $itemModel = new ItemModel;
        echo json_encode($itemModel->searchItem($item));
    }
    public function ajax_getItem(){
        $salesModel = new SalesModel;
        $itemModel = new ItemModel;

        helper('form');
          $item_obj = '';
        if($this->request->getMethod() == 'post'){
           $item_obj = $itemModel->find($this->request->getVar('item_id'));
        }

        echo json_encode($item_obj);

    }

    public function ajax_add_sale(){
        $salesModel = new SalesModel;
        $itemModel = new ItemModel;

        if($this->request->getMethod() == 'post'){

            $item_obj = $itemModel->find($this->request->getVar('item_id'));
            if( !($this->request->getVar('quantity') > $item_obj['qty']) ){

                //reduce qty for an item
                $itemModel->save(['id' => $this->request->getVar('item_id'), 'qty' =>  ($item_obj['qty'] - $this->request->getVar('quantity')) ]);
                $data  = [
                    'item_id' => $this->request->getVar('item_id'),
                    'qty' => $this->request->getVar('quantity'),
                    'dose' => $this->request->getVar('dose'),
                    'amount' => $this->request->getVar('price'),
                    'discount' => $this->request->getVar('discount'),
                    'description' => $this->request->getVar('description'),
                    'user_id' => session()->get('id')
                ];

                if($data['qty'] == 0){
                    echo json_encode(['error' => 'You can\'t sale this item, it is out of stock']);
                    return;
                }

               if($salesModel->save($data)){
                   $sale = $salesModel->find($salesModel->getInsertID());
                   echo json_encode(['success'=>'A drug sold', 'sale' => $sale]);
                   return;
               };

            }else{
                echo json_encode(['error' => 'You can\'t sale this item, it is out of stock']);
                return;
            }
        }
        
        // $data['item'] = $itemModel->find($item_id);
        // return view('sales/add_sale', $data);
    }

    //---------- TODO REMOVE ITEM ---------------------------.
    public function removesale(){
        $salesModel = new SalesModel;
        $itemModel = new ItemModel;
        if($this->request->getMethod() == 'post'){
          $sale_id = $this->request->getVar('sale_id');
          $sale = $salesModel->find($sale_id);
          $itemData = $itemModel->find($sale['item_id']);
          $updatedSale = [ 'id' => $sale['item_id'] , 'qty' => ($itemData['qty'] + $sale['qty']) ];

          /**
           * If update success then delete
           * and if deleted success then send success message otherwise failure message.
           */
          if($itemModel->save($updatedSale)){
              $salesModel->where('id', $sale_id)->delete();
              echo json_encode(['success'=>'A drug removed from sales']);
              return;
          } else{
              echo json_encode(['error' => 'The drug can\'t be removed']);
              return;
          }

        }
    }
    //---------- TODO REMOVE ITEM ---------------------------.

    public function addSale($item_id){
        $salesModel = new SalesModel;
        $itemModel = new ItemModel;

        helper('form');

        if($this->request->getMethod() == 'post'){

            $item_obj = $itemModel->find($this->request->getVar('item_id'));
            if( !($this->request->getVar('quantity') > $item_obj['qty']) ){

                //reduce qty for an item
                $itemModel->save(['id' => $this->request->getVar('item_id'), 'qty' =>  ($item_obj['qty'] - $this->request->getVar('quantity')) ]);

                $data  = [
                    'item_id' => $this->request->getVar('item_id'),
                    'qty' => $this->request->getVar('quantity'),
                    'dose' => $this->request->getVar('dose'),
                    'amount' => $this->request->getVar('price'),
                    'discount' => $this->request->getVar('discount'),
                    'description' => $this->request->getVar('description')
                 ];

                if($data['qty'] == 0){
                    $direct = "/sales/addSale/". $data['item_id'];
                    return redirect()->to($direct)->with('error', 'You can\'t sale this, it is out of stock');
                }

               if($salesModel->save($data)){
                   return redirect()->to('/sales/searchsale')->with('success', 'A drug sold');
               };

            }
            
        }
        
        $data['item'] = $itemModel->find($item_id);
        return view('sales/add_sale', $data);
    }

    public function addSaleFromAssignedMedicine($drug_id, $qty, $confirmedby){
        $salesModel = new SalesModel;
        $itemModel = new ItemModel;
    }
}
