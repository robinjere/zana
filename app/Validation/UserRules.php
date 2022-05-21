<?php namespace App\Validation;

 use App\Models\UserModel;

 class UserRules{
     public function validate_user(string $str,  string $fields, array $data){
         $userMode = new UserModel();
         $user = $userMode->where('email', $data['email'])
                          ->first();

         if(!$user)
             return FALSE;
        
        return password_verify($data['password'], $user['password']);
     }
 }

