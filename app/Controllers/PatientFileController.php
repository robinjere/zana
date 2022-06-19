<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PatientFileController extends BaseController
{
    public function index()
    {
        return view('patientfile/file');
    }
}
