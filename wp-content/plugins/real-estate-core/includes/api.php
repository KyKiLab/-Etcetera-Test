<?php
/**
 * REST API controller for Real Estate objects
 */

class Real_Estate_REST_Controller {

    public static function init() {
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
    }

    public static function register_routes() {
        register_rest_route('realestate/v1', '/objects', [
            'methods' => 'GET',
            'callback' => [__CLASS__, 'get_objects'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('realestate/v1', '/objects', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'create_object'],
            'permission_callback' => [__CLASS__, 'check_permissions'],
        ]);

        register_rest_route('realestate/v1', '/objects/(?P<id>\d+)', [
            'methods' => 'PUT',
            'callback' => [__CLASS__, 'update_object'],
            'permission_callback' => [__CLASS__, 'check_permissions'],
        ]);

        register_rest_route('realestate/v1', '/objects/(?P<id>\d+)', [
            'methods' => 'DELETE',
            'callback' => [__CLASS__, 'delete_object'],
            'permission_callback' => [__CLASS__, 'check_permissions'],
        ]);
    }

    public static function check_permissions() {
        return current_user_can('edit_posts');
    }

    public static function get_objects($request) {
        $args = [
            'post_type'   => 'real_estate',
            'post_status' => 'publish',
            'numberposts' => -1,
        ];

        if (!empty($request['eco_rating'])) {
            $args['meta_query'][] = [
                'key'     => 'eco_rating',
                'value'   => sanitize_text_field($request['eco_rating']),
                'compare' => '=',
            ];
        }

        $posts = get_posts($args);
        $data  = [];

        foreach ($posts as $post) {
            $data[] = [
                'id'          => $post->ID,
                'title'       => get_the_title($post),
                'eco_rating'  => get_field('eco_rating', $post->ID),
                'coordinates' => get_field('coordinates', $post->ID),
            ];
        }

        return rest_ensure_response($data);
    }

    public static function create_object($request) {
        $params   = $request->get_json_params();
        $post_id  = wp_insert_post([
            'post_type'   => 'real_estate',
            'post_title'  => sanitize_text_field($params['title'] ?? ''),
            'post_status' => 'publish',
        ]);

        if (is_wp_error($post_id)) {
            return new WP_Error('create_failed', 'Could not create object', ['status' => 500]);
        }

        self::save_acf_fields($post_id, $params);
        return rest_ensure_response(['success' => true, 'data' => ['id' => $post_id]]);
    }

    public static function update_object($request) {
        $id     = (int) $request['id'];
        $params = $request->get_json_params();

        if (get_post_type($id) !== 'real_estate') {
            return new WP_Error('not_found', 'Object not found', ['status' => 404]);
        }

        wp_update_post([
            'ID'         => $id,
            'post_title' => sanitize_text_field($params['title'] ?? ''),
        ]);

        self::save_acf_fields($id, $params);
        return rest_ensure_response(['success' => true, 'data' => ['updated' => true]]);
    }

    public static function delete_object($request) {
        $id = (int) $request['id'];

        if (get_post_type($id) !== 'real_estate') {
            return new WP_Error('not_found', 'Object not found', ['status' => 404]);
        }

        wp_delete_post($id, true);
        return rest_ensure_response(['success' => true, 'data' => ['deleted' => true]]);
    }

    private static function save_acf_fields($post_id, $params) {
        $fields = [
            'building_name',
            'coordinates',
            'number_of_floors',
            'building_type',
            'eco_rating',
        ];

        foreach ($fields as $field) {
            if (isset($params[$field])) {
                update_field($field, sanitize_text_field($params[$field]), $post_id);
            }
        }
    }
}

Real_Estate_REST_Controller::init();