<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['item_id', 'qty', 'dose', 'amount', 'discount', 'description','assigned_medicine_id', 'updated_at', 'user_id'];

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

    public function noticeTable(){
        $builder = $this->db->table('items');
        $builder->orderBy('sales.id', 'DESC');
        $builder->join('sales', 'items.id = sales.item_id');        
        return $builder;
    }

    public function TodaySales(){
      
            $date = date('Y-m-d');
            $curr_date = $date;
            $builder = $this->db->table('items');
            // $builder->select("sales.updated_at, items.name , sales.qty, sales.dose sales.amount, sales.discount");
            $builder->where('sales.updated_at >=', $curr_date);
            // $builder->from('sales');
            $builder->join('sales', 'items.id = sales.item_id ');
            return $builder;
            // exit;
    }

    public function itemDateFormat(){
        $column = function ($row){
            $date = date_create($row['updated_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }
    public function checkBox(){
        $column = function ($row){
            // $date = date_create($row['updated_at']);
            return '<input type="checkbox" name="sales[]" value="'.$row['id'].'" />';
        };
        return $column;
    }

    public function salesData($start_date, $end_date, $cashier_id = null){
            
            $builder = $this->db->table('sales');
            $builder->select('sales.id, sales.qty, sales.dose, sales.amount, sales.discount, sales.updated_at, items.name, items.selling_price');
            $builder->join('items', 'items.id = sales.item_id');
            // $builder->join('assigned_labtests', 'assigned_labtests.confirmed_by = user.id');
            // $builder->groupStart();
            if($cashier_id){
                $builder->where('sales.user_id', $cashier_id);
            }
            $builder->where('DATE(sales.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
            // $builder->groupEnd();    
            return $builder->get()->getResult(); 
            // return (string) $this->db->getLastQuery();

       
            // $builder = $this->db->table('sales');
            //             // ->groupStart()
            // $builder->select('sales.updated_at, sales.qty, sales.dose, sales.amount, sales.discount');
            // $builder->select('items.name, items.selling_price');
            //             // ->groupEnd()
            // $builder->join('items', 'sales.item_id = items.id');
            // $builder->groupStart();
            // if(!empty($user_id)){
            //     $builder->where('sales.user_id', $user_id);
            // }
            // $builder->where('DATE(sales.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
            // $builder->groupEnd();                    
            // return $builder->get()->getResult();
            // return (string) $this->db->getLastQuery();

    }

    public function get_sale($sale_id){
        $builder = $this->db->table('sales');
        $builder->select('sales.qty, sales.dose, sales.amount, sales.discount, items.name, items.selling_price ');
        $builder->where('sales.id', $sale_id);
        $builder->orderBy('sales.id', 'DESC');
        $builder->join('items', 'items.id = sales.item_id');        
        return $builder->get()->getRow();
    }
}
