<?php
/**
 * The Config Class
 */

namespace mehulkaklotar\wpnonce;


/**
 * Class NonceConfig
 * @package mehulkaklotar\wpnonce
 */
class NonceConfig extends NonceAbstract {

	/**
	 * Configuration
	 *
	 * @param string $action The action.
	 * @param string $request_name The new request name.
	 * @param int $lifetime The new lifetime.
	 **/
	function __construct( string $action, string $request_name, int $lifetime = null ) {
		$this->setAction( $action );
		$this->setRequestName( $request_name );
		if ( null != $lifetime ) {
			$this->setLifetime( $lifetime );
			// hook into the nonce_life filter
			add_filter( 'nonce_life', array( $this, 'nonce_life' ) );
		}
	}

	/**
	 * Hooks into the nonce_life filter.
	 *
	 * @param  int $old_lifetime The old lifetime.
	 *
	 * @return int $lifetime     The lifetime.
	 **/
	public function nonce_life( $old_lifetime ) {
		return $this->getLifetime( false );
	}

}