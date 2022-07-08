<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClinicModel;
use monken\TablesIgniter;

class ClinicController extends BaseController
{
    public function index()
    {
        return view('clinic/clinic');
    }

    public function addclinic(){
        helper('form');
        
        if($this->request->getMethod() === 'post'){
            $clinicModel = new ClinicModel;

            $rules = [
                'name' => 'required',
                'consultation_fee' => 'required|min_length[0]'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                try {
                    //code...
                    $clinicModel->save($this->request->getVar());
                    return redirect()->to('clinic/')->with('success', 'Clinic Added');
                } catch (\Exception $e) { 
                    // $e->getMessage()
                    session()->setFlashdata('validation', 'Failed to add clinic');
                }
            }
        }

        return view('clinic/addclinic');
    }

    public function ajax_clinics(){

    }
}
