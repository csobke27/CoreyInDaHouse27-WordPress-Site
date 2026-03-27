<?php

GLOBAL $wpdb;

add_action('rest_api_init', function () {
    register_rest_route('dbd-chaos-shuffle/v1', '/survivors', array(
        'methods' => 'GET',
        'callback' => 'getSurvivorList',
        'permission_callback' => '__return_true',
    ));
});

function getSurvivorList(){
    if (!function_exists('get_field_object')) {
        return new WP_Error('acf_missing', 'ACF is not active.', array('status' => 500));
    }

    $field = get_field_object('survivor_name', false, false, false);

    if (!$field && function_exists('acf_get_field')) {
        $field = acf_get_field('survivor_name');
    }

    if (!$field) {
        return new WP_Error(
            'acf_field_not_found',
            'Could not find ACF field "survivor_name". Use field key (e.g. field_xxx) or verify the field name.',
            array('status' => 404)
        );
    }

    return rest_ensure_response(array(
        'field_name' => $field['name'] ?? 'survivor_name',
        'choices' => $field['choices'] ?? array(),
    ));
}

add_action('rest_api_init', function () {
    register_rest_route('dbd-chaos-shuffle/v1', '/killers', array(
        'methods' => 'GET',
        'callback' => 'getKillerList',
        'permission_callback' => '__return_true',
    ));
});

function getKillerList(){
    if (!function_exists('get_field_object')) {
        return new WP_Error('acf_missing', 'ACF is not active.', array('status' => 500));
    }

    $field = get_field_object('killer_name', false, false, false);

    if (!$field && function_exists('acf_get_field')) {
        $field = acf_get_field('killer_name');
    }

    if (!$field) {
        return new WP_Error(
            'acf_field_not_found',
            'Could not find ACF field "killer_name". Use field key (e.g. field_xxx) or verify the field name.',
            array('status' => 404)
        );
    }

    return rest_ensure_response(array(
        'field_name' => $field['name'] ?? 'killer_name',
        'choices' => $field['choices'] ?? array(),
    ));
}

add_action('rest_api_init', function(){
    register_rest_route('dbd-chaos-shuffle/v1', '/shuffle', array(
        'methods' => 'POST',
        'callback' => 'generateChaosShuffle',
        'permission_callback' => '__return_true',
    ));
});

function generateChaosShuffle(WP_REST_Request $request){
    $data = $request->get_json_params();
    
    $survivors = isset($data['survivors']) ? $data['survivors'] : array();
    $killers = isset($data['killers']) ? $data['killers'] : array();
    if(empty($survivors) && empty($killers)) {
        return new WP_Error('invalid_input', 'Survivors and killer data are required.', array('status' => 400));
    }
    if(count($survivors) > 4) {
        return new WP_Error('too_many_survivors', 'A maximum of 4 survivors can be added.', array('status' => 400));
    }
    if(count($killers) > 1) {
        return new WP_Error('too_many_killers', 'Only 1 killer can be added.', array('status' => 400));
    }
    if(!empty($survivors)){
        foreach($survivors as $index => $survivor){
        $perks = new WP_Query(
            array(
                'post_type' => 'dbd_perks',
                'posts_per_page' => 4,
                'orderby' => 'rand',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'character_type',
                        'compare' => '=',
                        'value' => 'Survivor'
                    ),
                    array(
                        'key' => 'survivor_name',
                        'compare' => 'NOT IN',
                        'value' => array_map('sanitize_text_field', $survivor['filterSurvivors'])
                    )
                )
            )
        );
        $survivors[$index]['perks'] = getPerkFields($perks);
        }
    }
    if(!empty($killers)){
        foreach($killers as $index => $killer){
        $perks = new WP_Query(
            array(
                'post_type' => 'dbd_perks',
                'posts_per_page' => 4,
                'orderby' => 'rand',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'killer_name',
                        'compare' => 'NOT IN',
                        'value' => array_map('sanitize_text_field', $killer['filterKillers'])
                    ),
                    array(
                        'key' => 'character_type',
                        'compare' => '=',
                        'value' => 'Killer'
                    )
                )
            )
        );
        $killers[$index]['perks'] = getPerkFields($perks);
        }
    }


    
    // For demonstration, we'll just return the received data. Replace this with actual shuffle logic.
    return rest_ensure_response(array(
        'survivors' => $survivors,
        'killers' => $killers,
        'message' => 'Chaos Shuffle generated successfully! Implement your shuffle logic here.'
    ));
}

function getPerkFields($posts){
    $post_data = array();
    while($posts->have_posts()){
        
        $posts->the_post();
        $postId = get_the_ID();
        $fields = get_fields($postId) ?: array();
        $field_objects = get_field_objects($postId, false, false, false);

        // get_fields() only returns saved values, so conditional/unset fields can be missing.
        // get_field_objects() gives us field definitions + value, allowing null defaults.
        $all_fields = array();
        if (is_array($field_objects)) {
            foreach ($field_objects as $field_object) {
                $field_name = $field_object['name'] ?? null;
                if (!$field_name) {
                    continue;
                }
                $all_fields[$field_name] = array_key_exists('value', $field_object) ? $field_object['value'] : null;
            }
        }
        $all_fields = array_merge($all_fields, $fields);
        $name = $all_fields['survivor_name'] ?? $all_fields['killer_name'] ?? 'Base';
        if($name == ""){
            $name = 'Base';
        }

        $post_data[] = array(
            'id' => $postId,
            'title' => html_entity_decode(get_the_title(), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            'content' => get_the_content(),
            'perk_icon_url' => $all_fields['perk_icon']['url'] ?? '',
            'perk_icon_alt' => $all_fields['perk_icon']['alt'] ?? '',
            'name' => $name,
            'acf_fields' => $all_fields,
        );
        // Process fields as needed
    }
    wp_reset_postdata();
    return $post_data;
}