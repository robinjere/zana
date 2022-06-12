<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRoleModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_role';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['role_id', 'user_id'];

    // Dates
    // protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];
    public function get_user_role(Int $user_id){
        $builder = $this->db->table('user_role');
        $builder->select('role.role_type');
        $builder->where('user_id', $user_id);
        $builder->join('role', 'user_role.role_id = role.id');
        return $builder->get()->getRow();

    }
}
