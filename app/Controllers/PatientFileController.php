<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PatientsFileModel;
use App\Models\ConsultationModel;
use App\Models\ClinicalNoteModel;
use App\Models\ProceduresModel;
use App\Models\AssignedProceduresModel;
use App\Models\ItemModel;
use monken\TablesIgniter;


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
    
    public function ajax_getclinicalnotes(){
        if($this->request->getMethod() == 'post'){
            $clinicalNoteModel = new ClinicalNoteModel;
            $clinicalnotes = $clinicalNoteModel->getClinicalNotes($this->request->getVar('file_id'), $this->request->getVar('start_date'), $this->request->getVar('end_date'));
            if($clinicalnotes){
                echo json_encode($clinicalnotes);
            }
        }
    }

    public function ajax_assignprocedure(){
        $assignedProceduresModel =  new AssignedProceduresModel;
        if($this->request->getMethod() == 'post'){
            if($assignedProceduresModel->save($this->request->getVar())){
                echo json_encode(['success' => true, 'message' => 'Procedure assigned!']);   
            }else{
                echo json_encode(['success' => false, 'message' => 'Failed to assign a procedure!']); 
            }
        }
    }
    
    public function ajax_getprocedures(){
        $proceduresModel = new ProceduresModel;
        echo json_encode($proceduresModel->findAll());
    }
    public function ajax_deleteprocedure(){
       $assignedProceduresModel =  new AssignedProceduresModel;
       if($this->request->getMethod() == 'post'){
           if($assignedProceduresModel->where('id', $this->request->getVar('procedure_id'))->delete()){
               echo json_encode(['success' => true, 'message' => 'successful deleted!']);
            }else{
               echo json_encode(['success' => false, 'message' => 'failed deleted!']);
            }
       }
    }
    public function ajax_assignedprocedure(){
        $assignedProceduresModel =  new AssignedProceduresModel;
        if($this->request->getMethod() == 'post'){

           $file_id=$this->request->getVar('file_id');
           $start_date=$this->request->getVar('start_date');
           $end_date=$this->request->getVar('end_date');

        //    echo json_encode(['file_id' => $file_id, 'start_date' =>  $start_date, 'end_date' => $end_date]);
        //    exit;

           $data_table = new TablesIgniter();
           $data_table->setTable($assignedProceduresModel->getAssignedProcedures($file_id, $start_date, $end_date))
                      ->setDefaultOrder('id', 'DESC')
                    //   ->setSearch(['name'])
                      ->setOrder(['created_at', 'name', 'procedure_note', 'amount', 'doctor'])
                      ->setOutput([$assignedProceduresModel->procedureDateFormat(), 'name', 'procedure_note', $assignedProceduresModel->formatAmount(), $assignedProceduresModel->procedureDoctor(), $assignedProceduresModel->actionButtons()]);
   
           return $data_table->getDatatable();

        }
    }

   public function ajax_searchdrug(){
       $itemModel = new ItemModel;
       if($this->request->getMethod() == 'post'){
          //searchinput..
          echo json_encode(['searchItem' => $itemModel->searchItem($this->request->getVar('searchInput')) ]);
       }
   }
}
