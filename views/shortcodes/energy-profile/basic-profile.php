<?php $questions = json_decode($data['qTabs']);
?>

<div class="row trainee_pdf_content">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div id="trainee_pdf_content" class="col-lg-12">
                <h5><?php _e('Find out more ways to save', 'trainee'); ?> </h5>
                <p><?php _e('You are off to a good start! There are still ways to save even more. We have identified energy companies to help you save. Review the recommendations, find what is right for your home and get started today.', 'trainee'); ?></p>

                <a href="http://energy-performance-gap.local/questionnaire" class="btn btn-primary"> <?php _e('Learn More', 'trainee') ?></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div id="gauge4" class="gauge-container four  <?php echo $data['energyLevel'];?>">
                <span class="value-text"><?php _e('Energy points', 'trainee'); ?></span>
                <span class="energy-mark-title"><?php _e('Energy mark', 'trainee'); ?></span>
                <span class="energy-mark-span"><?php echo $data['energyMark']; ?></span>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="gauge-container-style four <?php echo $data['energyLevel'];?>">
                <canvas id="canvas1" style="width: 100%; height: auto;"> </canvas>
                <span class="waste_money"><?php _e('Wasting more money', 'trainee'); ?></span>
                <span class="save_money"><?php _e('Saving more money', 'trainee'); ?></span>
                <span class="energy-saving"> <span><?php echo 100 - (integer)$data['energyPoints']['total'] ?>%</span> <?php _e('potential energy savings.'); ?></span>
            </div>
        </div>

        <div class="col-lg-12"> <hr></div>

        <div class="col-lg-6 col-md-6 col-sm-12">
            <canvas id="chart_0" style="height:40vh; width:80vw">
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
            <ul>
                <li><?php _e('Residence Type', 'trainee'); ?>: <?php echo LcTrainee_Mapper::lctrainee_residence($data['energyProfile']['residence_type']); ?></li>
                <li><?php _e('Address', 'trainee'); ?>: <?php echo $data['energyProfile']['address']; ?></li>
                <li ><?php _e('City', 'trainee'); ?>: <?php echo LcTrainee_Mapper::lctrainee_map_city($data['energyProfile']['residence_city'])->name; ?></li>
                <li><?php _e('Year of construction', 'trainee'); ?>: <?php echo $data['energyProfile']['yearOfConstruction']; ?></li>
                <li><?php _e('Size in square meter', 'trainee'); ?>: <?php echo $data['energyProfile']['sizeInSquare']; ?></li>
                <li><?php _e('Occupants', 'trainee'); ?>: <?php echo $data['energyProfile']['occupants']; ?></li>
                <li class="<?php echo $data['energyLevel'];?>"><?php _e('Certification Mark', 'trainee'); ?>: <?php echo $data['energyMark']; ?></li>
            </ul>
        </div>

    </div>

    <?php if($data['possibleSolutions']): ?>
        <div class="row">
            <div class="col-lg-12"> <hr></div>
            <div class="col-lg-12">
                <h2><?php _e('Possible solutions', 'trainee'); ?>: </h2>
            </div>
        </div>
        <div class="row">
            <?php foreach ($data['possibleSolutions'] as $key => $solution): ?>
                <div class="col-lg-12"><h4><?php echo $questions->{$key}->tabTitleEditable; ?></h4></div>

                <?php foreach ($solution as $question): ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="trainee-solution-wrapper">
                            <div class="solution-body">
                                <h6><?php echo $questions->{$key}->questions->{$question->questionIndex}->question; ?></h6>
                                <p><?php _e('Your answer', 'trainee'); ?>: <?php echo $questions->{$key}->questions->{$question->questionIndex}->options->{$question->optionIndex}->optionName; ?></p>
                                <p><?php _e('Solution', 'trainee'); ?>: <?php echo $questions->{$key}->questions->{$question->questionIndex}->options->{$question->optionIndex}->energyPossibleSolution; ?></p>
                            </div>
                            <div class="solution-image">
                                <img src="<?php echo $questions->{$key}->questions->{$question->questionIndex}->options->{$question->optionIndex}->energyIcon; ?>" alt="<?php echo $questions->{$key}->questions->{$question->questionIndex}->question; ?>">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="col-lg-12"><hr></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if($data['solutions']->have_posts()): ?>
        <div class="row">
            <div class="col-lg-12"> <hr></div>
            <div class="col-lg-12">
                <h5><?php _e('Related Causes/Solutions', 'trainee'); ?>: </h5>
            </div>
        </div>

        <div class="row">
            <?php $counterS = 0; while($data['solutions']->have_posts()): $data['solutions']->the_post(); $counterS++; ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="trainee-solution-wrapper">
                    <div class="solution-body">
                        <h2><?php echo get_the_title(); ?></h2>
                        <?php the_excerpt(); ?>
                    </div>
                    <div class="solution-image">
                        <img src="<?php echo LcTrainee_Helper::return_post_img(get_the_ID()); ?>" alt="<?php echo get_the_title(); ?>">
                    </div>
                </div>
            </div>

         <?php if($counterS % 2 == 0) : ?>
             </div><div class="row">
        <?php endif; ?>

        <?php if($counterS >= $data['solutions']->post_count) : ?>
            </div>
        <?php endif; ?>

        <?php endwhile; wp_reset_postdata(); endif;?>

        <div class="row" style="margin-top: 20px;">
            <div class="col-lg-12"> <hr></div>
            <div class="col-lg-12">
                <a href="#" data-pdf-container="#trainee_pdf_content" class="btn btn-primary trainee-save-pdf"> <?php _e('Save to PDF', 'trainee'); ?></a>
                <a href="<?php bloginfo('url'); ?>/questionnaire" class="btn btn-primary"> <?php _e('Back to questionnaire', 'trainee'); ?></a>
            </div>
        </div>

    <div id="trainee_pdf_container" class="trainee_pdf_container">
        <header class="pdf_Header">
            <img src="<?php echo TRAINEE_PLUGIN_URL; ?>/assets/images/trainee-logo.png" alt=""><h5>Trainee | <?php _e('Energy Efficiency Profile', 'trainee'); ?></h5>
        </header>
            <div class="pdf_content">
                <div>
                    <div class="energy_mar_pdf <?php echo $data['energyLevel'];?>">
                        <span class="value-text"><span><?php echo $data['energyPoints']['total']; ?></span> <?php _e('Energy points', 'trainee'); ?></span>
                        <span class="energy-mark-title"><?php _e('Energy mark', 'trainee'); ?></span>
                        <span class="energy-mark-span"><?php echo $data['energyMark']; ?></span>
                    </div>
                </div>

                <div>
                    <div class="gauge-container-style four <?php echo $data['energyLevel'];?>">
                        <canvas id="canvas2" style="width: 100%; height: auto;"> </canvas>
                        <span class="waste_money"><?php _e('Wasting more money', 'trainee'); ?></span>
                        <span class="save_money"><?php _e('Saving more money', 'trainee'); ?></span>
                        <span class="energy-saving"> <span><?php echo 100 - (integer)$data['energyPoints']['total'] ?>%</span> <?php _e('potential energy savings.'); ?></span>
                    </div>
                </div>

                <div>
                    <ul class="building-info">
                        <li><?php _e('Residence Type', 'trainee'); ?>: <?php echo LcTrainee_Mapper::lctrainee_residence($data['energyProfile']['residence_type']); ?></li>
                        <li><?php _e('Address', 'trainee'); ?>: <?php echo $data['energyProfile']['address']; ?></li>
                        <li ><?php _e('City', 'trainee'); ?>: <?php echo LcTrainee_Mapper::lctrainee_map_city($data['energyProfile']['residence_city'])->name; ?></li>
                        <li><?php _e('Year of construction', 'trainee'); ?>: <?php echo $data['energyProfile']['yearOfConstruction']; ?></li>
                        <li><?php _e('Size in square meter', 'trainee'); ?>: <?php echo $data['energyProfile']['sizeInSquare']; ?></li>
                        <li><?php _e('Occupants', 'trainee'); ?>: <?php echo $data['energyProfile']['occupants']; ?></li>
                    </ul>
                </div>
            </div>

        <div class="pdf_graph">
            <h5><?php _e('Energy Efficiency per section', 'trainee'); ?></h5>
            <hr>
            <div style="height: 400px">
                <canvas id="chart_1" >
            </div>

        </div>

        <?php if($data['possibleSolutions']): ?>
            <div class="row">
                <div class="col-lg-12"> <hr></div>
                <div class="col-lg-12">
                    <h2 style="text-align: center"><?php _e('Possible solutions', 'trainee'); ?>: </h2>
                </div>
            </div>
            <div class="row"  style="padding: 0 20px">
                <?php foreach ($data['possibleSolutions'] as $key => $solution): ?>
                    <div class="col-lg-12"><h4 style="text-align: center;"><?php echo $questions->{$key}->tabTitleEditable; ?></h4>
                        <hr>
                    </div>

                    <?php foreach ($solution as $question): ?>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-2">
                                    <img src="<?php echo $questions->{$key}->questions->{$question->questionIndex}->options->{$question->optionIndex}->energyIcon; ?>" alt="<?php echo $questions->{$key}->questions->{$question->questionIndex}->question; ?>">
                                </div>
                                <div class="col-lg-10">
                                    <h6><?php echo $questions->{$key}->questions->{$question->questionIndex}->question; ?></h6>
                                    <p><?php _e('Your answer', 'trainee'); ?>: <?php echo $questions->{$key}->questions->{$question->questionIndex}->options->{$question->optionIndex}->optionName; ?></p>
                                    <p><?php _e('Solution', 'trainee'); ?>: <?php echo $questions->{$key}->questions->{$question->questionIndex}->options->{$question->optionIndex}->energyPossibleSolution; ?></p>
                                </div>
                            </div>
                            <hr>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

<script>
    window.addEventListener('load',function () {
        var points = '<?php echo $data['energyPoints']['total']; ?>';
        var tabsJsonEncoded = <?php echo json_encode($data['qTabs']); ?>;
        var tabsJson = JSON.parse(tabsJsonEncoded);
        var pointsJsonEncoded = '<?php echo json_encode($data['energyPoints']); ?>';
        var pointsJson = JSON.parse(pointsJsonEncoded);

        function chartsColor(points) {
            var colors = [];
            points.forEach(function (value) {
                if (value <= 22) {
                    colors.push("#bc2323");
                } else if (value <= 39) {
                    colors.push("#ee7e1a");
                } else if (value <= 55) {
                    colors.push("#f7aa38");
                } else if (value <= 71) {
                    colors.push("#f7d738");
                } else if (value <= 87) {
                    colors.push("#3cae1c");
                } else {
                    colors.push("#256d13");
                }
            });
            return colors;
        }
        var tabs = Object.keys(tabsJson).map(function(key) {
            return tabsJson[key]['tabTitleEditable'];
        });
        var tabsData = Object.keys(tabsJson).map(function(key) {
            var pKey = tabsJson[key]['tabTitle'] !== 'building_info' ? tabsJson[key]['tabTitle'].toLowerCase() + '_questions' : tabsJson[key]['tabTitle'].toLowerCase();

            if(pKey !== 'total' && pKey !== 'building_info'){
                var percentage = (pointsJson[pKey]/tabsJson[pKey].sectionMaxPoints)*100;
                return  percentage.toFixed(0);
            }

        });
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

        var data = {
            labels: tabs,
            datasets: [{
                label: "<?php _e('Energy efficiency per section', 'trainee'); ?>",
                backgroundColor: chartsColor(tabsData),
                borderColor: chartsColor(tabsData),
                borderWidth: 1,
                hoverBackgroundColor: chartsColor(tabsData),
                hoverBorderColor: chartsColor(tabsData),
                data: tabsData,
            }]
        };

        var option = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    stacked: true,
                    beginAtZero: true,
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 100
                    },
                    gridLines: {
                        display: true,
                        color: "rgba(255,99,132,0.2)"
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';
                        return '<?php _e('Efficiency in percentage', 'trainee'); ?>' + ': '+ tooltipItem.value + '%';
                    },
                }
            }
        };

        Chart.Bar('chart_0', {
            options: option,
            data: data
        });

        Chart.Bar('chart_1', {
            options: option,
            data: data
        });

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
                {strokeStyle: "#bc2323", min: 0, max: 22},
                {strokeStyle: "#ee7e1a", min: 22, max: 39},
                {strokeStyle: "#f7aa38", min: 39, max: 55},
                {strokeStyle: "#f7d738", min: 55, max: 71},
                {strokeStyle: "#3cae1c", min: 71, max: 87},
                {strokeStyle: "#256d13", min: 87, max: 100}
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