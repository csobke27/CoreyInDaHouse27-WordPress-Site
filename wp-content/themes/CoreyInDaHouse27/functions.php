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

add_action('enqueue_block_editor_assets', 'dahouse_editor_assets');
function dahouse_editor_assets() {
    wp_enqueue_style('dahouse_editor_styles', get_theme_file_uri('/build/index.css'));
}

add_action('init', 'our_new_blocks');
function our_new_blocks() {
    wp_localize_script(
        'wp-editor',
        'ourThemeData',
        array(
            'themePath' => get_stylesheet_directory_uri(),
        )
    );
    register_block_type( get_template_directory() . '/build/footer' );
    register_block_type( get_template_directory() . '/build/header' );
    register_block_type( get_template_directory() . '/build/slideshow' );
    register_block_type( get_template_directory() . '/build/slide' );
    register_block_type( get_template_directory() . '/build/page-not-found' );
}

function add_bootstrap() {
wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');
wp_enqueue_script('jquery'); // Ensure jQuery is loaded
wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'add_bootstrap');