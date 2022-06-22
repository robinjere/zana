<?php
 namespace App\Libraries;

class PatientPanel{
   public function PatientNavigation(){
       return view('patient/patient_navigation');
   }
   public function SearchPatient(){
       return view('patient/search_patient');
   }

   public function PatientFileNav(){
       return view('patientfile/filenav');
   }

   public function ClinicalNote(array $patientFile){
       return view('patientfile/clinicalnote', ['patient_file' => $patientFile]);
   }
}
