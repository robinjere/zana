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

        $data = [];
        $data['validation'] = '';
        
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
                    $clinic_to_save = $this->request->getVar();
                    $clinic_to_save['user'] = session()->get('id');

                    $clinicModel->save($clinic_to_save);
                    
                    return redirect()->to('clinic/')->with('success', 'Clinic Added');
                } catch (\Exception $e) { 
                    // $e->getMessage()
                    session()->setFlashdata('validation', $e->getMessage());
                }
            }
        }

        return view('clinic/addclinic', $data);
    }

    public function editclinic(Int $clinic_id){
        helper('form');
        $clinicModel = new ClinicModel;

        $data = [];
        $data['validation'] = '';

        // get clinic 
        $data['clinic'] = $clinicModel->find($clinic_id);
        
        if($this->request->getMethod() === 'post'){
          

            $rules = [
                'name' => 'required',
                'consultation_fee' => 'required|min_length[0]'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                try {
                    //code...
                    $clinic_to_save = $this->request->getVar();
                    $clinic_to_save['user'] = session()->get('id');
                    $clinic_to_save['id'] =  $clinic_id;

                    $clinicModel->save($clinic_to_save);
                    
                    return redirect()->to('clinic/')->with('success', 'Clinic Edited!');
                } catch (\Exception $e) { 
                    // $e->getMessage()
                    session()->setFlashdata('validation', $e->getMessage());
                }
            }
        }

        return view('clinic/editclinic', $data);
    }

    public function delete_clinic(Int $clinic_id){
        $clinicModel = new ClinicModel;
        if($clinicModel->where('id', $clinic_id)->delete()){
            return redirect()->to('clinic/')->with('success', 'clinic deleted');
        }else{
            return redirect()->to('clinic/')->with('error', 'failed to delete clinic');
        }
    }

    public function ajax_clinics(){
        $clinicModel = new ClinicModel;
        $data_table = new TablesIgniter();
        $data_table->setTable($clinicModel->getClinics())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['name'])
                   ->setOrder(['updated_at', 'name', 'consultation_fee'])
                   ->setOutput([$clinicModel->DateFormat(), 'name', $clinicModel->formatFee(), $clinicModel->status(), $clinicModel->actionButtons()]);

        return $data_table->getDatatable();
    }
}
