<?php
/**
 * Unit tests, using PHPUnit, wp-cli, WP_UnitTestCase
 *
 * The plugin is 'active' within a WP test environment
 *  so the plugin class has already been instantiated
 *  with the options set in wpdtrt-gallery.php
 *
 * Only function names prepended with test_ are run.
 * $debug logs are output with the test output in Terminal
 * A failed assertion may obscure other failed assertions in the same test.
 *
 * @package WPDTRT_Admin_Toolbar_Links
 * @version 0.1.0
 * @since   0.8.7 DTRT WordPress Plugin Boilerplate Generator
 * @see https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/wiki/Testing-&-Debugging#testing
 */

/**
 * WP_UnitTestCase unit tests for wpdtrt_admin_toolbar_links
 */
class WPDTRT_Admin_Toolbar_LinksTest extends WP_UnitTestCase {

	/**
	 * Compare two HTML fragments.
	 *
	 * @param string $expected Expected value.
	 * @param string $actual Actual value.
	 * @param string $error_message Message to show when strings don't match.
	 * @uses https://stackoverflow.com/a/26727310/6850747
	 */
	protected function assertEqualHtml( $expected, $actual, $error_message ) {
		$from = [ '/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/> </s' ];
		$to   = [ '>', '<', '\\1', '><' ];
		$this->assertEquals(
			preg_replace( $from, $to, $expected ),
			preg_replace( $from, $to, $actual ),
			$error_message
		);
	}

	/**
	 * SetUp
	 * Automatically called by PHPUnit before each test method is run
	 */
	public function setUp() {
		// Make the factory objects available.
		parent::setUp();

		$this->post_id_1 = $this->create_post( array(
			'post_title'   => 'DTRT Admin Toolbar Links test',
			'post_content' => 'This is a simple test',
		));
	}

	/**
	 * TearDown
	 * Automatically called by PHPUnit after each test method is run
	 *
	 * @see https://codesymphony.co/writing-wordpress-plugin-unit-tests/#object-factories
	 */
	public function tearDown() {

		parent::tearDown();

		wp_delete_post( $this->post_id_1, true );
	}

	/**
	 * Create post
	 *
	 * @param array $options Post options (post_title, post_date, post_content).
	 * @return number $post_id
	 * @see https://developer.wordpress.org/reference/functions/wp_insert_post/
	 * @see https://wordpress.stackexchange.com/questions/37163/proper-formatting-of-post-date-for-wp-insert-post
	 * @see https://codex.wordpress.org/Function_Reference/wp_update_post
	 */
	public function create_post( $options ) {

		$post_title   = null;
		$post_date    = null;
		$post_content = null;

		extract( $options, EXTR_IF_EXISTS );

		$post_id = $this->factory->post->create([
			'post_title' => $post_title,
			'post_date' => $post_date,
			'post_content' => $post_content,
			'post_type' => 'post',
			'post_status' => 'publish',
		]);

		return $post_id;
	}

	/**
	 * ===== Tests =====
	 */

	/**
	 * Demo test
	 */
	public function test_placeholder() {

		$this->assertEquals(
			'abc123',
			'abc123',
			'Strings do not match'
		);
	}
}
