<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\ConsultationFeeModel;
use App\Models\ConsultationModel;
use App\Models\PatientsFileModel;
use App\Models\UserModel;
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

    public function myList(){
        return view('consultation/my_list');
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
                   ->setSearch(['file_no', 'patients.first_name', 'patients.sir_name'])
                   ->setOrder([ 'updated_at', 'name','file_no', 'payment', 'first_name'])
                   ->setOutput([ $consultation_model->DateFormat(), $consultation_model->formatName(), 'file_no', 'payment',
                                $consultation_model->doctor(),
                                $consultation_model->actionButtons()
                               ]);
    
        return $data_table->getDatatable();
    }

    public function ajax_getconsultationList(){
        $consultation_model = new ConsultationModel();
    
        $data_table = new TablesIgniter();
    
        $data_table->setTable($consultation_model->myConsultationTable())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['file_no', 'patients.first_name', 'patients.sir_name'])
                   ->setOrder([ 'updated_at', 'name','file_no', 'first_name'])
                   ->setOutput([ $consultation_model->DateFormat(), $consultation_model->formatName(), 'file_no',
                                $consultation_model->doctor(),
                                $consultation_model->actionButtonAttend()
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
        $patientFileModel = new PatientsFileModel;
        $user_model = new UserModel;

        $data = ['id' => $consultation_id, 'payment_confirmed_by' => session()->get('id')];
        $consultationModel->save($data);

        $consultationData = $consultationModel->where('id', $consultation_id)->first();
         //update patient file from new to exiting
        //  print_r([ 'id' => $consultationData['file_id'], 'new_patient' => 0 ]);
        //  exit;
        $data['patient'] = $patientFileModel->patientFile($consultationData['file_id'], '');
         $patientFileModel->save([ 'id' => $consultationData['file_id'], 'new_patient' => 0 ]);
        $data['doctor'] = $user_model->where('id', $consultationData['doctor_id'])->first();

        //Generate consultation risit.
        // echo '<pre>';
        //  print_r($data);
        // echo '</pre>';
        // echo $data['doctor']['father_name'];
        // exit;
        session()->setflashdata('success', 'Consultation payment Approved!');
        
        return view('Risit/consultation', $data);

        // if($from_panel == 'search'){
        //     return redirect()->to('patient/search')->with('success', 'Consultation payment Approved!');
        // }else{
        //     return redirect()->to('consultation/list')->with('success', 'Consultation payment Approved!');
        // }
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
