<?php foreach ($data['options'] as $key => $option):
    $random = sha1(rand() + time());
    $id = str_replace(' ', '', $option->optionName);
    ?>
    <div class="step-option">
            <div class="option-icon">
                <label id="label-<?php echo $id.$random; ?>" class="q-option-label" for="<?php echo $id.$random; ?>">
                    <input data-option-index="<?php echo $key; ?>" data-question-index="<?php echo $data['questionIndex'];?>" data-possible-solution="<?php echo !empty($option->energyPossibleSolution) ? 'true' : ''; ?>" <?php $data['profile'] && isset($data['profile']['info'][$data['questionName']]) ? checked($data['profile']['info'][$data['questionName']], $option->energyLoss) : '' ?> required data-label="#label-<?php echo $id.$random; ?>" class="q-option-check" name="<?php echo $data['questionName']; ?>" id="<?php echo $id.$random; ?>" type="radio" value="<?php echo $option->energyLoss; ?>">
                    <img src="<?php echo $option->energyIcon; ?>" alt="<?php echo $option->optionName; ?>">
                </label>
             </div>
            <div class="option-name">
                <?php echo $option->optionName; ?>
            </div>
    </div>
<?php endforeach; ?>
<textarea name="<?php echo $data['questionName']; ?>_possible_solution" style="display: none" id="<?php echo $data['questionName']; ?>_possible_solution_q"></textarea>
