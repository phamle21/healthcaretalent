<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!doctype html>
<html <?php language_attributes(); ?> colorTheme="d">

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="<?php echo esc_attr( 'width=device-width, initial-scale=1' ); ?>">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <title><?php echo get_bloginfo( 'name' ); ?></title>

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <?php
    $mainmaxwidth = !empty( get_option( 'add_setting_mainmaxwidth', '' ) ) ? get_option( 'add_setting_mainmaxwidth', '' ) : '1200px';
    $mainthemecolor = !empty( get_option( 'add_setting_mainthemecolor', '' ) ) ? get_option( 'add_setting_mainthemecolor', '' ) : '#124395';
    $primarythemecolor = !empty( get_option( 'add_setting_primarythemecolor', '' ) ) ? get_option( 'add_setting_primarythemecolor', '' ) : '#EBBC34';
    $primarybtncolor = !empty( get_option( 'add_setting_primarybtncolor', '' ) ) ? get_option( 'add_setting_primarybtncolor', '' ) : '#f3ba2d';
    $secondbtncolor = !empty( get_option( 'add_setting_secondbtncolor', '' ) ) ? get_option( 'add_setting_secondbtncolor', '' ) : '#e2af31';
    ?>
    <style>
    :root {
        --main-max-width: <?php echo $mainmaxwidth;
        ?>;
        --main-color-theme: <?php echo $mainthemecolor;
        ?>;
        --primary-color: <?php echo $primarythemecolor;
        ?>;
        --primary-btn-color: <?php echo $primarybtncolor;
        ?>;
        --second-btn-color: <?php echo $secondbtncolor;
        ?>;
    }
    </style>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
	get_template_part( 'template-parts/header' );