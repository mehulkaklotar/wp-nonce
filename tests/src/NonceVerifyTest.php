<?php

use Brain\Monkey;
use Brain\Monkey\Functions;
use Brain\Monkey\WP\Filters;

use mehulkaklotar\wpnonce\NonceConfig;
use mehulkaklotar\wpnonce\NonceCreate;
use mehulkaklotar\wpnonce\NonceVerify;

class NonceVerifyTest extends \PHPUnit_Framework_TestCase {

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
	 * Set the test up.
	 **/
	public function setUp() {
		if ( ! defined( 'DAY_IN_SECONDS' ) ) {
			define( 'DAY_IN_SECONDS', 86400 );
		}
		// we mock wp_create_nonce with sha1().
		Functions::when( 'wp_create_nonce' )->alias( 'sha1' );

		// we mock wp_verify_nonce.
		Functions::expect( 'wp_verify_nonce' )->andReturnUsing( function ( $nonce, $action ) {
			return sha1( $action ) === $nonce;
		} );

		// we mock wp_unslash.
		Functions::expect( 'wp_unslash' )->andReturnUsing( function ( $string ) {
			return $string;
		} );

		// we mock sanitize_text_field.
		Functions::expect( 'sanitize_text_field' )->andReturnUsing( function ( $string ) {
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
	 * Check validation
	 */
	public function testValidity() {
		$create = new NonceCreate( $this->config );
		$nonce = $create->create();

		$verify = new NonceVerify( $this->config );
		$valid = $verify->verify( $nonce );

		// Check if nonce is valid.
		self::assertTrue( $valid );

		// Check if nonce is not valid.
		$not_valid = $verify->verify( 'not-valid' . $nonce );
		self::assertFalse( $not_valid );

		// Check auto-nonce assignment.
		$_REQUEST[ $this->request ] = $nonce;
		$verify = new NonceVerify( $this->config );
		$valid = $verify->verify();
		self::assertTrue( $valid );
	}

	/**
	 * Check age
	 **/
	public function testAge() {
		self::markTestSkipped( 'Skipped. wp_verify_nonce() needs a better mockup to test this functionality.' );
		$create = new Noncecreate( $this->config );
		$nonce = $create->create();

		$verify = new NonceVerify( $this->config );
		$age = $verify->get_nonce_age( $nonce );

		self::assertSame( 1, $age );
	}

	/**
	 * Tear down the test.
	 **/
	public function tearDown() {
		Monkey::tearDownWP();
		parent::tearDown();
	}

}
