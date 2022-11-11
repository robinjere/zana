<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpensesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'expenses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['description', 'amount', 'user_id', 'updated_at'];

    // Dates
    protected $useTimestamps = false;
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
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    public function expensesTable(){
        $builder = $this->db->table('user');
        $builder->join('expenses', 'user.id = expenses.user_id');
        return $builder;
    }

    public function expenseDateFormat(){
        $column = function ($row){
            $date = date_create($row['updated_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }
    public function expensePriceFormat(){
        return function($row){
            return number_format(floatval($row['amount'])) .'/='; 
        };
    }

    public function expenseIssuedBy(){
        $name = function($row){
            $f_name = $row['first_name'] ;
            $l_name = $row['last_name'] ;
            return $f_name.' '.$l_name;
      };
      return $name;
    }

    public function actionButtons(){
        $button = function($row){
            return '<a href="/expense/edit/'.$row['id'].'" class="badge bg-primary"> edit </a>  <a href="/expense/delete/'.$row['id'].'" class="badge bg-danger"> delete </a>';  
       };
       return $button;
    }

    public function expenseData($start_date, $end_date){
        $builder = $this->db->table('expenses');
        $builder->select('expenses.description, expenses.amount, expenses.updated_at, user.first_name, user.last_name');
        $builder->where('DATE(expenses.updated_at) >=', $start_date);
        $builder->where('DATE(expenses.updated_at) <=', $end_date);
        $builder->join('user', 'expenses.user_id = user.id');
        return $builder->get()->getResult();
    }


}
