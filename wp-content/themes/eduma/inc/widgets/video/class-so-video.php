<?php
/**
 * Thim_Builder Siteorigin Video widget
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

if ( ! class_exists( 'Thim_Video_Widget' ) ) {
	/**
	 * Class Thim_Accordion_Widget
	 */
	class Thim_Video_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_Accordion_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Video';

			parent::__construct();
		}
	}
}

