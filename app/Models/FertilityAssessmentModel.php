<?php

namespace App\Models;

use CodeIgniter\Model;

class FertilityAssessmentModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'fertility_assessment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'patient_id',
        'hospital_number',
        'clinic_number',
        'occupation',
        'height',
        'weight',
        'is_drug_allergy',
        'drug_allergy_mention',
        'is_genetic_disease',
        'genetic_disease_mention',
        'is_gynecological_history',
        'gynecological_history_mention',
        'is_pelvic_surgery',
        'pelvic_surgery_mention',
        'is_contraception',
        'contraception_mention',
        'rubella',
        'hepatitis',
        'other',
        'is_menstrualcycle_regular',
        'lnmp',
        'cycle_length',
        'dysmenorrhea',
        'conceive',
        'months',
        'years',
        'is_pregnant',
        'pregnant_mention',
        'current_relationship_para',
        'previous_relationship_para',
        'no_of_abortions',
        'GA',
        'ectopic_pregnancy',
        'is_fertility_treatment',
        'fertility_treatment_mention',
        'is_chronic_diseases',
        'chronic_diseases_mention',
        'is_current_medication',
        'current_medication',
        'is_smoke',
        'cigarettes_per_day',
        'is_alcohol',
        'unit_per_week',
        'is_recreational_drugs',
        'how_long',
        'currently_recreational_drugs',
        'is_regular_periods',
        'ultrasound',
        'HSG_HSU',
        'TSH',
        'i_ultrasound',
        'i_HSG_HSU',
        'i_FSH_LH',
        'i_TSH',
        'is_irregular_periods'

    ];

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

    function check_fertility_data($patient_id, $start_date, $end_date){
        $builder = $this->db->table('fertility_assessment');        
        $builder->where('patient_id', $patient_id);
        $builder->where('DATE(updated_at) >=', date('Y-m-d', strtotime($start_date)));
        if(strtotime($end_date) <= strtotime(date("Y-m-d"))){
            $builder->where('DATE(updated_at) <=', date('Y-m-d', strtotime($end_date)));
        }
        return $builder->get()->getRow();
    }
}
