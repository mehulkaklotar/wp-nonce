<?php

use Brain\Monkey;
use Brain\Monkey\Functions;
use Brain\Monkey\WP\Filters;

use mehulkaklotar\wpnonce\NonceConfig;
use mehulkaklotar\wpnonce\NonceCreateField;

class NonceCreateFieldTest extends \PHPUnit_Framework_TestCase {

	/**
	 * The lifetime.
	 *
	 * @var int
	 **/
	public $lifetime;

	/**
	 * The action.
	 *
	 * @var string
	 **/
	public $action;


	/**
	 * The request name.
	 *
	 * @var string
	 **/
	public $request;


	/**
	 * The configuration.
	 *
	 * @var NonceConfig
	 **/
	public $config;

	/**
	 * Set the test up
	 **/
	public function setUp() {
		if ( ! defined( 'DAY_IN_SECONDS' ) ) {
			define( 'DAY_IN_SECONDS', 86400 );
		}

		// we mock wp_create_nonce with sha1().
		Functions::when( 'wp_create_nonce' )->alias( 'sha1' );

		// we mock wp_nonce_field.
		Functions::expect( 'wp_nonce_field' )->andReturnUsing( function ( $action, $request_name, $referer, $echo ) {
			$string = $action . $request_name;
			if ( $referer ) {
				$string .= 'referer';
			}

			// Should never be true, since we call wp_nonce_field with $echo false always and do echo by ourselfs.
			if ( $echo ) {
				$string .= 'echo';
			}

			return $string;
		} );

		// we mock wp_kses.
		Functions::expect( 'wp_kses' )->andReturnUsing( function ( $string, $array ) {

			return $string;
		} );

		parent::setUp();
		Monkey::setUpWP();

		$this->action   = 'action';
		$this->request  = 'request';
		$this->lifetime = 123;
		$this->config = new NonceConfig( $this->action, $this->request, $this->lifetime );
	}

	/**
	 * Test Field creation
	 */
	public function testCreateField() {
		$create = new NonceCreateField( $this->config );
		$field = $create->create_field();

		self::assertSame( $field, $this->action . $this->request );

		$field = $create->create_field( true );
		self::assertSame( $field, $this->action . $this->request . 'referer' );

		// Test echo.
		ob_start();
		$field = $create->create_field( false, true );
		$echo_output = ob_get_contents();
		ob_end_clean();

		self::assertSame( $echo_output, $this->action . $this->request );
		self::assertSame( $field, $this->action . $this->request );
	}


	/**
	 * Tear down the test.
	 **/
	public function tearDown() {
		Monkey::tearDownWP();
		parent::tearDown();
	}

}
