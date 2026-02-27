<?php

// Add custom fonts, used in the main stylesheet.
wp_enqueue_style( 'news-post-fonts', wptt_get_webfont_url( news_post_fonts_url() ), array(), null );

// Slick style.
wp_enqueue_style( 'slick-style', get_template_directory_uri() . '/assets/css/slick.min.css', array(), '1.8.0' );

// Fontawesome style.
wp_enqueue_style( 'fontawesome-style', get_template_directory_uri() . '/assets/css/fontawesome.min.css', array(), '6.7.2' );

// Conveyor Ticker style.
wp_enqueue_style( 'conveyor-ticker-style', get_template_directory_uri() . '/assets/css/jquery.jConveyorTicker.min.css', array(), '1.1.0' );

// blocks.
wp_enqueue_style( 'news-post-blocks-style', get_template_directory_uri() . '/assets/css/blocks.min.css' );

// style.
wp_enqueue_style( 'news-post-style', get_template_directory_uri() . '/style.css', array(), NEWS_POST_VERSION );

// navigation.
wp_enqueue_script( 'news-post-navigation', get_template_directory_uri() . '/assets/js/navigation.min.js', array(), NEWS_POST_VERSION, true );

// Slick script.
wp_enqueue_script( 'slick-script', get_template_directory_uri() . '/assets/js/slick.min.js', array( 'jquery' ), '1.8.0', true );

// Conveyor Ticker script.
wp_enqueue_script( 'conveyor-ticker-script', get_template_directory_uri() . '/assets/js/jquery.jConveyorTicker.js', array( 'jquery' ), '1.1.0', true );

// Custom script.
wp_enqueue_script( 'news-post-custom-script', get_template_directory_uri() . '/assets/js/custom.min.js', array( 'jquery' ), NEWS_POST_VERSION, true );

if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}
