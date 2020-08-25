<?php $displayNone = isset($data['profile']) && $data['profile']['is_certified'] ? '' : 'style="display: none;"'; ?>
<?php $displayNoneNotCertified = isset($data['profile']) && !$data['profile']['is_certified'] ? '' : 'style="display: none;"'; ?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group">
            <label for="residence_type"><?php _e('I live in', 'trainee'); ?>:</label>

            <select required name="residence_type" class="form-control" id="residence_type">
                <option value=""><?php _e('Please Select', 'trainee'); ?></option>
                <option <?php selected('1' , $data['profile']['info']['residence_type']); ?> data-id="1" value="1"><?php _e('House', 'trainee'); ?></option>
                <option <?php  echo $data['profile'] ? selected('2' , $data['profile']['info']['residence_type']) : 'selected'; ?> data-id="2" value="2"><?php _e('Apartment', 'trainee'); ?></option>
            </select>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group">
            <label for="residence_city"><?php _e('City', 'trainee'); ?>:</label>
            <select required name="residence_city" class="form-control" id="residence_city">
                <option value=""><?php _e('Please Select', 'trainee'); ?></option>
                <?php foreach ($data['cities'] as $city): ?>
                    <option
                        <?php $data['profile'] ? selected(LcTrainee_Helper::city_slug_refactor($city->slug) , $data['profile']['info']['residence_city']) : selected(LcTrainee_Helper::city_slug_refactor($city->slug), 'skopje'); ?>
                        data-lat="<?php echo LcTrainee_Mapper::lctrainee_city_coordinates(LcTrainee_Helper::city_slug_refactor($city->slug))['lat']; ?>"
                        data-lng="<?php echo LcTrainee_Mapper::lctrainee_city_coordinates(LcTrainee_Helper::city_slug_refactor($city->slug))['lng']; ?>"
                        value="<?php echo LcTrainee_Helper::city_slug_refactor($city->slug); ?>">
                        <?php echo $city->name ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div id="trainee_buildings_map" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 buildings_map">
        <div class="form-group">
            <div id="traineeMap" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
    <div id="trainee_user_address" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 home_address">
        <div class="form-group">
            <label for="address"><?php _e('Address', 'trainee'); ?>:</label>
            <input <?php echo $data['profile'] ? 'readonly' : ''; ?> value="<?php echo $data['profile'] ? $data['profile']['info']['address'] : ''; ?>"
                    autocomplete="off" required type="text" name="address" class="form-control" placeholder="<?php _e('Enter Address', 'trainee'); ?>" id="address">
            <input autocomplete="off"  type="hidden" name="have_certificate" class="form-control"  id="have_certificate" value="<?php echo $data['profile'] && $data['profile']['is_certified'] ? 'true' : '';?>">
            <input autocomplete="off"  type="hidden" name="building_id" class="form-control"  id="building_id" value="<?php echo $data['profile'] ? $data['profile']['info']['building_id'] : ''; ?>">
            <small id="change_street" <?php echo $data['profile'] ? '' : 'style="display: none"'; ?>><a href="#" id="changeStreet"><?php _e('Change street', 'trainee'); ?></a></small>
        </div>

        <div class="col-lg-12 for_certified" <?php echo $displayNone; ?>>
            <h3 style="text-align: center;"><?php _e('This building has energy certificate.', 'trainee'); ?></h3>
        </div>

        <div id="certified_badge" class="energy_mar_pdf for_certified mark_<?php echo isset($data['profile']) ? LcTrainee::lctrainee_get_post_meta('lc_trainee_building_energy_mark_certificate', $data['profile']['info']['building_id']) : '' ?>" <?php echo $displayNone; ?> >
            <span class="energy-mark-title"><?php _e('Energy mark', 'trainee'); ?></span>
            <span id="building_cert" class="energy-mark-span"><?php echo isset($data['profile']) ? LcTrainee_Mapper::lctrainee_energy_marks(LcTrainee::lctrainee_get_post_meta('lc_trainee_building_energy_mark_certificate', $data['profile']['info']['building_id'])) : ''; ?></span>
        </div>

        <div class="form-group for_not_certified" <?php echo $displayNoneNotCertified ?>>
            <label for="yearOfConstruction"><?php _e('Year of construction', 'trainee'); ?></label>
            <input value="<?php echo $data['profile'] ? $data['profile']['info']['yearOfConstruction'] : ''; ?>" autocomplete="off" required type="text" name="yearOfConstruction" class="form-control" placeholder="<?php _e('Enter year of construction', 'trainee'); ?>" id="yearOfConstruction">
            <input type="hidden" name="yearOfConstructionPoints" id="yearOfConstructionPoints">
        </div>

        <div class="form-group for_not_certified" <?php echo $displayNoneNotCertified ?>>
            <label for="sizeInSquare"><?php _e('Size in square meter', 'trainee'); ?></label>
            <input value="<?php echo $data['profile'] ? $data['profile']['info']['sizeInSquare'] : ''; ?>" autocomplete="off" required type="text" name="sizeInSquare" class="form-control" placeholder="<?php _e('Enter size in square meters', 'trainee'); ?>" id="sizeInSquare">
            <input type="hidden" id="sizeInSquarePoints" name="sizeInSquarePoints">
            <small><?php _e('Don\'t include garages, balconies, or patio areas unless they are finished and heated.', 'trainee'); ?></small>
        </div>

        <div class="form-group for_not_certified" <?php echo $displayNoneNotCertified ?>>
            <label for="occupants"><?php _e('Occupants', 'trainee'); ?></label>
            <input value="<?php echo $data['profile'] ? $data['profile']['info']['occupants'] : ''; ?>" autocomplete="off" required type="text" name="occupants" class="form-control" placeholder="<?php _e('How many people do you live with in your home?', 'trainee'); ?>" id="occupants">
            <input type="hidden" id="occupantsPoints" name="occupantsPoints">
            <small><?php _e('The number of people that normally live in your home.', 'trainee'); ?></small>

        </div>

        <div class="col-lg-12 for_certified" <?php echo $displayNone; ?>>
            <hr>
            <h6 style="text-align: center;"><?php _e('How would you like to proceed?', 'trainee'); ?></h6>
        </div>
        <button <?php echo $displayNone; ?> class="btn btn-primary continue_with_q for_certified" >
            <?php _e('Continue with questionnaire', 'trainee'); ?>
        </button>
        <button
                <?php echo $displayNone; ?>
                id="certified_next_button"
                class="btn btn-primary trainee-system-map-next-step for_certified"
                data-current-step="#q-step-1"
                data-next-step="#q-step-2"
                data-question-count=""
                data-next-num="2"
                data-current-num="1"
        >
            <?php _e('Save to Profile', 'trainee'); ?>
        </button>
    </div>
</div>

<?php if($data['profile'] && $data['profile']['coordinates']['lat'] && $data['profile']['coordinates']['lng']): ?>
    <script>
        setTimeout(function () {
            var map = window.hereMap;
            map.setCenter({lat:<?php echo $data['profile']['coordinates']['lat'] ?>, lng:<?php echo $data['profile']['coordinates']['lng']?>});
            map.setZoom(18);
        }, 1000);
    </script>
<?php endif; ?>