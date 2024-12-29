<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
$min_salary = get_post_meta( $post->ID, 'min_salary', true );
$max_salary = get_post_meta( $post->ID, 'max_salary', true );
$job_expired = get_post_meta( $post->ID, 'job_expired', true );
$job_currency = get_post_meta( $post->ID, 'job_currency', true );
$currencies = array(
    'vnd' => 'VNĐ',
    'dolla' => 'Dolla'
);
$job_unit = get_post_meta( $post->ID, 'job_unit', true );
$units = array(
    'year' => __( 'Year', 'tried' ),
    'month' => __( 'Month', 'tried' ),
    'week' => __( 'Week', 'tried' ),
    'day' => __( 'Day', 'tried' ),
    'hour' => __( 'Hour', 'tried' )
);
?>

<fieldset class="metabox-block">
    <legend class="metabox-title"><?php _e( 'Job Salary', 'tried' ); ?></legend>
    <article class="metabox-article grid grid-col3">
        <div class="metabox-option <?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Min Salary', 'tried' ); ?>:</h4>
            <div class="option-wrapper price">
                <div class="option-inpt">
                    <input type="text" name="min_salary"
                        value="<?php echo filter_var( $min_salary, FILTER_SANITIZE_NUMBER_INT ); ?>" placeholder="0"
                        pattern="\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" />
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
        <div class="metabox-option <?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Max Salary', 'tried' ); ?>:</h4>
            <div class="option-wrapper price">
                <div class="option-inpt">
                    <input type="text" name="max_salary"
                        value="<?php echo filter_var( $max_salary, FILTER_SANITIZE_NUMBER_INT ); ?>" placeholder="0"
                        pattern="\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" />
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
    </article>
</fieldset>
<fieldset class="metabox-block">
    <legend class="metabox-title"><?php _e( 'Job Extend', 'tried' ); ?></legend>
    <article class="metabox-article grid grid-col3">
        <!-- <div class="metabox-option <?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Job Expiry', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <input type="date" class="hasDatepicker" name="job_expired" value="<?php echo $job_expired; ?>"
                        placeholder="dd/mm/YYYY" />
                </div>
                <p class="option-desc"></p>
            </div>
        </div> -->
        <div class="metabox-option <?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Currency', 'tried' ); ?>:</h4>
            <div class="option-wrapper price">
                <div class="option-inpt">
                    <select class="input-field" name="job_currency">
                        <option value=""><?php _e( 'Choose currency', 'tried' ); ?></option>
                        <?php
                            if ( !empty( $currencies ) ) {
                                foreach ( $currencies as $c => $currency ) {
                                    printf( '<option value="%s" %s>%s</option>', $c, selected( $c, $job_currency ),$currency );
                                }
                            }
                        ?>
                    </select>
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
        <div class="metabox-option <?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Unit', 'tried' ); ?>:</h4>
            <div class="option-wrapper price">
                <div class="option-inpt">
                    <select class="input-field" name="job_unit">
                        <option value=""><?php _e( 'Choose unit', 'tried' ); ?></option>
                        <?php
                            if ( !empty( $units ) ) {
                                foreach ( $units as $u => $unit ) {
                                    printf( '<option value="%s" %s>%s</option>', $u, selected( $u, $job_unit ), $unit );
                                }
                            }
                        ?>
                    </select>
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
    </article>
</fieldset>