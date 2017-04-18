<?php
/**
 * Create Nonce
 */

namespace mehulkaklotar\wpnonce;

/**
 * Class NonceCreate
 * @package mehulkaklotar\wpnonce
 */
class NonceCreate extends NonceAbstract {

	/**
	 * Configures the settings
	 *
	 * @param NonceSetting $setting The configuration.
	 **/
	function __construct( NonceSetting $setting ) {
		$this->setAction( $setting->getAction() );
		$this->setRequestName( $setting->getRequestName() );
		$this->setLifetime( $setting->getLifetime() );
	}

	/**
	 * create nonce
	 *
	 * @return string $nonce Created nonce
	 **/
	public function create() {
		$this->setNonce( wp_create_nonce( $this->getAction() ) );

		return $this->getNonce();
	}


}