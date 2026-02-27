<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
class News_Importer_Rest {

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('news-importer/v1', '/news', [
            'methods'  => 'GET',
            'callback' => [$this, 'get_news_list'],
            'permission_callback' => '__return_true',
            'args' => [
                'limit' => [
                    'sanitize_callback' => 'absint',
                    'default' => 10
                ],
                'category' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                'from' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ]
        ]);
    }

    public function get_news_list($request) {

        // Безпечний limit
        $limit = min(20, max(1, (int) $request['limit']));

        $args = [
            'post_type'      => 'post',
            'posts_per_page' => $limit,
            'post_status'    => 'publish',
            'meta_query'     => [
                [
                    'key'     => '_source_url',
                    'compare' => 'EXISTS'
                ]
            ]
        ];

        // Фільтр по категорії
        if (!empty($request['category'])) {
            $args['category_name'] = $request['category'];
        }

        // Фільтр по даті
        if (!empty($request['from'])) {
            $args['date_query'] = [
                [
                    'after' => $request['from']
                ]
            ];
        }

        $query = new WP_Query($args);

        $news = [];

        if ($query->have_posts()) {
            foreach ($query->posts as $post) {

                $news[] = [
                    'id'      => $post->ID,
                    'title'   => get_the_title($post->ID),
                    'content' => get_the_excerpt($post->ID),
                    'source'  => get_post_meta($post->ID, '_source_url', true),
                    'date'    => get_the_date('c', $post->ID),
                    'image'   => get_the_post_thumbnail_url($post->ID, 'full')
                ];
            }
        }

        wp_reset_postdata();

        return rest_ensure_response([
            'count' => count($news),
            'data'  => $news
        ]);
    }
}