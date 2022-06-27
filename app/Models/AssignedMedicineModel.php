<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignedMedicineModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'assignedmedicines';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['dosage','frequency','route','days','qty','instruction','drug_id','file_id','doctor','payed', 'created_at'];

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

    public function getAssignedMedicine(Int $file_id, $start_date, $end_date){

            $builder = $this->db->table('assignedmedicines');
            $builder->select('assignedmedicines.id, assignedmedicines.created_at, items.name, items.selling_price, assignedmedicines.dosage, assignedmedicines.route,assignedmedicines.frequency, assignedmedicines.days, assignedmedicines.qty, assignedmedicines.instruction, assignedmedicines.payed');
            $builder->join('items', 'assignedmedicines.drug_id = items.id');
            // $builder->join('user', 'assigned_procedures.doctor = user.id');
            $builder->groupStart();
            $builder->where('DATE(assignedmedicines.created_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
            $builder->where('assignedmedicines.file_id', $file_id);
            $builder->groupEnd();
            return $builder;
    }
    public function medicineDateFormat(){
        $column = function ($row){
            $date = date_create($row['created_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }
    public function formatAmount(){
        $column = function($row){
            return number_format(floatval($row['selling_price'])) . '/=';
        };
        return $column;
    }

    public function actionButtons(){
        return function($row){
            return '<button onclick="deleteMedicine('.$row['id'].')" class="badge badge-sm  bg-danger"> delete </button>';
        };
    }
}
