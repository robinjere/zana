<?= $this->extend('./patient/history/layout') ?>
<?= $this->section('history') ?>
<div>
    <?php 
     if(!empty($clinical_notes)){
     foreach ($clinical_notes as $key => $value) { ?>
         <div class="mt-4">
            <p> - Clinical note added by doctor : <?= strtoupper($value->first_name) .', '. strtoupper($value->last_name) .' | ' . date_format(date_create($value->updated_at ), 'd-m-Y') ?>  </p>
                <form class="disabled">
                <div  class="clinical_note_container p-3 mt-3">
                    <div class="note-section main_complain">
                        <span>Main complain  </span>
                        <textarea name="main_complain" disabled class="disabled form-control mb-2 pt-4" cols="30" rows="3"><?= $value->main_complain ?></textarea>
                    </div> <!-- /main_complain -->
                    <div class="note-section history_of_presert">  
                        <span>History of present illness  </span>
                        <textarea name="history_of_present" disabled class="disabled form-control mb-2 pt-4" cols="30" rows="3"><?= $value->history_of_present ?></textarea>
                    </div> <!-- /history_of_presert -->
                    <div class="note-section past_medical_history">  
                        <span>Past medical history  </span>
                        <textarea name="past_medical_history" disabled class="disabled form-control mb-2 pt-4" cols="30" rows="3"><?= $value->past_medical_history ?></textarea>
                    </div> <!-- /past_medical_history -->
                    <div class="note-section family_social_history">  
                        <span>Family social history  </span>
                        <textarea name="family_social_history" disabled class="disabled form-control mb-2 pt-4" cols="30" rows="3"><?= $value->family_social_history ?></textarea>
                    </div> <!-- /family_social_history -->
                    <div class="note-section family_social_history">  
                        <span> Drug and allergy history   </span>
                        <textarea name="drug_allergy_history" disabled class="disabled form-control mb-2 pt-4" cols="30" rows="3"><?= $value->drug_allergy_history ?></textarea>
                    </div> <!-- /family_social_history -->
                    <div class="note-section review_complain">  
                        <span>Review of other complain  </span>
                        <textarea name="review_complain" disabled class="disabled form-control mb-2 pt-4" cols="30" rows="3"><?= $value->review_complain ?></textarea>
                    </div> <!-- /review_complain -->
                    <div class="note-section review_complain">  
                        <span>Physical Examination   </span>
                        <textarea name="physical_examination" disabled class="disabled form-control mb-2 pt-4" cols="30" rows="3"><?= $value->physical_examination ?></textarea>
                    </div> <!-- /review_complain -->
                </div><!-- /clinical_note_container -->
            </form>
        </div>
    <?php
     }
    }else{ ?>
         <p> No history! </p>   
    <?php }
    ?>

</div>
<?= $this->endSection('history') ?>