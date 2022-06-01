<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\PatientsFileModel;
use App\Models\UserModel;
use App\Models\ConsultationModel;
class PatientController extends BaseController
{
    public function index()
    {
        return view('Patient/search_patient');
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
                  $patientFileModel->save(['patient_id' => $patient_id, 'file_no' => $file_generated]);
                  return redirect()->to('/patient/send_to_consultation/'.$patient_id)->with('success', 'patient registered');
           } catch (\Exception $e) {
               //throw $th;
               session()->setFlashdata('validation', $e->getMessage());
           }
        }

        return view('Patient/register', $data);
    }

    public function send_to_consultation($patient_id = ''){
        helper('form');
        $user_model = new UserModel;
        $patientFileModel = new PatientsFileModel;
        $consultationModel = new ConsultationModel;

        if($this->request->getMethod() == 'post'){
           $payment = '';

           $file_details = [
               'id' => $this->request->getVar('file_id'),
               'payment_method' => $this->request->getVar('payment_method')
            ];

           $consultation = [
               'file_id' => $this->request->getVar('file_id'),
               'doctor_id' => $this->request->getVar('doctor_id'),
               'payment' => $this->request->getVar('payment_method'),
               'assigned_by' => session()->get('id')
           ];

            if($this->request->getVar('payment_method') == 'CASH'){
              $consultation['amount'] = $this->request->getVar('amount');
              $file_details['amount'] = $this->request->getVar('amount');
            }else{
              $payment = $this->request->getVar('insuarance_no');
            }
           try {
               $patientFileModel->save($file_details);
               $consultationModel->save($consultation);
               return redirect()->to('/patient/search/')->with('success', 'Patient Sent to consultation');
           } catch (\Exception $e) {
              return redirect()->to('/patient/send_to_consultation/'.$patient_id)->with('errors', $e->getMessage());
           }
        }

        $data = [];
        $data['doctors'] = $user_model->get_users_doctor();
        $data['patient_info'] = $patientFileModel->where('patient_id', $patient_id)->first();
        return view('patient/send_to_consultation', $data);
    }
}
