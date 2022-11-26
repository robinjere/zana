<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HospitalReffersModel;
use App\Models\ReffersFormModel;
use monken\TablesIgniter;
use App\Models\PatientModel;
use App\Models\UserModel;


class ReffersController extends BaseController
{
    public function index()
    {
        return view('reffers/reffers');
    }

    public function addreffers($reffers_id = ''){
      helper('form');
      $hospitalReffersModel = new HospitalReffersModel;
      $data = [];
      $data['validation'] = '';
      $data['reffers'] =  ['hospital_name' => '', 'hospital_type' => ''];

      if(!empty($reffers_id)){
        $data['reffers'] = $hospitalReffersModel->where('id', $reffers_id)->first();
      }
      if($this->request->getMethod() == 'post'){
        $posted = $this->request->getVar();
        $posted['added_by'] = session()->get('id');                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
        if(!empty($reffers_id)){
            $posted['id'] = $reffers_id;
        }
        // print_r($posted);
        // exit;
        if($hospitalReffersModel->save($posted)){
            return redirect()->to('reffers')->with('success', 'Hospital reffers added!');
        }else{
            return redirect()->to('reffers')->with('error', 'Failed to add hospital reffers!');
        }
      }

      return view('reffers/addReffers', $data);

    }

    public function delete_reffers(Int $reffers_id){
      $hospitalReffersModel = new HospitalReffersModel;
      if($hospitalReffersModel->where('id', $reffers_id)->delete()){
          return redirect()->to('reffers/')->with('success', 'hospital reffers deleted');
      }else{
          return redirect()->to('reffers/')->with('error', 'failed to delete hospital reffers');
      }
    }

    public function ajax_reffers(){
        $hospitalReffersModel = new HospitalReffersModel;
        $data_table = new TablesIgniter();
        $data_table->setTable($hospitalReffersModel->getReffers())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['hospital_name'])
                   ->setOrder(['updated_at', 'hospital_name', 'hospital_type'])
                   ->setOutput([$hospitalReffersModel->DateFormat(), 'hospital_name','hospital_type', $hospitalReffersModel->actionButtons()]);

        return $data_table->getDatatable();
    }

    public function reffersTo(){
      $patientModel = new PatientModel;
      $hospitalReffersModel = new HospitalReffersModel;

      $data = [];
      
      $store = new StoreController;
      $data['clinic_contacts'] = $store->get_clinic_info();
      $data['hospital'] = $hospitalReffersModel->findAll();
  
      if($this->request->getMethod() == 'post'){
            $data['patientFile'] = $this->request->getVar();
            // $data['patient'] = $patientModel->where('id', $this->request->getVar('patient_id'))->first();
            $data['pageTitle'] = 'Reffers';
            return view('reffers/form', $data);
       }
  
       return  redirect()->to('patient/search');
      // return view('reffers/form');
    }

    public function ajax_addreffers(){
      $reffersFormModel  = new ReffersFormModel;
      if($this->request->getMethod() == 'post'){
        
        $patient_id = $this->request->getVar('patient_id');
        $start_treatment = $this->request->getVar('start_treatment');
        $end_treatment = $this->request->getVar('end_treatment');
        $reffers_data = $this->request->getVar('reffers_data');

        $is_reffers_present = $reffersFormModel->is_reffers_present($patient_id, $start_treatment, $end_treatment);
        
        // echo 'data sent <br/>';
        // print_r($_tocheck);

        // echo 'data sent <br/>';
        // echo json_encode($is_reffers_present);
        // exit;

        if(!empty($is_reffers_present)){
          $reffers_data->id = $is_reffers_present->id;
          if($reffersFormModel->save($reffers_data)){
            echo json_encode(['success' =>  true, 'messaage' => 'reffers successful added!']);
          };
        }else{
          if($reffersFormModel->save($reffers_data)){
            echo json_encode(['success' =>  true, 'messaage' => 'reffers successful added!']);
          };
        }
      }
    }

    public function ajax_getReffers(){
      if($this->request->getMethod() == 'post'){
        $reffersFormModel  = new ReffersFormModel;          
          $start_date = $this->request->getVar('start_treatment');
          $end_date = $this->request->getVar('end_treatment');
          $patient_id = $this->request->getVar('patient_id');
          $patient_info = '';
          $doctor_info = '';
          $_reffers = $reffersFormModel->is_reffers_present($patient_id, $start_date, $end_date);

          $track_date = date('Y-m-d');
          if(empty($_reffers)){
             $patient_info = $this::getPatient($patient_id);
             $doctor_info = $this::getDoctor(session()->get('id'));
             $_reffers = new \stdClass();
          }else{
            $patient_info = $this::getPatient($_reffers->patient);
            $doctor_info = $this::getDoctor($_reffers->doctor);
            $track_date = date_format(date_create($_reffers->updated_at), 'Y-m-d');  
          }

          $_reffers->patient = $patient_info->id;
          $_reffers->patient_file = $patient_info->file_no;
          $_reffers->patient_name = $patient_info->first_name.' '. $patient_info->middle_name .' ' . $patient_info->sir_name;
          $_reffers->age =  (date('Y') - date('Y', strtotime($patient_info->birth_date)));
          $_reffers->address = $patient_info->address;
          $_reffers->tel_no = $patient_info->phone_no;
          $_reffers->relative_name = $patient_info->next_kin_name;
          $_reffers->relative_tel_no = $patient_info->next_kin_phone;

          $_reffers->date = $track_date;
          $_reffers->doctor = $doctor_info['id'];
          $_reffers->doctor_name = $doctor_info['first_name'] .' '. $doctor_info['last_name'];
          $_reffers->doctor_signature = strtolower(substr($doctor_info['first_name'], 0,1). '.'. $doctor_info['last_name']);

          echo json_encode($_reffers);
      }
    }

    protected function getPatient($patient_id){
         $patientModel = new PatientModel;
         return $patientModel->searchPatientById($patient_id);
    }

    protected function getDoctor($doctor_id){
        $userModel = new UserModel;
        return $userModel->where('id', $doctor_id)->first();
    }
}
