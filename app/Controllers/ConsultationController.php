<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\ConsultationFeeModel;
use monken\TablesIgniter;

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

    public function add_fee($fee_id = ""){
        helper('form');
        $role_model = new RoleModel;
        $consultation_fee_model = new ConsultationFeeModel();
        $data = [];
        
        if($this->request->getMethod() == 'post'){
            $rules = [
                'role_id' => 'required|is_unique[consultation_fee.role_id]',
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
                 // die($e->getMessage());
                  session()->setFlashdata('validation', 'Duplicate Entry!');
              }
            }
        }

        $data['roles'] = $role_model->whereIn('role_type', ['general_doctor', 'specialist_doctor'])->findAll();
        return view('consultation/add_fee', $data);
    }

    public function ajax_getfees(){
        $consultation_fee_model = new ConsultationFeeModel();

        $data_table = new TablesIgniter();

        $data_table->setTable($consultation_fee_model->noticeTable())
                //    ->setDefaultOrder('id', 'DESC')
                //    ->setSearch(['name'])
                   ->setOrder([ 'updated_at', 'name', 'amount'])
                   ->setOutput([ $consultation_fee_model->DateFormat(),'name', 'amount',
                                $consultation_fee_model->actionButtons()
                               ]);

        return $data_table->getDatatable();
    }


}
