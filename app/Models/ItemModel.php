<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'qty', 'selling_price', 'buying_price', 'exp_date','drug_kind', 'description', 'user_id', 'updated_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        // "name" => "required|min_length[2]|is_unique[items.name]",
        "name" => "required|min_length[2]",
        "qty" => "required",
        "selling_price" => "required",
        "buying_price" => "required"
    ];
    // protected $validationMessages   = [
    //     "name" => [
    //         "is_unique" => "The item name you are trying to add is available. Specify another name"
    //     ]
    // ];
    protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

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

    public function noticeTable()
    {
        $builder = $this->db->table('items');
        $builder->where('qty !=', 0);
        return $builder;
    }

    public function updateItem($item, $item_id){
        $item['updated_at'] = date('Y-m-d');
        $builder = $this->db->table('items');
        $builder->where('id', $item_id);
        return $builder->update($item);
    }

    public function outOfStockTable()
    {
        $builder = $this->db->table('items');
        $builder->where('qty', 0);
        return $builder;
    }
    public function itemsNeartoEndTable()
    {
        $builder = $this->db->table('items');
        $builder->where('qty >', 0);
        $builder->where('qty <', 10);
        return $builder;
    }
    // public function count_out_of_stock(){
         
    // }

    public function formatBuyingPrice(){
        $column = function($row){
            return number_format(floatval($row['buying_price'])) . '/=';
        };
        return $column;
    }
    public function formatSellingPrice(){
        $column = function($row){
            return number_format(floatval($row['selling_price'])) . '/=';
        };
        return $column;
    }

    public function itemDateFormat(){
        $column = function ($row){
            $date = date_create($row['updated_at']);
            return date_format($date, 'd/m/Y');
        };
        return $column;
    }

    public function actionButtons(){
        $button = function($row){
            $edit = in_array('can_edit_drug', session()->get('permission')) ?  '<a href="/store/updateitem/'.$row['id'].'" class="badge bg-info"> Update</a>' : '';
            $delete = in_array('can_delete_drug', session()->get('permission')) ?  '<a href="/store/deleteitem/'.$row['id'].'" class="badge bg-danger"> Delete </a>' : '';

            return $edit. ' ' . $delete;  
        };
        return $button;
    }

    public function searchItem($item){
        $builder = $this->db->table('items');
        $builder->like('name', $item);
     
        return $builder->get()->getResult();
    }

    public function countItemsFinished(){
        $builder = $this->db->table('items');
        $builder->where('qty', 0);
        return $builder->countAllResults();
    }

    public function ItemsNearToEnd(){
        $builder = $this->db->table('items');
        $builder->where('qty > ', 0);
        $builder->where('qty < ', 10);
        return $builder->countAllResults();
    }

}
