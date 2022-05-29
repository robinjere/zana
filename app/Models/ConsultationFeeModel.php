<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultationFeeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'consultation_fee';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['role_id', 'amount'];

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
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    // protected function beforeInsert(array $data){
    //     if(isset($data['data']['role_id']))
    //       //something will go here..
    //    return $data;
    // }

    public function noticeTable(){
        $builder = $this->db->table('role');
        $builder->join('consultation_fee', 'role.id = consultation_fee.role_id');        
        return $builder;
    }
    public function DateFormat(){
        $column = function ($row){
            $date = date_create($row['updated_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }
    public function actionButtons(){
        $button = function($row){
             return ' <a href="/consultation/update_fee/'.$row['id'].'" class="badge bg-info"> Update</a> <a href="/consultation/delete_fee/'.$row['id'].'" class="badge bg-danger"> Delete </a> ';  
        };
        return $button;
    }
}
