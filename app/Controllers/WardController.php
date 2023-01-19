<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use monken\TablesIgniter;
use App\Models\WardModel;

class WardController extends BaseController
{
    public function index()
    {
        helper('form');
        if($this->request->getMethod() == 'post'){
            $wardModel = new WardModel;
            $ward = $this->request->getVar('ward');
            $status = $this->request->getVar('status');
            $price = $this->request->getVar('price');
            $wardModel->save(['name' => $ward,'status' => $status,'price' => $price]);
            return redirect()->to('ward')->with('success', 'Ward added!');
        }
        return view('ward/index');
    }

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
