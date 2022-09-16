<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PatientsFileModel;
use App\Models\ConsultationModel;
use App\Models\ClinicalNoteModel;
use App\Models\ProceduresModel;
use App\Models\AssignedProceduresModel;
use App\Models\AssignedMedicineModel;
use App\Models\ItemModel;
use App\Models\LabtestModel;
use App\Models\AssignedLabtestModel;
use App\Models\DiagnosesModel;
use App\Models\RadInvestigationModel;
use App\Models\RadResult;
use App\Models\AssignedDiagnosesModel;
use App\Models\GeneralExaminationModel;
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
        
        // $data['patient_file'] = $patientsFileModel->where('id', $file_id)->first();
        $_patient = $patientsFileModel->where('id', $file_id)->first();
        // print_r($_patient); exit;
        if($_patient['patient_character'] === 'outsider'){
            $data['patient_file'] = $patientsFileModel->patientFile($file_id, 'outsider');
        }else{
            $data['patient_file'] = $patientsFileModel->patientFile($file_id, '');
        }
        
        // print_r($data['patient_file']);
        // exit;

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

    public function ajax_deletenote(){
       if($this->request->getMethod() == 'post'){
            $clinicalNoteModel = new ClinicalNoteModel;
            if($clinicalNoteModel->where('id', $this->request->getVar('id'))->delete()){
                echo json_encode(['success'=> true, 'message' => 'successful deleted']);
            }
        }
    }
    
    public function ajax_getclinicalnotes(){
        if($this->request->getMethod() == 'post'){
            $clinicalNoteModel = new ClinicalNoteModel;
            $clinicalnotes = $clinicalNoteModel->getClinicalNotes($this->request->getVar('file_id'), $this->request->getVar('start_date'), $this->request->getVar('end_date'));
            if($clinicalnotes){
                echo json_encode($clinicalnotes);
            }else{
                echo json_encode(['empty' => true, 'message' => 'There is no clinical note available']);
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
                      ->setOrder(['created_at', 'name', 'procedure_note', 'amount', 'status', 'doctor'])
                      ->setOutput([$assignedProceduresModel->procedureDateFormat(), 'name', 'procedure_note', $assignedProceduresModel->formatAmount(), $assignedProceduresModel->status(), $assignedProceduresModel->procedureDoctor(), $assignedProceduresModel->actionButtons()]);
   
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
   
   public function ajax_assigndrug(){
       $assignedMedicineModel = new AssignedMedicineModel;
       if($this->request->getMethod() == 'post'){
         if($assignedMedicineModel->save($this->request->getVar())){
                echo json_encode(['success' => true, 'message' => 'Successful drug assigned to a patient!']);
          }else{
                echo json_encode(['success' => false, 'message' => 'Failed to assign drug to a patient!']);
          }
       }
   }

   public function ajax_deleteMedicine(){
    $assignedMedicineModel = new AssignedMedicineModel;
    if($this->request->getMethod() == 'post'){
        if($assignedMedicineModel->where('id', $this->request->getVar('medicine_id'))->delete()){
            echo json_encode(['success'=> true, 'message' => 'successful deleted']);
        }
    }
   }

   public function ajax_assignedmedicine(){
    $assignedMedicineModel = new AssignedMedicineModel;
    if($this->request->getMethod() == 'post'){

        $file_id=$this->request->getVar('file_id');
        $start_date=$this->request->getVar('start_date');
        $end_date=$this->request->getVar('end_date');

        // print_r($assignedMedicineModel->getAssignedMedicine($file_id, $start_date, $end_date));
        // exit;

        $data_table = new TablesIgniter();
        $data_table->setTable($assignedMedicineModel->getAssignedMedicine($file_id, $start_date, $end_date))
                   ->setDefaultOrder('id', 'DESC')
                 //   ->setSearch(['name'])
                   ->setOrder(['created_at', 'name', 'dosage','route','frequency','days','qty','instruction','payed','selling_price'])
                   ->setOutput([$assignedMedicineModel->medicineDateFormat(), 'name', 'dosage','route','frequency','days','qty','instruction','payed', $assignedMedicineModel->formatAmount(), $assignedMedicineModel->actionButtons()]);

        return $data_table->getDatatable();

     }
   }
   
   public function ajax_searchlabtest(){
    $labtestModel = new LabtestModel;
    if($this->request->getMethod() == 'post'){
       //searchinput..
       echo json_encode(['searchLabtest' => $labtestModel->searchLabTest($this->request->getVar('searchInput')) ]);
    }
   }

   public function ajax_assignlabtest(){
    $assignedLabtestModel = new AssignedLabtestModel;
    if($this->request->getMethod() == 'post'){
        if($assignedLabtestModel->save($this->request->getVar())){
            echo json_encode(['success' => true, 'message' => 'Successful labtest assigned to a patient!']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Failed to assign labtest to a patient!']);
        }
    }
   }

   public function ajax_assignedlabtest(){
     $assignedLabtestModel = new AssignedLabtestModel;
       if($this->request->getMethod() == 'post'){
        $file_id=$this->request->getVar('file_id');
        $start_date=$this->request->getVar('start_date');
        $end_date=$this->request->getVar('end_date');

        // print_r($assignedMedicineModel->getAssignedMedicine($file_id, $start_date, $end_date));
        // exit;

        $data_table = new TablesIgniter();
        $data_table->setTable($assignedLabtestModel->getAssignedLabtest($file_id, $start_date, $end_date))
                   ->setDefaultOrder('id', 'DESC')
                 //   ->setSearch(['name'])
                   ->setOrder(['updated_at', 'name','price'])
                   ->setOutput([$assignedLabtestModel->labtestDateFormat(), 'name', $assignedLabtestModel->formatPrice(), $assignedLabtestModel->status(), $assignedLabtestModel->actionButtons()]);

        return $data_table->getDatatable();
       }
   }

   public function ajax_deleteAssginedLabtest(){
    $assignedLabtestModel = new AssignedLabtestModel;
    if($this->request->getMethod() == 'post'){
        if($assignedLabtestModel->where('id', $this->request->getVar('assignedLabtest'))->delete()){
            echo json_encode(['success'=> true, 'message' => 'successful deleted']);
        }
    }
   }

   public function confirmPaymentLabTestResult(){
    $assignedLabtestModel = new AssignedLabtestModel;
    if($this->request->getMethod() == 'post'){
        if($assignedLabtestModel->save($this->request->getVar())){
            echo json_encode(['success'=> true, 'message' => 'payment confirmed!']);
        }else{
            echo json_encode(['success'=> false, 'message' => 'fail to confirm payment!']);
        }
    }
   }

   public function unconfirmPaymentLabTestResult(){
    $assignedLabtestModel = new AssignedLabtestModel;
    if($this->request->getMethod() == 'post'){
        if($assignedLabtestModel->save($this->request->getVar())){
            echo json_encode(['success'=> true, 'message' => 'payment confirmed!']);
        }else{
            echo json_encode(['success'=> false, 'message' => 'fail to confirm payment!']);
        }
    }
   }

   //radiology
   public function confirmPaymentRadiology(){

    $assignedRadResult = new RadResult;
    if($this->request->getMethod() == 'post'){
        if($assignedRadResult->save($this->request->getVar())){
            echo json_encode(['success'=> true, 'message' => 'payment confirmed!']);
        }else{
            echo json_encode(['success'=> false, 'message' => 'fail to confirm payment!']);
        }
    }
   }

   public function unconfirmPaymentRadiology(){
    $assignedRadResult = new RadResult;
    if($this->request->getMethod() == 'post'){
        if($assignedRadResult->save($this->request->getVar())){
            echo json_encode(['success'=> true, 'message' => 'payment confirmed!']);
        }else{
            echo json_encode(['success'=> false, 'message' => 'fail to confirm payment!']);
        }
    }
   }

   public function ajax_searchdiagnosis(){
    $diagnosesModel = new DiagnosesModel;
    if($this->request->getMethod() == 'post'){
       //searchinput..
       echo json_encode(['diagnosis' => $diagnosesModel->searchDiagnoses($this->request->getVar('searchInput')) ]);
    }
   }

   public function ajax_assigndiagnosis(){
    $assignedDiagnosesModel = new AssignedDiagnosesModel;
    if($this->request->getMethod() == 'post'){
        if($assignedDiagnosesModel->save($this->request->getVar())){
            echo json_encode(['success' => true, 'message' => 'Successful diagnose assigned!']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Failed to assign diagnose!']);
        }
    }
   }

   public function ajax_workingDiagnoses(){
       return $this->assinged_diagnoses('working');
   }

   public function ajax_finalDiagnoses(){
       return $this->assinged_diagnoses('final');
   }

   function assinged_diagnoses($diagnoses_type){
       
    $assignedDiagnosesModel = new AssignedDiagnosesModel;
    if($this->request->getMethod() == 'post'){
     $file_id=$this->request->getVar('file_id');
     $start_date=$this->request->getVar('start_date');
     $end_date=$this->request->getVar('end_date');

     // print_r($assignedMedicineModel->getAssignedMedicine($file_id, $start_date, $end_date));
     // exit;

     $data_table = new TablesIgniter();
     $data_table->setTable($assignedDiagnosesModel->getAssignedDiagnoses($file_id, $start_date, $end_date, $diagnoses_type))
                ->setDefaultOrder('id', 'DESC')
              //   ->setSearch(['name'])
                ->setOrder(['updated_at'])
                ->setOutput([$assignedDiagnosesModel->diagnosesDateFormat(), $assignedDiagnosesModel->diagnoses(), 'diagnoses_note', $assignedDiagnosesModel->actionButtons()]);

     return $data_table->getDatatable();
    }
   }
    
   public function ajax_deleteDiagnosis(){
    $assignedDiagnosesModel = new AssignedDiagnosesModel;
    if($this->request->getMethod() == 'post'){
        if($assignedDiagnosesModel->where('id', $this->request->getVar('id'))->delete()){
            echo json_encode(['success'=> true, 'message' => 'successful deleted']);
        }
    }
   }

   public function ajax_searchradiology(){
    $radInvestigationModel = new RadInvestigationModel;
    if($this->request->getMethod() == 'post'){
       //searchinput..
       echo json_encode(['searchRadiology' => $radInvestigationModel->searchradiology($this->request->getVar('searchInput')) ]);
    }
   }

   public function ajax_assignRadiology(){
    $radResultModel = new RadResult;
    if($this->request->getMethod() == 'post'){
       if($radResultModel->save([
            'rad_id' => $this->request->getVar('rad_id'), 
            'file_id' => $this->request->getVar('file_id'), 
            'doctor' => $this->request->getVar('doctor')
        ])){
            echo json_encode(['success'=> true, 'message' => 'successful radiology assigned!']);
        }else{
           echo json_encode(['success'=> false, 'message' => 'failed to assign radiology!']);
       }
    }
   }

   public function ajax_assignedRadiology(){
    $radResultModel = new RadResult;
    if($this->request->getMethod() == 'post'){
        $file_id=$this->request->getVar('file_id');
        $start_date=$this->request->getVar('start_date');
        $end_date=$this->request->getVar('end_date');
   
        $data_table = new TablesIgniter();
        $data_table->setTable($radResultModel->getAssignedResult($file_id, $start_date, $end_date))
                   ->setDefaultOrder('id', 'DESC')
                 //   ->setSearch(['name'])
                   ->setOrder(['updated_at'])
                   ->setOutput([$radResultModel->radiologyDateFormat(), 'test_name', $radResultModel->formatPrice(), $radResultModel->status(), $radResultModel->actionButtons()]);
   
        return $data_table->getDatatable();
       }
   }

   public function ajax_labtestResults(){
    $assignedLabtestModel = new AssignedLabtestModel;
    if($this->request->getMethod() == 'post'){
        $file_id=$this->request->getVar('file_id');
        $start_date=$this->request->getVar('start_date');
        $end_date=$this->request->getVar('end_date');
   
        $data_table = new TablesIgniter();
        $data_table->setTable($assignedLabtestModel->getLabtestResult($file_id, $start_date, $end_date))
                   ->setDefaultOrder('id', 'DESC')
                 //   ->setSearch(['name'])
                   ->setOrder(['updated_at'])
                   ->setOutput(['name', 'result', 'ranges', 'unit', 'level', 'attachment',$assignedLabtestModel->labtestDateFormat(), $assignedLabtestModel->updateLabtestResult()]);
   
        return $data_table->getDatatable();
       }
   }

   public function ajax_getLabtestResult(){
    $labtestResult = new AssignedLabtestModel;
    if($this->request->getMethod() == 'post'){
       $labtest_id = $this->request->getVar('labtest_id');
       $result = $labtestResult->where('id', $labtest_id)->first();
       echo json_encode(['result' => $result ]);
    //    echo json_encode(['result' => $this->request->getVar('labtest_id') ]);
    }
   }

   //labtest result
   public function ajax_addLabTestResult(){
    $labtestResult = new AssignedLabtestModel;
    if($this->request->getMethod() == 'post'){
    //   $labtest_id = $this->request->getVar('labtest_id');
    //   $result = $labtestResult->('labtest_id', $labtest_id)->first();
      if($labtestResult->save($this->request->getVar())){
          echo json_encode(['success'=> true, 'message' => 'successful lab test result added!']);
      }
    }
   }

   public function ajax_radiologyResults(){
    $radResultModel = new RadResult;
    if($this->request->getMethod() == 'post'){
        $file_id=$this->request->getVar('file_id');
        $start_date=$this->request->getVar('start_date');
        $end_date=$this->request->getVar('end_date');
   
        $data_table = new TablesIgniter();
        $data_table->setTable($radResultModel->getRadiologyResults($file_id, $start_date, $end_date))
                   ->setDefaultOrder('id', 'DESC')
                 //   ->setSearch(['name'])
                   ->setOrder(['updated_at'])
                   ->setOutput(['test_name', 'result', 'ranges', 'unit', 'level', 'attachment',$radResultModel->radiologyDateFormat(), $radResultModel->updateRadResult()]);
   
        return $data_table->getDatatable();
       }
   }

   public function ajax_deleteAssignedRadiology(){
    $radResultModel = new RadResult;
    if($this->request->getMethod() == 'post'){
        if($radResultModel->where('id', $this->request->getVar('assignedRadiology'))->delete()){
            echo json_encode(['success'=> true, 'message' => 'successful deleted']);
        }else{
            echo json_encode(['success'=> false, 'message' => 'failed to delete assigned radiology!']);
        }
    }
   }

   public function ajax_assignExamination(){
      $generalExaminationModel = new GeneralExaminationModel;
      if($this->request->getMethod() == 'post'){
        $availableExamination = $generalExaminationModel->checkIfExaminationEntered($this->request->getVar('patient_file'), $this->request->getVar('start_treatment'), $this->request->getVar('end_treatment'));
        // echo json_encode(['success'=> true, 'message' => 'successful deleted']);
        $isEmpty = true;
        if(!empty($availableExamination)){
          $isEmpty = false;  
          $newExamination = $this->request->getVar();
          
          $newExamination->id = $availableExamination->id;
          if($generalExaminationModel->save($newExamination)){
            $this->ajax_Examination();
            // echo json_encode(['success'=> true, 'message' => 'updated!', 'availableExamination' => $newExamination]);  
          }
        //   echo json_encode(['availableExamination' => $availableExamination, 'empty_examination' => $isEmpty]);
        }else{
            if($generalExaminationModel->save($this->request->getVar())){
                $this->ajax_Examination();
                // echo json_encode(['success'=> true, 'message' => 'Examination saved!']);  
            }
        }
        
      }
   }

   public function ajax_Examination(){
    $generalExaminationModel = new GeneralExaminationModel;
    if($this->request->getMethod() == 'post'){
        $availableExamination = $generalExaminationModel->getExamination($this->request->getVar('patient_file'), $this->request->getVar('start_treatment'), $this->request->getVar('end_treatment'));
        echo json_encode($availableExamination);
    }
   }

}
