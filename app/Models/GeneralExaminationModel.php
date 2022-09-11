<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneralExaminationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'general_examination';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pressure', 'temperature', 'pulse_rate', 'weight',
        'height','body_mass','body_surface_area',
        'body_mass_comment','saturation_of_oxygen',
        'respiratory_rate','description','patient_file','added_by',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks..
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    //check if examination entered..
    public function checkIfExaminationEntered($file_id, $start_treatment, $end_treatment){
                
        $builder = $this->db->table('general_examination');        
        $builder->select('general_examination.id');
        $builder->join('patients_file', 'patients_file.id = general_examination.patient_file');
        
        //  -------------- **** ---------- //

        $builder->groupStart();
        
        $builder->where('general_examination.patient_file', $file_id);
        // $builder->where('DATE(patients_file.start_treatment) >=', $start_treatment);
        // $builder->where('DATE(patients_file.end_treatment) <=', $end_treatment );
        $builder->where('DATE(patients_file.start_treatment) >=', date('Y-m-d', strtotime($start_treatment)));
        
        if(strtotime($end_treatment) < strtotime(date("Y-m-d"))){
            $builder->where('DATE(patients_file.end_treatment) <=', date('Y-m-d', strtotime($end_treatment)));
        }

        // --------- **** ------  //

        $builder->groupEnd();
        return $builder->get()->getRow();
        
    }

    //get examination
    public function getExamination($file_id, $start_treatment, $end_treatment){
        $builder = $this->db->table('general_examination');        
        $builder->select('general_examination.pressure, general_examination.temperature, general_examination.pulse_rate, general_examination.weight, general_examination.height, general_examination.body_mass, general_examination.body_surface_area, general_examination.body_mass_comment, general_examination.saturation_of_oxygen,general_examination.respiratory_rate,general_examination.description,general_examination.added_by');
        $builder->join('patients_file', 'patients_file.id = general_examination.patient_file');
        
        //  -------------- **** ---------- //
        $builder->groupStart();
        
        $builder->where('general_examination.patient_file', $file_id);
        // $builder->where('DATE(patients_file.start_treatment) >=', $start_treatment);
        // $builder->where('DATE(patients_file.end_treatment) <=', $end_treatment );
        $builder->where('DATE(patients_file.start_treatment) >=', date('Y-m-d', strtotime($start_treatment)));
        
        if(strtotime($end_treatment) < strtotime(date("Y-m-d"))){
            $builder->where('DATE(patients_file.end_treatment) <=', date('Y-m-d', strtotime($end_treatment)));
        }

        // --------- **** ------  //
        $builder->groupEnd();
        return $builder->get()->getRow();
    }

    // Save Examination,
    // public function saveExamination(Array $examinationData){
    //     $builder = $this->db->table('generalexaminations');
    //     $builder->where('DATE(assigneddiagnoses.updated_at) BETWEEN "'. date('Y-m-d', strtotime($examinationData['start_treatment'])) .'" and "'. date('Y-m-d', strtotime($examinationData['end_treatment'])) .'"');
    // }
    
}
