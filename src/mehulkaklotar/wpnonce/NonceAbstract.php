<?php
/**
 * NonceAbstract
 * abstract class
 *
 * @package MehulKaklotarWPNonce
 * @license GPL2+
 */

namespace mehulkaklotar\wpnonce;


/**
 * Class NonceAbstract
 * @package mehulkaklotar\wpnonce
 */
class NonceAbstract implements NonceInterface {

	/**
	 * The name of the action
	 *
	 * @var string
	 **/
	private $action = '';
	/**
	 * The name of the request
	 *
	 * @var string
	 **/
	private $request_name = '';
	/**
	 * The nonce
	 *
	 * @var string
	 **/
	private $nonce = '';
	/**
	 * The lifetime of a nonce in seconds
	 *
	 * @var int
	 **/
	private $lifetime = DAY_IN_SECONDS;

	/**
	 * Set the nonce
	 *
	 * @param string $nonce The nonce to verify.
	 *
	 * @return string $nonce    The nonce
	 **/
	public function setNonce( string $nonce ) {
		$this->nonce = $nonce;

		return $this->getNonce();
	}

	/**
	 * Get the nonce
	 *
	 * @return string $nonce The nonce
	 **/
	public function getNonce() {
		return $this->nonce;
	}

	/**
	 * Set the lifetime
	 *
	 * @param int $lifetime The new lifetime.
	 *
	 * @return int $lifetime    The current lifetime.
	 **/
	public function setLifetime( int $lifetime ) {
		$this->lifetime = $lifetime;

		return $this->getLifetime();
	}

	/**
	 * Get the lifetime
	 *
	 * @param boolean $actual_lifetime Use the lifetime used by WordPress or the lifetime stored in $lifetime. Optional. Default: true.
	 *
	 * @return int $lifetime       The lifetime.
	 **/
	public function getLifetime( bool $actual_lifetime = true ) {
		if ( $actual_lifetime ) {
			/**
			 * We run $lifetime through the 'nonce_life' to get the actual lifetime, which
			 * the system is using right now, since other systems might interfere with
			 * this filter.
			 */
			return apply_filters( 'nonce_life', $this->lifetime );
		}

		return $this->lifetime;
	}

	/**
	 * Set the action
	 *
	 * @param string $action The action name.
	 *
	 * @return string $action     The action.
	 **/
	public function setAction( string $action ) {
		$this->action = $action;

		return $this->getAction();
	}

	/**
	 * Get the action
	 *
	 * @return string $action The action.
	 **/
	public function getAction() {
		return $this->action;
	}

	/**
	 * Set the request name
	 *
	 * @param string $request_name The new request name.
	 *
	 * @return string $request_name    The request name.
	 **/
	public function setRequestName( string $request_name ) {
		$this->request_name = $request_name;

		return $this->getRequestName();
	}

	/**
	 * Get the request name
	 *
	 * @return string $request_name The request name.
	 **/
	public function getRequestName() {
		return $this->request_name;
	}

}