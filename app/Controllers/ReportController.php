<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SalesModel;
use App\Models\ExpensesModel;
use App\Models\ItemModel;
use App\Models\UserModel;
use App\Models\ConsultationModel;
use App\Models\AssignedProceduresModel;
use App\Models\AssignedMedicineModel;
use App\Models\AssignedLabtestModel;
use App\Controllers\StoreController;

class ReportController extends BaseController
{
    public function index()
    {
        helper('form');
        $userModel = new UserModel;
        $data = [];

        $data['doctors'] = $userModel->getDoctors();
        $data['salesBy'] = $userModel->getUserByRole('cashier');

        return view('report/generate', $data);
    }

    public function generate_report(){
        if($this->request->getMethod() == 'post'){
             $data = [
                 'start_date' => $this->request->getVar('start_date'),
                 'end_date' => $this->request->getVar('end_date'),
                 'report_type' => $this->request->getVar('report_type')
             ];

             switch ($data['report_type']) {
                case 'sales':
                    $this->request->getVar('cashier_id');
                    $rules = [
                        'cashier_id' => 'required'
                    ];
        
                    if(!$this->validate($rules)){
                        $data['validation'] = $this->validator;
                        return redirect()->to('report');
                    }

                    $this->sales_report($start_date = $data['start_date'], $end_date = $data['end_date']);
                    break;

                case 'sales-drug':
                    $this->request->getVar('cashier_id');
                    // $rules = [
                    //     'cashier_id' => 'required'
                    // ];
        
                    // if(!$this->validate($rules)){
                    //     $data['validation'] = $this->validator;
                    //     return redirect()->to('report');
                    // }

                    $this->sales_drug($start_date = $data['start_date'], $end_date = $data['end_date']);
                    break;

                case 'expenses':
                    $this->expenses_report($start_date = $data['start_date'], $end_date = $data['end_date']);
                    break;

                case 'items_in_stock':
                    $this->items_in_stock($start_date = $data['start_date'], $end_date = $data['end_date']);
                    break;

                case 'items_out_stock':
                    $this->items_out_stock($start_date = $data['start_date'], $end_date = $data['end_date']);  
                    break;

                case 'items_expected_to_expire':
                    $this->items_out_stock($start_date = $data['start_date'], $end_date = $data['end_date']);  
                    break;

                case 'items_expected_to_expire':
                    $this->items_expected_to_expire($start_date = $data['start_date'], $end_date = $data['end_date']);
                    break;

                case 'consultation':
                    $this->consultation($start_date = $data['start_date'], $end_date = $data['end_date']);
                    break;

                case 'labtest':
                    return $this->labtestReport($start_date = $data['start_date'], $end_date = $data['end_date']);
                    break;

                case 'procedure':
                    $this->procedure($start_date = $data['start_date'], $end_date = $data['end_date']);
                    break;

                case 'medicine':
                    $this->medicine($start_date = $data['start_date'], $end_date = $data['end_date']);
                    break;
                
                default:
                    # code...
                    break;
             }
        }
    }

    public function labtestReport($start_date, $end_date){
        $data['labtest'] = '';
        $assignedLabtestModel = new AssignedLabtestModel;
        $data['labtest'] = $assignedLabtestModel->getLabtestVerified($start_date, $end_date);
        // echo  '<pre>';
        // print_r($data['labtest']);
        // echo  '</pre>';
        $store = new StoreController;
        $data['clinic_contacts'] = $store->get_clinic_info();

        // return view('report/labtest', $data);

        $data['pageTitle'] = 'Lab test';


        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('report/labtest', $data));
        $dompdf->setPaper('A4', 'portait');
        // $customPaper = array(0,0,302.36220472, 1122.519685);
        // $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream("'labtest_report'.pdf", array("Attachment"=>0)); 
    }

    public function medicine($start_date, $end_date ){
        $doctor = !empty($this->request->getVar('doctor_id')) ? $this->request->getVar('doctor_id') : '' ;
        $data = [];
        $assignedMedicineModel = new AssignedMedicineModel;
        $userModel = new UserModel;
        $data['medicines'] = $assignedMedicineModel->medicineByDoctor($doctor, $start_date, $end_date);

        if(!empty($doctor)){
            $data['doctor'] = $userModel->where('id', $doctor)->first();
        }

        // echo '------ print doctor ------';
        // print_r($doctor); 
        // echo '<br> -- doctor --- <br/> ';
        // print_r($data['doctor']);
        // echo '<br> -- medicine --- <br/> ';
        // print_r($data['medicines']);
        // echo '<br/>';

        $store = new StoreController;
        $data['clinic_contacts'] = $store->get_clinic_info();

        
        // return view('report/medicine', $data);
        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('report/medicine', $data));
        $dompdf->setPaper('A4', 'portait');
        // $customPaper = array(0,0,302.36220472, 1122.519685);
        // $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream("'medicine_report'.pdf", array("Attachment"=>0)); 
    }

    public function procedure($start_date, $end_date){
        $doctor = $this->request->getVar('doctor_id');
        $assignedProcedureModel = new AssignedProceduresModel;
        $userModel = new UserModel;

        $procedures = $assignedProcedureModel->proceduresByDoctor($doctor, $start_date, $end_date);

        $data['procedures'] = $procedures;
        $data['doctor'] = $userModel->where('id', $this->request->getVar('doctor_id'))->first();

        $store = new StoreController;
        $data['clinic_contacts'] = $store->get_clinic_info();

        // return view('report/procedures', $data);
        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('report/procedures', $data));
        $dompdf->setPaper('A4', 'portait');
        // $customPaper = array(0,0,302.36220472, 1122.519685);
        // $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream("'procedures_report'.pdf", array("Attachment"=>0)); 
    }

    public function consultation($start_date, $end_date){
         $consultationModel = new ConsultationModel;
         $userModel = new UserModel;
         $data = [];
         $consultations = $consultationModel->consultationByDoctor($this->request->getVar('doctor_id'), $start_date, $end_date);
         $store = new StoreController;

         $data['clinic_contacts'] = $store->get_clinic_info();
         $data['consultations'] = $consultations;
         $data['doctor'] = $userModel->where('id', $this->request->getVar('doctor_id'))->first();

        //  echo '<pre>';
        //   print_r($data['consultations']);
        //  echo '</pre>';

        //  return view('report/consultation', $data);
        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('report/consultation', $data));
        $dompdf->setPaper('A4', 'portait');
        // $customPaper = array(0,0,302.36220472, 1122.519685);
        // $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream("'consultation_report'.pdf", array("Attachment"=>0)); 

    }

    public function items_expected_to_expire($start_date, $end_date){
        $itemModel = new ItemModel;
        //->where('qty !=', 0)
        $items = $itemModel->where('DATE(exp_date) >=', $start_date)->where('DATE(exp_date) <=', $end_date)->where('qty !=', 0)->findAll();
        // print_r($items);
        // exit;
        $store = new StoreController;

        $data['clinic_contacts'] = $store->get_clinic_info();
  
        $data['items'] = $items;
        // view('report/items_expected_to_expire', $data);
 
        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('report/items_expected_to_expire', $data));
        $dompdf->setPaper('A4', 'portait');
        // $customPaper = array(0,0,302.36220472, 1122.519685);
        // $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream("items_expected_to_expire.pdf", array("Attachment"=>0));   
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
        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'cashier_name' => '',
            'total_consultation' => 0,
            'total_procedure' => 0,
            'total_medicine' => 0,
            'total_labtest' => 0
        ];

        $salesModel = new SalesModel;
        $userModel = new UserModel;
        $consultationModel = new ConsultationModel;
        $assignedProcedureModel = new AssignedProceduresModel;
        $assignedMedicineModel = new AssignedMedicineModel;
        $assignedLabtestModel = new AssignedLabtestModel;


        $cashier_id = $this->request->getVar('cashier_id');
        // $sales_data = $salesModel->salesData($start_date, $end_date);

        //calculate consultation 
        $consultation_data = $consultationModel->where('payment_confirmed_by', $cashier_id)->where('DATE(updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"')->findAll();
        foreach ($consultation_data as $key => $cons) {
            $data['total_consultation'] += $cons['amount'];
        }

        //calculate procedures
        $procedures_data = $assignedProcedureModel->where('confirmed_by', $cashier_id)->where('DATE(updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"')->findAll();
        foreach ($procedures_data as $key => $proc) {
            $data['total_procedure'] += $proc['amount'];
        }

        //calculate medicine
        // $medicine_data = $assignedMedicineModel->where('confirmed_by', $cashier_id)->where('DATE(updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"')->findAll();
        $medicine_data = $assignedMedicineModel->getPaidAssignedMedicine($cashier_id, $start_date, $end_date);
        foreach ($medicine_data as $key => $med) {
            $data['total_medicine'] += ($med->selling_price*$med->qty);
        }

        //calculate assigned labtest
        $lab_data = $assignedLabtestModel->where('confirmed_by', $cashier_id)->where('DATE(updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"')->findAll();
        foreach ($lab_data as $key => $lab) {
            $data['total_labtest'] += $lab['price'];
        }

        //cashier full name,
        $cashier = $userModel->where('id', $cashier_id)->first();
        $data['cashier_name'] = $cashier['first_name'] .' '. $cashier['last_name'];
        
        // echo ' sales: <pre> ';
        // print_r($lab_data);
        // echo '<pre> ';
        // print_r($data);
        // echo '</pre>';
        // exit;

        $store = new StoreController;

        $data['clinic_contacts'] = $store->get_clinic_info();
        // $data['cashier'] = $userModel->where('id', $cashier_id)->first();
  
        // $data['sales'] = $sales_data;
        // return view('report/sales_risit', $data);

        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('report/sales_risit', $data));
        $dompdf->setPaper('A4', 'portait');
        // $customPaper = array(0,0,302.36220472, 1122.519685);
        // $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream("sales.pdf", array("Attachment"=>0));
 
    }

    public function sales_drug($start_date, $end_date){
        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'cashier_name' => '',
            'sales' => []
        ];

        $salesModel = new SalesModel;
        $userModel = new UserModel;
        // $consultationModel = new ConsultationModel;
        // $assignedProcedureModel = new AssignedProceduresModel;
        // $assignedMedicineModel = new AssignedMedicineModel;
        // $assignedLabtestModel = new AssignedLabtestModel;


        $cashier_id = $this->request->getVar('cashier_id');
        $data['sales'] = $salesModel->salesData($start_date, $end_date, $cashier_id);

    
        //cashier full name,
        if($cashier_id){
            $cashier = $userModel->where('id', $cashier_id)->first();
            $data['cashier_name'] = $cashier['first_name'] .' '. $cashier['last_name'];
        }

        
        // echo 'Sales: <pre> </pre> ';
        
        // echo '<pre> ';
        // print_r($data);
        // echo '</pre>';
        // exit;

        $store = new StoreController;

        $data['clinic_contacts'] = $store->get_clinic_info();
        // $data['cashier'] = $userModel->where('id', $cashier_id)->first();
  
      
        // return view('report/sales_drug', $data);

        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('report/sales_drug', $data));
        $dompdf->setPaper('A4', 'portait');
        // $customPaper = array(0,0,302.36220472, 1122.519685);
        // $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream("sales_drug.pdf", array("Attachment"=>0));
 
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
