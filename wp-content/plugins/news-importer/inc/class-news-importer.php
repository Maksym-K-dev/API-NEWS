<?php

if (!defined('ABSPATH')) {
    exit;
}

class News_Importer_Service {

    private $api_key;
    private $endpoint;
    private $limit;
    private $log_file;

    public function __construct() {
        $options = get_option('news_importer_settings', []);

        $this->api_key  = $options['api_key'] ?? '';
        $this->endpoint = $options['api_endpoint'] ?? 'https://newsapi.org/v2/everything';
        $this->limit    = !empty($options['import_count']) ? absint($options['import_count']) : 5;
        $upload_dir = wp_upload_dir();
        $this->log_file = ( ! empty( $upload_dir['basedir'] ) ) ? $upload_dir['basedir'] . '/news-importer.log' : WP_CONTENT_DIR . '/news-importer.log';
    }

    /**
     * Main import method
     */
    public function import() {

        if (empty($this->api_key)) {
            return ['imported' => 0, 'skipped' => 0, 'errors' => 1];
        }

        $url = add_query_arg([
            'q'        => 'technology',
            'pageSize' => $this->limit,
            'language' => 'en',
            'apiKey'   => $this->api_key,
        ], $this->endpoint);

        $response = wp_remote_get($url, [
            'timeout' => 20,
            'headers' => [
                'User-Agent' => 'WordPress News Importer'
            ]
        ]);

        if (is_wp_error($response)) {
            $this->log('HTTP Error: ' . $response->get_error_message());
            return ['imported' => 0, 'skipped' => 0, 'errors' => 1];
        }

        $body_raw = wp_remote_retrieve_body( $response );
        $body     = json_decode( $body_raw, true );

        if ( ! is_array( $body ) || ! isset( $body['status'] ) || $body['status'] !== 'ok' ) {
            $this->log( 'API Error Response: ' . $body_raw );
            return [ 'imported' => 0, 'skipped' => 0, 'errors' => 1 ];
        }

        if ( empty( $body['articles'] ) ) {
            return ['imported' => 0, 'skipped' => 0, 'errors' => 0];
        }

        $stats = [
            'imported' => 0,
            'skipped'  => 0,
            'errors'   => 0
        ];

        foreach ($body['articles'] as $article) {

            try {
                $result = $this->process_article($article);
                $stats[$result]++;
            } catch (Exception $e) {
                $stats['errors']++;
                $this->log('Article Exception: ' . $e->getMessage());
            }

        }

        $this->log('Import finished: ' . json_encode($stats));
        return $stats;
    }


    /**
     * Process single article
     */
    private function process_article($article) {

        if (empty($article['title']) || empty($article['url'])) {
            return 'errors';
        }

        $source_url = esc_url_raw($article['url']);

        // Deduplication
        $existing = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 1,
            'meta_query'     => [
                [
                    'key'   => '_source_url',
                    'value' => $source_url,
                ]
            ],
            'fields' => 'ids'
        ]);

        if ($existing->have_posts()) {
            return 'skipped';
        }

        // Prepare post data
        $post_data = [
            'post_title'   => sanitize_text_field($article['title']),
            'post_content' => wp_kses_post($article['content'] ?? $article['description'] ?? ''),
            'post_status'  => 'publish',
            'post_type'    => 'post',
        ];

        if (!empty($article['publishedAt'])) {
            $post_data['post_date'] = date(
                'Y-m-d H:i:s',
                strtotime($article['publishedAt'])
            );
        }

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id) || !$post_id) {
            return 'errors';
        }

        // Save source URL
        update_post_meta($post_id, '_source_url', $source_url);

        // Category: get existing or create
        if ( ! empty( $article['source']['name'] ) ) {
            $category_name = sanitize_text_field( $article['source']['name'] );
            $term          = get_term_by( 'name', $category_name, 'category' );
            $cat_id        = $term ? (int) $term->term_id : wp_create_category( $category_name );
            if ( $cat_id ) {
                wp_set_post_categories( $post_id, [ $cat_id ] );
            }
        }

        // Image
        if (!empty($article['urlToImage'])) {
            $this->sideload_image($post_id, esc_url_raw($article['urlToImage']));
        }

        return 'imported';
    }


    /**
     * Download and attach image
     */
    private function sideload_image($post_id, $image_url) {

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $image_id = media_sideload_image($image_url, $post_id, null, 'id');

        if (!is_wp_error($image_id)) {
            set_post_thumbnail($post_id, $image_id);
        } else {
            $this->log('Image Error: ' . $image_id->get_error_message());
        }
    }


    /**
     * Logging
     */
    private function log($message) {

        $time = current_time('mysql');
        $entry = '[' . $time . '] ' . $message . PHP_EOL;

        error_log($entry, 3, $this->log_file);
    }

}