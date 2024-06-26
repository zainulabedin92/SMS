<?php

namespace Thim_EL_Kit\Elementor\Motion_Effects;

use Thim_EL_Kit\SingletonTrait;
use Elementor\Controls_Stack;
use Elementor\Element_Base;
use Elementor\Controls_Manager;

class Init {

	use SingletonTrait;

	public function __construct() {
		add_action( 'elementor/element/after_section_end', array( $this, 'add_controls_to_element' ), 10, 2 );
	}

	public function add_controls_to_element( Controls_Stack $controls_stack, $section_id ) {
		if ( $section_id === 'section_effects' ) {
			$controls_stack->start_controls_section(
				'thim_ekit_motion_effects',
				array(
					'label' => esc_html__( ' Thim Motion Effects', 'thim-elementor-kit' ),
					'tab'   => Controls_Manager::TAB_ADVANCED,
				)
			);

			$controls_stack->add_control(
				'thim_ekit_motion_fx_mouse',
				array(
					'label'              => esc_html__( 'Mouse Effects', 'thim-elementor-kit' ),
					'type'               => Controls_Manager::SWITCHER,
					'label_off'          => esc_html__( 'Off', 'thim-elementor-kit' ),
					'label_on'           => esc_html__( 'On', 'thim-elementor-kit' ),
					'render_type'        => 'none',
					'frontend_available' => true,
				)
			);

			$controls_stack->add_control(
				'thim_ekit_motion_fx_mouseTrack_effect',
				array(
					'label'              => esc_html__( 'Mouse Track', 'thim-elementor-kit' ),
					'type'               => Controls_Manager::SWITCHER,
					'label_off'          => esc_html__( 'Off', 'thim-elementor-kit' ),
					'label_on'           => esc_html__( 'On', 'thim-elementor-kit' ),
					'condition'          => array(
						'thim_ekit_motion_fx_mouse' => 'yes',
					),
					'render_type'        => 'none',
					'frontend_available' => true,
				)
			);

			$controls_stack->add_control(
				'thim_ekit_motion_fx_mouseTrack_direction',
				array(
					'label'              => esc_html__( 'Direction', 'thim-elementor-kit' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => '',
					'options'            => array(
						''         => esc_html__( 'Opposite', 'thim-elementor-kit' ),
						'negative' => esc_html__( 'Direct', 'thim-elementor-kit' ),
					),
					'condition'          => array(
						'thim_ekit_motion_fx_mouse'             => 'yes',
						'thim_ekit_motion_fx_mouseTrack_effect' => 'yes',
					),
					'render_type'        => 'none',
					'frontend_available' => true,
				)
			);

			$controls_stack->add_control(
				'thim_ekit_motion_fx_mouseTrack_speed',
				array(
					'label'              => esc_html__( 'Speed', 'thim-elementor-kit' ),
					'type'               => Controls_Manager::SLIDER,
					'default'            => array(
						'size' => 1,
					),
					'range'              => array(
						'px' => array(
							'max'  => 10,
							'step' => 0.1,
						),
					),
					'condition'          => array(
						'thim_ekit_motion_fx_mouse'             => 'yes',
						'thim_ekit_motion_fx_mouseTrack_effect' => 'yes',
					),
					'render_type'        => 'none',
					'frontend_available' => true,
					'separator'          => 'after',
				)
			);

			$controls_stack->add_control(
				'thim_ekit_motion_fx_tilt_effect',
				array(
					'label'              => esc_html__( '3D Tilt', 'thim-elementor-kit' ),
					'type'               => Controls_Manager::SWITCHER,
					'label_off'          => esc_html__( 'Off', 'thim-elementor-kit' ),
					'label_on'           => esc_html__( 'On', 'thim-elementor-kit' ),
					'condition'          => array(
						'thim_ekit_motion_fx_mouse' => 'yes',
					),
					'render_type'        => 'none',
					'frontend_available' => true,
				)
			);

			$controls_stack->add_control(
				'thim_ekit_motion_fx_tilt_direction',
				array(
					'label'              => esc_html__( 'Direction', 'thim-elementor-kit' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => '',
					'options'            => array(
						''         => esc_html__( 'Opposite', 'thim-elementor-kit' ),
						'negative' => esc_html__( 'Direct', 'thim-elementor-kit' ),
					),
					'condition'          => array(
						'thim_ekit_motion_fx_mouse'       => 'yes',
						'thim_ekit_motion_fx_tilt_effect' => 'yes',
					),
					'render_type'        => 'none',
					'frontend_available' => true,
				)
			);

			$controls_stack->add_control(
				'thim_ekit_motion_fx_tilt_speed',
				array(
					'label'              => esc_html__( 'Speed', 'thim-elementor-kit' ),
					'type'               => Controls_Manager::SLIDER,
					'default'            => array(
						'size' => 1,
					),
					'range'              => array(
						'px' => array(
							'max'  => 10,
							'step' => 0.1,
						),
					),
					'condition'          => array(
						'thim_ekit_motion_fx_mouse'       => 'yes',
						'thim_ekit_motion_fx_tilt_effect' => 'yes',
					),
					'render_type'        => 'none',
					'frontend_available' => true,
				)
			);

			$controls_stack->end_controls_section();
		}
	}
}

Init::instance();
