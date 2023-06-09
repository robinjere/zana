<?php

namespace App\Models;

use CodeIgniter\Model;

class WardModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ward';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'status', 'price'];

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

    public function wardTable()
    {
        $builder = $this->db->table('ward');
        // $builder->where('qty !=', 0);
        return $builder;
    }
    public function formatPrice(){
        $column = function($row){
            return number_format(floatval($row['price'])) . '/=';
        };
        return $column;
    }

    public function _DateFormat(){
        $column = function ($row){
            $date = date_create($row['updated_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }

    public function room(){
        return function($row){
            $view_btn = $row['name'] === 'GENERAL' ?  '<a class="btn btn-success btn-sm" href="'.base_url('ward/bed/'.$row['id']).'">view</a>': '<a class="btn btn-success btn-sm" href="'.base_url('ward/private/'.$row['id']).'">view</a>';
            return $view_btn;
        };
    }

    public function actionButtons(){
        $button = function($row){
            $edit = '<a href="/ward/update/'.$row['id'].'" class="badge bg-info"> Update</a>';
            $delete = '<a href="/ward/delete/'.$row['id'].'" class="badge bg-danger"> Delete </a>';
            return $edit. ' ' . $delete;  
        };
        return $button;
    }
    
}
