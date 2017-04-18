<?php
use Brain\Monkey;
use Brain\Monkey\Functions;
use Brain\Monkey\WP\Filters;

use mehulkaklotar\wpnonce\NonceSetting;

class NonceSettingTest extends \PHPUnit_Framework_TestCase {

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

		parent::setUp();
		Monkey::setUpWP();

		$this->action   = 'action';
		$this->request  = 'request';
	}

	/**
	 * Check if NonceConfig stores the data correctly.
	 */
	public function testCreateConfig() {
		$this->lifetime = 213;

		// The filter should be added once.
		Filters::expectAdded( 'nonce_life' )
			->once();

		$this->setting = new NonceSetting( $this->action, $this->request, $this->lifetime );

		self::assertSame( $this->setting->getAction(),       $this->action );
		self::assertSame( $this->setting->getRequestName(), $this->request );
		self::assertSame( $this->setting->getLifetime(),     $this->lifetime );

		// Check if nonce_life returns the right value.
		self::assertSame( $this->setting->nonce_life( DAY_IN_SECONDS ), $this->lifetime );
	}

	/**
	 * Check if filter is not added, when lifetime is not set.
	 **/
	public function test_no_filter_added() {
		$this->lifetime = null;

		// The filter should be added once.
		Filters::expectAdded( 'nonce_life' )
			->never();
		$this->setting = new NonceSetting( $this->action, $this->request, $this->lifetime );
	}


	/**
	 * Tear down the test.
	 **/
	public function tearDown() {
		Monkey::tearDownWP();
		parent::tearDown();
	}

}
