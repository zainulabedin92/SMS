<?php
defined( 'ABSPATH' ) || die();

require_once WLSM_PLUGIN_DIR_PATH . 'includes/helpers/WLSM_Config.php';
require_once WLSM_PLUGIN_DIR_PATH . 'includes/helpers/WLSM_M_Session.php';

class WLSM_Session {
	public static function fetch_sessions() {
		// Check if the current user has the required capability.
		if ( ! current_user_can( WLSM_ADMIN_CAPABILITY ) ) {
			die();
		}
	
		global $wpdb;
	
		$page_url = WLSM_M_Session::get_page_url();
	
		// Create a prepared statement to prevent SQL injection.
		$query = $wpdb->prepare( WLSM_M_Session::fetch_query() );
	
		$query_filter = $query;
	
		// Grouping.
		$group_by = ' ' . WLSM_M_Session::fetch_query_group_by();
	
		$query .= $group_by;
		$query_filter .= $group_by;
	
		// Searching.
		$condition = '';
		if ( esc_sql( $_POST['search']['value'] ) ) {
			$search_value = sanitize_text_field( esc_sql($_POST['search']['value']) );
			if ( '' !== $search_value ) {
				// Sanitize and validate user input.
				$condition .= $wpdb->prepare( '(ss.label LIKE "%%%s%%")', $search_value );
	
				$start_date = DateTime::createFromFormat( WLSM_Config::date_format(), $search_value );
	
				if ( $start_date ) {
					$format_start_date = 'Y-m-d';
				} else {
					if ( ! $start_date ) {
						$start_date = DateTime::createFromFormat( 'Y', $search_value );
						$format_start_date = 'Y';
					}
				}
	
				if ( $start_date && isset( $format_start_date ) ) {
					$start_date = $start_date->format( $format_start_date );
					$start_date = $wpdb->prepare( ' OR (ss.start_date LIKE "%%%s%%")', $start_date );
	
					$condition .= $start_date;
				}
	
				$end_date = DateTime::createFromFormat( WLSM_Config::date_format(), $search_value );
	
				if ( $end_date ) {
					$format_end_date = 'Y-m-d';
				} else {
					if ( ! $end_date ) {
						$end_date = DateTime::createFromFormat( 'Y', $search_value );
						$format_end_date = 'Y';
					}
				}
	
				if ( $end_date && isset( $format_end_date ) ) {
					$end_date = $end_date->format( $format_end_date );
					$end_date = $wpdb->prepare( ' OR (ss.end_date LIKE "%%%s%%")', $end_date );
	
					$condition .= $end_date;
				}
	
				$query_filter .= ( ' HAVING ' . $condition );
			}
		}
	
		// Ordering.
		$columns = array( 'ss.label', 'ss.start_date', 'ss.end_date' );
		if ( esc_sql( isset( $_POST['order'] ) ) && esc_sql( $columns[ $_POST['order']['0']['column'] ] ) ) {
			$order_by  = sanitize_text_field( esc_sql( $columns[ $_POST['order']['0']['column'] ]) );
			$order_dir = sanitize_text_field( esc_sql($_POST['order']['0']['dir']) );
	
			$query_filter .= $wpdb->prepare( ' ORDER BY %s %s', $order_by, $order_dir );
		} else {
			$query_filter .= ' ORDER BY ss.label, ss.start_date, ss.end_date DESC';
		}
	
		// Limiting.
		$limit = '';
		if ( -1 != $_POST['length'] ) {
			$start  = absint( esc_sql($_POST['start']) );
			$length = absint( esc_sql($_POST['length']) );
	
			$limit  = $wpdb->prepare( ' LIMIT %d, %d', $start, $length );
		}
	
		// Total query.
		$rows_query = WLSM_M_Session::fetch_query_count();
	
		// Total rows count.
		$total_rows_count = $wpdb->get_var( $rows_query );
	
		// Filtered rows count.
		if ( $condition ) {
			$filter_rows_count = $wpdb->get_var( $rows_query . ' WHERE (' . $condition . ')' );
		} else {
			$filter_rows_count = $total_rows_count;
		}
	
		// Filtered limit rows.
		$filter_rows_limit = $wpdb->get_results( $query_filter . $limit );
	
		$data = array();
		if ( count( $filter_rows_limit ) ) {
	
			foreach ( $filter_rows_limit as $row ) {
				// Table columns.
				// Escape the output to prevent XSS attacks.
				$data[] = array(
					esc_html( WLSM_M_Session::get_label_text( $row->label ) ),
					esc_html( WLSM_Config::get_date_text( $row->start_date ) ),
					esc_html( WLSM_Config::get_date_text( $row->end_date ) ),
					'<a class="text-primary" href="' . esc_url( $page_url . "&action=save&id=" . $row->ID ) . '"><span class="dashicons dashicons-edit"></span></a>&nbsp;&nbsp;
					<a class="text-danger wlsm-delete-session" data-nonce="' . esc_attr( wp_create_nonce( 'delete-session-' . $row->ID ) ) . '" data-session="' . esc_attr( $row->ID ) . '" href="#" data-message-title="' . esc_attr__( 'Please Confirm!', 'school-management-system' ) . '" data-message-content="' . esc_attr__( 'This will delete all data associated with this session.', 'school-management-system' ) . '" data-cancel="' . esc_attr__( 'Cancel', 'school-management-system' ) . '" data-submit="' . esc_attr__( 'Confirm', 'school-management-system' ) . '"><span class="dashicons dashicons-trash"></span></a>'
				);
			}
		}
	
		$output = array(
			'draw'            => intval( esc_sql($_POST['draw']) ),
			'recordsTotal'    => $total_rows_count,
			'recordsFiltered' => $filter_rows_count,
			'data'            => $data,
		);
	
		echo json_encode( $output );
		die;
	}
	

	public static function save() {
		if ( ! current_user_can( WLSM_ADMIN_CAPABILITY ) ) {
			die();
		}

		try {
			ob_start();
			global $wpdb;

			$session_id = isset( $_POST['session_id'] ) ? absint( $_POST['session_id'] ) : 0;

			if ( $session_id ) {
				if ( ! wp_verify_nonce( $_POST[ 'edit-session-' . $session_id ], 'edit-session-' . $session_id ) ) {
					die();
				}
			} else {
				if ( ! wp_verify_nonce( $_POST['add-session'], 'add-session' ) ) {
					die();
				}
			}

			// Checks if session existss.
			if ( $session_id ) {
				$session = WLSM_M_Session::get_session( $session_id );

				if ( ! $session ) {
					throw new Exception( esc_html__( 'Session not found.', 'school-management-system' ) );
				}
			}

			$label      = isset( $_POST['label'] ) ? sanitize_text_field( $_POST['label'] ) : '';
			$start_date = isset( $_POST['start_date'] ) ? DateTime::createFromFormat( WLSM_Config::date_format(), sanitize_text_field( $_POST['start_date'] ) ) : NULL;
			$end_date   = isset( $_POST['end_date'] ) ? DateTime::createFromFormat( WLSM_Config::date_format(), sanitize_text_field( $_POST['end_date'] ) ) : NULL;

			// Start validation.
			$errors = array();

			if ( empty( $label ) ) {
				$errors['label'] = esc_html__( 'Please provide session label.', 'school-management-system' );
			} else {
				if ( strlen( $label ) > 191 ) {
					$errors['label'] = esc_html__( 'Maximum length cannot exceed 191 characterss.', 'school-management-system' );
				}
			}

			if ( $start_date >= $end_date ) {
				$errors['start_date'] = esc_html__( 'Session start date must be lower than end date.', 'school-management-system' );
			}

			if ( empty( $start_date ) ) {
				$errors['start_date'] = esc_html__( 'Please provide start date of a session.', 'school-management-system' );
			} else {
				$start_date = $start_date->format( 'Y-m-d' );
			}

			if ( empty( $end_date ) ) {
				$errors['end_date'] = esc_html__( 'Please provide end date of a session.', 'school-management-system' );
			} else {
				$end_date = $end_date->format( 'Y-m-d' );
			}

			// Checks if session already exists with this label, start_date and end_date.
			if ( $session_id ) {
				$session_exist = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) as count FROM ' . WLSM_SESSIONS . ' as ss WHERE ss.label = %s AND ss.start_date = "%s" AND ss.end_date = "%s" AND ss.ID != %d', $label, $start_date, $end_date, $session_id ) );
			} else {
				$session_exist = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) as count FROM ' . WLSM_SESSIONS . ' as ss WHERE ss.label = %s', $label ) );
			}

			if ( $session_exist ) {
				$errors['label'] = esc_html__( 'Session already exists with this label, start date and end date.', 'school-management-system' );
			}
			// End validation.

		} catch ( Exception $exception ) {
			$buffer = ob_get_clean();
			if ( ! empty( $buffer ) ) {
				$response = $buffer;
			} else {
				$response = $exception->getMessage();
			}
			wp_send_json_error( $response );
		}

		if ( count( $errors ) < 1 ) {
			try {
				$wpdb->query( 'BEGIN;' );

				// Data to update or insert.
				$data = array(
					'label'      => $label,
					'start_date' => $start_date,
					'end_date'   => $end_date,
				);

				// Checks if update or insert.
				if ( $session_id ) {
					$data['updated_at'] = date( 'Y-m-d H:i:s' );

					$success = $wpdb->update( WLSM_SESSIONS, $data, array( 'ID' => $session_id ) );
					$message = esc_html__( 'Session updated successfully.', 'school-management-system' );
					$reset   = false;
				} else {
					$success = $wpdb->insert( WLSM_SESSIONS, $data );
					$message = esc_html__( 'Session added successfully.', 'school-management-system' );
					$reset   = true;
				}

				$buffer = ob_get_clean();
				if ( ! empty( $buffer ) ) {
					throw new Exception( $buffer );
				}

				if ( false === $success ) {
					throw new Exception( $wpdb->last_error );
				}

				$wpdb->query( 'COMMIT;' );

				wp_send_json_success( array( 'message' => $message, 'reset' => $reset ) );
			} catch ( Exception $exception ) {
				$wpdb->query( 'ROLLBACK;' );
				wp_send_json_error( $exception->getMessage() );
			}
		}
		wp_send_json_error( $errors );
	}

	public static function delete() {
		if ( ! current_user_can( WLSM_ADMIN_CAPABILITY ) ) {
			die();
		}

		try {
			ob_start();
			global $wpdb;

			$session_id = isset( $_POST['session_id'] ) ? absint( $_POST['session_id'] ) : 0;

			if ( ! wp_verify_nonce( $_POST[ 'delete-session-' . $session_id ], 'delete-session-' . $session_id ) ) {
				die();
			}

			// Checks if session existss.
			$session = WLSM_M_Session::get_session( $session_id );

			if ( ! $session ) {
				throw new Exception( esc_html__( 'Session not found.', 'school-management-system' ) );
			}

		} catch ( Exception $exception ) {
			$buffer = ob_get_clean();
			if ( ! empty( $buffer ) ) {
				$response = $buffer;
			} else {
				$response = $exception->getMessage();
			}
			wp_send_json_error( $response );
		}

		try {
			$wpdb->query( 'BEGIN;' );

			$success = $wpdb->delete( WLSM_SESSIONS, array( 'ID' => $session_id ) );
			$message = esc_html__( 'Session deleted successfully.', 'school-management-system' );

			$exception = ob_get_clean();
			if ( ! empty( $exception ) ) {
				throw new Exception( $exception );
			}

			if ( false === $success ) {
				throw new Exception( $wpdb->last_error );
			}
			
			$wpdb->query( 'COMMIT;' );

			wp_send_json_success( array( 'message' => $message ) );
		} catch ( Exception $exception ) {
			$wpdb->query( 'ROLLBACK;' );
			wp_send_json_error( $exception->getMessage() );
		}
	}
}