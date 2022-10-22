<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientHistoryModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'patient_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['file_id', 'start_treatment', 'end_treatment','status','payment_method','insuarance_no','pcharacter'];

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

    //getHistory
    public function getHistory($file, $start_treatment, $end_treatment){
        // echo $start_treatment;
        // echo $end_treatment;

        $builder = $this->db->table('patient_history');
        $builder->where('file_id', $file);
        $builder->where('DATE(start_treatment) >=', date('Y-m-d', strtotime($start_treatment))); 
        $builder->where('DATE(end_treatment) <=', date('Y-m-d', strtotime($end_treatment))); 
        return $builder->get()->getResult();
    }
}
