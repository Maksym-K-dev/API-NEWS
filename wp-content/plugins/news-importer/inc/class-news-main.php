<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class News_Importer_Main {
    public function __construct() {
        if ( class_exists( 'News_Importer_Service' ) ) {
            new News_Importer_Service();
        }

        if ( class_exists( 'News_Importer_Settings' ) ) {
            new News_Importer_Settings();
        }

        if ( class_exists( 'News_Importer_Rest' ) ) {
            new News_Importer_Rest();
        }

        add_action( 'news_importer_cron_event', [ $this, 'scheduled_run' ] );
        add_action( 'update_option_news_importer_settings', [ $this, 'reschedule_cron' ], 10, 3 );
    }

    public function scheduled_run() {
        $service = new News_Importer_Service();
        $service->import();
    }

    public function reschedule_cron( $old_value, $value, $option ) {
        $interval = isset( $value['interval'] ) ? $value['interval'] : 'hourly';
        $allowed  = [ 'hourly', 'twicedaily', 'daily' ];
        if ( ! in_array( $interval, $allowed, true ) ) {
            $interval = 'hourly';
        }
        wp_clear_scheduled_hook( 'news_importer_cron_event' );
        wp_schedule_event( time(), $interval, 'news_importer_cron_event' );
    }

    public static function activate() {
        $options  = get_option( 'news_importer_settings', [] );
        $interval = $options['interval'] ?? 'hourly';
        $allowed  = [ 'hourly', 'twicedaily', 'daily' ];
        if ( ! in_array( $interval, $allowed, true ) ) {
            $interval = 'hourly';
        }

        if ( ! wp_next_scheduled( 'news_importer_cron_event' ) ) {
            wp_schedule_event( time(), $interval, 'news_importer_cron_event' );
        }
    }

    public static function deactivate() {
        wp_clear_scheduled_hook( 'news_importer_cron_event' );
    }
}

