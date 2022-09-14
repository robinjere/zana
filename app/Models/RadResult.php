<?php

namespace App\Models;

use CodeIgniter\Model;

class RadResult extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'rad_results';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['rad_id','result','ranges','unit','level','attachment','paid','file_id','doctor','updated_at'];

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

    public function getAssignedResult($file_id, $start_date, $end_date){
        $builder = $this->db->table('rad_results');
        $builder->select('rad_results.id, rad_results.updated_at, rad_results.paid, rad_investigation.test_name, rad_investigation.price');
        $builder->join('rad_investigation', 'rad_results.rad_id = rad_investigation.id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        $builder->where('DATE(rad_results.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        $builder->where('rad_results.file_id', $file_id);
        $builder->groupEnd();
       
        return $builder;
    }

    public function getRadiologyResults($file_id, $start_date, $end_date){
        $builder = $this->db->table('rad_results');
        $builder->select('rad_results.id, rad_results.updated_at, rad_investigation.test_name, rad_results.result, rad_results.ranges, rad_results.unit, rad_results.level, rad_results.attachment');
        $builder->join('rad_investigation', 'rad_investigation.id = rad_results.rad_id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        $builder->where('DATE(rad_results.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        $builder->where('rad_results.file_id', $file_id);
        $builder->groupEnd();
       
        return $builder;
    }

    public function radiologyDateFormat(){
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
            return $row['paid'] ? '<span class="badge badge-sm bg-success"> Paid </span>' : '<span class="badge badge-sm bg-danger"> notPaid </span>';
        };
    }
    public function actionButtons(){
        return function($row){
            if(in_array(strtolower(session()->get('role')),['doctor','reception'])){
                return '<button onclick="deleteAssignedRadiology('.$row['id'].')" class="badge badge-sm  bg-danger"> delete </button>';
            }
        };
    }
    public function updateRadResult(){
        return function($row){
            if(strtolower(session()->get('role')) == 'lab'){
                return '<button onclick="updateRadResult('.$row['id'].')" class="badge badge-sm  bg-success"> Update </button>';
            }
        };
    }
}
