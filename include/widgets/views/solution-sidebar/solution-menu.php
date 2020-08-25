<?php foreach ($sections as $section): ?>
<div class="cause-solution-section">
    <div class="cs-section-title">
        <h3><?php echo $section->name; ?></h3>
    </div>

    <div class="cs-causes-container">
        <ul>
            <?php foreach ($section->posts as $cause): ?>
                <li><a href="<?php echo get_the_permalink($cause->ID); ?>" class="cs-cause-title"><?php echo $cause->post_title; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>
<?php endforeach; ?>
