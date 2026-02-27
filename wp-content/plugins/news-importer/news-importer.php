<?php
/**
 * Plugin Name: News Importer
 * Description: Import news articles from an external API (e.g. NewsAPI) and publish them as WordPress posts.
 * Version: 1.0.0
 * Author: Maksym K.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. require files
require_once __DIR__ . '/inc/class-news-importer.php';
require_once __DIR__ . '/inc/class-news-settings.php';
require_once __DIR__ . '/inc/class-news-rest.php';
require_once __DIR__ . '/inc/class-news-main.php';

// 2. One start Plugin
$news_importer = new News_Importer_Main();

// 3. register hooks
register_activation_hook(__FILE__, ['News_Importer_Main', 'activate']);
register_deactivation_hook(__FILE__, ['News_Importer_Main', 'deactivate']);