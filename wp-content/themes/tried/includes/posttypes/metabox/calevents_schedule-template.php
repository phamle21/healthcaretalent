<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
$video = get_post_meta( $post->ID, 'video', true );
$location = get_post_meta( $post->ID, 'location', true );
$publish = get_post_meta( $post->ID, 'publish', true );

$agenda_calevent = get_post_meta( $post->ID, 'agenda_calevent', true );
$picture_calevent = get_post_meta( $post->ID, 'picture_calevent', true );
$sponsor_calevent = get_post_meta( $post->ID, 'sponsor_calevent', true );
?>

<fieldset class="metabox-block">
    <div id="taxonomy-tried_calevents" class="categorydiv">
        <ul id="tried_calevents-tabs" class="category-tabs">
            <li class="tabs"><a href="#agenda_calevents-tab"><?php _e( 'Agenda', 'tried' ); ?></a></li>
            <li><a href="#picture_calevents-tab"><?php _e( 'Picture', 'tried' ); ?></a></li>
            <li><a href="#sponsor_calevents-tab"><?php _e( 'Sponsor', 'tried' ); ?></a></li>
        </ul>
        <div id="agenda_calevents-tab" class="tabs-panel">
            <a class="button button-primary addnew-calevents" href="javascript:void(0)"
                title="<?php _e( 'Add new', 'tried' ); ?>"
                style="position: absolute; right: 12px; top: 12px; z-index: 3;"><?php _e( 'Add new', 'tried' ); ?></a>
            <table class="form-table">
                <tbody>
                    <?php
                        if ( !empty( $agenda_calevent ) ) {
                            for ( $agd = 0; $agd < count( $agenda_calevent['title'] ); $agd++ ) {
                                printf(
                                    '<tr>
                                        <th><label>%s</label></th>
                                        <td>
                                            <h4 style="margin: 10px 0;">%s</h4>
                                            <input type="time" name="agenda_calevent[time_start][]" value="%s" required/>
                                            <h4 style="margin: 10px 0;">%s</h4>
                                            <input type="time" name="agenda_calevent[time_finish][]" value="%s" required/>
                                            <h4 style="margin: 10px 0;">%s</h4>
                                            <input type="text" name="agenda_calevent[title][]" value="%s" required/>
                                            <h4 style="margin: 10px 0;">%s</h4>
                                            <textarea name="agenda_calevent[content][]">%s</textarea>
                                            <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                        </td>
                                    </tr>',
                                    __( 'Item', 'tried' ),
                                    __( 'Time start', 'tried' ),
                                    $agenda_calevent['time_start'][$agd],
                                    __( 'Time Finish', 'tried' ),
                                    $agenda_calevent['time_finish'][$agd],
                                    __( 'Title', 'tried' ),
                                    $agenda_calevent['title'][$agd],
                                    __( 'Content', 'tried' ),
                                    $agenda_calevent['content'][$agd],
                                    __( 'Delete', 'tried' ),
                                    __( 'Delete', 'tried' )
                                );
                            }
                        } else {
                            printf(
                                '<tr>
                                    <th><label>%s</label></th>
                                    <td>
                                        <h4 style="margin: 10px 0;">%s</h4>
                                        <input type="time" name="agenda_calevent[time_start][]" value="" required/>
                                        <h4 style="margin: 10px 0;">%s</h4>
                                        <input type="time" name="agenda_calevent[time_finish][]" value="" required/>
                                        <h4 style="margin: 10px 0;">%s</h4>
                                        <input type="text" name="agenda_calevent[title][]" value="" required/>
                                        <h4 style="margin: 10px 0;">%s</h4>
                                        <textarea name="agenda_calevent[content][]" required></textarea>
                                        <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                    </td>
                                </tr>',
                                __( 'Item', 'tried' ),
                                __( 'Time start', 'tried' ),
                                __( 'Time Finish', 'tried' ),
                                __( 'Title', 'tried' ),
                                __( 'Content', 'tried' ),
                                __( 'Delete', 'tried' ),
                                __( 'Delete', 'tried' )
                            );
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div id="picture_calevents-tab" class="tabs-panel" style="display:none">
            <a class="button button-primary addnew-calevents" href="javascript:void(0)"
                title="<?php _e( 'Add new', 'tried' ); ?>"
                style="position: absolute; right: 12px; top: 12px; z-index: 3;"><?php _e( 'Add new', 'tried' ); ?></a>
            <table class="form-table">
                <tbody>
                    <?php
                        if ( !empty( $picture_calevent ) ) {
                            for ( $pct = 0; $pct < count( $picture_calevent['image'] ); $pct++ ) {
                                printf(
                                    '<tr>
                                        <th><label>%s</label></th>
                                        <td>
                                            <h4 style="margin: 10px 0;">%s</h4>
                                            <input type="text" name="picture_calevent[image][]" value="%s" required/>
                                            <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                        </td>
                                    </tr>',
                                    __( 'Item', 'tried' ),
                                    __( 'Picture', 'tried' ),
                                    $picture_calevent['image'][$pct],
                                    __( 'Delete', 'tried' ),
                                    __( 'Delete', 'tried' )
                                );
                            }
                        } else {
                            printf(
                                '<tr>
                                    <th><label>%s</label></th>
                                    <td>
                                        <h4 style="margin: 10px 0;">%s</h4>
                                        <input type="text" name="picture_calevent[image][]" value="" required/>
                                        <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                    </td>
                                </tr>',
                                __( 'Item', 'tried' ),
                                __( 'Picture', 'tried' ),
                                __( 'Delete', 'tried' ),
                                __( 'Delete', 'tried' )
                            );
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div id="sponsor_calevents-tab" class="tabs-panel" style="display:none">
            <div class="tabs-panel" style="position: relative;">
                <table class="form-table">
                    <thead>
                        <tr>
                            <th><label><?php _e( 'Info Content', 'tried' ); ?></label></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Title', 'tried' ); ?></label></th>
                            <td>
                                <input type="text" name="sponsor_calevent[0][title]"
                                    value="<?php echo $sponsor_calevent[0]['title'] ?: ''; ?>"
                                    placeholder="<?php _e( 'Enter title of sponsor', 'tried' ); ?>" required />
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Description', 'tried' ); ?></label></th>
                            <td>
                                <textarea name="sponsor_calevent[0][description]" cols="30" rows="4"
                                    placeholder="<?php _e( 'Enter title of sponsor', 'tried' ); ?>"
                                    required><?php echo $sponsor_calevent[0]['description'] ?: ''; ?></textarea>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="tabs-panel" style="position: relative;">
                <a class="button button-primary addnew-calevents" href="javascript:void(0)"
                    title="<?php _e( 'Add new', 'tried' ); ?>"
                    style="position: absolute; right: 12px; top: 12px; z-index: 3;"><?php _e( 'Add new', 'tried' ); ?></a>
                <table class="form-table">
                    <thead>
                        <tr>
                            <th><label><?php _e( 'Group 1', 'tried' ); ?></label></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Title', 'tried' ); ?></label></th>
                            <td>
                                <input type="text" name="sponsor_calevent[1][title]"
                                    value="<?php echo $sponsor_calevent[1]['title'] ?: ''; ?>"
                                    placeholder="<?php _e( 'Enter title of group', 'tried' ); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Title(color)', 'tried' ); ?></label></th>
                            <td>
                                <input type="color" name="sponsor_calevent[1][title_color]"
                                    value="<?php echo $sponsor_calevent[1]['title_color'] ?: '#000'; ?>" required />
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ( isset( $sponsor_calevent[1]['picture'] ) && !empty( $sponsor_calevent[1]['picture'] ) ) {
                                for ( $sps1 = 0; $sps1 < count( $sponsor_calevent[1]['picture'] ); $sps1++ ) {
                                    printf(
                                        '<tr>
                                            <th><label>%s</label></th>
                                            <td>
                                                <h4 style="margin: 10px 0;">%s</h4>
                                                <input type="text" name="sponsor_calevent[1][picture][]" value="%s" required/>
                                                <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                            </td>
                                        </tr>',
                                        __( 'Item', 'tried' ),
                                        __( 'Picture', 'tried' ),
                                        $sponsor_calevent[1]['picture'][$sps1],
                                        __( 'Delete', 'tried' ),
                                        __( 'Delete', 'tried' )
                                    );
                                }
                            } else {
                                printf(
                                    '<tr>
                                        <th><label>%s</label></th>
                                        <td>
                                            <h4 style="margin: 10px 0;">%s</h4>
                                            <input type="text" name="sponsor_calevent[1][picture][]" value="" required/>
                                            <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                        </td>
                                    </tr>',
                                    __( 'Item', 'tried' ),
                                    __( 'Picture', 'tried' ),
                                    __( 'Delete', 'tried' ),
                                    __( 'Delete', 'tried' )
                                );
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="tabs-panel" style="position: relative;">
                <a class="button button-primary addnew-calevents" href="javascript:void(0)"
                    title="<?php _e( 'Add new', 'tried' ); ?>"
                    style="position: absolute; right: 12px; top: 12px; z-index: 3;"><?php _e( 'Add new', 'tried' ); ?></a>
                <table class="form-table">
                    <thead>
                        <tr>
                            <th><label><?php _e( 'Group 2', 'tried' ); ?></label></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Title', 'tried' ); ?></label></th>
                            <td>
                                <input type="text" name="sponsor_calevent[2][title]"
                                    value="<?php echo $sponsor_calevent[2]['title'] ?: ''; ?>"
                                    placeholder="<?php _e( 'Enter title of group', 'tried' ); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Title(color)', 'tried' ); ?></label></th>
                            <td>
                                <input type="color" name="sponsor_calevent[2][title_color]"
                                    value="<?php echo $sponsor_calevent[2]['title_color'] ?: '#000'; ?>" required />
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ( isset( $sponsor_calevent[2]['picture'] ) && !empty( $sponsor_calevent[2]['picture'] ) ) {
                                for ( $sps2 = 0; $sps2 < count( $sponsor_calevent[2]['picture'] ); $sps2++ ) {
                                    printf(
                                        '<tr>
                                            <th><label>%s</label></th>
                                            <td>
                                                <h4 style="margin: 10px 0;">%s</h4>
                                                <input type="text" name="sponsor_calevent[2][picture][]" value="%s" required/>
                                                <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                            </td>
                                        </tr>',
                                        __( 'Item 2', 'tried' ),
                                        __( 'Picture', 'tried' ),
                                        $sponsor_calevent[2]['picture'][$sps2],
                                        __( 'Delete', 'tried' ),
                                        __( 'Delete', 'tried' )
                                    );
                                }
                            } else {
                                printf(
                                    '<tr>
                                        <th><label>%s</label></th>
                                        <td>
                                            <h4 style="margin: 10px 0;">%s</h4>
                                            <input type="text" name="sponsor_calevent[2][picture][]" value="" required/>
                                            <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                        </td>
                                    </tr>',
                                    __( 'Item', 'tried' ),
                                    __( 'Picture', 'tried' ),
                                    __( 'Delete', 'tried' ),
                                    __( 'Delete', 'tried' )
                                );
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="tabs-panel" style="position: relative;">
                <a class="button button-primary addnew-calevents" href="javascript:void(0)"
                    title="<?php _e( 'Add new', 'tried' ); ?>"
                    style="position: absolute; right: 12px; top: 12px; z-index: 3;"><?php _e( 'Add new', 'tried' ); ?></a>
                <table class="form-table">
                    <thead>
                        <tr>
                            <th><label><?php _e( 'Group 3', 'tried' ); ?></label></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Title', 'tried' ); ?></label></th>
                            <td>
                                <input type="text" name="sponsor_calevent[3][title]"
                                    value="<?php echo $sponsor_calevent[3]['title'] ?: ''; ?>"
                                    placeholder="<?php _e( 'Enter title of group', 'tried' ); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Title(color)', 'tried' ); ?></label></th>
                            <td>
                                <input type="color" name="sponsor_calevent[3][title_color]"
                                    value="<?php echo $sponsor_calevent[3]['title_color'] ?: '#000'; ?>" required />
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ( isset( $sponsor_calevent[3]['picture'] ) && !empty( $sponsor_calevent[3]['picture'] ) ) {
                                for ( $sps3 = 0; $sps3 < count( $sponsor_calevent[3]['picture'] ); $sps3++ ) {
                                    printf(
                                        '<tr>
                                            <th><label>%s</label></th>
                                            <td>
                                                <h4 style="margin: 10px 0;">%s</h4>
                                                <input type="text" name="sponsor_calevent[3][picture][]" value="%s" required/>
                                                <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                            </td>
                                        </tr>',
                                        __( 'Item', 'tried' ),
                                        __( 'Picture', 'tried' ),
                                        $sponsor_calevent[3]['picture'][$sps3],
                                        __( 'Delete', 'tried' ),
                                        __( 'Delete', 'tried' )
                                    );
                                }
                            } else {
                                printf(
                                    '<tr>
                                        <th><label>%s</label></th>
                                        <td>
                                            <h4 style="margin: 10px 0;">%s</h4>
                                            <input type="text" name="sponsor_calevent[3][picture][]" value="" required/>
                                            <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                        </td>
                                    </tr>',
                                    __( 'Item', 'tried' ),
                                    __( 'Picture', 'tried' ),
                                    __( 'Delete', 'tried' ),
                                    __( 'Delete', 'tried' )
                                );
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="tabs-panel" style="position: relative;">
                <a class="button button-primary addnew-calevents" href="javascript:void(0)"
                    title="<?php _e( 'Add new', 'tried' ); ?>"
                    style="position: absolute; right: 12px; top: 12px; z-index: 3;"><?php _e( 'Add new', 'tried' ); ?></a>
                <table class="form-table">
                    <thead>
                        <tr>
                            <th><label><?php _e( 'Group 4', 'tried' ); ?></label></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Title', 'tried' ); ?></label></th>
                            <td>
                                <input type="text" name="sponsor_calevent[4][title]"
                                    value="<?php echo $sponsor_calevent[4]['title'] ?: ''; ?>"
                                    placeholder="<?php _e( 'Enter title of group', 'tried' ); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php _e( 'Title(color)', 'tried' ); ?></label></th>
                            <td>
                                <input type="color" name="sponsor_calevent[4][title_color]"
                                    value="<?php echo $sponsor_calevent[4]['title_color'] ?: '#000'; ?>" required />
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ( isset( $sponsor_calevent[4]['picture'] ) && !empty( $sponsor_calevent[4]['picture'] ) ) {
                                for ( $sps4 = 0; $sps4 < count( $sponsor_calevent[4]['picture'] ); $sps4++ ) {
                                    printf(
                                        '<tr>
                                            <th><label>%s</label></th>
                                            <td>
                                                <h4 style="margin: 10px 0;">%s</h4>
                                                <input type="text" name="sponsor_calevent[4][picture][]" value="%s" required/>
                                                <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                            </td>
                                        </tr>',
                                        __( 'Item', 'tried' ),
                                        __( 'Picture', 'tried' ),
                                        $sponsor_calevent[4]['picture'][$sps4],
                                        __( 'Delete', 'tried' ),
                                        __( 'Delete', 'tried' )
                                    );
                                }
                            } else {
                                printf(
                                    '<tr>
                                        <th><label>%s</label></th>
                                        <td>
                                            <h4 style="margin: 10px 0;">%s</h4>
                                            <input type="text" name="sponsor_calevent[4][picture][]" value="" required/>
                                            <a class="button" href="javascript:void(0)" title="%s"style="position: absolute; top: 20px;left: 600px;">%s</a>
                                        </td>
                                    </tr>',
                                    __( 'Item', 'tried' ),
                                    __( 'Picture', 'tried' ),
                                    __( 'Delete', 'tried' ),
                                    __( 'Delete', 'tried' )
                                );
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</fieldset>

<script>
(function($) {
    'use strict';
    var clone_CaleventsTabItem = '';
    $(document).on('click', '.addnew-calevents', function() {
        var wrapper = $(this).closest('.tabs-panel'),
            formTable = wrapper.find('.form-table tbody');

        if (formTable) {
            if (clone_CaleventsTabItem == '') {
                clone_CaleventsTabItem = formTable.find('tr').html();
            }
            formTable.append(`<tr>${clone_CaleventsTabItem}</tr>`);
        }
    });

    $(document).on('click', '.tabs-panel .form-table tr td a', function() {
        var wrapper = $(this).closest('.tabs-panel'),
            rowContent = $(this).closest('tr');

        if (wrapper.find('.form-table tbody tr').length > 1) {
            rowContent.remove();
        }
    });
})(jQuery);
</script>