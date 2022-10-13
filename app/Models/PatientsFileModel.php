<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientsFileModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'patients_file';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['file_no', 'patient_id', 'clinic', 'payment_method', 'start_treatment', 'end_treatment', 'status', 'patient_character', 'upadated_at'];

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

    public function patientFile(Int $file_id, String $character = ''){
       $builder = $this->db->table('patients_file');
       if($character === ''){
           $builder->select('patients_file.id, patients_file.file_no, patients_file.patient_id, patients_file.payment_method, patients_file.insuarance_no, patients_file.start_treatment, patients_file.end_treatment, patients_file.status, patients_file.patient_character,
           patients.first_name, patients.middle_name, patients.sir_name, patients.birth_date, patients.gender, clinics.name, clinics.consultation_fee');
        }else{
            $builder->select('patients_file.id, patients_file.file_no, patients_file.patient_id, patients_file.payment_method, patients_file.insuarance_no, patients_file.start_treatment, patients_file.end_treatment, patients_file.status, patients_file.patient_character,
            patients.first_name, patients.middle_name, patients.sir_name, patients.birth_date, patients.gender');
        }
      
       $builder->where('patients_file.id', $file_id);
       $builder->join('patients', 'patients_file.patient_id = patients.id');
       if($character === ''){
           $builder->join('clinics', 'patients_file.clinic = clinics.id');
       }
       return $builder->get()->getRow();
    }
}
