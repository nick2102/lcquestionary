<div id="post-body">
    <div class="wrap">
        <h1 class="wp-heading-inline"> <?php _e('Questionnaire settings', 'trainee'); ?> </h1>
        <div id="poststuff">
            <div class="select_q">
                <label for=""><?php _e('Please select questionnaire', 'trainee'); ?></label>
                <select id="select_q">
                    <option value="">-- <?php _e('Please select', 'trainee'); ?> --</option>
                    <?php if($questionnaires):
                        foreach ($questionnaires as $q) :
                            echo '<option value="'.$q->ID.'">'.$q->post_title.'</option>';
                        endforeach;
                    endif;?>
                </select>
            </div>


            <div id="q-solution-panel-wrapper">

            </div>
        </div>
    </div>
</div>