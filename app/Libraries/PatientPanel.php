<?php
 namespace App\Libraries;

class PatientPanel{
   public function PatientNavigation(){
       return view('patient/patient_navigation');
   }
   public function SearchPatient(){
       return view('patient/search_patient');
   }

   public function PatientFileTopMenu(array $patientFile){
      return view('patientfile/topMenu', $patientFile);
   }

   public function PatientFileNav(){
       return view('patientfile/filenav');
   }

   public function ClinicalNote(array $patientFile){
       return view('patientfile/clinicalnote', ['patient_file' => $patientFile]);
   }
   public function Procedures(array $patientFile){
       return view('patientfile/procedure', ['patient_file'=> $patientFile]);
   }
   public function Medicine(array $patientFile){
       return view('patientfile/medicine', ['patient_file'=> $patientFile]);
   }
   public function Labtest(array $patientFile){
       return view('patientfile/labtest', ['patient_file'=> $patientFile]);
   }
   public function Radiology(array $patientFile){
       return view('patientfile/radiology', ['patient_file'=> $patientFile]);
   }
   public function Diagnoses(array $patientFile){
       return view('patientfile/diagnosis', ['patient_file'=> $patientFile]);
   }
   public function GeneralExamination(array $patientFile){
       return view('patientfile/generalExamination', ['patient_file'=> $patientFile]);
   }
   
}
