<?php
/**
 * Plugin sub class.
 *
 * @package wpdtrt_admin_toolbar_links
 * @version 0.1.0
 * @since   0.8.7 DTRT WordPress Plugin Boilerplate Generator
 */

/**
 * Extend the base class to inherit boilerplate functionality.
 * Adds application-specific methods.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class WPDTRT_Admin_Toolbar_Links_Plugin extends DoTheRightThing\WPDTRT_Plugin_Boilerplate\r_1_5_10\Plugin {

	/**
	 * Supplement plugin initialisation.
	 *
	 * @param     array $options Plugin options.
	 * @since     1.0.0
	 * @version   1.1.0
	 */
	public function __construct( $options ) {

		// edit here.
		parent::__construct( $options );
	}

	/**
	 * ====== WordPress Integration ======
	 */

	/**
	 * Supplement plugin's WordPress setup.
	 * Note: Default priority is 10. A higher priority runs later.
	 *
	 * @see https://codex.wordpress.org/Plugin_API/Action_Reference Action order
	 */
	protected function wp_setup() {

		parent::wp_setup();
		// add actions and filters here.
	}

	/**
	 * ====== Getters and Setters ======
	 */

	/**
	 * ===== Renderers =====
	 */

	/**
	 * ===== Filters =====
	 */

	/**
	 * ===== Helpers =====
	 */
}
