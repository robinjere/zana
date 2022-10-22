<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignedDiagnosesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'assigneddiagnoses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['diagnoses_id','diagnoses_type','diagnoses_note', 'doctor', 'file_id', 'created_at','treatment_ended'];

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

  
    public function getAssignedDiagnoses(Int $file_id, $start_date, $end_date, String $diagnoses_type){

        $builder = $this->db->table('assigneddiagnoses');
        $builder->select('assigneddiagnoses.id, assigneddiagnoses.updated_at, assigneddiagnoses.diagnoses_type, assigneddiagnoses.diagnoses_note, diagnoses.diagnosis_code, diagnoses.diagnosis_description');
        $builder->join('diagnoses', 'diagnoses.id = assigneddiagnoses.diagnoses_id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        $builder->where('DATE(assigneddiagnoses.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        $builder->where('assigneddiagnoses.file_id', $file_id);
        $builder->where('assigneddiagnoses.diagnoses_type', $diagnoses_type);
        $builder->groupEnd();
        return $builder;
    }
    public function diagnosesDateFormat(){
        $column = function ($row){
            $date = date_create($row['updated_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }
    public function diagnoses(){
        $column = function ($row){
            return '<span class="badge bg-success badge-sm">'. $row['diagnosis_code'] .'</span>, 
              <span class="ml-2"> '.$row['diagnosis_description'] .'</span>';
        };
        return $column;
    }

    public function actionButtons(){
        return function($row){
            if(session()->get('role') == 'doctor'){
                return '<button onclick="deleteDiagnose('.$row['id'].',\''. $row['diagnoses_type'] .'\') "class="btn btn-danger btn-sm"> &#9587; </button>';
            }
        };
    }

}
