<?php
/**
 * Create nonce field
 */

namespace mehulkaklotar\wpnonce;

/**
 * Class NonceCreateField
 * @package mehulkaklotar\wpnonce
 */
class NonceCreateField extends NonceCreate {

	/**
	 * field
	 *
	 * @var string
	 **/
	private $field = '';

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
	 * @param boolean $referer Whether to add a referer field or not.
	 * @param boolean $echo Whether to echo the field immediatly or not.
	 *
	 * @return string $field   The created field.
	 **/
	public function create_field( bool $referer = null, bool $echo = null ) {
		// Make sure, we have booleans.
		$referer = (bool) $referer;
		$echo    = (bool) $echo;
		// Let's create a nonce to populate $nonce.
		$this->create();
		$field = wp_nonce_field( $this->getAction(), $this->getRequestName(), $referer, false );
		$this->set_field( $field );
		if ( true === $echo ) {
			echo wp_kses(
				$this->get_field(),
				array(
					'input' => array(
						'type'  => array(),
						'id'    => array(),
						'name'  => array(),
						'value' => array(),
					),
				)
			);
		}

		return $this->get_field();
	}

	/**
	 * Set the URL
	 *
	 * @param  string $new_field The new field.
	 *
	 * @return string $field       The field
	 **/
	public function set_field( string $new_field ) {
		$this->field = $new_field;

		return $this->get_field();
	}

	/**
	 * Get the URL
	 *
	 * @return string $url The URL
	 **/
	public function get_field() {
		return $this->field;
	}

}