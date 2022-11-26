<?php

namespace App\Models;

use CodeIgniter\Model;

class HospitalReffersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'hospital_reffers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'hospital_name', 'hospital_type', 'added_by'];

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

    //get reffers
    public function getReffers(){
        $builder = $this->db->table('hospital_reffers');
        $builder->select('id, hospital_name, hospital_type, updated_at, added_by');
        return $builder;
    }

    //format date
    public function DateFormat(){
        return function($row){
            return date_format(date_create($row['updated_at']), 'd/m/Y'); 
        };
    }

    public function actionButtons(){
        return function($row){
            return '<a href="'. base_url('/reffers/delete/'. $row['id']).'" class="btn btn-sm btn-danger"> delete </button>
                    <a href="'. base_url('/reffers/edit/'. $row['id']).'" class="btn btn-sm btn-success"> Edit </button>';
        };
    }
}
