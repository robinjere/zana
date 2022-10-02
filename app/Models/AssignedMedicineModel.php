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
    protected $allowedFields    = ['dosage','frequency','route','days','qty','instruction','drug_id','file_id','doctor','confirmed_by', 'created_at'];

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
            $builder->select('assignedmedicines.id, assignedmedicines.created_at, items.name, items.selling_price, assignedmedicines.dosage, assignedmedicines.route,assignedmedicines.frequency, assignedmedicines.days, assignedmedicines.qty, assignedmedicines.instruction, assignedmedicines.confirmed_by, assignedmedicines.printed');
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

    public function isPaid(){
        return function ($row){
            return $row['confirmed_by'] == 0 ? 'not paid' : 'paid';
        };
    }

    public function actionButtons(){
        return function($row){
            if(session()->get('role') == 'doctor' && $row['confirmed_by'] == 0){
                return '<button onclick="deleteMedicine('.$row['id'].')" class="badge badge-sm  bg-danger"> delete </button>';
            }
            if(in_array(session()->get('role'), ['cashier']) && $row['printed'] == 0){
                if($row['confirmed_by'] != 0){
                    return '<button @click="unconfirmPaymentMedicine('.$row['id'].')" class="badge badge-sm bg-warning"> UnConfirm </button>';
                }else{
                    return '<button @click="confirmPaymentMedicine('.$row['id'].')" class="badge badge-sm bg-success"> Confirm Payment </button>';
                }
            }
        };
    }

    
    public function paidMedicine($medicineList){
        $builder = $this->db->table('assignedmedicines');
        $builder->select('assignedmedicines.id, assignedmedicines.updated_at, items.name, assignedmedicines.dosage, assignedmedicines.qty, assignedmedicines.instruction, items.selling_price, assignedmedicines.confirmed_by');
        $builder->join('items', 'assignedmedicines.drug_id = items.id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        $builder->whereIn('assignedmedicines.id', $medicineList);
        $builder->groupEnd();
       
        return $builder->get()->getResult();
    }

    public function mark_printed_risit($medicineList){
        $builder = $this->db->table('assignedmedicines');
        $builder->whereIn('id', $medicineList);
        return $builder->update(['printed' => true ]);
    }
}
