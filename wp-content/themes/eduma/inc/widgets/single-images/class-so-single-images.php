<?php
/**
 * Thim_Builder Siteorigin Single Images widget
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

if ( ! class_exists( 'Thim_Single_Images_Widget' ) ) {
	/**
	 * Class Thim_Accordion_Widget
	 */
	class Thim_Single_Images_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_Accordion_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Single_Images';

			parent::__construct();
		}
	}
}

