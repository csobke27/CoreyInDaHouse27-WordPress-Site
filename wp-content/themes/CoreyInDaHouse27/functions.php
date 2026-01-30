<?php

add_action('after_setup_theme', 'CoreyInDaHouse27_features');

function CoreyInDaHouse27_features() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}

add_action('login_enqueue_scripts', 'ourLoginCSS');
function ourLoginCSS() {
    wp_enqueue_style('custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('fictional_university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('fictional_university_extra_styles', get_theme_file_uri('/build/index.css'));
}

add_action('init', 'our_new_blocks');
function our_new_blocks() {
    register_block_type( get_template_directory() . '/build/footer' );
}