<?php
    // Register Custom Post Type for DBD Perks
    function create_dbd_posttype(){
        register_post_type('dbd',
            array(
                'labels' => array(
                    'name' => __('DBD Perks'),
                    'singular_name' => __('DBD Perk'),
                    'add_new_item' => __('Add New DBD Perk'),
                    'new_item' => __('New DBD Perk'),
                    'all_items' => __('All DBD Perks'),
                    'edit_item' => __('Edit DBD Perk'),
                ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'dbd'),
                'show_in_rest' => true,
                'menu_icon' => 'dashicons-games',
                'rewrite' => array('slug' => 'dbd-perks'),
            )
        );
    }
    add_action('init', 'create_dbd_posttype');

    // register custom post type for Game Extensions
    function create_game_extensions_posttype(){
        register_post_type('game-extensions',
            array(
                'labels' => array(
                    'name' => __('Game Extensions'),
                    'singular_name' => __('Game Extension'),
                    'add_new_item' => __('Add New Game Extension'),
                    'new_item' => __('New Game Extension'),
                    'all_items' => __('All Game Extensions'),
                    'edit_item' => __('Edit Game Extension'),
                ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'game-extensions'),
                'show_in_rest' => true,
                'menu_icon' => 'dashicons-games',
            )
        );
    }
    add_action('init', 'create_game_extensions_posttype');

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
        register_block_type( get_template_directory() . '/build/content-page' );
        register_block_type( get_template_directory() . '/build/hoverbox' );
        register_block_type( get_template_directory() . '/build/hoveritem' );
        register_block_type( get_template_directory() . '/build/game-extensions' );
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

    function get_youtube_data($channel_id, $api_key) {
    // Get channel stats (subscribers)
    $channel_url = "https://www.googleapis.com/youtube/v3/channels?part=statistics,snippet&id={$channel_id}&key={$api_key}";
    $channel_response = wp_remote_get($channel_url);
    $channel_data = json_decode(wp_remote_retrieve_body($channel_response), true);
    
    // Get latest video
    $videos_url = "https://www.googleapis.com/youtube/v3/search?key={$api_key}&channelId={$channel_id}&part=snippet,id&order=date&maxResults=1";
    $videos_response = wp_remote_get($videos_url);
    $videos_data = json_decode(wp_remote_retrieve_body($videos_response), true);
    
    return array(
        'subscribers' => $channel_data['items'][0]['statistics']['subscriberCount'],
        'latest_video' => array(
            'id' => $videos_data['items'][0]['id']['videoId'],
            'title' => $videos_data['items'][0]['snippet']['title'],
            'thumbnail' => $videos_data['items'][0]['snippet']['thumbnails']['medium']['url'],
            'url' => 'https://www.youtube.com/watch?v=' . $videos_data['items'][0]['id']['videoId']
        )
    );
}

function format_number_short($number) {
    $number = (int)$number; // Ensure it's a number
    if ($number >= 1000000) {
        return round($number / 1000000, 2) . 'M';
    } elseif ($number >= 1000) {
        return round($number / 1000, 2) . 'K';
    }
    return $number;
}

function get_youtube_channel_data($channel_id, $api_key) {
    // Check cache first
    $cached_data = get_transient('youtube_channel_data');
    if ($cached_data !== false) {
        $cached_data['subscriber_count'] = $cached_data['subscriber_count'];
        return $cached_data;
    }
    
    // Get channel statistics (subscribers)
    $channel_url = "https://www.googleapis.com/youtube/v3/channels?part=statistics,snippet&id={$channel_id}&key={$api_key}";
    $channel_response = wp_remote_get($channel_url);
    
    if (is_wp_error($channel_response)) {
        return false;
    }
    
    $channel_data = json_decode(wp_remote_retrieve_body($channel_response), true);
    
    // Get latest video
    $videos_url = "https://www.googleapis.com/youtube/v3/search?key={$api_key}&channelId={$channel_id}&part=snippet,id&order=date&maxResults=1&type=video";
    $videos_response = wp_remote_get($videos_url);
    
    if (is_wp_error($videos_response)) {
        return false;
    }
    
    $videos_data = json_decode(wp_remote_retrieve_body($videos_response), true);
    
    $result = array(
        'subscriber_count' => format_number_short($channel_data['items'][0]['statistics']['subscriberCount']),
        'video_count' => $channel_data['items'][0]['statistics']['videoCount'],
        'latest_video' => array(
            'id' => $videos_data['items'][0]['id']['videoId'],
            'title' => $videos_data['items'][0]['snippet']['title'],
            'thumbnail' => $videos_data['items'][0]['snippet']['thumbnails']['high']['url'],
            'url' => 'https://www.youtube.com/watch?v=' . $videos_data['items'][0]['id']['videoId'],
            'published_at' => $videos_data['items'][0]['snippet']['publishedAt']
        )
    );
    
    // Cache for 1 hour
    set_transient('youtube_channel_data', $result, HOUR_IN_SECONDS);
    
    return $result;
}

function get_facebook_posts($page_id, $access_token, $limit = 3) {
    // Check cache
    $cache_key = 'facebook_posts_' . $page_id;
    $cached_data = get_transient($cache_key);
    if ($cached_data !== false) {
        return $cached_data;
    }
    
    // Get posts from page
    $url = "https://graph.facebook.com/v18.0/{$page_id}/posts?fields=id,message,created_time,full_picture,permalink_url,likes.summary(true),comments.summary(true)&limit={$limit}&access_token={$access_token}";
    echo $url; // Debugging line to check the URL being called
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $data = json_decode(wp_remote_retrieve_body($response), true);
    
    if (!isset($data['data'])) {
        return false;
    }
    
    $posts = array();
    foreach ($data['data'] as $post) {
        $posts[] = array(
            'id' => $post['id'],
            'message' => isset($post['message']) ? $post['message'] : '',
            'image' => isset($post['full_picture']) ? $post['full_picture'] : '',
            'created_at' => $post['created_time'],
            'url' => $post['permalink_url'],
            'likes' => isset($post['likes']) ? $post['likes']['summary']['total_count'] : 0,
            'comments' => isset($post['comments']) ? $post['comments']['summary']['total_count'] : 0
        );
    }
    
    // Cache for 30 minutes
    set_transient($cache_key, $posts, 30 * MINUTE_IN_SECONDS);
    
    return $posts;
}