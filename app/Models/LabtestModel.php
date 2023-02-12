<?php

namespace App\Models;

use CodeIgniter\Model;

class LabtestModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'labtests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description', 'price', 'created_at', 'added_by'];

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

   public function searchLabTest($searchName){
        $builder = $this->db->table('labtests');
        $builder->like('name', $searchName);
     
        return $builder->get()->getResult();
    }
    
    public function getLabTest(){
        $builder = $this->db->table('labtests');
        $builder->select('id,name, description, price, updated_at');
        return $builder;
    }

    public function formatDate(){
        return function($row){
            return date_format(date_create($row['updated_at']), 'd-m-Y');
        };
    }

    public function formatPrice(){
        return function($row){
            return number_format(floatval($row['price'])) .'/=';
        };
    }

    public function actionButtons(){
        return function($row){
            $edit = in_array('can_edit_labtest', session()->get('permission')) ?  '<a href="'. base_url('store/editlabtest/'.$row['id']) .'" class="badge badge-sm bg-success"> edit </a>' : '';
            $delete = in_array('can_delete_labtest', session()->get('permission')) ?  ' <a href="'. base_url('store/deletelabtest/'.$row['id']).'" class="badge badge-sm bg-danger"> delete </a> ' : '';
            if(in_array(session()->get('role'), ['doctor', 'superuser','admin', 'lab'])){
                return $edit.' '. $delete;
            }
        };
    }

    public function patientList(){
        $builder = $this->db->table('assigned_labtests');
        $builder->select('assigned_labtests.id, assigned_labtests.doctor, assigned_labtests.verified_by, patients.first_name, patients.sir_name, assigned_labtests.updated_at, patients_file.id as file, patients_file.payment_method, patients_file.file_no, user.first_name as doctor_first_name, user.last_name as doctor_last_name');
        $builder->where('assigned_labtests.verified_by', 0);
        // $builder->where('assigned_labtests.doctor', session()->get('id'));
        $builder->join('patients_file', 'assigned_labtests.file_id = patients_file.id');        
        $builder->join('patients', 'patients_file.patient_id = patients.id');        
        $builder->join('user', 'assigned_labtests.doctor = user.id');        
        return $builder;
    }

    public function patientListAction(){
        return function($row){
            return '<a href="'. base_url('patientfile/attend/'.$row['file']).'" class="badge badge-sm bg-success"> ATTEND </a>';
        };
    }
    
    public function formatName(){
        return function($row){
            return '<span>'.$row['first_name'] . ','. $row['sir_name'] . '</span>';
        };
    }

    public function doctorName(){
        return function($row){
            return '<span>'.$row['doctor_first_name'] . ','. $row['doctor_last_name'] . '</span>';
        };
    }

    
}
