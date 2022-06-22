<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PatientsFileModel;
use App\Models\ConsultationModel;
use App\Models\ClinicalNoteModel;

class PatientFileController extends BaseController
{
    public function index($file_id)
    { 
        $patientsFileModel = new PatientsFileModel;
        $data = [];
        $data['patient_file'] = $patientsFileModel->where('id', $file_id)->first();
        return view('patientfile/file', $data);
    }

    // public function pfile($file){
    //     echo 'patient file is :'. $file;
    // }
    public function consult($file_id){
        $patientsFileModel = new PatientsFileModel;
        $consultationModel = new ConsultationModel;
        $consultation = $consultationModel->checkConsultationPayment($file_id);
        $consultation->consulted_by = session()->get('id');

        $data = [];
        $consultationModel->save($consultation);
        $patientsFileModel->save(['id' => $file_id, 'start_treatment' => date('Y/m/d'), 'status' => 'inTreatment']);
        //load patient file
        return $this::patient_file($file_id);
    }

    public function attend($file_id){
       return $this::patient_file($file_id);
    }

    protected function patient_file(Int $file_id){
        $patientsFileModel = new PatientsFileModel;
        $data['patient_file'] = $patientsFileModel->where('id', $file_id)->first();
        return view('patientfile/file', $data);
    }

    public function ajax_addnote(){
        if($this->request->getMethod() == 'post'){
            $clinicalNoteModel = new ClinicalNoteModel;
            if($clinicalNoteModel->save($this->request->getVar())){
                echo json_encode(['success' => true, 'message' => 'clinical note added!']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Failed to add clinical!']);
            }           
        }
    }
}
