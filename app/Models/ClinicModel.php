<?php

namespace App\Models;

use CodeIgniter\Model;

class ClinicModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'clinics';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','consultation_fee', 'user', 'created_at'];

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

    public function getClinics(){
        $builder = $this->db->table('clinics');
        $builder->select('clinics.id, clinics.created_at, clinics.name, clinics.consultation_fee, user.first_name, user.last_name');
        $builder->join('user', 'clinics.user = user.id');
        return $builder;
    }

    public function DateFormat(){
        $column = function ($row){
            $date = date_create($row['created_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }

    public function formatFee(){
        $column = function($row){
            return number_format(floatval($row['consultation_fee'])) . '/=';
        };
        return $column;
    }

    public function status(){
        return function($row){
            return '<span> Added by '. $row['last_name'] .', '. $row['first_name'] .' </span>';
        };
    }

    public function actionButtons(){
        return function($row){
            return '<a href="'. base_url('/clinic/delete/'. $row['id']).'" class="btn btn-sm btn-danger"> delete </button>
                    <a href="'. base_url('/clinic/edit/'. $row['id']).'" class="btn btn-sm btn-success"> Edit </button>';
        };
    }
}
