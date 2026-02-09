<?php

    add_action('after_setup_theme', 'CoreyInDaHouse27_features');
    add_post_type_support( 'page', 'excerpt' );
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
        wp_enqueue_style('coreyindahouse_main_styles', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('coreyindahouse_extra_styles', get_theme_file_uri('/build/index.css'));
    }

    add_action('enqueue_block_assets', 'dahouse_editor_assets');
    function dahouse_editor_assets() {
        if (is_admin()) {
            wp_enqueue_style('bootstrap-css-editor', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
            wp_enqueue_style('dahouse_editor_styles', get_theme_file_uri('/build/index.css'));
        }
        wp_enqueue_style('dahouse_frontend_styles', get_theme_file_uri('/build/style-index.css'));
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
        register_block_type( get_template_directory() . '/build/singlepost' );
        register_block_type( get_template_directory() . '/build/archiveabout' );
        register_block_type( get_template_directory() . '/build/singleabout' );
        register_block_type( get_template_directory() . '/build/bloghome' );
    }

    function coreyindahouse_files() {
        wp_enqueue_script('main-university.js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
        wp_enqueue_style('custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('coreyindahouse27_main_styles', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('coreyindahouse27_extra_styles', get_theme_file_uri('/build/index.css'));
        wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');

        wp_enqueue_script('jquery'); // Ensure jQuery is loaded
        wp_enqueue_script('glide-js', 'https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/glide.min.js', array(), '3.6.0', true);
        // wp_enqueue_script('main.js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
        wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    }
    add_action('wp_enqueue_scripts', 'coreyindahouse_files');

    function coreyindahouse_features() {
        // Add support for custom menus
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_image_size('pageBanner', 1500, 350, true);
        add_theme_support('editor-styles');
        add_editor_style(array(
            'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i',
            'build/style-index.css',
            'build/index.css'
        ));
    }

    add_action('after_setup_theme', 'coreyindahouse_features');

    // redirect subscriber accounts out of admin and onto homepage
    add_action('admin_init', 'redirectSubsToFrontend');
    function redirectSubsToFrontend() {
        $ourCurrentUser = wp_get_current_user();
        if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
            wp_redirect(site_url('/'));
            exit;
        }
    }

    // remove admin bar for subscribers
    add_action('wp_loaded', 'noSubsAdminBar');
    function noSubsAdminBar() {
        $ourCurrentUser = wp_get_current_user();
        if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
            show_admin_bar(false);
        }
    }