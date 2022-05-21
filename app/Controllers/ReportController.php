<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SalesModel;
use App\Models\ExpensesModel;
use App\Models\ItemModel;
use App\Controllers\StoreController;

class ReportController extends BaseController
{
    public function index()
    {
        helper('form');
        return view('report/generate');
    }

    public function generate_report(){
        if($this->request->getMethod() == 'post'){
             $data = [
                 'start_date' => $this->request->getVar('start_date'),
                 'end_date' => $this->request->getVar('end_date'),
                 'report_type' => $this->request->getVar('report_type')
             ];

             if($data['report_type'] == 'sales'){
                 $this->sales_report($start_date = $data['start_date'], $end_date = $data['end_date']);
             }elseif($data['report_type'] == 'expenses'){
                 $this->expenses_report($start_date = $data['start_date'], $end_date = $data['end_date']);
             }elseif($data['report_type'] == 'items_in_stock'){
                 $this->items_in_stock($start_date = $data['start_date'], $end_date = $data['end_date']);
             }elseif($data['report_type'] == 'items_out_stock'){
                $this->items_out_stock($start_date = $data['start_date'], $end_date = $data['end_date']);  
             }
        }
    }

    public function items_out_stock($start_date, $end_date){

        $itemModel = new ItemModel;
        $items = $itemModel->where('DATE(updated_at) >=', $start_date)->where('DATE(updated_at) <=', $end_date)->where('qty', 0)->findAll();
        // print_r($items);
        // exit;
        $store = new StoreController;

        $data['clinic_contacts'] = $store->get_clinic_info();
  
        // view('report/sales_risit', $data);
        $data['items'] = $items;
 
        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('report/drug_out_stock', $data));
        $dompdf->setPaper('A4', 'portait');
        // $customPaper = array(0,0,302.36220472, 1122.519685);
        // $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream("drugs out of stock.pdf", array("Attachment"=>0));

    }
    public function items_in_stock($start_date, $end_date){
            $itemModel = new ItemModel;
            $items = $itemModel->where('DATE(updated_at) >=', $start_date)->where('DATE(updated_at) <=', $end_date)->where('qty >', 0)->findAll();
            // print_r($items);
            // exit;

            // if(empty($items)){
            //     return $this::no_data('Drugs');
            // }

            $store = new StoreController;

            $data['clinic_contacts'] = $store->get_clinic_info();
      
            // view('report/sales_risit', $data);
            $data['items'] = $items;
     
            $dompdf = new \Dompdf\Dompdf(); 
            $dompdf->loadHtml(view('report/drug_in_stock', $data));
            $dompdf->setPaper('A4', 'portait');
            // $customPaper = array(0,0,302.36220472, 1122.519685);
            // $dompdf->setPaper($customPaper);
            $dompdf->render();
            $dompdf->stream("drugs in stock.pdf", array("Attachment"=>0));
    }

    public function expenses_report($start_date, $end_date){
       $expensesModel = new ExpensesModel;
       $expenses = $expensesModel->expenseData($start_date, $end_date);

    //    if(empty($expenses)){
    //      $this::no_data('Expenses');
    //    }

       $store = new StoreController;

       $data['clinic_contacts'] = $store->get_clinic_info();
 
       // view('report/sales_risit', $data);
       $data['expenses'] = $expenses;

       $dompdf = new \Dompdf\Dompdf(); 
       $dompdf->loadHtml(view('report/expenses', $data));
       $dompdf->setPaper('A4', 'portait');
       // $customPaper = array(0,0,302.36220472, 1122.519685);
       // $dompdf->setPaper($customPaper);
       $dompdf->render();
       $dompdf->stream("expenses.pdf", array("Attachment"=>0));
    }

    public function sales_report($start_date, $end_date){
        $salesModel = new SalesModel;
        $sales_data = $salesModel->salesData($start_date, $end_date);
        
        // if(empty($sales_data)){
        //     return $this::no_data('Sales');
        // }

        $store = new StoreController;

        $data['clinic_contacts'] = $store->get_clinic_info();
  
        // view('report/sales_risit', $data);
        $data['sales'] = $sales_data;

        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('report/sales', $data));
        $dompdf->setPaper('A4', 'portait');
        // $customPaper = array(0,0,302.36220472, 1122.519685);
        // $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream("sales.pdf", array("Attachment"=>0));
 
    }

    private function no_data($report_type){
        return redirect()->to('report')->with('error', 'No '.$report_type.' data');
    }

    public function sales_risit(){
        $salesModel = new SalesModel;
        $data = [];
        if($this->request->getMethod() == 'post'){
           $sales = $this->request->getVar('sales_id');
           if(empty($sales)){
               return redirect()->to('sales/searchsale')->with('error', 'No Item Sold');
           }
           $item_sales = [];
           $if_sale_available = '';
           foreach ($sales as $sale) {
                $if_sale_available = $salesModel->find($sale);
               if(empty($if_sale_available)){
                   continue;
               }
               # code...
               $item_sales [] = $salesModel->get_sale($sale);
           }
           $data['sales'] = $item_sales;
        }

        $store = new StoreController;

        $data['clinic_contacts'] = $store->get_clinic_info();
  
        view('report/sales_risit', $data);

        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('report/sales_risit', $data));
        // $dompdf->setPaper('A4', 'portait');
        $customPaper = array(0,0,302.36220472, 1122.519685);
        $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream("drugs.pdf", array("Attachment"=>0));
    }
    
}
