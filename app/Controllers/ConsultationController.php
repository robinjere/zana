<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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

    public function add_fee(){
        return view('consultation/add_fee');
    }
}
