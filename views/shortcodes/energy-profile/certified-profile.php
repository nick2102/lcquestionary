<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div id="trainee_pdf_content" class="col-lg-12">
            <h5><?php _e('Find out more ways to save', 'trainee'); ?> </h5>
            <p><?php _e('You are off to a good start! There are still ways to save even more. We have identified energy companies to help you save. Review the recommendations, find what is right for your home and get started today.', 'trainee'); ?></p>

            <a href="http://energy-performance-gap.local/questionnaire" class="btn btn-primary"> <?php _e('Learn More', 'trainee') ?></a>

            <hr>
            <h3><?php _e('This building has been certified!', 'trainee'); ?></h3>
            <ul>
                <li><?php _e('Residence Type', 'trainee'); ?>: <?php echo LcTrainee_Mapper::lctrainee_residence($data['energyProfile']['residence_type']); ?></li>
                <li><?php _e('Address', 'trainee'); ?>: <?php echo $data['info']->post_title; ?></li>
                <li><?php _e('City', 'trainee'); ?>: <?php echo $data['city']->name; ?></li>
                <li><?php _e('Certification Mark', 'trainee'); ?>: <?php echo LcTrainee_Mapper::lctrainee_energy_marks($data['meta']['lc_trainee_building_energy_mark_certificate'][0]); ?></li>
                <li><?php _e('Building primary energy', 'trainee'); ?>: <?php echo $data['meta']['lc_trainee_building_primary_energy'][0]; ?></li>
                <li><?php _e('Building needed heating energy', 'trainee'); ?>: <?php echo $data['meta']['lc_trainee_building_needed_heating_energy'][0]; ?></li>
                <li><a href="<?php echo $data['meta']['lc_trainee_building_certificate'][0] ?>" target="_blank"><?php _e('Certificate', 'trainee'); ?></a></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12">
        <div id="gauge4" class="gauge-container four  mark_<?php echo $data['meta']['lc_trainee_building_energy_mark_certificate'][0];?>">
            <span class="value-text"><?php _e('Energy points', 'trainee'); ?></span>
            <span class="energy-mark-title"><?php _e('Energy mark', 'trainee'); ?></span>
            <span class="energy-mark-span"><?php echo LcTrainee_Mapper::lctrainee_energy_marks($data['meta']['lc_trainee_building_energy_mark_certificate'][0]); ?></span>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12">
        <div class="gauge-container-style four  mark_<?php echo $data['meta']['lc_trainee_building_energy_mark_certificate'][0];?>">
            <canvas id="canvas1" style="width: 100%; height: auto;"> </canvas>
            <span class="waste_money"><?php _e('Wasting more money', 'trainee'); ?></span>
            <span class="save_money"><?php _e('Saving more money', 'trainee'); ?></span>
            <span class="energy-saving"> <span><?php echo 100 - (integer)LcTrainee_Mapper::points_by_mark($data['meta']['lc_trainee_building_energy_mark_certificate'][0]); ?>%</span> <?php _e('potential energy savings.'); ?></span>
        </div>
    </div>

    <div class="col-lg-12"> <hr></div>

        <div class="col-lg-12">
            <a href="#" data-pdf-container="#trainee_pdf_content" class="btn btn-primary trainee-save-pdf"> <?php _e('Save to PDF', 'trainee'); ?></a>
            <a href="<?php bloginfo('url'); ?>/questionnaire" class="btn btn-primary"> <?php _e('Back to questionnaire', 'trainee'); ?></a>
        </div>
    </div>
</div>

<div class="trainee_pdf_container">
    <div class="pdf_Header">
        <img src="<?php echo TRAINEE_PLUGIN_URL; ?>/assets/images/trainee-logo.png" alt=""><h5>Trainee | <?php _e('Energy Efficiency Profile', 'trainee'); ?></h5>
    </div>
    <div class="pdf_content certified">
        <div>
            <div class="energy_mar_pdf mark_<?php echo $data['meta']['lc_trainee_building_energy_mark_certificate'][0]; ?>" >
                <span class="value-text"><span><?php echo LcTrainee_Mapper::points_by_mark($data['meta']['lc_trainee_building_energy_mark_certificate'][0]); ?></span> <?php _e('Energy points', 'trainee'); ?></span>
                <span class="energy-mark-title"><?php _e('Energy mark', 'trainee'); ?></span>
                <span class="energy-mark-span"><?php echo LcTrainee_Mapper::lctrainee_energy_marks($data['meta']['lc_trainee_building_energy_mark_certificate'][0]); ?></span>
            </div>
        </div>

        <div>
            <div class="gauge-container-style four  mark_<?php echo $data['meta']['lc_trainee_building_energy_mark_certificate'][0];?>">
                <canvas id="canvas2" style="width: 100%; height: auto;"> </canvas>
                <span class="waste_money"><?php _e('Wasting more money', 'trainee'); ?></span>
                <span class="save_money"><?php _e('Saving more money', 'trainee'); ?></span>
                <span class="energy-saving"> <span><?php echo 100 - (integer)LcTrainee_Mapper::points_by_mark($data['meta']['lc_trainee_building_energy_mark_certificate'][0]); ?>%</span> <?php _e('potential energy savings.'); ?></span>
            </div>
        </div>
    </div>

    <div style="padding: 0 15px; margin-top: 100px;">
        <h5 style="text-align: center;"><?php _e('Certified Building', 'trainee'); ?></h5>
        <hr>
        <ul class="building-info certified">
            <li><?php _e('Residence Type', 'trainee'); ?>: <?php echo LcTrainee_Mapper::lctrainee_residence($data['energyProfile']['residence_type']); ?></li>
            <li><?php _e('Address', 'trainee'); ?>: <?php echo $data['info']->post_title; ?></li>
            <li><?php _e('City', 'trainee'); ?>: <?php echo $data['city']->name; ?></li>
            <li><?php _e('Certification Mark', 'trainee'); ?>: <?php echo LcTrainee_Mapper::lctrainee_energy_marks($data['meta']['lc_trainee_building_energy_mark_certificate'][0]); ?></li>
            <li><?php _e('Building primary energy', 'trainee'); ?>: <?php echo $data['meta']['lc_trainee_building_primary_energy'][0]; ?></li>
            <li><?php _e('Building needed heating energy', 'trainee'); ?>: <?php echo $data['meta']['lc_trainee_building_needed_heating_energy'][0]; ?></li>
        </ul>
    </div>

    <div class="pdf_Footer">
        <small>© <?php echo date('Y'); ?> <?php _e('Project TRAINEE - TowaRd market-based skills for sustAINable Energy Efficient construction', 'trainee'); ?> </small>
    </div>


<script>
    window.addEventListener('load',function () {
        var points = '<?php echo LcTrainee_Mapper::points_by_mark($data['meta']['lc_trainee_building_energy_mark_certificate'][0]); ?>';
        var gauge2 = Gauge2(
            document.getElementById("gauge4"), {
                min: 0,
                max: 100,
                dialStartAngle: 90,
                dialEndAngle: 0,
                value: 10,

                color: function (value) {
                    if (value <= 22) {
                        return "#bc2323";
                    } else if (value <= 39) {
                        return "#ee7e1a";
                    } else if (value <= 55) {
                        return "#f7aa38";
                    } else if (value <= 71) {
                        return "#f7d738";
                    } else if (value <= 87) {
                        return "#3cae1c";
                    } else {
                        return "#256d13";
                    }
                }
            }
        );
        gauge2.setValueAnimated(points, 2);

        var cont = jQuery('#canvas1');
        var cont2 = jQuery('#canvas2');

        var gauge = new Gauge(cont.get(0));
        var gauge3 = new Gauge(cont2.get(0));

        var opts = {
            angle: 0.0,
            lineWidth: 0.31,
            radiusScale: 1,
            pointer: {
                length: 0.45,
                strokeWidth: 0.03,
                color: '#256d13'
            },
            staticZones: [
                {strokeStyle: "#bc2323", min: 0, max: 16},
                {strokeStyle: "#ee7e1a", min: 16, max: 32},
                {strokeStyle: "#f7aa38", min: 32, max: 48},
                {strokeStyle: "#f7d738", min: 48, max: 64},
                {strokeStyle: "#3cae1c", min: 64, max: 80},
                {strokeStyle: "#256d13", min: 80, max: 100}
            ]
        };
        gauge.setOptions(opts);
        gauge.maxValue = 100;
        gauge.animationSpeed = 32;
        gauge.set(points);

        gauge3.setOptions(opts);
        gauge3.maxValue = 100;
        gauge3.animationSpeed = 32;
        gauge3.set(points);

    });

</script>