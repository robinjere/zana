<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'room_no';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['room_number', 'ward', 'user'];

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

    public function roomTable($ward_id=null)
    {
        $builder = $this->db->table('room_no');
        $builder->where('ward', $ward_id);
        return $builder;
    }

    public function _DateFormat(){
        $column = function ($row){
            $date = date_create($row['updated_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }

    public function actionButtons($ward_id=null){
        $button = function($row){
            $edit =  '<a href="#" onclick="updateRoom('.$row['id'].')" class="badge bg-info"> Update</a>';
            $delete = '<a href="#" onclick="deleteRoom('.$row['id'].')" class="badge bg-danger"> Delete</a>';
            return $edit. ' ' . $delete;  
        };
        return $button;
    }

}
