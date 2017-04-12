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
	 * @param NonceConfig $config The configuration.
	 **/
	function __construct( NonceConfig $config ) {
		$this->setAction( $config->getAction() );
		$this->setRequest_name( $config->getRequestName() );
		$this->setLifetime( $config->getLifetime() );
	}

	/**
	 * Verify nonce
	 *
	 * @return string $nonce Created nonce
	 **/
	public function create() {
		$this->setNonce( wp_create_nonce( $this->getAction() ) );

		return $this->getNonce();
	}


}