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
        $builder->select('id,name, description, price, created_at');
        return $builder;
    }

    public function formatDate(){
        return function($row){
            return date_format(date_create($row['created_at']), 'd-m-Y');
        };
    }

    public function formatPrice(){
        return function($row){
            return number_format(floatval($row['price'])) .'/=';
        };
    }

    public function actionButtons(){
        return function($row){
            if(in_array(session()->get('role'), ['doctor', 'superuser','admin'])){
                return '<a href="'. base_url('store/editlabtest/'.$row['id']) .'" class="badge badge-sm bg-success"> edit </a> <a href="'. base_url('store/deletelabtest/'.$row['id']).'" class="badge badge-sm bg-danger"> delete </a> ';
            }
        };
    }
}
