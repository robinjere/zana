<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\PatientsFileModel;

class PatientModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'patients';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['first_name', 'middle_name', 'sir_name', 'birth_date', 
    'gender', 'address', 'nationality', 'email', 'phone_no', 'next_kin_name', 'next_kin_relationship', 'next_kin_phone', 'pcharacter', 'user_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // protected function generate_file(array $data){
    //     $patients_file_model = new PatientsFileModel;
    //     $p_id = $this->getInsertID();
    //     try {
    //         $patients_file_model->save(['patient_id' => $p_id, 'file_no' => 'MRNO/'.date('Y').'/'.$p_id]);
    //     } catch (\Exception $e) {
    //         echo $e->getMessage();
    //     }
    // }

    public function searchPatient(String $filter, String $searchterm){
        $builder = $this->db->table('patients');
        $builder->select('patients.id,  patients.first_name, patients.middle_name, patients.sir_name, patients_file.id as file_id, patients_file.patient_id, patients_file.file_no, patients_file.payment_method, patients_file.start_treatment, patients_file.end_treatment, patients_file.status, patients_file.clinic, clinics.name, patients_file.patient_character');
        if($filter == 'name'){
            //check searchterm if contain space
            // $searchterm = explode(' ', $searchterm);
            
            // $firstname = '';
            // $middlename = '';
            // $lastname = '';

            // switch (count($searchterm)) {
            //     case 1:
            //         $firstname = strval($searchterm[0]);
            //         break;
                
            //     case 2:
            //         $middlename = strval($searchterm[1]);
            //         break;
                
            //     case 3:
            //         $lastname = strval($searchterm[2]);
            //         break;
                
            //     default:
            //         # code...
            //         break;
            // }
            
            // $builder->like('patients.first_name', $firstname, 'before');
            // if($middlename !== ''){
            //     $builder->orLike('patients.middle_name', $middlename, 'before');
            // }
            // if($lastname !== ''){
            //     $builder->orLike('patients.sir_name', $lastname, 'before');
            // }

            $searchterm = trim($searchterm);
            $searchterm = strtolower($searchterm);

            $builder->like('patients.first_name', $searchterm, 'after');
            $builder->orLike('patients.middle_name', $searchterm, 'after');
            $builder->orLike('patients.sir_name', $searchterm, 'after');

        }elseif ($filter == 'file_no') {

            $searchterm =ltrim($searchterm , '0');
            // echo 'after ltrm';
            // print_r($searchterm);

            $builder->like('patients_file.file_no', $searchterm,'before');
            $builder->orLike('patients.phone_no', $searchterm,'before');
        }
        $builder->join('patients_file', 'patients.id = patients_file.patient_id');
        $builder->join('clinics', 'patients_file.clinic = clinics.id');
     
        return $builder->get()->getResult();
    }

    public function searchPatientWithNoClinic(String $filter, String $searchterm){
        $builder = $this->db->table('patients');
        $builder->select('patients.id,  patients.first_name, patients.middle_name, patients.sir_name, patients_file.id as file_id, patients_file.patient_id, patients_file.file_no, patients_file.payment_method, patients_file.start_treatment, patients_file.end_treatment, patients_file.status, patients_file.clinic, patients_file.patient_character');
        if($filter == 'name'){
            //check searchterm if contain space
            // $searchterm = explode(' ', $searchterm);
            
            // $firstname = '';
            // $middlename = '';
            // $lastname = '';

            // switch (count($searchterm)) {
            //     case 1:
            //         $firstname = strval($searchterm[0]);
            //         break;
                
            //     case 2:
            //         $middlename = strval($searchterm[1]);
            //         break;
                
            //     case 3:
            //         $lastname = strval($searchterm[2]);
            //         break;
                
            //     default:
            //         # code...
            //         break;
            // }
            
            // $builder->like('patients.first_name', $firstname, 'before');
            // if($middlename !== ''){
            //     $builder->orLike('patients.middle_name', $middlename, 'before');
            // }
            // if($lastname !== ''){
            //     $builder->orLike('patients.sir_name', $lastname, 'before');
            // }

            $searchterm = trim($searchterm);
            $searchterm = strtolower($searchterm);

            $builder->like('patients.first_name', $searchterm, 'after');
            $builder->orLike('patients.middle_name', $searchterm, 'after');
            $builder->orLike('patients.sir_name', $searchterm, 'after');

        }elseif ($filter == 'file_no') {

            $searchterm =ltrim($searchterm , '0');
            // echo 'after ltrm';
            // print_r($searchterm);

            $builder->like('patients_file.file_no', $searchterm,'before');
            $builder->orLike('patients.phone_no', $searchterm,'before');
        }
        $builder->join('patients_file', 'patients.id = patients_file.patient_id');
        // $builder->join('clinics', 'patients_file.clinic = clinics.id');
     
        return $builder->get()->getResult();
    }

    public function searchPatientById(Int $patient_id){
        $builder = $this->db->table('patients');
        $builder->select('patients.id,  patients.first_name, patients.middle_name, patients.sir_name, patients.birth_date, patients.address, patients.phone_no, patients.next_kin_name, patients.next_kin_phone, patients.sir_name, patients_file.id as file_id, patients_file.patient_id, patients_file.clinic, patients_file.file_no, patients_file.payment_method, patients_file.start_treatment, patients_file.end_treatment, patients_file.status, clinics.name, patients_file.patient_character');
        $builder->where('patients.id', $patient_id);
        $builder->join('patients_file', 'patients.id = patients_file.patient_id');
        $builder->join('clinics', 'patients_file.clinic = clinics.id');
     
        return $builder->get()->getRow();
    }
    public function searchPatientByIdWithNoClinic(Int $patient_id){
        $builder = $this->db->table('patients');
        $builder->select('patients.id,  patients.first_name, patients.middle_name, patients.sir_name, patients.birth_date, patients.address, patients.phone_no, patients.next_kin_name, patients.next_kin_phone, patients.sir_name, patients_file.id as file_id, patients_file.patient_id, patients_file.clinic, patients_file.file_no, patients_file.payment_method, patients_file.start_treatment, patients_file.end_treatment, patients_file.status, patients_file.patient_character');
        $builder->where('patients.id', $patient_id);
        $builder->join('patients_file', 'patients.id = patients_file.patient_id');
        // $builder->join('clinics', 'patients_file.clinic = clinics.id');
     
        return $builder->get()->getRow();
    }
}
