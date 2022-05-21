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
            return $builder;
      }

      function getUsersStatus(){
            $badges = function($row){
                  $activeBadge = $row['is_active'] ? '<span class="badge bg-success me-2"> active</span>' : '<span class=" badge bg-danger me-2"> blocked</span>' ;
                  $confirmedBadge = $row['is_info_confirmed'] ? '<span class="badge bg-success me-2"> confirmed </span>': '<span class=" badge bg-danger me-2"> not Confirmed</span>';
                  return $activeBadge.''.$confirmedBadge;
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