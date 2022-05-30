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
    'gender', 'address', 'phone_no', 'next_kin_name', 'next_kin_relationship', 'next_kin_phone', 'user_id'];

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
}
