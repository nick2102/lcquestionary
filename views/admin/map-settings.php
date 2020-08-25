<div id="post-body">
    <div class="wrap">
        <h1 class="wp-heading-inline"> <?php _e('Map step settings', 'trainee'); ?> </h1>


        <div class="tabLongTitle">
            <div>
                <label for="trainee_years_range"><?php _e('Enter years range with the points, comma separated', 'trainee'); ?>.</label>
                <p><?php _e('Ex: 1990:1998#10 this means if user enters between 1990 and 1998 he will get 10 points for this question', 'trainee'); ?>.</p>
                <textarea id="trainee_years_range" class="longTitle" name="trainee_years_range" type="text" placeholder=""></textarea>
            </div>
        </div>

        <div class="tabLongTitle">
            <div>
                <label for="trainee_square_range"><?php _e('Enter square meter range with the points, comma separated', 'trainee'); ?>.</label>
                <p><?php _e('Ex: 30:45#10 this means if user enters between 30 and 45 he will get 10 points for this question', 'trainee'); ?>.</p>
                <textarea id="trainee_square_range" class="longTitle" name="trainee_square_range" type="text" placeholder=""></textarea>
            </div>
        </div>

        <div class="tabLongTitle">
            <div>
                <label for="trainee_occupants_range"><?php _e('Enter occupants range with the points, comma separated', 'trainee'); ?>.</label>
                <p><?php _e('Ex: 1:3#10 this means if user enters between 1 and 3 he will get 10 points for this question', 'trainee'); ?>.</p>
                <textarea id="trainee_occupants_range" class="longTitle" name="trainee_occupants_range" type="text" placeholder=""></textarea>
            </div>
        </div>

    </div>
</div>