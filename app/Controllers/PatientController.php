<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\PatientsFileModel;
use App\Models\UserModel;
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
        $user_model = new UserModel;
        $patientFileModel = new PatientsFileModel;
        $data = [];
        $data['doctors'] = $user_model->get_users_doctor();
        $data['patient_info'] = $patientFileModel->where('patient_id', $patient_id)->first();
        return view('patient/send_to_consultation', $data);
    }
}
