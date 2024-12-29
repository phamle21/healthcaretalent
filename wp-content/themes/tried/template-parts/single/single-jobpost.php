<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$template = 'detail';
if ( isset( $_GET['apply_job'] ) ) {
    $template = 'apply';
}

get_template_part( 'template-parts/single/jobpost/job', $template, array(
    'id' => ''
) );