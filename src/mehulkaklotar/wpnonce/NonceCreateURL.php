<?php
/**
 * Create nonce URL
 */

namespace mehulkaklotar\wpnonce;

/**
 * Class NonceCreateURL
 * @package mehulkaklotar\wpnonce
 */
class NonceCreateURL extends NonceCreate {

	/**
	 * The URL
	 *
	 * @var string
	 **/
	private $url = '';

	/**
	 * Configure the class.
	 *
	 * @param NonceSetting $setting The configuration instance.
	 **/
	function __construct( NonceSetting $setting ) {
		parent::__construct( $setting );
	}

	/**
	 * Verify a nonce
	 *
	 * @param string $url The URL to append the Nonce.
	 *
	 * @return string $nonce The created nonce
	 **/
	public function create_url( string $url ) {
		// Let's create a nonce to populate $nonce.
		$this->create();
		$url = wp_nonce_url( $url, $this->getAction(), $this->getRequestName() );
		$this->set_url( $url );

		return $this->get_url();
	}

	/**
	 * Set the URL
	 *
	 * @param string $new_url The new URL.
	 *
	 * @return string $nonce  The URL
	 **/
	public function set_url( string $new_url ) {
		$this->url = $new_url;

		return $this->get_url();
	}

	/**
	 * Get the URL
	 *
	 * @return string $url The URL
	 **/
	public function get_url() {
		return $this->url;
	}

}