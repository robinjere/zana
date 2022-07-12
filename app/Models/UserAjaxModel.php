<?php namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class UserAjaxModel{
      protected $db;
      
      public function __construct(ConnectionInterface &$db){
            $this->db =& $db;
      }
      
      function getUsers(){
            // SELECT * FROM posts 
            // return $this->db->table('posts')->get()->getResult();
            $builder = $this->db->table('user');
            $builder->select('user.id, user.first_name, user.last_name, user.is_active, role.name as role_name');
            $builder->join('user_role', 'user.id = user_role.user_id');
            $builder->join('role', 'user_role.role_id = role.id');
            return $builder;
      }

      function getUserPosition(){
            return function($row){
                  return '<span>'.$row['role_name'].'</span>';
            };
      }

      function getUsersStatus(){
            $badges = function($row){
                  $activeBadge = $row['is_active'] ? '<span class="badge bg-success me-2"> active</span>' : '<span class=" badge bg-danger me-2"> blocked</span>' ;
                  // $confirmedBadge = $row['is_info_confirmed'] ? '<span class="badge bg-success me-2"> confirmed </span>': '<span class=" badge bg-danger me-2"> not Confirmed</span>';
                  return $activeBadge;
            };
            return $badges;
      }

      function getButtonUserView(){
            $button = function($row){
                 return ' <a href="/user/info/'.$row['id'].'" class="badge bg-info"> view</a>  <a href="/user/edit/'.$row['id'].'" class="badge bg-primary"> edit </a>  <a href="/user/delete/'.$row['id'].'" class="badge bg-danger"> delete </a>';  
            };
            return $button;
      }
}