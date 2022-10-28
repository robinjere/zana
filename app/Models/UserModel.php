<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'first_name', 'last_name', 'father_name', 'sex', 'email', 'phone_number', 'address', 'password',
        'is_active', 'is_info_confirmed', 'confirmed_by'
    ];

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
    protected $beforeInsert   = ['beforeInsert'];
    // protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate'];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    protected function beforeInsert(array $data){
        $data = $this->hashingPassword($data);
        return $data;
    }

    protected function beforeUpdate(array $data){
        $data = $this->hashingPassword($data);
        return $data;
    }

    protected function hashingPassword(array $data){
       if(isset($data['data']['password']))
          $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
       return $data;
    }

    public function get_users_doctor(){
        $builder = $this->table('user');
        $builder->select('user.id, user.first_name, user.last_name, user.phone_number, role.name, role.role_type, consultation_fee.amount');
        $builder->join('user_role', 'user_role.user_id = user.id');
        $builder->join('role', 'role.id = user_role.role_id');
        $builder->join('consultation_fee', 'consultation_fee.role_id = role.id');
        return $builder->get()->getResult();
    }

    public function getDoctors(){
        $builder = $this->table('user');
        $builder->select('user.id, user.first_name, user.last_name, user.phone_number, role.name, role.role_type');
        $builder->join('user_role', 'user_role.user_id = user.id');
        $builder->join('role', 'role.id = user_role.role_id');
        $builder->where('role.role_type', 'doctor');
        return $builder->get()->getResult();
    }

}
