<?php

namespace App\Models;

use CodeIgniter\Model;

class ClinicalNoteModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'clinicalnotes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['file_id','note','doctor','created_at', 'updated_at', 'treatment_ended'];

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


    //clinical notes
    public function getClinicalNotes($file_id, $start_date, $end_date){
        $builder = $this->db->table('clinicalnotes');
        $builder->select('clinicalnotes.id, clinicalnotes.updated_at, clinicalnotes.note, user.first_name, user.last_name');
        $builder->orderBy('clinicalnotes.id', 'DESC');
        $builder->join('user', 'clinicalnotes.doctor = user.id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        $builder->where('DATE(clinicalnotes.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        $builder->where('clinicalnotes.file_id', $file_id);
        $builder->groupEnd();
        return $builder->get()->getResult();
    }

    
}
