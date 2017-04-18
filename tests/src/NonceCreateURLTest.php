<?php

use Brain\Monkey;
use Brain\Monkey\Functions;
use Brain\Monkey\WP\Filters;

use mehulkaklotar\wpnonce\NonceSetting;
use mehulkaklotar\wpnonce\NonceCreateURL;

class NonceCreateURLTest extends \PHPUnit_Framework_TestCase {

	/**
	 * The request name.
	 *
	 * @var string
	 **/
	public $request;

	/**
	 * The action.
	 *
	 * @var string
	 **/
	public $action;

	/**
	 * The lifetime.
	 *
	 * @var int
	 **/
	public $lifetime;

	/**
	 * The configuration.
	 *
	 * @var NonceSetting
	 **/
	public $setting;

	/**
	 * Set the test up.
	 **/
	public function setUp() {
		if ( ! defined( 'DAY_IN_SECONDS' ) ) {
			define( 'DAY_IN_SECONDS', 86400 );
		}
		// We mock wp_create_nonce with sha1().
		Functions::when( 'wp_create_nonce' )->alias( 'sha1' );

		// We mock wp_nonce_url.
		Functions::expect( 'wp_nonce_url' )->andReturnUsing( function ( $url, $action, $request_name ) {
			return $url . $action . $request_name;
		} );

		parent::setUp();
		Monkey::setUpWP();

		$this->action   = 'action';
		$this->request  = 'request';
		$this->lifetime = 213;
		$this->setting = new NonceSetting( $this->action, $this->request, $this->lifetime );
	}

	/**
	 * Test URL creation
	 */
	public function testCreateURL() {
		$create = new NonceCreateURL( $this->setting );
		$url = 'http://example.com/';
		$url_with_nonce = $create->create_url( $url );

		self::assertSame( $url_with_nonce, $url . $this->action . $this->request );

		self::assertSame( $url_with_nonce, $create->get_url() );
		self::assertSame( $create->set_url( 'abc' ), 'abc' );
	}


	/**
	 * Tear down the test.
	 **/
	public function tearDown() {
		Monkey::tearDownWP();
		parent::tearDown();
	}

}
