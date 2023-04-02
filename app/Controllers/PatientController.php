<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\PatientsFileModel;
use App\Models\UserModel;
use App\Models\ConsultationModel;
use App\Models\ClinicModel;
use App\Models\CountriesModel;
use App\Models\LabtestModel;
use monken\TablesIgniter;

class PatientController extends BaseController
{
    public function index()
    {
        // return view('Patient/search_patient');
        return $this::search_patient();
    }

    public function register(){
        $patientModel = new PatientModel();
        $countriesModel = new CountriesModel;
        helper('form');
        $data = [];

        $data['countries'] = $countriesModel->findAll();

        if($this->request->getMethod() === 'post'){
            $rules = [
                'first_name' => 'required',
                'sir_name' => 'required',
                'birth_date' => 'required',
                'gender' => 'required',
                'pcharacter' => 'required'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                $form_data = $this->request->getVar();
                $form_data['user_id'] = session()->get('id');
              
                try {
                       $patientModel->save($form_data);
                       //generate file number MRNO/YEAR_OF_REGISTRATION/PATIENT_ID
                       $patient_id = $patientModel->getInsertID();
                       $file_generated = 'MRNO/'.date('Y').'/'.$patient_id;
                       //session()->setFlashdata('success', 'patient registered');
                       //save patient file generated.
                       // print_r($patient_id);
                       // exit;
                       
                       $patientFileModel = new PatientsFileModel;
                       $patientFileModel->save(['patient_id' => $patient_id, 'file_no' => $file_generated, 'patient_character' => $form_data['pcharacter'], 'new_patient' => 1]);
                       if($form_data['pcharacter'] == 'outsider'){
                           return redirect()->to('/patient/outsider/'.$patient_id)->with('success', 'patient registered');
                       }
                       return redirect()->to('/patient/send_to_consultation/'.$patient_id)->with('success', 'patient registered');
                } catch (\Exception $e) {
                    //throw $th;
                    print_r($e->getMessage());
                    exit;
                    session()->setFlashdata('validation', $e->getMessage());
                }
            }
        }

        return view('Patient/register', $data);
    }

    public function edit_patient(int $patient_id){
        $patientModel = new PatientModel();
        $patientFileModel = new PatientsFileModel();
        $countriesModel = new CountriesModel;

        helper('form');
        $data = [];
        $data['countries'] = $countriesModel->findAll();
        $data['currentPatient'] = $patientModel->where('id', $patient_id)->first();
        $data['patientFile'] = $patientFileModel->where('patient_id', $patient_id)->first();
        if($this->request->getMethod() === 'post'){
            $rules = [
                'first_name' => 'required',
                'sir_name' => 'required',
                'birth_date' => 'required',
                'gender' => 'required',
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                $form_data = $this->request->getVar();
                $form_data['user_id'] = session()->get('id');
                $form_data['id'] = $patient_id;
              
                try {
                       $patientModel->save($form_data);
                       $data['patientFile']['patient_character'] = $form_data['pcharacter'];
                    //    print_r($data['patientFile'] );
                    //    exit;
                       $patientFileModel->save($data['patientFile']);
                       //generate file number MRNO/YEAR_OF_REGISTRATION/PATIENT_ID
                    
                       if($form_data['pcharacter'] == 'outsider'){
                           return redirect()->to('/patient/outsider/'.$patient_id)->with('success', 'Patient Info edited!');
                       }
                    //    return redirect()->to('/patient/edit/'.$patient_id)->with('success', 'Patient Info edited!');
                       return redirect()->to('/patient/search')->with('success', 'Patient Info edited!');
                } catch (\Exception $e) {
                    //throw $th;
                    print_r($e->getMessage());
                    exit;
                    session()->setFlashdata('validation', $e->getMessage());
                }
            }
        }

        return view('Patient/edit', $data);
    }

    public function outsider($patient_id =""){
        $data = [];
        helper('form');
        $user_model = new UserModel;
        $patientFileModel = new PatientsFileModel;
        $patientModel = new PatientModel;
        // $consultationModel = new ConsultationModel;
        $clinicModel = new ClinicModel;

        // $data['doctors'] = $user_model->get_users_doctor();
        $data['clinics'] = $clinicModel->find();
        $data['patient_info'] = $patientFileModel->where('patient_id', $patient_id)->first();
        $data['patient_profile'] = $patientModel->where('id', $patient_id)->first();
        
        return view('patient/outsider', $data);
    }

    public function outsider_start_treatment(){
        $patientFileModel = new PatientsFileModel;
        if($this->request->getMethod() == 'post'){
            // print_r($this->request->getVar());
            $_updateFile = [
               'id' => $this->request->getVar('file_id'),
               'payment_method' => $this->request->getVar('payment_method'),
               'start_treatment' => $this->request->getVar('start_treatment'),
               'status' => $this->request->getVar('status'),
            ];
            if($patientFileModel->save($_updateFile)){
                return redirect()->to('/patient/outsider/'.$this->request->getVar('patient_id'))->with('success', 'outsider started treament');
            }
        }
    }

    public function send_to_consultation($patient_id = ''){
        $data = [];
        helper('form');
        $user_model = new UserModel;
        $patientFileModel = new PatientsFileModel;
        $patientModel = new PatientModel;
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
                    'start_treatment' => date('Y-m-d'),
                    'end_treatment' => '',
                    'clinic' =>  $this->request->getVar('clinic')
                 ];
     
                $consultation = [
                    'file_id' => $this->request->getVar('file_id'),
                    'doctor_id' => $this->request->getVar('doctor_id'),
                    'payment' => $this->request->getVar('payment_method'),
                    'assigned_by' => session()->get('id'),
                    'amount' => $this->request->getVar('amount'),
                    // 'payment_confirmed_by' => session()->get('id')
                ];
     
                 if(!empty($this->request->getVar('insuarance_no'))){
                   $file_details['insuarance_no'] = $this->request->getVar('insuarance_no');
                 }
     
                try {
                    $patientFileModel->save($file_details);
                    $consultationModel->save($consultation);
                    
                   
                    // return redirect()->to('/patient/search');

                    return redirect()->to('/patient/search/')->with('success', 'Patient Sent to Doctor');
                } catch (\Exception $e) {
                   return redirect()->to('/patient/send_to_consultation/'.$patient_id)->with('errors', $e->getMessage());
                }
            }
        }

        $data['doctors'] = $user_model->get_users_doctor();
        $data['clinics'] = $clinicModel->find();
        $data['patient_info'] = $patientFileModel->where('patient_id', $patient_id)->first();
        $data['patient_profile'] = $patientModel->where('id', $patient_id)->first();
        
        return view('patient/send_to_consultation', $data);
    }

    public function ajax_searchPatient(){
        $patientModel = new PatientModel;
        $data = [];
        if($this->request->getMethod() == 'post'){
          $searchterm = $this->request->getVar('searchterm');
           $filter = '';
          if (preg_match('~[0-9]+~', $searchterm)) {
            $filter = 'file_no';
          }else{
            $filter = 'name';
          }
           try {
            //code...
            //    echo 'filter -> ';
            //    print_r($filter);
            //    echo '<br/>';
            //    print_r('Search term');
            //    print_r($searchterm);
            //    echo '<br/>';

              $data['patient_info'] = $patientModel->searchPatient($filter, $searchterm);
            //   $data['search_by'] = $filter;
            // print_r($data['patient_info']);
            // echo '<br/>';

              if(empty($data['patient_info'])){
                   $data['patient_info'] = $patientModel->searchPatientWithNoClinic($filter, $searchterm);
                   if(empty($data['patient_info'])){
                       echo json_encode(['success' => false, 'errors' => 'Unfortunately, no patient were found!, Please adjust your filter criteria.']);
                   }else{
                    echo json_encode(['success' => true, 'patient_info' => $data['patient_info']]);
                   }
              }else{
                  /**
                   * Check if patient sent to consultation -> status === 'consultation'
                   * check if payment is cash then check if consultation fee is payed. 
                   */
                  echo json_encode(['success' => true, 'patient_info' => $data['patient_info']]);
              }

           } catch (\Exception $e) {
               //throw $th;
                echo json_encode(['success' => false, 'errors' =>  $e->getMessage()]);
           }
        }
    }

    protected function search_patient(){
        $patientModel = new PatientModel;
        $data = [];

        if($this->request->getMethod() == 'post'){
        //    $filter = $this->request->getVar('filter'); // 'file_no / name
            //check if a search term contain number. 
        
           $patient_id = $this->request->getVar('patient_id');
           $filter = '';
        //   if (preg_match('~[0-9]+~', $searchterm)) {
        //     $filter = 'file_no';
        //   }else{
        //     $filter = 'name';
        //   }
           try {
               //code...
              $data['patient_info'] = $patientModel->searchPatientById($patient_id);
              $data['search_by'] = 'name';

              if(empty($data['patient_info'])){
                   $data['patient_info'] = $patientModel->searchPatientByIdWithNoClinic($patient_id);
                   if(empty($data['patient_info'])){
                       session()->setFlashdata('errors', 'Unfortunately, no patient were found!, Please adjust your filter criteria.');
                   }else{
                    $patientInfo = $data['patient_info'];
                    $consultationModel = new ConsultationModel;
                    
                    if($patientInfo->status == 'consultation' && ($patientInfo->payment_method == 'CASH' || $patientInfo->payment_method == 'NHIF')){
                       $data['consultation_payment'] = $consultationModel->checkConsultationPayment($patientInfo->file_id);
                    }
                   }
              }else{
                  /**
                   * Check if patient sent to consultation -> status === 'consultation'
                   * check if payment is cash then check if consultation fee is payed. 
                   */
                  $patientInfo = $data['patient_info'];
                  $consultationModel = new ConsultationModel;
                  
                  if($patientInfo->status == 'consultation' && ($patientInfo->payment_method == 'CASH' || $patientInfo->payment_method == 'NHIF')){
                     $data['consultation_payment'] = $consultationModel->checkConsultationPayment($patientInfo->file_id);
                  }
              }

           } catch (\Exception $e) {
               //throw $th;
               return redirect()->to('patient/search')->with('errors', $e->getMessage());
           }
        }
        return view('Patient/search_patient', $data);
 
        // return redirect()->to('patient/search');
    }


    //lab_patient_list..
    public function ajax_lab_patient_list(){
        $labtest_model = new LabtestModel();
    
        $data_table = new TablesIgniter();
    
        $data_table->setTable($labtest_model->patientList())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['file_no', 'patients.first_name', 'patients.sir_name'])
                   ->setOrder([ 'updated_at', 'name','file_no', 'payment_method'])
                   ->setOutput([ $labtest_model->formatDate(), $labtest_model->formatName(), 'file_no', 'payment_method',
                                 $labtest_model->doctorName(),
                                 $labtest_model->patientListAction()
                               ]);
    
        return $data_table->getDatatable();
    }

}