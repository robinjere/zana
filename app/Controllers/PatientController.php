<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\PatientsFileModel;
use App\Models\UserModel;
use App\Models\ConsultationModel;
use App\Models\ClinicModel;

class PatientController extends BaseController
{
    public function index()
    {
        // return view('Patient/search_patient');
        return $this::search_patient();
    }

    public function register(){
        $patientModel = new PatientModel();
        helper('form');
        $data = [];

        if($this->request->getMethod() === 'post'){
           $form_data = $this->request->getVar();
           $form_data['user_id'] = session()->get('id');
           try {
                  $patientModel->save($form_data);
                  //generate file number MRNO/YEAR_OF_REGISTRATION/PATIENT_ID
                  $patient_id = $patientModel->getInsertID();
                  $file_generated = 'MRNO/'.date('Y').'/'.$patient_id;
                //   session()->setFlashdata('success', 'patient registered');
                  //save patient file generated.
                  $patientFileModel = new PatientsFileModel;
                  $patientFileModel->save(['patient_id' => $patient_id, 'file_no' => $file_generated, 'patient_character' => 'outpatient']);
                  return redirect()->to('/patient/send_to_consultation/'.$patient_id)->with('success', 'patient registered');
           } catch (\Exception $e) {
               //throw $th;
               session()->setFlashdata('validation', $e->getMessage());
           }
        }

        return view('Patient/register', $data);
    }

    public function send_to_consultation($patient_id = ''){
        $data = [];
        helper('form');
        $user_model = new UserModel;
        $patientFileModel = new PatientsFileModel;
        $consultationModel = new ConsultationModel;
        $clinicModel = new ClinicModel;

        if($this->request->getMethod() == 'post'){

            $rules = [
                'file_id' => 'required',
                'payment_method' => 'required',
                'amount' => 'required',
                'clinic' => 'required',
                'doctor_id' => 'required'
            ];
             if($this->request->getVar('payment_method') !== 'CASH'){
                $rules['insuarance_no'] = 'required';
             }

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                $payment = '';
     
                $file_details = [
                    'id' => $this->request->getVar('file_id'),
                    'payment_method' => $this->request->getVar('payment_method'),
                    'status' => 'consultation',
                    'clinic' =>  $this->request->getVar('clinic')
                 ];
     
                $consultation = [
                    'file_id' => $this->request->getVar('file_id'),
                    'doctor_id' => $this->request->getVar('doctor_id'),
                    'payment' => $this->request->getVar('payment_method'),
                    'assigned_by' => session()->get('id'),
                    'amount' => $this->request->getVar('amount')
                ];
     
                 if(!empty($this->request->getVar('insuarance_no'))){
                   $file_details['insuarance_no'] = $this->request->getVar('insuarance_no');
                 }
     
                try {
                    $patientFileModel->save($file_details);
                    $consultationModel->save($consultation);
                    return redirect()->to('/patient/search/')->with('success', 'Patient Sent to consultation');
                } catch (\Exception $e) {
                   return redirect()->to('/patient/send_to_consultation/'.$patient_id)->with('errors', $e->getMessage());
                }
            }
        }

        $data['doctors'] = $user_model->get_users_doctor();
        $data['clinics'] = $clinicModel->find();
        $data['patient_info'] = $patientFileModel->where('patient_id', $patient_id)->first();
        
        return view('patient/send_to_consultation', $data);
    }

    protected function search_patient(){
        $patientModel = new PatientModel;
        $data = [];

        if($this->request->getMethod() == 'post'){
           $filter = $this->request->getVar('filter'); // 'file_no / name
           $searchterm = $this->request->getVar('searchterm');
           try {
               //code...
              $data['patient_info'] = $patientModel->searchPatient($filter, $searchterm);
              $data['search_by'] = $filter;

              if(empty($data['patient_info'])){
                   session()->setFlashdata('errors', 'Unfortunately, no patient were found!, Please adjust your filter criteria.');
              }else{
                  /**
                   * Check if patient sent to consultation -> status === 'consultation'
                   * check if payment is cash then check if consultation fee is payed. 
                   */
                  $patientInfo = $data['patient_info'];
                  $consultationModel = new ConsultationModel;
                  
                  if($patientInfo->status == 'consultation' && $patientInfo->payment_method == 'CASH'){
                     $data['consultation_payment'] = $consultationModel->checkConsultationPayment($patientInfo->file_id);
                  }
              }

           } catch (\Exception $e) {
               //throw $th;
               return redirect()->to('/patient/search')->with('errors', $e->getMessage());
           }
        }

        return view('Patient/search_patient', $data);
    }
}