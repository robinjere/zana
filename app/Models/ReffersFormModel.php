<?php

namespace App\Models;

use CodeIgniter\Model;

class ReffersFormModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'reffers_form';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hospital_reffers', 'patient', 'reasons_reffers', 'department', 'history', 'observation','doctor'];

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

    public function is_reffers_present($patient_id, $start_treament, $end_treatment){
       $builder = $this->db->table('reffers_form');
       $builder->where('patient', $patient_id);
       $builder->where('DATE(updated_at) >=', date('Y-m-d', strtotime($start_treament)));
       if(strtotime($end_treatment) <= strtotime(date("Y-m-d"))){
           $builder->where('DATE(updated_at) <=', date('Y-m-d', strtotime($end_treatment)));
       }
       return $builder->get()->getRow();
    }
}
