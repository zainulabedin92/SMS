<?php
defined( 'ABSPATH' ) || die();

class WLSM_M_Setting {
	public static function get_settings_general( $school_id ) {
		global $wpdb;
		$school_logo = NULL;

		$settings = $wpdb->get_row( $wpdb->prepare( 'SELECT ID, setting_value FROM ' . WLSM_SETTINGS . ' WHERE school_id = %d AND setting_key = "general"', $school_id ) );
		if ( $settings ) {
			$settings    = unserialize( $settings->setting_value );
			$school_logo = isset( $settings['school_logo'] ) ? $settings['school_logo'] : '';
		}

		return array(
			'school_logo' => $school_logo,
		);
	}

	public static function get_settings_email( $school_id ) {
		global $wpdb;
		$carrier = NULL;

		$settings = $wpdb->get_row( $wpdb->prepare( 'SELECT ID, setting_value FROM ' . WLSM_SETTINGS . ' WHERE school_id = %d AND setting_key = "email"', $school_id ) );
		if ( $settings ) {
			$settings = unserialize( $settings->setting_value );
			$carrier  = isset( $settings['carrier'] ) ? $settings['carrier'] : '';
		}

		return array(
			'carrier' => $carrier,
		);
	}


	public static function get_settings_registration( $school_id ) {
		global $wpdb;

		$form_title            = esc_html__( 'Online Registration', 'school-management' );
		$login_user            = 0;
		$redirect_url          = '';
		$create_invoice        = 1;
		$auto_admission_number = 0; // Auto generate admission number when registering student from back-end.
		$auto_roll_number      = 0; // Auto generate roll nubmer 
		$admin_email           = '';
		$admin_phone           = '';
		$success_message       = '';

		$dob               = 1;
		$student_aprove    = 0;
		$gender            = 1;
		$religion          = 1;
		$caste             = 1;
		$blood_group       = 1;
		$phone             = 1;
		$city              = 1;
		$state             = 1;
		$country           = 1;
		$transport         = 1;
		$parent_detail     = 1;
		$parent_login      = 1;
		$id_number         = 1;
		$id_number         = 0;
		$parent_occupation = 1;
		$survey            = 0;
		$fees              = 0;

		$default_success_message = esc_html__( 'Your registration has been submitted. Please check your email.', 'school-management' );

		$settings = $wpdb->get_row( $wpdb->prepare( 'SELECT ID, setting_value FROM ' . WLSM_SETTINGS . ' WHERE school_id = %d AND setting_key = "registration"', $school_id ) );
		if ( $settings ) {
			$settings              = unserialize( $settings->setting_value );
			$form_title            = isset( $settings['form_title'] ) ? $settings['form_title'] : '';
			$login_user            = isset( $settings['login_user'] ) ? $settings['login_user'] : '';
			$redirect_url          = isset( $settings['redirect_url'] ) ? $settings['redirect_url'] : '';
			$create_invoice        = isset( $settings['create_invoice'] ) ? $settings['create_invoice'] : '';
			$auto_admission_number = isset( $settings['auto_admission_number'] ) ? $settings['auto_admission_number'] : '';
			$auto_roll_number      = isset( $settings['auto_roll_number'] ) ? $settings['auto_roll_number'] : '';
			$admin_email           = isset( $settings['admin_email'] ) ? $settings['admin_email'] : '';
			$admin_phone           = isset( $settings['admin_phone'] ) ? $settings['admin_phone'] : '';
			$success_message       = isset( $settings['success_message'] ) ? $settings['success_message'] : '';

			$dob               = isset( $settings['dob'] ) ? $settings['dob'] : '';
			$student_aprove    = isset( $settings['student_aprove'] ) ? $settings['student_aprove'] : '';
			$gender            = isset( $settings['gender'] ) ? $settings['gender'] : '';
			$religion          = isset( $settings['religion'] ) ? $settings['religion'] : '';
			$caste             = isset( $settings['caste'] ) ? $settings['caste'] : '';
			$blood_group       = isset( $settings['blood_group'] ) ? $settings['blood_group'] : '';
			$phone             = isset( $settings['phone'] ) ? $settings['phone'] : '';
			$city              = isset( $settings['city'] ) ? $settings['city'] : '';
			$state             = isset( $settings['state'] ) ? $settings['state'] : '';
			$country           = isset( $settings['country'] ) ? $settings['country'] : '';
			$transport         = isset( $settings['transport'] ) ? $settings['transport'] : '';
			$parent_detail     = isset( $settings['parent_detail'] ) ? $settings['parent_detail'] : '';
			$parent_occupation = isset( $settings['parent_occupation'] ) ? $settings['parent_occupation'] : '';
			$parent_login      = isset( $settings['parent_login'] ) ? $settings['parent_login'] : '';
			$id_number         = isset( $settings['id_number'] ) ? $settings['id_number'] : '';
			$survey            = isset( $settings['survey'] ) ? $settings['survey'] : '';
			$fees              = isset( $settings['fees'] ) ? $settings['fees'] : '';

		}

		if ( empty( $success_message ) ) {
			$success_message = $default_success_message;
		}

		return array(
			'form_title'            => $form_title,
			'login_user'            => (bool) $login_user,
			'redirect_url'          => $redirect_url,
			'create_invoice'        => (bool) $create_invoice,
			'auto_admission_number' => (bool) $auto_admission_number,
			'auto_roll_number'      => (bool) $auto_roll_number,
			'admin_email'           => $admin_email,
			'admin_phone'           => $admin_phone,
			'success_message'       => $success_message,
			'dob'                   => (bool)$dob,
			'student_aprove'        => (bool)$student_aprove,
			'gender'                => (bool)$gender,
			'religion'              => (bool)$religion,
			'caste'                 => (bool)$caste,
			'blood_group'           => (bool)$blood_group,
			'phone'                 => (bool)$phone,
			'city'                  => (bool)$city,
			'state'                 => (bool)$state,
			'country'               => (bool)$country,
			'transport'             => (bool)$transport,
			'parent_detail'         => (bool)$parent_detail,
			'parent_occupation'     => (bool)$parent_occupation,
			'id_number'             => (bool)$id_number,
			'survey'                => (bool)$survey,
			'fees'                  => (bool)$fees,
			'parent_login'          => (bool)$parent_login

		);
	}

	public static function get_settings_wp_mail( $school_id ) {
		global $wpdb;
		$from_name  = NULL;
		$from_email = NULL;

		$settings = $wpdb->get_row( $wpdb->prepare( 'SELECT ID, setting_value FROM ' . WLSM_SETTINGS . ' WHERE school_id = %d AND setting_key = "wp_mail"', $school_id ) );
		if ( $settings ) {
			$settings  = unserialize( $settings->setting_value );
			$from_name = isset( $settings['from_name'] ) ? $settings['from_name'] : '';
			$from_email = isset( $settings['from_email'] ) ? $settings['from_email'] : '';
		}

		return array(
			'from_name'  => $from_name,
			'from_email' => $from_email,
		);
	}

	public static function get_settings_smtp( $school_id ) {
		global $wpdb;
		$from_name  = NULL;
		$host       = NULL;
		$username   = NULL;
		$password   = NULL;
		$encryption = NULL;
		$port       = NULL;

		$settings = $wpdb->get_row( $wpdb->prepare( 'SELECT ID, setting_value FROM ' . WLSM_SETTINGS . ' WHERE school_id = %d AND setting_key = "smtp"', $school_id ) );

		if ( $settings ) {
			$settings   = unserialize( $settings->setting_value );
			$from_name  = isset( $settings['from_name'] ) ? $settings['from_name'] : '';
			$host       = isset( $settings['host'] ) ? $settings['host'] : '';
			$username   = isset( $settings['username'] ) ? $settings['username'] : '';
			$password   = isset( $settings['password'] ) ? $settings['password'] : '';
			$encryption = isset( $settings['encryption'] ) ? $settings['encryption'] : '';
			$port       = isset( $settings['port'] ) ? $settings['port'] : '';
		}

		return array(
			'from_name'  => $from_name,
			'host'       => $host,
			'username'   => $username,
			'password'   => $password,
			'encryption' => $encryption,
			'port'       => $port,
		);
	}

	public static function get_settings_email_student_admission( $school_id ) {
		global $wpdb;

		$enable  = 0;
		$subject = '';
		$body    = '';

		$settings = $wpdb->get_row( $wpdb->prepare( 'SELECT ID, setting_value FROM ' . WLSM_SETTINGS . ' WHERE school_id = %d AND setting_key = "email_student_admission"', $school_id ) );

		if ( $settings ) {
			$settings = unserialize( $settings->setting_value );
			$enable   = isset( $settings['enable'] ) ? (bool) $settings['enable'] : 0;
			$subject  = isset( $settings['subject'] ) ? $settings['subject'] : '';
			$body     = isset( $settings['body'] ) ? $settings['body'] : '';
		}

		return array(
			'enable'  => $enable,
			'subject' => $subject,
			'body'    => $body,
		);
	}

	public static function get_settings_email_invoice_generated( $school_id ) {
		global $wpdb;

		$enable  = 0;
		$subject = NULL;
		$body    = NULL;

		$settings = $wpdb->get_row( $wpdb->prepare( 'SELECT ID, setting_value FROM ' . WLSM_SETTINGS . ' WHERE school_id = %d AND setting_key = "email_invoice_generated"', $school_id ) );

		if ( $settings ) {
			$settings = unserialize( $settings->setting_value );
			$enable   = isset( $settings['enable'] ) ? (bool) $settings['enable'] : 0;
			$subject  = isset( $settings['subject'] ) ? $settings['subject'] : '';
			$body     = isset( $settings['body'] ) ? $settings['body'] : '';
		}

		return array(
			'enable'  => $enable,
			'subject' => $subject,
			'body'    => $body,
		);
	}

	public static function get_settings_email_online_fee_submission( $school_id ) {
		global $wpdb;

		$enable  = 0;
		$subject = NULL;
		$body    = NULL;

		$settings = $wpdb->get_row( $wpdb->prepare( 'SELECT ID, setting_value FROM ' . WLSM_SETTINGS . ' WHERE school_id = %d AND setting_key = "email_online_fee_submission"', $school_id ) );

		if ( $settings ) {
			$settings = unserialize( $settings->setting_value );
			$enable   = isset( $settings['enable'] ) ? (bool) $settings['enable'] : 0;
			$subject  = isset( $settings['subject'] ) ? $settings['subject'] : '';
			$body     = isset( $settings['body'] ) ? $settings['body'] : '';
		}

		return array(
			'enable'  => $enable,
			'subject' => $subject,
			'body'    => $body,
		);
	}

	public static function get_settings_email_offline_fee_submission( $school_id ) {
		global $wpdb;

		$enable  = 0;
		$subject = NULL;
		$body    = NULL;

		$settings = $wpdb->get_row( $wpdb->prepare( 'SELECT ID, setting_value FROM ' . WLSM_SETTINGS . ' WHERE school_id = %d AND setting_key = "email_offline_fee_submission"', $school_id ) );

		if ( $settings ) {
			$settings = unserialize( $settings->setting_value );
			$enable   = isset( $settings['enable'] ) ? (bool) $settings['enable'] : 0;
			$subject  = isset( $settings['subject'] ) ? $settings['subject'] : '';
			$body     = isset( $settings['body'] ) ? $settings['body'] : '';
		}

		return array(
			'enable'  => $enable,
			'subject' => $subject,
			'body'    => $body,
		);
	}

	public static function get_settings_stripe( $school_id ) {
		global $wpdb;

		$enable          = 0;
		$publishable_key = NULL;
		$secret_key      = NULL;

		$settings = $wpdb->get_row( $wpdb->prepare( 'SELECT ID, setting_value FROM ' . WLSM_SETTINGS . ' WHERE school_id = %d AND setting_key = "stripe"', $school_id ) );

		if ( $settings ) {
			$settings        = unserialize( $settings->setting_value );
			$enable          = isset( $settings['enable'] ) ? (bool) $settings['enable'] : 0;
			$publishable_key = isset( $settings['publishable_key'] ) ? $settings['publishable_key'] : '';
			$secret_key      = isset( $settings['secret_key'] ) ? $settings['secret_key'] : '';
		}

		return array(
			'enable'          => $enable,
			'publishable_key' => $publishable_key,
			'secret_key'      => $secret_key,
		);
	}
}
