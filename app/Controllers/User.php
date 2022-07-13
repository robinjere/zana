<?php

namespace App\Controllers;
use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use App\Models\UserAjaxModel;
use App\Models\ClinicModel;

use App\Models\PermissionModel;
use App\Models\UserPermissionModel;
use App\Models\ClinicDoctorsModel;

use monken\TablesIgniter;

use App\Controllers\StoreController;

class User extends BaseController
{
    public function index()
    {
        return redirect()->to('/user/login');
    }

    public function login(){
        $data = [];

        helper('form');

        if($this->request->getMethod() == 'post'){
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required|min_length[5]|validate_user[email,password]'
            ];

            $errors = [
                'password' => [
                    'validate_user' => 'Email or password don\'t match'
                ]
            ];

            if(!$this->validate($rules, $errors)){
                $data['validation'] = $this->validator;
            }else{
                $user = new UserModel();
                $LoginUser = $user->where('email', $this->request->getVar('email'))
                                  ->first();
                $this->setUserSession($LoginUser);

                // if($LoginUser['is_info_confirmed']){
                //     if($LoginUser['is_active'])
                //         return redirect()->to('/dashboard/overview');
                    
                //     // return redirect()->to('/account/blocked');
                // }else {
                //     return redirect()->to('account/info');
                //  }

                //redirect based on session.
                switch (session()->get('role')) {
                    case 'admin':
                        return redirect()->to('/store/items');
                        break;

                    case 'superuser':
                        return redirect()->to('/store/items');
                        break;
                    
                    default:
                        return redirect()->to('/patient/search');
                        break;
                }

                //  return redirect()->to('/store/items');
                
            }
        }
        $clinic = new StoreController;
        $data['clinic'] = $clinic->get_clinic_info();
        return view('user/login', $data);
    }

    private function setUserSession($LoginUser){
        $userPermission = new UserPermissionModel;
        $userRole = new UserRoleModel();
        $user_role = $userRole->get_user_role($LoginUser['id']);
       $data = [
           'id' => $LoginUser['id'],
           'first_name' => $LoginUser['first_name'],
           'last_name' => $LoginUser['last_name'],
           'email' => $LoginUser['email'],
           'isLoggedIn' => TRUE,
           'isActive' => $LoginUser['is_active'],
           'isConfirmed' => $LoginUser['is_info_confirmed'],
           'role' => $user_role->role_type
       ];
        
       $u_permission = $userPermission->get_permissions_by($LoginUser['id']); 
       $u_p = [];
       foreach ($u_permission as $permission) {
           $u_p[] = $permission->name;
       }

       $data['permission'] = $u_p;
       session()->set($data);
          
       return TRUE;
    }

    public function AccountBlocked(){
        return view('user/blocked-account');
    }

    public function registration(){
        $role = new RoleModel();
        $user = new UserModel();
        $clinicModel = new ClinicModel();

        $data = [];
        $data['roles'] = $role->findAll();
        $data['clinic'] = $clinicModel->find();
        helper('form');
         
        if($this->request->getMethod() == 'post'){

            $rules = [
                'first_name' => 'required|min_length[3]',
                'last_name' => 'required|min_length[3]',
                'father_name' => 'required|min_length[3]',
                'sex' => 'required',
                'email' => 'required|valid_email|is_unique[user.email]',
                'phone_number' => 'required',
                'role'=> 'required',
                'address' => 'required', 
                'password' => 'required|min_length[5]',
                'password_confirm' => 'required|matches[password]'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                //save the user info in the database.
                //code..
               $newData = [
                'first_name' => $this->request->getVar('first_name'), 
                'last_name' => $this->request->getVar('last_name'),
                'father_name' => $this->request->getVar('father_name'), 
                'sex' => $this->request->getVar('sex'), 
                'email' => $this->request->getVar('email'), 
                'phone_number' => $this->request->getVar('phone_number'), 
                'address' => $this->request->getVar('address'), 
                'password' => $this->request->getVar('password'),
                'is_active' => TRUE, 
                'is_info_confirmed' => TRUE
               ];

               $user->insert($newData);
               $user_id = $user->getInsertID();
               
               //save role related to user.
               $user_role = new UserRoleModel();
               $user_role->save([
                   'role_id' => $this->request->getVar('role'),
                   'user_id' => $user_id,
               ]);
               //save user to specific clinic
               if($this->request->getVar('clinic') ){
                   $clinicDoctorsModel = new ClinicDoctorsModel;
                   
                   $clinicDoctorsModel->save(['user_id' => $user_id, 'clinic_id' => $this->request->getVar('clinic')]);
               }

                /**
                 * Assign user permission based on role.
                 */
               $this::assignPermission( $this->request->getVar('role'), $user_id);

               $session = session();
               $session->setFlashdata('success', 'Successful registration');

               return redirect()->to('/user/list');

            }
        }

            return view('user/registration', $data);
    }

    public function delete($user_id = null){
        $user = new UserModel();
        $userRole = new UserRoleModel();
        $userPermission = new UserPermissionModel();
        if(isset($user_id)){
           $user->delete($user_id);
           $userRole->where('user_id',$user_id)->delete();
           $userPermission->where('user_id',$user_id)->delete();
           
           return redirect()->to('/user/list')->with('success', 'user deleted!');
        }
    }

    public function updateUserInfo($param_id){
        $role = new RoleModel();
        $user = new UserModel();
        $userRole = new UserRoleModel();
        $clinicModel = new ClinicModel;
        $clinicDoctorsModel = new ClinicDoctorsModel;

        $_message = 'Successful registration';

        $data = [];
        $_userRole = $role->findAll(); 
        $data['roles'] =  $_userRole;
        $data['clinic'] = $clinicModel->find();

        helper('form');
         
        if($this->request->getMethod() == 'post'){

            $rules = [
                'first_name' => 'required|min_length[3]',
                'last_name' => 'required|min_length[3]',
                'father_name' => 'required|min_length[3]',
                'sex' => 'required',
                'phone_number' => 'required',
                'role'=> 'required',
                'address' => 'required'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                //save the user info in the database.
                //code..
               $the_user = $user->find($param_id);
               $myPass  = '';
               if(!empty($this->request->getVar('password'))){
                  $myPass = $this->request->getVar('password');
               }else{
                  $myPass = $the_user['password'];
               }

               $newData = [
                'id' => $param_id,
                'first_name' => $this->request->getVar('first_name'), 
                'last_name' => $this->request->getVar('last_name'),
                'father_name' => $this->request->getVar('father_name'), 
                'sex' => $this->request->getVar('sex'), 
                'phone_number' => $this->request->getVar('phone_number'), 
                'address' =>  $this->request->getVar('address'), 
                'password' => $myPass,
                'is_active' => TRUE, 
                'is_info_confirmed' => TRUE
               ];

            //    if(isset($param_id)){
            //        $newData['id'] = $param_id;
            //        $_message = 'Successful Updated';
            //    }
               if(!$user->save($newData)){
                $_message = 'Failed to update';
               }
               $_message = 'Successful Updated';
               $user->insert($newData);
            //    $user_id = $user->getInsertID();
               
               //save role related to user.
               $user_role = new UserRoleModel();
               $user_role->where('user_id',$param_id)->delete();
               $user_role->save([
                   'role_id' => $this->request->getVar('role'),
                   'user_id' => $param_id,
               ]);
               
               //save clinic relateb by user.
              //print_r($this->request->getVar());
               $__userRole = '';
               foreach ($_userRole as $r) {
                  if($r['id'] == $this->request->getVar('role')){
                    $__userRole = $r;
                    break;
                  }
               }
            //   print_r($__userRole);
             if($__userRole['role_type'] == 'doctor'){
                    $usrClinic =  $clinicDoctorsModel->where('user_id', $param_id)->first();
                    // print_r($user_id);
                    // print_r($usrClinic);
                    // exit;
                    if(empty($usrClinic)){
                        $clinicDoctorsModel->save(['user_id' => $param_id, 'clinic_id' => $this->request->getVar('clinic')]);
                    }else{
                        $clinicDoctorsModel->save(['id' => $usrClinic['id'], 'clinic_id' => $this->request->getVar('clinic')]);
                    }
              }else{
                $clinicDoctorsModel->where('user_id', $param_id)->delete();
              }

               /**
                 *  First delete permission for this user.
                 *  Assign user permission based on role.
                 */
                $userPermission = new UserPermissionModel();
                $userPermission->where('user_id',$param_id)->delete();
  
               $this::assignPermission($this->request->getVar('role'), $param_id);

               $session = session();
               $session->setFlashdata('success', $_message);

               return redirect()->to('/user/list');

            }
        }

        if(isset($param_id)){
            $data['userInfo'] = $user->find($param_id);
            $data['userRole'] = $userRole->where('user_id', $param_id)->first();
            $__userClinic = $clinicDoctorsModel->where('user_id', $param_id)->first();
            $data['userClinic'] = empty($__userClinic)? ['clinic_id' => ''] : $__userClinic;
            // print_r($param_id);
            // print_r('userClinic');
            // exit;
        }else{
            return view('user/registration', $data);
        }

        return view('user/edit', $data);
    }


    public function registerSuperuser(){
        $role = new RoleModel();
        $user = new UserModel();
        $userPermission = new UserPermissionModel;
        $permissionModel = new PermissionModel;

        $data = [];
        $data['roles'] = $role->findAll();
        helper('form');
         
        if($this->request->getMethod() == 'post'){

            $rules = [
                'first_name' => 'required|min_length[3]',
                'last_name' => 'required|min_length[3]',
                'father_name' => 'required|min_length[3]',
                'sex' => 'required',
                'email' => 'required|valid_email|is_unique[user.email]',
                'phone_number' => 'required',
                'role'=> 'required|not_in_list[superuser]',
                'address' => 'required', 
                'password' => 'required|min_length[5]',
                'password_confirm' => 'required|matches[password]'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                //save the user info in the database.
                //code..
               $newData = [
                'first_name' => $this->request->getVar('first_name'), 
                'last_name' => $this->request->getVar('last_name'),
                'father_name' => $this->request->getVar('father_name'), 
                'sex' => $this->request->getVar('sex'), 
                'email' => $this->request->getVar('email'), 
                'phone_number' => $this->request->getVar('phone_number'), 
                'address' => $this->request->getVar('address'), 
                'password' => $this->request->getVar('password'),
                'is_active' => TRUE, 
                'is_info_confirmed' => TRUE,
               ];

               $user->insert($newData);
               $user_id = $user->getInsertID();
               
               //save role related to user.
               $user_role = new UserRoleModel();
               $user_role->save([
                   'role_id' => $this->request->getVar('role'),
                   'user_id' => $user_id,
               ]);
               //save 

               $all_permission = $permissionModel->findAll();
                $my_perm = [];
               foreach($all_permission as $perm){
                 $my_perm[] = ['user_id' => $user_id,'permission_id' => $perm['id']];
               }

               $userPermission->saveMultiplePermission($my_perm);

               $session = session();
               $session->setFlashdata('success', 'Successful registration.');

               return redirect()->to('/user');

            }
        }
        $clinic = new StoreController;
        $data['clinic'] = $clinic->get_clinic_info();

        return view('user/registersuperuser', $data);
    }

    protected function assignPermission(Int $user_role, Int $user_id ){
        $role = new RoleModel();
        $user = new UserModel();
        $userPermission = new UserPermissionModel;
        $permissionModel = new PermissionModel;
       
       /**
        * find a role 
        * assign group permission based on role -> (drug, diagnosis, procedure, patient, labtest, clinicalnote and radiology)
        */
        $user_r = $role->where('id', $user_role)->first();

        switch ($user_r['role_type']) {
            case 'doctor':
                $this::save_permission_based_group($user_id, ['consultation', 'drug', 'diagnosis', 'procedure', 'patient', 'labtest', 'clinicalnote', 'radiology']);
                break;
            case 'specialist_doctor':
                $this::save_permission_based_group($user_id, ['consultation', 'drug', 'diagnosis', 'procedure', 'patient', 'labtest', 'clinicalnote', 'radiology']);
                break;
            case 'admin':
                $this::save_permission_based_group($user_id, ['expenses','user','permission','drug', 'report', 'diagnosis', 'procedure', 'patient', 'labtest', 'clinicalnote', 'radiology']);
                break;
            case 'reception':
                $this::save_permission_based_group($user_id, ['consultation','expenses','drug', 'patient', 'radiology']);
                break;
            case 'cashier':
                $this::save_permission_based_group($user_id, ['consultation','expenses','drug', 'patient', 'labtest']);
                break;
            case 'pharmacy':
                $this::save_permission_based_group($user_id, ['drug', 'patient']);
                break;
            
            default:
                # code...
                break;
        }

    }

    protected function save_permission_based_group(Int $user_id, array $group){
        $permissionModel = new PermissionModel;
        $userPermission = new UserPermissionModel;
        
        $all_permission = $permissionModel->get_permission_based_group($group);
        $my_perm = [];
        foreach($all_permission as $perm){
            $my_perm[] = ['user_id' => $user_id,'permission_id' => $perm->id];
        }
        $userPermission->saveMultiplePermission($my_perm);
    }

    public function accountInfo(){
        $userModel = new UserModel();
        $role = new RoleModel();
        $userRoleModel  = new UserRoleModel();
         
        if($this->request->getMethod() == 'post'){

            $rules = [
                'first_name' => 'min_length[3]',
                'last_name' => 'min_length[3]',
                'father_name' => 'min_length[3]'
            ];

            //update password if requested to edit
            if($this->request->getPost('password') != ''){
                 $rules['password'] = 'required|min_length[5]';
                 $rules['password_confirm'] = 'required|matches[password]';
            }

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                //save the user info in the database.
                //code..
               $newData = [
                'id' => session()->get('id'),
                'first_name' => $this->request->getPost('first_name'), 
                'last_name' => $this->request->getPost('last_name'),
                'father_name' => $this->request->getPost('father_name'), 
                'phone_number' => $this->request->getPost('phone_number'), 
                'address' => $this->request->getPost('address')
               ];

              if($this->request->getPost('password') != ''){
                $newData['password'] = $this->request->getPost('password');
              }

               $userModel->save($newData);

            // $session = session();
               session()->setFlashdata('success', 'Successful updated.');
               return redirect()->to('account/info');
            }
        }

        $user = $userModel->where('id', session()->get('id'))->first();
        $data['userInfo'] = $user;
        $data['roles'] = $role->findAll();

        //get all roles assigned to specific user
        // $selectedRoles = $userRoleModel->where('user_id', $user)->get();
        $data['userSelectedRole'] = '';

        helper(['form']);
        return view('user/account-info', $data);
    }

    /** 
     * Confirm account info
     * */  

    public function confirmUserInfo($user_id){
        $model = new UserModel();
         
        // print_r($this->request->getMethod());
        // exit;
        if($this->request->getMethod() === 'post'){
            $model->save([
                'id' => $user_id,
                'is_info_confirmed' => FALSE,
                'confirmed_by' => session()->get('id')
            ]);
           return redirect()->to('/account/user/'.$user_id)->with('success', 'User is unconfirmed');
        }else{
            $model->save([
                'id' => $user_id,
                'is_info_confirmed' => TRUE,
                'confirmed_by' => session()->get('id')
            ]);
           return redirect()->to('/account/user/'.$user_id)->with('success', 'User info confirmed');
        }
    }
    
    public function BlockUser($user_id){
        $model = new UserModel();
        $message = [];
        if($this->request->getMethod() === 'post'){
            $model->save([
                'id' => $user_id,
                'is_active' => TRUE,
            ]);
            return redirect()->to('/account/user/'.$user_id)->with('success', 'This user account is unblocked.');
        }else{
            $model->save([
                'id' => $user_id,
                'is_active' => FALSE,
            ]);
            return redirect()->to('/account/user/'.$user_id)->with('success', 'This user account is blocked.');
        }
    }

    public function assignMultipleRole(){

    }
    public function userInfo($user_id){
        $userModel = new UserModel();
        $role = new RoleModel();
        $userRoleModel  = new UserRoleModel();
         
        $user = $userModel->where('id', $user_id)->first();
        $data['userInfo'] = $user;
        $data['roles'] = $role->findAll();

        //get all roles assigned to specific user
        // $selectedRoles = $userRoleModel->where('user_id', $user)->get();
        $data['userRole'] = $userRoleModel->where('user_id', $user_id)->first();
        $data['user id passed'] = $user_id;
         
        helper(['form']);
        return view('user/user_info', $data);
    }

    public function userPermission($user_id){
        $userModel = new UserModel;
        $permission = new PermissionModel;
        $userPermission  = new UserPermissionModel;

        if($this->request->getMethod() == 'post'){
            $user_permission = $this->request->getVar('permission');
            $userPermission->where('user_id', $user_id)->delete();
            $_data = [];
            foreach($user_permission as $_permission){
                $_data[] = ['user_id' => $user_id , 'permission_id' => $_permission];
            }
            $userPermission->saveMultiplePermission($_data);
            // $userPermission->save($_data);
        }

        $data['userInfo'] = $userModel->find($user_id);

        //associate permission on a certaion group;
        $permission_all = $permission->findAll();
        $data['user_p'] = $this::group_permission_by('user', $permission_all);
        $data['drug_p'] = $this::group_permission_by('drug', $permission_all);
        $data['sale_p'] = $this::group_permission_by('sale', $permission_all);
        $data['permission_p'] = $this::group_permission_by('permission', $permission_all);
        $data['expenses_p'] = $this::group_permission_by('expenses', $permission_all);
        $data['report_p'] = $this::group_permission_by('report', $permission_all);

        $data['user_permission'] = $userPermission->where('user_id', $user_id)->findAll();
        return view('user/permission', $data);
    }

    protected function group_permission_by(String $group_name, array $permissions){
            $_permission_list = [];
           foreach ($permissions as $permission) {
               if($permission['permission_group'] == $group_name){
                   $_permission_list[] = $permission;
               }
           }
           return $_permission_list;
    }

    public function updateAccountInfo(){
        $user = new UserModel();
        // return view('user/registration', $data);
    }

    public function logout(){
        session()->destroy();
        return redirect()->to('/');
    }

    public function delectAccount($id){
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if($user){
            $userModel->delete($id);
            session()->setFlashdata('success', 'You deleted account.');
            return redirect()->to('/logout');
        }
    }

    public function list(){
        $model = new UserModel();
        $data['count_users'] = $model->countAll(); 

        return view('user/users-list', $data);
    }

    public function ajax_getUsers(){
        $db = db_connect();
        $model = new UserAjaxModel($db);

        $data_table = new TablesIgniter();
        $data_table->setTable($model->getUsers())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['first_name','last_name'])
                   ->setOrder(['id', 'first_name', 'last_name'])
                   ->setOutput(["id", "first_name", "last_name",
                                $model->getUserPosition(),
                                $model->getUsersStatus(),
                                $model->getButtonUserView()
                               ]);

        return $data_table->getDatatable();
    }
}
