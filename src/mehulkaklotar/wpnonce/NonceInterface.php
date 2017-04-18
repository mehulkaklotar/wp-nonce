<?php
/**
 * NonceInterface
 * The interface of the Nonce OOP.
 *
 * @package MehulKaklotarWPNonce
 * @license GPL2+
 */

namespace mehulkaklotar\wpnonce;

/**
 * Interface NonceInterface
 * @package mehulkaklotar\wpnonce
 */
interface NonceInterface {

	/**
	 * Set the nonce
	 *
	 * @param string $nonce The nonce to verify.
	 *
	 * @return string $nonce     The nonce
	 **/
	public function setNonce( string $nonce );

	/**
	 * Get the nonce
	 *
	 * @return string $nonce The nonce
	 **/
	public function getNonce();

	/**
	 * Set a lifetime
	 *
	 * @param int $lifetime The lifetime.
	 *
	 * @return int $lifetime The lifetime
	 **/
	public function setLifetime( int $lifetime );

	/**
	 * Get the lifetime
	 *
	 * @param  boolean $actual_lifetime Whether to run the 'nonce_life' filter or not. Optional. Default is true.
	 *
	 * @return int     $lifetime     The lifetime
	 **/
	public function getLifetime( bool $actual_lifetime = true );

    /**
     * Set an action
     *
     * @param string $action The action
     *
     * @return string $action
     */
    public function setAction( string $action );

    /**
     * Get the action
     *
     * @return string $action The action
     **/
    public function getAction();

    /**
     * Set a request name
     *
     * @param string $request_name The request name
     *
     * @return string $request The request
     **/
    public function setRequestName( string $request_name );

    /**
     * Get the request name
     *
     * @return string $request The request name
     **/
    public function getRequestName();
}