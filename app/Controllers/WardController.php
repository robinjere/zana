<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use monken\TablesIgniter;
use App\Models\WardModel;

class WardController extends BaseController
{
    public function index($updateId = null)
    {
        helper('form');
        $wardModel = new WardModel;
        $data = ['id' => '', 'name' => '', 'status' => '', 'price' => ''];
        if($this->request->getMethod() == 'post'){
            $id = $this->request->getVar('id');
            $ward = $this->request->getVar('ward');
            $status = $this->request->getVar('status');
            $price = $this->request->getVar('price');
            $ward_data = [];
            $notificate_message = '';
            if($id){
               $ward_data = ['id' => $id, 'name' => $ward,'status' => $status,'price' => $price];
               $notificate_message = 'ward updated!';
            }else{
                $ward_data = ['name' => $ward,'status' => $status,'price' => $price];
                $notificate_message = 'Ward added!';
            }
            $wardModel->save($ward_data);
            return redirect()->to('ward')->with('success', $notificate_message);
        }
        if($updateId){
           $todatedData = $wardModel->where('id',$updateId)->first();
           $data['id'] =  $todatedData['id'];
           $data['name'] = $todatedData['name'];
           $data['status'] = $todatedData['status'];
           $data['price'] = $todatedData['price'];
        }
        return view('ward/index', $data);
    }

    // public function update($updateId){

    // }

    public function ajax_getWards(){
        helper('form');
        $wardModel = new WardModel;

        $data_table = new TablesIgniter();
        $data_table->setTable($wardModel->wardTable())
                   ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['name'])
                   ->setOrder(['id', 'updated_at', 'name','status', 'price'])
                   ->setOutput(['id', $wardModel->_DateFormat(), 'name', 'status', $wardModel->formatPrice(), $wardModel->room(),
                                $wardModel->actionButtons()
                               ]);

        return $data_table->getDatatable();
    }

    public function deleteWard($id){
        $wardModel = new WardModel;
        $wardModel->where('id', $id)->delete();
        return redirect()->to('ward')->with('success', 'Ward deleted!');
    }
}
