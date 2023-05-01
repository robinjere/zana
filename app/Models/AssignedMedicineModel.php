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
    protected $allowedFields    = ['dosage','frequency','route','days','qty','instruction','drug_id','file_id','doctor','confirmed_by', 'taken', 'created_at','treatment_ended'];

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

    public function getAssignedMedicine(Int $file_id, $start_date=null, $end_date=null){

            $builder = $this->db->table('assignedmedicines');
            $builder->select('assignedmedicines.id, assignedmedicines.updated_at, assignedmedicines.taken, items.name, items.selling_price, assignedmedicines.dosage, assignedmedicines.route,assignedmedicines.frequency, assignedmedicines.days, assignedmedicines.qty, assignedmedicines.instruction, assignedmedicines.confirmed_by, assignedmedicines.printed');
            $builder->join('items', 'assignedmedicines.drug_id = items.id');
            // $builder->join('user', 'assigned_procedures.doctor = user.id');
            $builder->groupStart();
            if($start_date != null || $end_date != null){
                $builder->where('DATE(assignedmedicines.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
            }
            if(session()->get('clinic') && session()->get('phistory') != true){
                $builder->where('clinic_doctors.clinic_id', session()->get('clinic'));
                $builder->join('user', 'assignedmedicines.doctor = user.id');
                $builder->join('clinic_doctors', 'user.id = clinic_doctors.user_id');
            }
            $builder->where('assignedmedicines.file_id', $file_id);
            $builder->groupEnd();
            return $builder;
    }
    public function medicineDateFormat(){
        $column = function ($row){
            $date = date_create($row['updated_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }
    public function formatAmount(){
        $column = function($row){
            // if(!session()->get('phistory')){
                return number_format(floatval($row['qty']*$row['selling_price'])) . '/=';
            // }
            // return '';
        };
        return $column;
    }

    public function isPaid(){
        return function ($row){
            // if(!session()->get('phistory')){
                return $row['confirmed_by'] == 0 ? '<span class="badge bg-success badge-sucesss"> not paid </span>' : '<span class="badge bg-success badge-sucesss" > paid </span> ';
            // }
            // return '';
        };
    }

    public function actionButtons(){
        return function($row){
            if(session()->get('role') == 'doctor' && $row['confirmed_by'] == 0 && !session()->has('phistory')){
                return '<button onclick="deleteMedicine('.$row['id'].')" class="badge badge-sm  bg-danger"> delete </button>';
            }
            if(in_array(session()->get('role'), ['pharmacy', 'doctor']) &&  $row['confirmed_by'] != 0 ){
                $disabled = session()->has('phistory')? "disabled" : "" ;
                if($row['taken'] == 0 ){
                    return '<button '.$disabled.' @click="taken('.$row['id'].')" class="badge badge-sm bg-danger"> not taken </button>';
                }else{
                    return '<button '.$disabled.' @click="nottaken('.$row['id'].')" class="badge badge-sm bg-success"> taken </button>';
                }
            }
            if(in_array(session()->get('role'), ['cashier']) && $row['printed'] == 0 && !session()->has('phistory')){
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

    public function medicineByDoctor($doctor = '', $start_date="", $end_date=""){
        $builder = $this->db->table('assignedmedicines');
        $builder->select('user.first_name as doctor_first_name, user.last_name as doctor_last_name, patients.first_name, patients.middle_name, patients.sir_name, patients.phone_no, patients.address, assignedmedicines.id, assignedmedicines.updated_at, assignedmedicines.qty, assignedmedicines.taken, patients_file.file_no, items.name, items.selling_price');
        $builder->join('items', 'assignedmedicines.drug_id = items.id');
        $builder->join('patients_file', 'assignedmedicines.file_id = patients_file.id');
        $builder->join('patients', 'patients_file.patient_id = patients.id');
        $builder->join('user', 'assignedmedicines.doctor = user.id');
        $builder->groupStart();
        // $builder->where('assignedmedicines.taken', 1);
        $builder->where('assignedmedicines.confirmed_by !=', 0);
        if(!empty($doctor)){
            $builder->where('assignedmedicines.doctor', $doctor);
        }
        $builder->where('DATE(assignedmedicines.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        // $builder->where('assignedmedicines.file_id', $file_id);
        $builder->groupEnd();
        return $builder->get()->getResult(); 
    }

    public function getPaidAssignedMedicine(Int $cashier, $start_date, $end_date){

        $builder = $this->db->table('assignedmedicines');
        $builder->select('assignedmedicines.id, assignedmedicines.updated_at, assignedmedicines.taken, items.name, items.selling_price, assignedmedicines.dosage, assignedmedicines.route,assignedmedicines.frequency, assignedmedicines.days, assignedmedicines.qty, assignedmedicines.instruction, assignedmedicines.confirmed_by, assignedmedicines.printed');
        $builder->join('items', 'assignedmedicines.drug_id = items.id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        $builder->where('DATE(assignedmedicines.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        $builder->where('assignedmedicines.confirmed_by', $cashier);
        $builder->groupEnd();
        return $builder->get()->getResult();
    }
}
