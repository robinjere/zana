<?php

namespace App\Controllers;
use App\Models\AssignedLabtestModel;
use App\Models\AssignedMedicineModel;
use App\Models\AssignedProceduresModel;
use App\Models\RadResult;

use App\Controllers\BaseController;

class GenerateRisitController extends BaseController
{
    public function index()
    {
        //
    }

    public function generate(){
        //
        if($this->request->getMethod() == 'post'){
            // echo '<pre>';
            // echo 'data to featch <br/>';
            // print_r($this->request->getVar());
            // echo '</pre>';     
            // echo '<br/> --------------------- <br/> ';
            // echo 'type of print list';
            // print_r(json_decode($this->request->getVar('printList')));
            switch ($this->request->getVar('risitType')) {
                case 'labtest':
                    return $this::labtestRisit();
                    break;

                case 'radiology':
                    return $this::radiologyRisit();
                    break;

                case 'medicine':
                    return $this::medicineRisit();
                    break;

                case 'procedure':
                    return $this::procedureRisit();
                    break;
                
                default:
                    # code...
                    echo 'default is called';
                    break;
            }
        }
    }

    protected function labtestRisit(){
         $data = [
           'file_no' => $this->request->getVar('fileNo'),
           'full_name' =>  $this->request->getVar('fullName')
         ]; 
         $assignedLabtestModel = new AssignedLabtestModel;
        //  $_labtest = $assignedLabtestModel->whereIn('id', json_decode($this->request->getVar('printList')))->find();
        $_labtest = $assignedLabtestModel->paidLabtest(json_decode($this->request->getVar('printList')));

        $assignedLabtestModel->mark_printed_risit(json_decode($this->request->getVar('printList')));
        
        $data['labtest'] = $_labtest;
        //  echo '<pre>';
        //  print_r($_labtest);
        //  echo '</pre>';

        //  return View('risit/labtest');
         return view('Risit/labtest', $data);
    }

    protected function procedureRisit(){

         //TODO::
         $data = [
            'file_no' => $this->request->getVar('fileNo'),
            'full_name' =>  $this->request->getVar('fullName')
          ]; 
          $assignedProceduresModel = new AssignedProceduresModel;
         //  $_labtest = $assignedLabtestModel->whereIn('id', json_decode($this->request->getVar('printList')))->find();
         $_procedure = $assignedProceduresModel->paidProcedure(json_decode($this->request->getVar('printList')));
 
         $assignedProceduresModel->mark_printed_risit(json_decode($this->request->getVar('printList')));
         
         $data['procedureList'] = $_procedure;
        //   echo '<pre>';
        // //   print_r($_labtest);
        //   echo '</pre>';
        //   exit;
        
          return view('Risit/procedure', $data);

    }

    protected function medicineRisit(){
        //TODO::
        $data = [
            'file_no' => $this->request->getVar('fileNo'),
            'full_name' =>  $this->request->getVar('fullName')
          ]; 
          $assignedMedicineModel = new AssignedMedicineModel;
         //  $_labtest = $assignedLabtestModel->whereIn('id', json_decode($this->request->getVar('printList')))->find();
         $_medicine = $assignedMedicineModel->paidMedicine(json_decode($this->request->getVar('printList')));
 
         $assignedMedicineModel->mark_printed_risit(json_decode($this->request->getVar('printList')));
         
         $data['medicineList'] = $_medicine;
        //   echo '<pre>';
        // //   print_r($_labtest);
        //   echo '</pre>';
        //   exit;
        
          return view('Risit/medicine', $data);
    }

    protected function radiologyRisit(){
         $data = [
           'file_no' => $this->request->getVar('fileNo'),
           'full_name' =>  $this->request->getVar('fullName')
         ]; 
         $assignedRadResult = new RadResult;
        //  $_labtest = $assignedLabtestModel->whereIn('id', json_decode($this->request->getVar('printList')))->find();
        $_radiology = $assignedRadResult->paidRadiology(json_decode($this->request->getVar('printList')));

        $assignedRadResult->mark_printed_risit(json_decode($this->request->getVar('printList')));
        
        $data['radiology'] = $_radiology;
        //  echo '<pre>';
        //  print_r($_labtest);
        //  echo '</pre>';

        //  return View('risit/labtest');
         return view('Risit/radiology', $data);
    }

}
