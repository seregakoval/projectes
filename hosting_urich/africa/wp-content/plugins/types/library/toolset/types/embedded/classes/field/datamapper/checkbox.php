<?php

/**
 * Data mapper for a checkbox field.
 *
 * @since 1.9
 */
class WPCF_Field_DataMapper_Checkbox extends WPCF_Field_DataMapper_Abstract {


	/**
	 * If this is a checkbox field that is not set, we will set the value manually to false.
	 *
	 * @param mixed $post_value
	 * @param array $form_data
	 *
	 * @return bool|mixed
	 */
	public function post_to_intermediate( $post_value, $form_data ) {
		if( ! array_key_exists( $this->field_definition->get_slug(), $form_data ) ) {
			$value = false;
		} else {
			$value = $post_value;
		}
		return $value;
	}
}