<?php
use Brain\Monkey;
use Brain\Monkey\Functions;
use Brain\Monkey\WP\Filters;

use mehulkaklotar\wpnonce\NonceSetting;
use mehulkaklotar\wpnonce\NonceCreate;

class NonceCreateTest extends \PHPUnit_Framework_TestCase {

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

		parent::setUp();
		Monkey::setUpWP();

		$this->action   = 'action';
		$this->request  = 'request';
		$this->lifetime = 213;
		$this->setting = new NonceSetting( $this->action, $this->request, $this->lifetime );
	}

	/**
	 * Check create()
	 */
	public function testCreate() {
		$create = new NonceCreate( $this->setting );
		$nonce = $create->create();

		// Check if nonce is stored correctly.
		self::assertSame( $nonce, $create->getNonce() );
	}



	/**
	 * Tear down the test.
	 **/
	public function tearDown() {
		Monkey::tearDownWP();
		parent::tearDown();
	}

}
