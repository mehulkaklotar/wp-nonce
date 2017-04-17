<?php
use Brain\Monkey;
use Brain\Monkey\Functions;
use Brain\Monkey\WP\Filters;

use mehulkaklotar\wpnonce\NonceConfig;
use mehulkaklotar\wpnonce\NonceCreate;

class NonceCreateTest extends \PHPUnit_Framework_TestCase {

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
		// We mock wp_create_nonce with sha1().
		Functions::when( 'wp_create_nonce' )->alias( 'sha1' );

		parent::setUp();
		Monkey::setUpWP();

		$this->action   = 'action';
		$this->request  = 'request';
		$this->lifetime = 123;
		$this->config = new NonceConfig( $this->action, $this->request, $this->lifetime );
	}

	/**
	 * Check create()
	 */
	public function testCreate() {
		$create = new NonceCreate( $this->config );
		$nonce = $create->create();

		// Check if nonce is stored correctly.
		self::assertSame( $nonce, $create->get_nonce() );
	}



	/**
	 * Tear down the test.
	 **/
	public function tearDown() {
		Monkey::tearDownWP();
		parent::tearDown();
	}

}
