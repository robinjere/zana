<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'consultation';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'file_id',
        'doctor_id',
        'payment',
        'amount',
        'assigned_by',
        'payment_confirmed_by',    
        'consulted_by',    
        'updated_at'        
    ];

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

    public function consultationTable(){
        $builder = $this->db->table('consultation');
        $builder->select('consultation.id, patients.first_name as p_firstname, patients.middle_name, patients.sir_name as p_lastname, consultation.updated_at, consultation.payment, consultation.amount, consultation.payment_confirmed_by, patients_file.patient_id, patients_file.id as p_fileid, patients_file.file_no, user.id as doctor, user.first_name, user.last_name');
        $builder->where('consultation.consulted_by', 0);
        $builder->where('user.id', session()->get('id'));
        $builder->join('patients_file', 'consultation.file_id = patients_file.id');        
        $builder->join('patients', 'patients_file.patient_id = patients.id');        
        $builder->join('user', 'consultation.doctor_id = user.id');        
        return $builder;
    }
    public function DateFormat(){
        $column = function ($row){
            $date = date_create($row['updated_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }
    public function formatName(){
        return function($row){
            return '<span>'.$row['p_firstname'] .', '.$row['p_lastname'] .'</span>';
        };
    }
    public function doctor(){
        $column = function($row){
            return '<span>'. $row['last_name'] .','. $row['first_name'] .'</span>';
        };
        return $column;
    }
    public function formatAmount(){
        return function($row){
            return number_format($row['amount'], 2, '.', ',').'/=';
        };
    }
    public function actionButtons(){
        $button = function($row){
            // $waiting = '<span class="badge bg-info"> Waiting </span>';
            // $accept_payment = ' <a href="/consultation/approve_payment/'.$row['id'].'/consultation" class="badge bg-success"> Approve payment</a> '; 
            // $reject_payment = ' <a href="/consultation/disapprove_payment/'.$row['id'].'/consultation" class="badge bg-danger"> Disapprove payment</a> '; 
            // $consult = ' <a href="/consultation/attend/'.$row['patient_id'].'" class="badge bg-success"> Consult </a> '; 
            // $showButtons = '';
            
            // /*
            //    *TODO:: restrict by role.. Cashier should accept or reject payment
            //    *TODO:: Doctor can consult patient
            // */
            // if($row['payment'] == 'CASH' && session()->get('role') == 'cashier'){
            //    $showButtons = $row['payment_confirmed_by'] == 0 ? $accept_payment : $reject_payment;
            // }
            
            // $doctor_role = ['specialist_doctor', 'general_doctor'];
            // if($row['payment'] == 'CASH' && in_array(session()->get('role'), $doctor_role ) && $row['payment_confirmed_by'] !== 0){
            //     $showButtons = $consult;
            // }elseif ($row['payment'] != 'CASH' && in_array(session()->get('role'), $doctor_role)) {
            //     $showButtons = $consult;   
            // }
            
            return  '<a href="'. base_url('patientfile/consult/'.$row['p_fileid']).'" class="badge bg-success"> ATTEND </a>' ;  
        };
        return $button;
    }

    public function consultationByDoctor($doctor, $start_date, $end_date){
        $builder = $this->db->table('consultation');
        $builder->select('consultation.id, consultation.updated_at, consultation.payment, consultation.amount, patients_file.patient_id, patients_file.file_no, patients.first_name, patients.middle_name, patients.sir_name, patients.phone_no, patients_file.patient_character');
        $builder->where('consultation.consulted_by !=', 0);
        $builder->where('consultation.doctor_id', $doctor);
        $builder->where('DATE(consultation.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        $builder->join('patients_file', 'consultation.file_id = patients_file.id');        
        $builder->join('patients', 'patients_file.patient_id = patients.id');        
        return $builder->get()->getResult();
    }

    public function checkConsultationPayment(Int $file_id){
        $builder = $this->db->table('consultation');
        $builder->where('file_id', $file_id);
        // $builder->orderBy('created_at', 'DESC');
        return $builder->get()->getLastRow();
    }
}
