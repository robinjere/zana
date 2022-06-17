<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\ConsultationFeeModel;
use App\Models\ConsultationModel;
use App\Models\PatientsFileModel;
use monken\TablesIgniter;

class ConsultationController extends BaseController
{
    public function index()
    {
        //
    }

    public function list(){
        return view('consultation/list');
    }

    public function fees(){
        return view('consultation/fee');
    }

    public function add_fee($fee_id = ""){
        helper('form');
        $role_model = new RoleModel;
        $consultation_fee_model = new ConsultationFeeModel();
        $data = [];
        
        if($this->request->getMethod() == 'post'){
            $rules = [
                'role_id' => 'required|is_unique[consultation_fee.role_id]',
                'amount' => 'required|min_length[0]'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                $new_fee = [
                    'role_id' =>  $this->request->getVar('role_id'),
                    'amount' =>  $this->request->getVar('amount')
                ];

              try {
                  //code...
                  $consultation_fee_model->save($new_fee);
                  return redirect()->to('consultation/fees')->with('success', 'new fee added');
              } catch (\Exception $e) {
                  //throw $th;
                 // die($e->getMessage());
                  session()->setFlashdata('validation', 'Duplicate Entry!');
              }
            }
        }

        $data['roles'] = $role_model->whereIn('role_type', ['general_doctor', 'specialist_doctor'])->findAll();
        return view('consultation/add_fee', $data);
    }

    public function ajax_getfees(){
        $consultation_fee_model = new ConsultationFeeModel();

        $data_table = new TablesIgniter();

        $data_table->setTable($consultation_fee_model->noticeTable())
                //    ->setDefaultOrder('id', 'DESC')
                //    ->setSearch(['name'])
                   ->setOrder([ 'updated_at', 'name', 'amount'])
                   ->setOutput([ $consultation_fee_model->DateFormat(),'name', $consultation_fee_model->formatAmount(),
                                $consultation_fee_model->actionButtons()
                               ]);

        return $data_table->getDatatable();
    }
    
    public function ajax_getconsultation(){
        $consultation_model = new ConsultationModel();
    
        $data_table = new TablesIgniter();
    
        $data_table->setTable($consultation_model->consultationTable())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['file_no'])
                   ->setOrder([ 'updated_at', 'file_no', 'payment', 'first_name', 'amount'])
                   ->setOutput([ $consultation_model->DateFormat(),'file_no', 'payment',
                                $consultation_model->doctor(), $consultation_model->formatAmount(),
                                $consultation_model->actionButtons()
                               ]);
    
        return $data_table->getDatatable();
    }

    public function cancel_consultation(Int $consultation_id, Int $file_id){
        $consultationModel = new ConsultationModel;
        $patientFileModel = new PatientsFileModel;

        echo 'consultation id -> '. $consultation_id; 
        echo 'patient file -> '. $file_id; 
        if($consultationModel->where('id', $consultation_id)->delete()){
            $patientFileModel->save(['id' => $file_id, 'status' => 'finishTreatment']);
        }
        return redirect()->to('patient/search')->with('success', 'patient removed from consultation');
    }

    public function approve_payment(Int $consultation_id, String $from_panel){
        $consultationModel = new ConsultationModel;
        $data = ['id' => $consultation_id, 'payment_confirmed_by' => session()->get('id')];
        $consultationModel->save($data);

        if($from_panel == 'search'){
            return redirect()->to('patient/search')->with('success', 'Consultation payment Approved!');
        }else{
            return redirect()->to('consultation/list')->with('success', 'Consultation payment Approved!');
        }
    }

    public function dis_approve_payment(Int $consultation_id, String $from_panel){
        $consultationModel = new ConsultationModel;
        $data = ['id' => $consultation_id, 'payment_confirmed_by' => 0];
        $consultationModel->save($data);
        if($from_panel == 'search'){
            return redirect()->to('patient/search')->with('errors', 'Consultation payment Disapproved!');
        }else{
            return redirect()->to('consultation/list')->with('errors', 'Consultation payment Disapproved!');
        }
    }


}
