<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\PatientsFileModel;
class PatientController extends BaseController
{
    public function index()
    {
        return view('Patient/patient_dashboard');
    }

    public function register(){
        $patientModel = new PatientModel();
        helper('form');
        $data = [];

        if($this->request->getMethod() === 'post'){
           $form_data = $this->request->getVar();
           $form_data['user_id'] = session()->get('id');

           if($patientModel->save($form_data) == false){
              session()->setFlashdata('validation', $patientModel->errors());
           }else{
               //generate file number MRNO/YEAR_OF_REGISTRATION/PATIENT_ID
               $patient_id = $patientModel->getInsertID();
               $file_generated = 'MRNO/'.date('Y').'/'.$patient_id;

               return redirect()->to('/patient/file/'.$file_generated)->with('success', 'patient registered');
           }
        }

        return view('Patient/register', $data);
    }
}
