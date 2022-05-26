<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PatientController extends BaseController
{
    public function index()
    {
        return view('Patient/patient_dashboard');
    }

    public function register(){
        helper('form');
        $data = [];
        return view('Patient/register', $data);
    }
}
