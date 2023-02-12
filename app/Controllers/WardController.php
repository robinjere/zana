<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use monken\TablesIgniter;
use App\Models\WardModel;
use App\Models\BedModel;
use App\Models\RoomModel;

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


    public function private($ward_id=null, $room_id=null){
        helper('form');
        $roomModel = new RoomModel;
        $wardModel = new WardModel;

        //get info of general ward
        $privateWard = $wardModel->where('id',$ward_id)->first();
       
        $data = ['id' => '', 'room_number' => '', 'ward' => '', 'user' => ''];

        if(!empty($privateWard)){
            $data['private_name'] = $privateWard['name'];
            $data['ward_id'] = $ward_id;
            $data['private_status'] = $privateWard['status'];
        }

        if($this->request->getMethod() == 'post'){
            $rules = [
                'room_number' => 'required'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                $id = $this->request->getVar('room_id');
                $room_number = $this->request->getVar('room_number');
                $ward = $ward_id;
                $user = session()->get('id');
                $room_data = [];
                $notificate_message = '';
                if($id){
                   $room_data = ['id' => $id, 'room_number' => $room_number,'ward' => $ward,'user' => $user];
                   $notificate_message = 'Room updated!';
                }else{
                    $room_data = ['room_number' => $room_number,'ward' => $ward,'user' => $user];
                    $notificate_message = 'Room added!';
                }
                $roomModel->save($room_data);
                return redirect()->to('ward/private/'.$ward_id)->with('success', $notificate_message);
            }
        }

        if($room_id){
           $prevRoomData = $roomModel->where('id',$room_id)->first();
           if(!empty($prevRoomData)){
               $data['id'] =  $prevRoomData['id'];
               $data['room_number'] = $prevRoomData['room_number'];
               $data['ward'] = $prevRoomData['ward'];
              //$data['user'] = $prevBedData['user'];
           }
        }

        return view('ward/private', $data);
    }


    //general ward
    public function general($ward_id=null, $bed_id=null){
        helper('form');
        $bedModel = new BedModel;
        $wardModel = new WardModel;

        //get info of general ward
        $generalWard = $wardModel->where('id',$ward_id)->first();
       
        $data = ['id' => '', 'bed_number' => '', 'ward' => '', 'user' => ''];

        if(!empty($generalWard)){
            $data['general_name'] = $generalWard['name'];
            $data['ward_id'] = $ward_id;
            $data['general_status'] = $generalWard['status'];
        }

        if($this->request->getMethod() == 'post'){
            $rules = [
                'bed_number' => 'required'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
                $id = $this->request->getVar('id');
                $bed_number = $this->request->getVar('bed_number');
                $ward = $ward_id;
                $user = session()->get('id');
                $bed_data = [];
                $notificate_message = '';
                if($id){
                   $bed_data = ['id' => $id, 'bed_number' => $bed_number,'ward' => $ward,'user' => $user];
                   $notificate_message = 'Bed updated!';
                }else{
                    $bed_data = ['bed_number' => $bed_number,'ward' => $ward,'user' => $user];
                    $notificate_message = 'Bed added!';
                }
                $bedModel->save($bed_data);
                return redirect()->to('ward/bed/'.$ward_id)->with('success', $notificate_message);
            }
        }

        if($bed_id){
           $prevBedData = $bedModel->where('id',$bed_id)->first();
           if(!empty($prevBedData)){
               $data['id'] =  $prevBedData['id'];
               $data['bed_number'] = $prevBedData['bed_number'];
               $data['ward'] = $prevBedData['ward'];
              //$data['user'] = $prevBedData['user'];
           }
        }

        return view('ward/general', $data);
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

    public function ajax_getBed(){
        helper('form');
        $bedModel = new BedModel;
        if($this->request->getMethod() == 'post'){
            $ward_id = $this->request->getVar('ward_id');
            $data_table = new TablesIgniter();
            $data_table->setTable($bedModel->bedTable($ward_id))
            ->setDefaultOrder('id', 'DESC')
            ->setSearch(['bed_number'])
            ->setOrder(['id', 'updated_at', 'bed_number'])
            ->setOutput(['id', $bedModel->_DateFormat(), 'bed_number',
                         $bedModel->actionButtons($ward_id)
                        ]);
    
            return $data_table->getDatatable();
        }
    }

    public function deleteBed($ward_id=null,$bedId=null){
        $bedModel = new bedModel;
        $bedModel->where('id', $bedId)->delete();
        return redirect()->to('ward/bed/'.$ward_id)->with('success', 'Bed deleted!');   
    }



    public function ajax_getRoom(){
        helper('form');
        $roomModel = new RoomModel;
        if($this->request->getMethod() == 'post'){
            $ward_id = $this->request->getVar('ward_id');
            $data_table = new TablesIgniter();
            $data_table->setTable($roomModel->roomTable($ward_id))
            ->setDefaultOrder('id', 'DESC')
            ->setSearch(['room_number'])
            ->setOrder(['id', 'updated_at', 'room_number'])
            ->setOutput(['id', $roomModel->_DateFormat(), 'room_number',
                         $roomModel->actionButtons($ward_id)
                        ]);
    
            return $data_table->getDatatable();
        }
    }

    public function deleteRoom($ward_id=null,$room_id=null){
        $roomModel = new RoomModel;
        $roomModel->where('id', $room_id)->delete();
        return redirect()->to('ward/private/'.$ward_id)->with('success', 'Room deleted!');   
    }

}
