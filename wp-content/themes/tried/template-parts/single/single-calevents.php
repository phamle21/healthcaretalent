<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-calevents-single' );
wp_enqueue_script( 'countdown-min' );

$publish = get_post_meta( $post->ID, 'publish', true );
$procPublich = date_create( $publish );
$currentNow = current_datetime()->format( 'Y-m-d H:i' );
if ( !empty( $publish ) ) {
    if ( ( strtotime( 'now' ) - strtotime( $publish ) ) > 0 ) {
        $currentNow = $publish;
    }
}

$agenda_calevent = get_post_meta( $post->ID, 'agenda_calevent', true );
$picture_calevent = get_post_meta( $post->ID, 'picture_calevent', true );
$sponsor_calevent = get_post_meta( $post->ID, 'sponsor_calevent', true );

$location = get_post_meta( $post->ID, 'location', true );

$feature_iamge = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

$register_event_form = get_option( 'add_setting_register_event_form', '' );

$key = wp_generate_uuid4();
// $getCaleventTerms = get_the_terms( get_the_ID(), 'calevent_cat' );
// $caleventTerms = array();
// if ( $caleventTerms ) {
//     foreach ( $caleventTerms as $caleventTerm ) {
//         array_push( $caleventTerm, $caleventTerm->term_id );
//     }
// }
$caleventRelated = get_posts( array (
    'post_type' => get_post_type(),
    'orderby' => 'date',
    'order'=> 'DESC', 
    'post_status' => 'publish',
    // 'tax_query' => array(
    //     array(
    //         'taxonomy' => 'calevent_cat',
    //         'field'    => 'term_id',
    //         'terms'    => $caleventTerms,
    //     ),
    // ),
    'posts_per_page' => 6
) );
?>
<main <?php post_class( 'site-main' ); ?>>
    <div class="main-contain calevents-detail">
        <div class="wrapper">
            <article class="single-calevents">
                <div class="section-event_pushtime" id="event_pushtime">
                    <?php
                        if ( $feature_iamge ) {
                            printf(
                                '<div class="section-overlay" style="background-image: url(%s)"></div>',
                                $feature_iamge[0]
                            );
                        }
                    ?>
                    <div class="section-wrapper">
                        <div class="info-block">
                            <h5>
                                <span><?php echo date_format( $procPublich, 'M d, Y h:i A' ); ?>,</span>
                                <span><?php echo __( 'at', 'tried' ) . ' ' . $location; ?></span>
                            </h5>
                            <h3><?php echo get_the_title(); ?></h3>
                        </div>
                        <div class="timedown-block">
                            <div id="calevent-upcoming_countdown"></div>
                        </div>
                        <div class="viewmore-block">
                            <a href="#event_registerform" class="registerform"
                                title="<?php _e( 'Register Now', 'tried' ); ?>"><?php _e( 'Register Now', 'tried' ); ?></a>
                            <a href="#event_content"
                                title="<?php _e( 'Register Now', 'tried' ); ?>"><?php _e( 'View more', 'tried' ); ?></a>
                        </div>
                    </div>
                </div>

                <div class="section-event_content" id="event_content">
                    <div class="section-wrapper">
                        <div class="info-block">
                            <h5><?php _e( 'Who we are?', 'tried' ); ?></h5>
                            <h3><?php _e( 'About Live Events', 'tried' ); ?></h3>
                        </div>
                        <div class="content-block">
                            <div class="contents"><?php the_content(); ?></div>
                            <a class="content-collapse" href="javascript:void(0)"
                                title="<?php _e( 'Show more/Show less', 'tried' ); ?>"
                                data-more="<?php _e( 'Show more', 'tried' ); ?>"
                                data-less="<?php _e( 'Show less', 'tried' ); ?>"><?php _e( 'Show more', 'tried' ); ?></a>
                        </div>
                    </div>
                </div>

                <div class="section-event_schedule" id="event_schedule">
                    <div class="section-wrapper">
                        <div class="info-block">
                            <h5><?php _e( 'Schedule', 'tried' ); ?></h5>
                            <h3><?php _e( 'Conference Schedule', 'tried' ); ?></h3>
                        </div>
                        <div class="scheduletab-block">
                            <div class="scheduletab-nav">
                                <a href="javascript:void(0)" class="active" data-tab="scheduletab-agenda"
                                    title="<?php _e( 'Agenda', 'tried' ); ?>"><?php _e( 'Agenda', 'tried' ); ?></a>
                                <a href="javascript:void(0)" data-tab="scheduletab-picture"
                                    title="<?php _e( 'Picture', 'tried' ); ?>"><?php _e( 'Picture', 'tried' ); ?></a>
                                <a href="javascript:void(0)" data-tab="scheduletab-sponsor"
                                    title="<?php _e( 'Sponsor', 'tried' ); ?>"><?php _e( 'Sponsor', 'tried' ); ?></a>
                            </div>
                            <div class="scheduletab-content">
                                <div class="scheduletab-content_item scheduletab-agenda active">
                                    <?php
                                        if ( !empty( $agenda_calevent ) ) {
                                            echo '<div class="agenda_calevents">';
                                            for ( $agd = 0; $agd < count( $agenda_calevent['title'] ); $agd++ ) {
                                                $timeAgenda = $agenda_calevent['time_start'][$agd];
                                                if ( $agenda_calevent['time_finish'][$agd] ) $timeAgenda .= ' - ' . $agenda_calevent['time_finish'][$agd];
                                                printf(
                                                    '<div class="agenda_calevent-item">
                                                        <span>%s</span>
                                                        <div>
                                                            <h4>%s</h4>
                                                            <p>%s</p>
                                                        </div>
                                                    </div>',
                                                    $timeAgenda,
                                                    $agenda_calevent['title'][$agd],
                                                    $agenda_calevent['content'][$agd]
                                                );
                                            }
                                            echo '</div>';
                                        } else {
                                            printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned', 'tried') );
                                        }
                                    ?>
                                </div>
                                <div class="scheduletab-content_item scheduletab-picture">
                                    <?php
                                        if ( !empty( $picture_calevent ) ) {
                                            echo '<div class="picture_calevents">';
                                            for ( $pct = 0; $pct < count( $picture_calevent['image'] ); $pct++ ) {
                                                if ( empty( $picture_calevent['image'] ) ) continue;
                                                printf(
                                                    '<div class="picture_calevent-item">
                                                        <img src="%s" alt=""/>
                                                    </div>',
                                                    $picture_calevent['image'][$pct],
                                                );
                                            }
                                            echo '</div>';
                                        } else {
                                            printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned', 'tried') );
                                        }
                                    ?>
                                </div>
                                <div class="scheduletab-content_item scheduletab-sponsor">
                                    <?php
                                        echo '<h4 class="sponsor-title">'.( $sponsor_calevent[0]['title'] ?: __( 'Title', 'tried' ) ).'</h4>'
                                        . '<p class="sponsor-description">'.( $sponsor_calevent[0]['description'] ?: __( 'Description', 'tried' ) ).'</p>';
                                        echo '<div class="sponsor_calevents">';
                                        for ( $sps = 1; $sps <= 4; $sps++ ) {
                                            if ( empty( $sponsor_calevent[$sps]['title'] ) ) continue;
                                            echo '<div class="sponsor_calevents-item">'
                                            . '<h5 class="sponsor-title" style="color: '.( $sponsor_calevent[$sps]['title_color'] ?: '#000' ).'">'.$sponsor_calevent[$sps]['title'].'</h5>';
                                            if ( isset( $sponsor_calevent[$sps]['picture'] ) && !empty( $sponsor_calevent[$sps]['picture'] ) ) {
                                                echo '<div class="sponsor_pictures">';
                                                foreach ( $sponsor_calevent[$sps]['picture'] as $sponsorPicture ) {
                                                    if ( empty( $sponsorPicture ) ) continue;
                                                    printf(
                                                        '<div class="sponsor_picture-item">
                                                            <img src="%s" alt=""/>
                                                        </div>',
                                                        $sponsorPicture,
                                                    );
                                                }
                                                echo '</div>';
                                            } else {
                                                printf( '<p class="no-result">%s</p>', __( 'Sorry, no results were returned', 'tried' ) );
                                            }
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-event_related" id="event_related">
                    <div class="section-wrapper">
                        <div class="headtop-block">
                            <div>
                                <h4 class="related-title"><?php _e( 'Last Event', 'tried' ); ?></h4>
                                <p class="related-description">
                                    <?php _e( 'See how you can up your career status', 'tried' ); ?></p>
                            </div>
                            <div>
                                <a href="<?php echo home_url( 'event' ); ?>" class="related-viewall"
                                    title="<?php _e( 'View all', 'tried' ); ?>"><?php _e( 'View all', 'tried' ); ?></a>
                            </div>
                        </div>
                        <div class="related-block">
                            <div class="eventrelateds swiper" data-control="<?php echo $key; ?>">
                                <div class="swiper-wrapper">
                                    <?php
                                        if ( !empty( $caleventRelated ) ) {
                                            foreach ( $caleventRelated as $advice ) {
                                                get_template_part( 'template-parts/advice-item/item', null, array(
                                                    'id' => $advice->ID,
                                                    'is_slide' => true
                                                ) );
                                            }
                                        } else {
                                            printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned', 'tried') );
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-event_registerform" id="event_registerform">
                    <div class="section-wrapper">
                        <div class="info-block">
                            <h4><?php _e( 'Event Register Form', 'tried' ); ?></h4>
                        </div>
                        <div class="form-block">
                            <?php echo do_shortcode( '[contact-form-7 id="'.$register_event_form.'"]' ); ?>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</main>

<script>
$(function() {
    var section_event_related = $('.section-event_related .eventrelateds');
    if (section_event_related && section_event_related.hasClass('swiper')) {
        let control = section_event_related.attr('data-control');
        const slide_event_related = new Swiper('.section-event_related .eventrelateds.swiper', {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 5000,
            },
            breakpoints: {
                0: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                991: {
                    slidesPerView: 3,
                    spaceBetween: 20
                }
            }
        });
    }
    var austDay = new Date('<?php echo $publish; ?>');
    $('#calevent-upcoming_countdown').countdown({
        until: austDay
    });

    var section_event_schedule = $('.section-event_schedule');
    if (section_event_schedule) {
        section_event_schedule.find('.scheduletab-nav a').on('click', function() {
            section_event_schedule.find('.scheduletab-nav a.active').removeClass('active');
            $(this).addClass('active');

            section_event_schedule.find('.scheduletab-content .scheduletab-content_item.active')
                .removeClass('active');
            section_event_schedule.find(
                    `.scheduletab-content .scheduletab-content_item.${$(this).attr('data-tab')}`)
                .addClass('active');
        });
    }
});
</script>