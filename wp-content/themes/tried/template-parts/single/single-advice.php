<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-advice-single' );
$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
$image = get_theme_file_uri( "/assets/img/placeholder.png" );
if (!empty($image_url[0])) {
    $image = $image_url[0];
}

$getAdviceTerms = get_the_terms( get_the_ID(), 'advice_cat' );
$adviceTerms = array();
if ( $getAdviceTerms ) {
    foreach ( $getAdviceTerms as $adviceTerm ) {
        array_push( $adviceTerms, $adviceTerm->term_id );
    }
}

$adviceRelated = get_posts( array (
    'post_type' => get_post_type(),
    'orderby' => 'date',
    'order'=> 'DESC', 
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'advice_cat',
            'field'    => 'term_id',
            'terms'    => $adviceTerms,
        ),
    ),
    'posts_per_page' => 6
) );
?>
<main <?php post_class( 'site-main' ); ?>>
    <div class="main-contain advice">
        <div class="banner-advice">
            <div class="wrapper">
                <h2 class="advice-title"><?php echo get_the_title(); ?></h2>
            </div>
        </div>
        <div class="wrapper">
            <article class="single-advice have-sidebar">
                <div class="wrapper">
                    <div class="context-advice">
                        <div class="featured-image">
                            <img src="<?php echo $image; ?>" alt="<?php echo get_the_title(); ?>" />
                        </div>
                        <div class="content-info">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </article>
            <?php
                if ( !empty( $adviceRelated ) ) {
                    $key = wp_generate_uuid4();
                    echo '<div class="related-advice">'
                    . '<div class="related-wrapper"><div class="headtop-advice">'
                    . '<h4 class="related-title">'.__( 'Advices & Insights', 'tried' ).'</h4>'
                    . '<p class="related-description">'.__( 'See how you can up your career status', 'tried' ).'</p>'
                    // . '<div class="related-navbutton">'
                    // . '<div class="swiper-button swiper-button-prev" key="'.$key.'"></div>'
                    // . '<div class="swiper-button swiper-button-next" key="'.$key.'"></div>'
                    // . '</div>'
                    . '</div>'
                    . '<div class="advices swiper" data-control="'.$key.'"><div class="swiper-wrapper">';
                    foreach ( $adviceRelated as $advice ) {
                        get_template_part( 'template-parts/advice-item/item', null, array(
                            'id' => $advice->ID,
                            'is_slide' => true
                        ) );
                    }
                    echo '</div></div></div></div>';
                    wp_reset_postdata();
                } else {
                    printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned', 'tried') );
                }
            ?>
        </div>
    </div>
</main>

<script>
var relate_advices = $('.related-advice .advices');
if (relate_advices && relate_advices.hasClass('swiper')) {
    let control = relate_advices.attr('data-control');
    const related_advices = new Swiper('.related-advice .advices.swiper', {
        slidesPerView: 3,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button.swiper-button-next[key="' + control + '"]',
            prevEl: '.swiper-button.swiper-button-prev[key="' + control + '"]',
        },
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
</script>