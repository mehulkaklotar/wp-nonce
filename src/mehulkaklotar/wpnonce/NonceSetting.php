<?php
/**
 * The Config Class
 */

namespace mehulkaklotar\wpnonce;


/**
 * Class NonceSetting
 * @package mehulkaklotar\wpnonce
 */
class NonceSetting extends NonceAbstract {

	/**
	 * NonceSetting constructor.
	 *
	 * @param $action Action
	 * @param $request_name The new request name
	 * @param $lifetime Lifetime of the nonce
	 */
	function __construct( string $action, string $request_name, int $lifetime = null ) {

		$this->setAction( $action );
		$this->setRequestName( $request_name );

		if ( ! empty( $lifetime ) ) {
			$this->setLifetime( $lifetime );
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