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
    protected $allowedFields    = ['rad_id','result','ranges','unit','level','attachment','confirmed_by','file_id','doctor','printed','updated_at'];

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

    public function getAssignedResult($file_id, $start_date=null, $end_date=null){
        $builder = $this->db->table('rad_results');
        $builder->select('rad_results.id, rad_results.updated_at, rad_results.confirmed_by, rad_results.printed, rad_investigation.test_name, rad_investigation.price');
        $builder->join('rad_investigation', 'rad_results.rad_id = rad_investigation.id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        if($start_date != null && $end_date != null){
            $builder->where('DATE(rad_results.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        }
        $builder->where('rad_results.file_id', $file_id);
        $builder->groupEnd();
       
        return $builder;
    }

    public function getRadiologyResults($file_id, $start_date=null, $end_date=null){
        $builder = $this->db->table('rad_results');
        $builder->select('rad_results.id, rad_results.updated_at, rad_investigation.test_name, rad_results.result, rad_results.ranges, rad_results.unit, rad_results.level, rad_results.attachment, rad_results.printed, user.first_name, user.last_name ');
        $builder->join('rad_investigation', 'rad_investigation.id = rad_results.rad_id');
        $builder->join('user', 'rad_results.doctor = user.id');
        $builder->groupStart();
        if($start_date != null && $end_date != null){
            $builder->where('DATE(rad_results.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        }
        $builder->where('rad_results.file_id', $file_id);
        $builder->where('rad_results.result !=', '');
        $builder->groupEnd();
       
        return $builder;
    }

    public function attachment(){
        return function($row){
            if($row['attachment'] != ''){
                return '<a href="#">attachment</a>';
            }
        };
    }
    public function doctor(){
        return function($row){
            return '<span>'.$row['first_name']. ' ' . $row['last_name'] . '</span>';
        };
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
            return $row['confirmed_by'] != 0 ? '<span class="badge badge-sm bg-success"> Paid </span>' : '<span class="badge badge-sm bg-danger"> notPaid </span>';
        };
    }
    public function actionButtons(){
        return function($row){
            if(in_array(strtolower(session()->get('role')),['doctor','reception']) && !session()->has('phistory')){
                return '<button onclick="deleteAssignedRadiology('.$row['id'].')" class="badge badge-sm  bg-danger"> delete </button>';
            }

            if(in_array(strtolower(session()->get('role')),['radiology']) && $row['confirmed_by'] != 0 && !session()->has('phistory')){
                return '<button data-bs-toggle="modal" data-bs-target="#addRadiologyResult_" @click="getRadiology('.$row['id'].')" class="badge badge-sm  bg-success"> Add result </button>';
            }

            if(in_array(session()->get('role'), ['cashier']) && $row['printed'] == 0 && !session()->has('phistory')){
                if($row['confirmed_by'] != 0){
                    return '<button @click="unconfirmPaymentRadiology('.$row['id'].')" class="badge badge-sm bg-warning"> UnConfirm </button>';
                }else{
                    return '<button @click="confirmPaymentRadiology('.$row['id'].')" class="badge badge-sm bg-success"> Confirm Payment </button>';
                }
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

    public function paidRadiology($labtestList){
        $builder = $this->db->table('rad_results');
        $builder->select('rad_results.id, rad_results.updated_at, rad_investigation.test_name, rad_results.result, rad_investigation.price, rad_results.confirmed_by, rad_results.doctor');
        $builder->join('rad_investigation', 'rad_investigation.id = rad_results.rad_id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        $builder->whereIn('rad_results.id', $labtestList);
        $builder->groupEnd();
       
        return $builder->get()->getResult();
    }

    public function mark_printed_risit($labtestList){
        $builder = $this->db->table('rad_results');
        $builder->whereIn('id', $labtestList);
        return $builder->update(['printed' => true ]);
    }
}
