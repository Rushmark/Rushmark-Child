<?php
/**
 * PWA Offline
 *
* @package      RushmarkChild
* @author      Chris Clarke
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Offline Content
 *
 */
function rushmark_pwa_offline_content() {
	echo '<h1>Oops, it looks like you\'re offline</h1>';
	if( function_exists( 'wp_service_worker_error_message_placeholder' ) )
		wp_service_worker_error_message_placeholder();

}
add_action( 'genesis_loop', 'rushmark_pwa_offline_content' );
remove_action( 'genesis_loop', 'rushmark_archive_loop' );
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Build the page
genesis();
