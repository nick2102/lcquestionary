<div class="wrap">
    <h1><?php _e('Shortcode List', 'trainee'); ?></h1>
    <hr>
    <div class="trainee-field-set">
        <table class="form-table" role="presentation">
            <tbody>
            <?php foreach ($data as $key => $shortcode): ?>
                <tr>
                    <th scope="row"><label for="blogname"><?php echo $shortcode['title']; ?></label></th>
                    <td><input  readonly type="text"  value="<?php echo $shortcode['shortcode']; ?>" class="regular-text"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>