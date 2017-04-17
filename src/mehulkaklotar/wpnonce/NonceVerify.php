<?php
/**
 * Verify nonce
 */

namespace mehulkaklotar\wpnonce;

/**
 * Class NonceVerify
 * @package mehulkaklotar\wpnonce
 */
class NonceVerify extends NonceAbstract {

	/**
	 * Configure the class.
	 *
	 * @param NonceConfig $config The configuration instance.
	 **/
	public function __construct( NonceConfig $config ) {
		$this->setAction( $config->getAction() );
		$this->setRequestName( $config->getRequestName() );
		$this->setLifetime( $config->getLifetime() );
		// If the $_REQUEST is set, we set the nonce here.
		if ( isset( $_REQUEST[ $this->getRequestName() ] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_REQUEST[ $this->getRequestName() ] ) );
			$this->setNonce( $nonce );
		}
	}

	/**
	 * Verify a nonce.
	 *
	 * @param string $nonce The nonce to verify (optional).
	 *
	 * @return boolean $valid Whether the nonce is valid or not.
	 **/
	public function verify( string $nonce = null ) {
		if ( null != $nonce ) {
			$this->setNonce( $nonce );
		}
		$valid = wp_verify_nonce( $this->getNonce(), $this->getAction() );
		if ( false === $valid ) {
			return false;
		}

		return true;
	}

	/**
	 * Get the age of a nonce
	 *
	 * @return string $age
	 **/
	public function get_nonce_age() {
		$age = wp_verify_nonce( $this->getNonce(), $this->getAction() );

		return $age;
	}

}