<?php
/**
 * Thim_Builder Visual Composer Image Box shortcode
 *
 * @version     1.0.0
 * @author      ThimPress
 * @package     Thim_Builder/Classes
 * @category    Classes
 * @author      Thimpress, tuanta
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Thim_Builder_VC_Image_Box' ) ) {
	/**
	 * Class Thim_Builder_VC_Image_Box
	 */
	class Thim_Builder_VC_Image_Box extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Image_Box constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Image_Box';

			parent::__construct();
		}
	}
}

new Thim_Builder_VC_Image_Box();