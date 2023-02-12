<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PatientsFileModel;
use App\Models\PatientHistoryModel;
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
use App\Models\FertilityAssessmentModel;
use App\Models\PatientModel;
use App\Models\ClinicModel;
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

        // print_r($consultation);
        // exit;

        $data = [];
        $consultationModel->save($consultation);
        $patientsFileModel->save(['id' => $file_id, 'start_treatment' => date('Y/m/d'), 'end_treatment' => '', 'status' => 'inTreatment']);
        //load patient file
        // $p= $this::patient_file($file_id);
        // print_r($p);
        return $this->attend($file_id);
    }

    public function attend($file_id){
        //remove session -> phistory
        session()->remove('phistory');

       $data['patient_file']  = $this::patient_file($file_id);
       if($data['patient_file']->status == 'finishTreatment'){
         return redirect()->to('patient/search');
       }  

    //    print_r($data['patient_file']);
    //    exit;
       return view('patientfile/file', $data);
    }

    public function viewHistory(){
        $clinicalModel = new ClinicModel;
        if($this->request->getMethod() == 'post'){
            // echo '<pre>';
            // print_r($this->request->getVar());
            // echo '</pre>';
            // exit;
            $patient_file  = $this::patient_file($this->request->getVar('file_id'));
            $patient_file->start_treatment = $this->request->getVar('start_treatment'); 
            $patient_file->end_treatment = $this->request->getVar('end_treatment');
            $patient_file->payment_method = $this->request->getVar('payment_method');
            // print_r($patient_file);
            
            $clinic = $clinicalModel->where('id', $this->request->getVar('clinic'))->first();
            // $patient_file->end_treatment = $this->request->getVar('end_treatment');
            // echo '<pre> --- clinic ---';
            // print_r($clinic);
            // echo 'requested clinical ide->'.$this->request->getVar('clinic');
            // echo '</pre>';
            // exit;
            if(!empty($clinic)){
                $patient_file->name = $clinic['name'];
            }

            $patient_file->consultation_fee = $this->request->getVar('consultation_fee');
            $data['patient_file'] = $patient_file;

            session()->set(['phistory' => true ]);
            
            $data['history'] = 'Patient history';
           return view('patientfile/file', $data);
        }
    }

    public function history($file_id){
        helper('form');
        $data['patient_file'] = $this::patient_file($file_id);
        $patientHistoryModel = new PatientHistoryModel;

        if($this->request->getMethod() == 'post'){
            //TODO... 
            //1. find history by patient_id
            //2. find history by start_treatment 
            //3. find history by end_treatment 
            $patientHistory = $patientHistoryModel->getHistory($file_id, $this->request->getVar('start_treatment'), $this->request->getVar('end_treatment'));
            $data['patient_history'] = $patientHistory;
            $data['start'] = $this->request->getVar('start_treatment');
            $data['end'] = $this->request->getVar('end_treatment');
        }
        return view('patient/filter_patient_history', $data);
    }

    protected function patient_file(Int $file_id){
        $patientsFileModel = new PatientsFileModel;
        
        // $data['patient_file'] = $patientsFileModel->where('id', $file_id)->first();
        $_patient = $patientsFileModel->where('id', $file_id)->first();
        $patient_file = '';
        
        if($_patient['patient_character'] === 'outsider'){
            $patient_file = $patientsFileModel->patientFile($file_id, 'outsider');
        }else{
            $patient_file = $patientsFileModel->patientFile($file_id, '');
        }
        // print_r($_patient); exit;
        return $patient_file;
       
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

    public function finishTreatment($patientFile){
        $patientsFileModel = new PatientsFileModel;
        $patientHistoryModel = new PatientHistoryModel;
        $clinicModel = new ClinicModel;
        // $date = date_create(now());
        // $date = date_format($date, 'd/m/Y');
            $patient_file = [
                'id' => $patientFile,
                'end_treatment' => date('Y-m-d'),
                'status' => 'finishTreatment'
            ];
            $phistory = $patientsFileModel->where('id', $patientFile)->first();
            $consultation_fee = $clinicModel->where('id', $phistory['clinic'])->first();
            if(!empty($consultation_fee)){
                // print_r($consultation_fee['consultation_fee']);
                // exit;
                $consultation_fee = $consultation_fee['consultation_fee'];
            }else{
                if($phistory['patient_character'] == 'outsider'){
                    $consultation_fee = 0;
                }
            }
            $createHistory = [
                'file_id' => $patientFile, 
                'start_treatment' => $phistory['start_treatment'],
                'end_treatment' => date('Y-m-d'),
                'status' => 'finishTreatment',
                'payment_method' => $phistory['payment_method'],
                'insuarance_no' => $phistory['insuarance_no'],
                'pcharacter' => $phistory['patient_character'],
                'clinic' => $phistory['clinic'],
                'consultation_fee' => $consultation_fee
            ];

            // print_r($createHistory);
            // exit;
        //save patient history first
        $patientHistoryModel->save($createHistory);
        $patientsFileModel->save($patient_file);

        //clear all treatment
        $this::clearTreatment($patientFile);

        return redirect()->to('/patient/search/')->with('success', 'patient finished!');
    }

    protected function clearTreatment($file_id){
        $assignedDiagnosesModel = new AssignedDiagnosesModel;
        $assignedProceduresModel = new AssignedProceduresModel;
        $assignedLabtestModel = new AssignedLabtestModel;
        $assignedMedicineModel = new AssignedMedicineModel;
        $generalExaminationModel = new GeneralExaminationModel;
        $clinicalNoteModel = new ClinicalNoteModel;

        $assignedDiagnosesModel->where('file_id', $file_id)->set(['treatment_ended' => true])->update();
        $assignedProceduresModel->where('file_id', $file_id)->set(['treatment_ended' => true])->update();
        $assignedLabtestModel->where('file_id', $file_id)->set(['treatment_ended' => true])->update();
        $assignedMedicineModel->where('file_id', $file_id)->set(['treatment_ended' => true])->update();
        $generalExaminationModel->where('patient_file', $file_id)->set(['treatment_ended' => true])->update();
        $clinicalNoteModel->where('file_id', $file_id)->set(['treatment_ended' => true])->update();
    }

    public function ajax_assignedprocedure(){
        $assignedProceduresModel =  new AssignedProceduresModel;
        if($this->request->getMethod() == 'post'){

           $file_id=$this->request->getVar('file_id');
           $start_date=$this->request->getVar('start_date');
           $end_date=$this->request->getVar('end_date');

        // echo json_encode(['file_id' => $file_id, 'start_date' =>  $start_date, 'end_date' => $end_date]);
        // exit;

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
       $itemModel = new ItemModel;
       if($this->request->getMethod() == 'post'){

        //TODO :: detuct qty of drugs in store.
        $qty = $this->request->getVar('qty');
        $drug_id = $this->request->getVar('drug_id');

        $_item = $itemModel->first($drug_id);
        $new_qty = $_item['qty'] - $qty;

        $itemModel->save(['id' => $drug_id, 'qty' => $new_qty]);

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
                   ->setOrder(['created_at', 'name', 'dosage','route','frequency','days','qty','instruction','paid','selling_price'])
                   ->setOutput([$assignedMedicineModel->medicineDateFormat(), 'name', 'dosage','route','frequency','days','qty','instruction',$assignedMedicineModel->isPaid(), $assignedMedicineModel->formatAmount(), $assignedMedicineModel->actionButtons()]);

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

   //medicine
   public function confirmPaymentMedicine(){
    $assignedMedicine = new AssignedMedicineModel;
    if($this->request->getMethod() == 'post'){
        
        if($assignedMedicine->save($this->request->getVar())){
            echo json_encode(['success'=> true, 'message' => 'payment confirmed!']);
        }else{
            echo json_encode(['success'=> false, 'message' => 'fail to confirm payment!']);
        }
    }
   }

   public function takenMedicine(){
    $assignedMedicine = new AssignedMedicineModel;
    if($this->request->getMethod() == 'post'){
        if($assignedMedicine->save($this->request->getVar())){
            echo json_encode(['success'=> true, 'message' => 'medicine taken!']);
        }else{
            echo json_encode(['success'=> false, 'message' => 'medicine not taken!']);
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

   //confirm and unconfirm procedures..
   public function confirmPaymentProcedure(){
    $assignedProceduresModel = new AssignedProceduresModel;
    if($this->request->getMethod() == 'post'){
        if($assignedProceduresModel->save($this->request->getVar())){
            echo json_encode(['success'=> true, 'message' => 'payment confirmed!']);
        }else{
            echo json_encode(['success'=> false, 'message' => 'fail to confirm payment!']);
        }
    }
   }
   
   public function unconfirmPaymentProcedure(){
    $assignedProceduresModel = new AssignedProceduresModel;
    if($this->request->getMethod() == 'post'){
        if($assignedProceduresModel->save($this->request->getVar())){
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

   public function FertilityAssessment(){
    $patientModel = new PatientModel;
    $data = [];
    
    $store = new StoreController;
    $data['clinic_contacts'] = $store->get_clinic_info();

    if($this->request->getMethod() == 'post'){
          $data['patientFile'] = $this->request->getVar();
          $data['patient'] = $patientModel->where('id', $this->request->getVar('patient_id'))->first();
          $data['pageTitle'] = 'fertility-assessment';
          return view('patientfile/fertility_assessment', $data);
     }

     return  redirect()->to('patient/search');

    // print_r($data['patientFile']);    
   }

   public function ajax_addFertility(){
    if($this->request->getMethod() == 'post'){
        $fertilityAssessmentModel = new FertilityAssessmentModel;
        //check where the fertility data is present according to date range..
        $start_date = $this->request->getVar('start_treatment');
        $end_date = $this->request->getVar('end_treatment');
        $patient_id = $this->request->getVar('patient_id');
        $fertility_data = $this->request->getVar('fertility_data');
     
        $_fertility = $fertilityAssessmentModel->check_fertility_data($patient_id, $start_date, $end_date);
        $fertility_data->patient_id = $patient_id;
        if(!empty($_fertility)){
            $fertility_data->id = $_fertility->id;
            $fertility_data->user_id = session()->get('id');
            $fertilityAssessmentModel->save($fertility_data);
        }else{
            $fertility_data->user_id = session()->get('id');
            $fertilityAssessmentModel->save($fertility_data);
        }
        // print_r($fertility_data);
        
        // echo json_encode($this->request->getVar());
        // $clinicalNoteModel = new ClinicalNoteModel;
        // if($clinicalNoteModel->save($this->request->getVar())){
        //     echo json_encode(['success' => true, 'message' => 'clinical note added!']);
        // }else{
        //     echo json_encode(['success' => false, 'message' => 'Failed to add clinical!']);
        // }           
    }
}

public function ajax_getFertility(){
    if($this->request->getMethod() == 'post'){
        $fertilityAssessmentModel = new FertilityAssessmentModel;
        //check where the fertility data is present according to date range..
        $start_date = $this->request->getVar('start_treatment');
        $end_date = $this->request->getVar('end_treatment');
        $patient_id = $this->request->getVar('patient_id');
        $_fertility = $fertilityAssessmentModel->check_fertility_data($patient_id, $start_date, $end_date);
        echo json_encode($_fertility);
    }
}

   //print lab result
   public function labresult(){
    $assignedLabtestModel = new AssignedLabtestModel;

       if( $this->request->getMethod() == 'post'){ 
        $file_id = $this->request->getVar('file_id');
        $start_treatment = $this->request->getVar('start_treatment');
        $end_treatment = $this->request->getVar('end_treatment');
        $_result = $assignedLabtestModel->getAssignedResult($file_id, $start_treatment, $end_treatment);
        // echo '<pre>';
        // print_r($_result);
        // echo '</pre>';
        // exit;
        
        $data = [
          'labresult' => $_result,
          'file_no' => $this->request->getVar('file_no'),
          'full_name' =>  $this->request->getVar('fullname'),
          'pageTitle' => 'Lab result'
        ];
        return view('risit/labtestResult', $data);
       }

   }

    //----  SEND PATIENT TO WARD ---//
    public function sendToWard($patient_id){

        $patientFileModel = new PatientsFileModel;
        $patient_f  = $patientFileModel->where('patient_id',$patient_id)->first();
        // $patient_f['patient_character'] =  'inpatient';
        
        // echo 'patient tobe edited';
        // print_r($patient_f);
        // exit;

        $patientFileModel->save(['id' => $patient_id, 'patient_character' => 'inpatient']);

        return redirect()->to('/patientfile/attend/'.$patient_id)->with('success', 'patient sent to ward');

    }

}
