<?php
/**
 * Plugin Name: Gutenberg PX
 * Plugin URI: https://github.com/hrsetyono/gutenberg-px
 * Description: WordPress editor with minor customization for version compatibility.
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * Version: 62.4.0
 * Author: Gutenberg Team & Pixel Studio
 * Text Domain: gutenberg
 *
 * @package gutenberg
 */

### BEGIN AUTO-GENERATED DEFINES
define( 'GUTENBERG_VERSION', '62.4.0' ); // 15.2.4
define( 'GUTENBERG_GIT_COMMIT', '0429fb1969ad5d01b108a01f0498c7ec4247b600' );
### END AUTO-GENERATED DEFINES

gutenberg_pre_init();

/**
 * Display a version notice and deactivate the Gutenberg plugin.
 *
 * @since 0.1.0
 */
function gutenberg_wordpress_version_notice() {
	echo '<div class="error"><p>';
	/* translators: %s: Minimum required version */
	printf( __( 'Gutenberg requires WordPress %s or later to function properly. Please upgrade WordPress before activating Gutenberg.', 'gutenberg' ), '5.9' );
	echo '</p></div>';

	deactivate_plugins( array( 'gutenberg/gutenberg.php' ) );
}

/**
 * Display a build notice.
 *
 * @since 0.1.0
 */
function gutenberg_build_files_notice() {
	echo '<div class="error"><p>';
	_e( 'Gutenberg development mode requires files to be built. Run <code>npm install</code> to install dependencies, <code>npm run build</code> to build the files or <code>npm run dev</code> to build the files and watch for changes. Read the <a href="https://github.com/WordPress/gutenberg/blob/HEAD/docs/contributors/code/getting-started-with-code-contribution.md">contributing</a> file for more information.', 'gutenberg' );
	echo '</p></div>';
}

/**
 * Verify that we can initialize the Gutenberg editor , then load it.
 *
 * @since 1.5.0
 */
function gutenberg_pre_init() {
	global $wp_version;
	if ( defined( 'GUTENBERG_DEVELOPMENT_MODE' ) && GUTENBERG_DEVELOPMENT_MODE && ! file_exists( __DIR__ . '/build/blocks' ) ) {
		add_action( 'admin_notices', 'gutenberg_build_files_notice' );
		return;
	}

	// Get unmodified $wp_version.
	include ABSPATH . WPINC . '/version.php';

	// Strip '-src' from the version string. Messes up version_compare().
	$version = str_replace( '-src', '', $wp_version );

	// Compare against major release versions (X.Y) rather than minor (X.Y.Z)
	// unless a minor release is the actual minimum requirement. WordPress reports
	// X.Y for its major releases.
	if ( version_compare( $version, '5.9', '<' ) ) {
		add_action( 'admin_notices', 'gutenberg_wordpress_version_notice' );
		return;
	}

	require_once __DIR__ . '/lib/load.php';
}
