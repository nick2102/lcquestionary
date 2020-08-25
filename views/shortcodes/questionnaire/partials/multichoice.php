<?php foreach ($data['options'] as $option):
    $random = sha1(rand() + time());
    $id = str_replace(' ', '', $option->optionName); ?>
    <div class="step-option">
        <div class="option-icon">
            <label id="label-<?php echo $id.$random; ?>" class="q-option-label" for="<?php echo $id.$random; ?>">
                <input required data-label="#label-<?php echo $id.$random; ?>" class="q-option-check" name="<?php echo $data['questionName']; ?>[]" id="<?php echo $id.$random; ?>" type="checkbox" value="<?php echo $option->energyLoss; ?>">
                <img src="<?php echo $option->energyIcon; ?>" alt="<?php echo $option->optionName; ?>">
            </label>
        </div>
        <div class="option-name">
            <?php echo $option->optionName; ?>
        </div>
    </div>
<?php endforeach; ?>
