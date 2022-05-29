<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\ConsultationFeeModel;

class ConsultationController extends BaseController
{
    public function index()
    {
        //
    }

    public function list(){
        return view('consultation/list');
    }

    public function fees(){
        return view('consultation/fee');
    }

    public function add_fee($fee_id = 0){
        helper('form');
        $role_model = new RoleModel;
        $consultation_fee_model = new ConsultationFeeModel();
        $data = [];
        
        if($this->request->getMethod() == 'post'){
            $rules = [
                'role_id' => 'required',
                'amount' => 'required|min_length[0]'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                $new_fee = [
                    'role_id' =>  $this->request->getVar('role_id'),
                    'amount' =>  $this->request->getVar('amount')
                ];

              try {
                  //code...
                  $consultation_fee_model->save($new_fee);
                  return redirect()->to('consultation/fees')->with('success', 'new fee added');
              } catch (\Exception $e) {
                  //throw $th;
                //   die($e->getMessage());
                  session()->setFlashdata('validation', 'Duplicate Entry!');
              }
            //   if($consultation_fee_model->save($new_fee) == false){
            //       session()->setFlashdata('validation', $itemModel->errors());
            // }else{
            //       return redirect()->to('consultation/fees')->with('success', 'new fee added');
            //   }
            }
        }

        $data['roles'] = $role_model->whereIn('role_type', ['general_doctor', 'specialist_doctor'])->findAll();
        return view('consultation/add_fee', $data);
    }
}
