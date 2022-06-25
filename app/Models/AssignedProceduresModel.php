<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignedProceduresModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'assigned_procedures';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['file_id','procedure_id','diagnosis','doctor','file','procedure_note','amount','confirmed_by','created_at'];

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

    public function getAssignedProcedures(Int $file_id, $start_date, $end_date){
        $builder = $this->db->table('assigned_procedures');
        $builder->select('procedures.name, user.first_name, user.last_name, assigned_procedures.id, assigned_procedures.procedure_note, assigned_procedures.amount, assigned_procedures.confirmed_by, assigned_procedures.created_at');
        $builder->join('procedures', 'assigned_procedures.procedure_id = procedures.id');
        $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        $builder->where('DATE(assigned_procedures.created_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        $builder->where('assigned_procedures.file_id', $file_id);
        $builder->groupEnd();
        return $builder;
    }
    public function procedureDateFormat(){
        $column = function ($row){
            $date = date_create($row['created_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }

    public function procedureDoctor(){
        return function($row){
           return '<b>'. $row['first_name'] .', '. $row['last_name'] .'</b>';
        };
    }
    public function actionButtons(){
        return function($row){
            return '<button onclick="deleteProcedure('.$row['id'].')" class="badge badge-sm  bg-danger"> delete </button>';
        };
    }
    public function formatAmount(){
        $column = function($row){
            return number_format(floatval($row['amount'])) . '/=';
        };
        return $column;
    }
}
