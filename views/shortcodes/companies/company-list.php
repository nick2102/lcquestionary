<div class="container">
    <div id="trainee-companies">
        <?php if($data->have_posts()) : ?>
            <?php while($data->have_posts()) : $data->the_post(); $meta = get_post_meta(get_the_ID()); $id= get_the_ID();
                include TRAINEE_PLUGIN_DIR . 'views/shortcodes/companies/company.php';
            endwhile; wp_reset_postdata(); ?>
     </div>
        <?php if($data->post_count >= 50 ): ?>
            <div class="row">
                <div class="col-lg-12">
                    <a href="#" class="btn btn-primary btn-load-more-companies" data-offset="20"> <?php _e('Load more', 'trainee'); ?></a>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-12">
                <p class="alert alert-warning"> <?php _e('The list is currently empty. Please check later.'); ?> </p>
            </div>
        </div>
    <?php endif ?>
</div>