<?php

namespace App\Models;

use CodeIgniter\Model;

class RadInvestigationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'rad_investigation';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['test_name', 'price', 'user_id'];

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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

  public function searchradiology($searchName){
    $builder = $this->db->table('rad_investigation');
    $builder->like('test_name', $searchName);
    return $builder->get()->getResult();
  }

  public function getRadiologyList(){
    $builder =  $this->db->table('rad_investigation');
    $builder->select('id,test_name, price, updated_at');

    return $builder;
  }

  public function radDateFormat(){
    return function($row){
      return date_format(date_create($row['updated_at']), 'd-m-Y');
    };
  }
  
  public function formatPrice(){
    return function ($row){
      return  number_format(floatval( $row['updated_at']));
    };
  }

  public function actionButtons(){
    return function($row){
      $edit = in_array('can_edit_radiology', session()->get('permission')) ?  '<a href="'. base_url('store/editRadInvestigation/'.$row['id']) .'" class="badge badge-sm bg-success"> edit </a>' : '';
      $delete = in_array('can_delete_radiology', session()->get('permission')) ?  ' <a href="'. base_url('store/deleteRadInvestigation/'.$row['id']).'" class="badge badge-sm bg-danger"> delete </a> ' : '';
      if(in_array(session()->get('role'), ['doctor', 'superuser','admin', 'lab'])){
          return $edit.' '. $delete;
      }
    };
  }

}
