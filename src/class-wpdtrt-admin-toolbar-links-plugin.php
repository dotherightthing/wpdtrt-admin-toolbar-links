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
	 * @see https://www.smashingmagazine.com/2012/03/inside-the-wordpress-toolbar/ - wp_before_admin_bar_render
	 */
	protected function wp_setup() {

		parent::wp_setup();

		add_action( 'wp_before_admin_bar_render', array( $this, 'render_repository_links' ) );
	}

	/**
	 * ====== Getters and Setters ======
	 */

	/**
	 * Get the contents of the active theme's composer.json as a PHP variable
	 *
	 * @return array Associative array of composer fields
	 * @see https://wordpress.stackexchange.com/a/114923 wp_remote_get vs file_get_contents
	 */
	protected function get_composer_vars() {
		// if we've already run this function, return the results.
		if ( isset( $this->composer_vars ) ) {
			return $this->composer_vars;
		}

		$composer_json_path     = ( get_stylesheet_directory_uri() . '/composer.json' );
		$composer_json_contents = wp_remote_get( $composer_json_path );
		$composer_json_vars     = array();

		// check for remote get error.
		if ( is_wp_error( $composer_json_contents ) ) {
			return $composer_json_vars;
		}

		// if the theme doesn't have a composer.json file, exit.
		if ( false === $composer_json_contents ) {
			return $composer_json_vars;
		}

		// convert to an array.
		$composer_json_vars = json_decode( $composer_json_contents['body'], true );

		// $composer_json_vars = get_object_vars( $composer_json );
		// store vars to avoid repeated lookups.
		$this->composer_vars = $composer_json_vars;

		return $composer_json_vars;
	}

	/**
	 * Get the name of the company
	 * which hosts the git repository
	 * containing the theme code.
	 *
	 * @return array Associative array of composer fields
	 */
	protected function get_githost_hostname() {
		$githost_vars = $this->get_composer_vars();
		$source_host  = '';

		if ( array_key_exists( 'support', $githost_vars ) ) {
			$support = $githost_vars['support'];

			if ( array_key_exists( 'source', $support ) ) {
				$source = $support['source'];

				// array: scheme (https), host (github.com), path (/a/b/c).
				$source_parts = wp_parse_url( $source );
				$source_host  = $source_parts['host'];

				// github.com -> Github.
				$source_host = explode( '.', $source_host );
				$source_host = $source_host[0];
				$source_host = ucfirst( $source_host );
			}
		}

		return $source_host;
	}

	/**
	 * Get the URL of the issue tracker
	 * for the git repository
	 * containing the theme code.
	 *
	 * @return string The issues URL
	 */
	protected function get_githost_issues_url() {
		$githost_vars = $this->get_composer_vars();
		$issues_url   = '';

		if ( array_key_exists( 'support', $githost_vars ) ) {
			$support = $githost_vars['support'];

			if ( array_key_exists( 'issues', $support ) ) {
				$issues_url = $support['issues'];
			}
		}

		return $issues_url;
	}

	/**
	 * Get the source URL
	 * for the git repository
	 * containing the theme code.
	 *
	 * @return string The source URL
	 */
	protected function get_githost_source_url() {
		$githost_vars = $this->get_composer_vars();
		$source_url   = '';

		if ( array_key_exists( 'support', $githost_vars ) ) {
			$support = $githost_vars['support'];

			if ( array_key_exists( 'source', $support ) ) {
				$source_url = $support['source'];
			}
		}

		return $source_url;
	}

	/**
	 * Get the wiki URL
	 * for the git repository
	 * containing the theme code.
	 *
	 * @return string The wiki URL
	 */
	protected function get_githost_wiki_url() {
		$githost_vars = $this->get_composer_vars();
		$wiki_url     = '';

		if ( array_key_exists( 'support', $githost_vars ) ) {
			$support = $githost_vars['support'];

			if ( array_key_exists( 'wiki', $support ) ) {
				$wiki_url = $support['wiki'];
			}
		}

		return $wiki_url;
	}

	/**
	 * ===== Renderers =====
	 */

	/**
	 * Render links to admin bar
	 *
	 * @uses http://www.bitbucket.com/wp-tutorials/13-plugins-and-tips-to-improve-wordpress-admin-area/
	 * @see https://www.php.net/manual/en/language.types.string.php Template strings - Complex (curly) syntax
	 * @todo Trailing params, e.g. 'https://bitbucket.org/BaseJumpImprov/basejumpimprov/issues?status=new&status=open'
	 */
	public function render_repository_links() {
		global $wp_admin_bar;
		$hostname    = $this->get_githost_hostname();
		$source_url  = $this->get_githost_source_url();
		$issues_url  = $this->get_githost_issues_url();
		$wiki_url    = $this->get_githost_wiki_url();
		$hostname_lc = strtolower( $hostname );

		$plugin_args = array(
			'id'    => "wpdtrt-admin-toolbar-links_{$hostname_lc}",
			'title' => 'Theme links',
			'href'  => '#', // else can't be tabbed to.
			'meta'  => array(
				'class'  => 'wpdtrt-admin-toolbar-links',
				'title'  => "Open {$hostname} in a new tab/window",
				'target' => '_blank',
			),
		);

		$source_args = array(
			'id'     => "wpdtrt-admin-toolbar-links_{$hostname_lc}-source",
			'title'  => "{$hostname} source code",
			'href'   => $source_url,
			'parent' => "wpdtrt-admin-toolbar-links_{$hostname_lc}",
			'meta'  => array(
				'class'  => "wpdtrt-admin-toolbar-links_{$hostname_lc}--source",
				'title'  => "Open {$hostname} in a new tab/window",
				'target' => '_blank',
			),
		);

		$issues_args = array(
			'id'     => "wpdtrt-admin-toolbar-links_{$hostname_lc}-issues",
			'title'  => "{$hostname} Issues",
			'href'   => $issues_url,
			'parent' => "wpdtrt-admin-toolbar-links_{$hostname_lc}",
			'meta'   => array(
				'class'  => "wpdtrt-admin-toolbar-links_{$hostname_lc}--issues",
				'title'  => "Open {$hostname} Issues in a new tab/window",
				'target' => '_blank',
			),
		);

		$wiki_args = array(
			'id'     => "wpdtrt-admin-toolbar-links_{$hostname_lc}-wiki",
			'title'  => "{$hostname} Wiki",
			'href'   => $wiki_url,
			'parent' => "wpdtrt-admin-toolbar-links_{$hostname_lc}",
			'meta'   => array(
				'class'  => "wpdtrt-admin-toolbar-links_{$hostname_lc}--wiki",
				'title'  => "Open {$hostname} Wiki in a new tab/window",
				'target' => '_blank',
			),
		);

		$wp_admin_bar->add_node( $plugin_args );
		$wp_admin_bar->add_node( $source_args );
		$wp_admin_bar->add_node( $issues_args );
		$wp_admin_bar->add_node( $wiki_args );
	}

	/**
	 * ===== Filters =====
	 */

	/**
	 * ===== Helpers =====
	 */
}
