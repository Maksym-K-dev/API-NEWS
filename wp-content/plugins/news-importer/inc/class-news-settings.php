<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class News_Importer_Settings {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_init', [$this, 'init_settings']);
        add_action('admin_post_news_manual_import', [$this, 'handle_manual']);
    }

    public function add_menu() {
        add_menu_page(
                'News Importer Settings',    // Page Title
                'News Importer',             // Menu Title
                'manage_options',
                'news-importer',
                [$this, 'render'],
                'dashicons-rss',
                25
        );
    }

    public function init_settings() {
        register_setting('news_importer_group', 'news_importer_settings', [
                'sanitize_callback' => [$this, 'sanitize_settings']
        ]);
    }

    // Function Check Security
    public function sanitize_settings( $input ) {
        if ( ! is_array( $input ) ) {
            return get_option( 'news_importer_settings', [] );
        }
        $sanitized = [];
        $sanitized['api_key']      = sanitize_text_field( $input['api_key'] ?? '' );
        $sanitized['api_endpoint'] = esc_url_raw( $input['api_endpoint'] ?? 'https://newsapi.org/v2/everything' );
        $sanitized['import_count'] = absint( $input['import_count'] ?? 5 );
        $allowed_intervals        = [ 'hourly', 'twicedaily', 'daily' ];
        $interval                 = sanitize_text_field( $input['interval'] ?? 'hourly' );
        $sanitized['interval']    = in_array( $interval, $allowed_intervals, true ) ? $interval : 'hourly';
        return $sanitized;
    }

    public function handle_manual() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to run imports.', 'news-importer' ) );
        }
        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'manual_import_action' ) ) {
            wp_die( esc_html__( 'Security check failed.', 'news-importer' ) );
        }

        $service = new News_Importer_Service();
        $stats = $service->import();

        set_transient( 'news_import_results', $stats, 60 );
        wp_safe_redirect( admin_url( 'admin.php?page=news-importer' ) );
        exit;
    }

    public function render() {
        $options = get_option('news_importer_settings', []);
        $stats = get_transient('news_import_results');
        delete_transient('news_import_results');
        ?>
        <div class="wrap">
            <?php if ( $stats ) : ?>
                <div class="notice notice-success is-dismissible">
                    <p>Imported: <?php echo esc_html( (string) $stats['imported'] ); ?> | Skipped: <?php echo esc_html( (string) $stats['skipped'] ); ?> | Errors: <?php echo esc_html( (string) $stats['errors'] ); ?></p>
                </div>
            <?php endif; ?>

            <form action="options.php" method="post">
                <?php settings_fields('news_importer_group'); ?>
                <table class="form-table">
                    <tr><th>API Key</th><td><input type="text" name="news_importer_settings[api_key]" value="<?php echo esc_attr($options['api_key'] ?? ''); ?>" class="regular-text"></td></tr>
                    <tr><th>Endpoint</th><td><input type="text" name="news_importer_settings[api_endpoint]" value="<?php echo esc_attr($options['api_endpoint'] ?? 'https://newsapi.org/v2/everything'); ?>" class="regular-text"></td></tr>
                    <tr><th>Count</th><td><input type="number" name="news_importer_settings[import_count]" value="<?php echo esc_attr($options['import_count'] ?? 5); ?>"></td></tr>
                    <tr>
                        <th>Interval</th>
                        <td>
                            <select name="news_importer_settings[interval]">
                                <option value="hourly" <?php selected($options['interval'] ?? 'hourly', 'hourly'); ?>>Every Hour</option>
                                <option value="twicedaily" <?php selected($options['interval'] ?? 'hourly', 'twicedaily'); ?>>Two times on day</option>
                                <option value="daily" <?php selected($options['interval'] ?? 'hourly', 'daily'); ?>>Every day</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>

            <hr>
            <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
                <input type="hidden" name="action" value="news_manual_import">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('manual_import_action'); ?>">
                <?php submit_button('Import Now (Manual)', 'secondary'); ?>
            </form>
        </div>
        <?php
    }
}

