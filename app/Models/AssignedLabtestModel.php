<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignedLabtestModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'assigned_labtests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['labtest_id', 'file_id', 'memo', 'price', 'confirmed_by', 'doctor', 'created_at'];

    // Dates
    protected $useTimestamps = false;
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

    public function getAssignedLabtest($file_id, $start_date, $end_date){
        $builder = $this->db->table('assigned_labtests');
        $builder->select('assigned_labtests.id, assigned_labtests.updated_at, labtests.name, assigned_labtests.memo, assigned_labtests.price, assigned_labtests.confirmed_by, assigned_labtests.doctor');
        $builder->join('labtests', 'assigned_labtests.labtest_id = labtests.id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        $builder->where('DATE(assigned_labtests.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        $builder->where('assigned_labtests.file_id', $file_id);
        $builder->groupEnd();
       
        return $builder;
    }

    public function labtestDateFormat(){
        $column = function ($row){
            $date = date_create($row['updated_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }
    public function formatPrice(){
        $column = function($row){
            return number_format(floatval($row['price'])) . '/=';
        };
        return $column;
    }
    
    public function status(){
        return function($row){
           return '<span class="badge badge-sm bg-danger"> Not paid </span>';
        };
    }
    public function actionButtons(){
        return function($row){
            return '<button onclick="deleteAssignedLabtest('.$row['id'].')" class="badge badge-sm  bg-danger"> delete </button>';
        };
    }
}
