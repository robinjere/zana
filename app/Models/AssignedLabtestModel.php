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
    protected $allowedFields    = ['labtest_id', 'file_id', 'result', 'ranges','unit', 'level', 'attachment', 'price', 'confirmed_by', 'doctor', 'verified_by', 'printed', 'created_at', 'treatment_ended'];

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

    public function getAssignedLabtest($file_id, $start_date=null, $end_date=null){
        $builder = $this->db->table('assigned_labtests');
        $builder->select('assigned_labtests.id, assigned_labtests.updated_at, labtests.name, assigned_labtests.result, assigned_labtests.price, assigned_labtests.confirmed_by, assigned_labtests.doctor, assigned_labtests.printed');
        $builder->join('labtests', 'assigned_labtests.labtest_id = labtests.id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        if($start_date != null || $end_date != null){
            $builder->where('DATE(assigned_labtests.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        }
        $builder->where('assigned_labtests.file_id', $file_id);
        $builder->groupEnd();
       
        return $builder;
    }

    public function AssignedResultTable($file_id, $start_treatment=null, $end_treatment=null){
        $builder = $this->db->table('assigned_labtests');
        $builder->select('assigned_labtests.id, assigned_labtests.updated_at, labtests.name, assigned_labtests.result, assigned_labtests.ranges, assigned_labtests.unit, assigned_labtests.level, user.first_name, user.last_name');
        $builder->join('labtests', 'assigned_labtests.labtest_id = labtests.id');
        $builder->join('user', 'assigned_labtests.verified_by = user.id');
        $builder->groupStart();
        $builder->where('assigned_labtests.file_id', $file_id);
        if($start_treatment != null || $end_treatment != null){
            $builder->where('DATE(assigned_labtests.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_treatment)) .'" and "'. date('Y-m-d', strtotime($end_treatment)) .'"');
        }
        $builder->groupEnd();
       
        return $builder;
    }

    public function doctor(){
        return function($row){
            return '<span>'.$row['first_name']. ' '. $row['last_name'] . '</span>';;
        };
    }
    
    public function getAssignedResult($file_id, $start_treatment, $end_treatment){
        $builder = $this->db->table('assigned_labtests');
        $builder->select('assigned_labtests.id, assigned_labtests.updated_at, labtests.name, assigned_labtests.result, assigned_labtests.ranges, assigned_labtests.unit, assigned_labtests.level, user.first_name, user.last_name');
        $builder->join('labtests', 'assigned_labtests.labtest_id = labtests.id');
        $builder->join('user', 'assigned_labtests.verified_by = user.id');
        $builder->groupStart();
        $builder->where('assigned_labtests.file_id', $file_id);
        $builder->where('DATE(assigned_labtests.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_treatment)) .'" and "'. date('Y-m-d', strtotime($end_treatment)) .'"');
        $builder->groupEnd();
       
        return $builder->get()->getResult();
    }

    public function getLabtestVerified($start_date, $end_date){
        $builder = $this->db->table('assigned_labtests');
        $builder->select('patients.first_name as p_first_name, patients.sir_name as p_sir_name, assigned_labtests.id, assigned_labtests.updated_at, labtests.name, assigned_labtests.price, assigned_labtests.ranges, assigned_labtests.unit, assigned_labtests.level, user.first_name, user.last_name');
        $builder->join('labtests', 'assigned_labtests.labtest_id = labtests.id');
        $builder->join('user', 'assigned_labtests.verified_by = user.id');
        $builder->join('patients_file', 'assigned_labtests.file_id = patients_file.id');
        $builder->join('patients', 'patients_file.patient_id = patients.id');
        $builder->groupStart();
        // $builder->where('assigned_labtests.confirmed_by', $cashier);
        $builder->where('DATE(assigned_labtests.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        $builder->groupEnd();
       
        return $builder->get()->getResult();
    }

    

    public function getLabtestResult($file_id, $start_date, $end_date){
        $builder = $this->db->table('assigned_labtests');
        $builder->select('assigned_labtests.id, assigned_labtests.updated_at, labtests.name, assigned_labtests.result, assigned_labtests.ranges, assigned_labtests.unit, assigned_labtests.level, assigned_labtests.attachment, assigned_labtests.confirmed_by, assigned_labtests.printed');
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
            // return $row['price'];
        };
        return $column;
    }
    
    public function status(){
        return function($row){
            if($row['confirmed_by'] != 0){
                return '<span class="badge badge-sm bg-success"> paid </span>';
            }else{
                return '<span class="badge badge-sm bg-danger"> Not paid </span>';
            }
        };
    }
      
    public function updateLabtestResult(){
       return function ($row) {
         return $row['confirmed_by'] != 0 ? '<button data-bs-toggle="modal" data-bs-target="#addLabtestResult_" @click="getLabTestResult('.$row['id'].')" class="update-result badge badge-sm bg-success"> update result </button>': '';
       };
    }

    public function actionButtons(){
        return function($row){
            if(in_array(session()->get('role'), ['doctor', 'reception']) && $row['confirmed_by'] == 0 && !session()->has('phistory')){
                return '<button onclick="deleteAssignedLabtest('.$row['id'].')" class="badge badge-sm bg-danger"> delete </button>';
            }
            if(session()->get('role') == 'lab' && $row['confirmed_by'] != 0 && !session()->has('phistory') && $row['result'] == ''){
                return '<button data-bs-toggle="modal" data-bs-target="#addLabtestResult_" @click="getLabTestResult('.$row['id'].')" class="badge badge-sm bg-success"> add result </button>';
            }
            if(in_array(session()->get('role'), ['cashier']) && $row['printed'] == 0 && !session()->has('phistory')){
                    if($row['confirmed_by'] != 0){
                        return '<button @click="unconfirmPaymentLabTestResult('.$row['id'].')" class="badge badge-sm bg-warning"> UnConfirm </button>';
                    }else{
                        return '<button @click="confirmPaymentLabTestResult('.$row['id'].')" class="badge badge-sm bg-success"> Confirm Payment </button>';
                    }
            }
        };
    }

    public function Attachment(){
        return function($row){
          return $row['attachment'] != '' ? '<a class="badge bg-success" target="_blank" href="'.base_url('uploads/'.$row['attachment']).'">view </a>' : '';
        };
    }

    public function paidLabtest($labtestList){
        $builder = $this->db->table('assigned_labtests');
        $builder->select('assigned_labtests.id, assigned_labtests.updated_at, labtests.name, assigned_labtests.result, assigned_labtests.price, assigned_labtests.confirmed_by, assigned_labtests.doctor');
        $builder->join('labtests', 'assigned_labtests.labtest_id = labtests.id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        $builder->whereIn('assigned_labtests.id', $labtestList);
        $builder->groupEnd();
       
        return $builder->get()->getResult();
    }

    public function mark_printed_risit($labtestList){
        $builder = $this->db->table('assigned_labtests');
        $builder->whereIn('id', $labtestList);
        return $builder->update(['printed' => true ]);
    }

}
