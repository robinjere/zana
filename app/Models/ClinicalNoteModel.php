<?php

namespace App\Models;

use CodeIgniter\Model;

class ClinicalNoteModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'clinicalnotes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['file_id', 'main_complain', 'history_of_present', 'past_medical_history', 'family_social_history', 'drug_allergy_history', 'review_complain', 'physical_examination', 'doctor','created_at', 'updated_at', 'treatment_ended'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    //clinical notes
    public function getClinicalNotes($file_id, $start_date=null, $end_date=null){
        $builder = $this->db->table('clinicalnotes');
        $builder->select('clinicalnotes.id, clinicalnotes.updated_at, clinicalnotes.main_complain, clinicalnotes.history_of_present, clinicalnotes.past_medical_history, clinicalnotes.family_social_history, clinicalnotes.drug_allergy_history, clinicalnotes.review_complain, clinicalnotes.physical_examination, user.first_name, user.last_name, clinicalnotes.doctor');
        $builder->orderBy('clinicalnotes.id', 'DESC');
        $builder->join('user', 'clinicalnotes.doctor = user.id');
        // $builder->join('user', 'assigned_procedures.doctor = user.id');
        $builder->groupStart();
        if($start_date != null && $end_date !=null){
            $builder->where('DATE(clinicalnotes.updated_at) BETWEEN "'. date('Y-m-d', strtotime($start_date)) .'" and "'. date('Y-m-d', strtotime($end_date)) .'"');
        }
        $builder->where('clinicalnotes.file_id', $file_id);
        if(session()->get('clinic')){
            $builder->where('clinic_doctors.clinic_id', session()->get('clinic'));
            $builder->join('clinic_doctors', 'user.id = clinic_doctors.user_id');
        }
        $builder->groupEnd();
        return $builder->get()->getResult();
    }

    
}
