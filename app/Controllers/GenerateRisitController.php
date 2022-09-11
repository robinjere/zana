<?php

namespace App\Controllers;
use App\Models\AssignedLabtestModel;

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
                    # code...
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
        $data['labtest'] = $_labtest;
        //  echo '<pre>';
        //  print_r($_labtest);
        //  echo '</pre>';

        //  return View('risit/labtest');
         return view('Risit/labtest', $data);
    }
}
