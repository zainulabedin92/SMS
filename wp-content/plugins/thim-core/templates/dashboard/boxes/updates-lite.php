<?php

do_action( 'thim_core_background_check_update_theme_lite' );

$theme_data      = Thim_Theme_Manager::get_metadata();
$template        = $theme_data['template'];
$current_version = $theme_data['version'];

$update_themes = Thim_Free_Theme::get_update_themes();
$themes        = $update_themes['themes'];

$data = isset( $themes[$template] ) ? $themes[$template] : false;

$purchase_code = Thim_Product_Registration::get_data_theme_register( 'purchase_code' );

$link_check = Thim_Dashboard::get_link_main_dashboard(
	array(
		'force-check' => 1,
	)
);

$can_update = version_compare( $data['version'], $current_version, '>' );
?>

<div class="tc-box-body">
	<div class="td-box-welcome-admin">
		<div class="box-left">
			<p>
				<?php printf(
					__(
						'Thanks for installing the %1$s theme. If this is the first time you work with %1$s, please read and follow
			the instructions carefully. This is the getting started section of %1$s Theme Dashboard.', 'thim-core'
					), $data['name']
				); ?>
			</p>
			<a href="<?php echo admin_url( 'admin.php?page=thim-getting-started' ); ?>"
			   class="tc-button-box tc-button-black"><?php esc_html_e( 'Let\'s get started', 'thim-core' ); ?></a>
		</div>
		<div class="box-right">
			<?php
			if ( ! $data ) {
				$data_info = array(
					'title'      => __( 'Something went wrong!', 'thim-core' ),
					'desc'       => __( 'Please try again later.', 'thim-core' ),
					'class'      => 'no-info-theme',
					'btn-update' => '',
				);
			} else {
				if ( $can_update ) {
					$data_info = array(
						'title' => __( 'New version available', 'thim-core' ),
						'class' => 'has-update',
						'desc'  => __( 'Your Version is', 'thim-core' ) . ' ' . $current_version
					);
					if ( empty( $purchase_code ) ) {
						$data_info['btn-update'] = '<div class="update-notice"><a href="' . esc_url( add_query_arg( array( 'page' => 'thim-license', 'thim_redirect' => urlencode( $link_check ) ), admin_url( 'admin.php' ) ) ) . '" class="button-link">' . __( 'Activate now.', 'thim-core' ) . '</a></div>';
					} else {
						$data_info['btn-update'] = '<div class="update-message"><button class="button-link tc-update-now" type="button">' . esc_html__( 'Update now', 'thim-core' ) . '</button></div>';
					}
				} else {
					$data_info = array(
						'title'      => __( 'Theme is up to date', 'thim-core' ),
						'class'      => 'no-update',
						'desc'       => __( 'Your Version is', 'thim-core' ) . ' ' . $current_version,
						'btn-update' => '',
					);
				}
			}

			$requirements_notification = apply_filters( 'thim_core_number_requirements_notification', 0 );
			if ( $requirements_notification > 0 ) {
				$requiremen_info = array(
					'title' => __( 'Something wrong', 'thim-core' ),
					'desc'  => __( 'We detected ' . $requirements_notification . ' issues', 'thim-core' ),
					'link'  => admin_url( 'admin.php?page=thim-system-status' ),
					'icon'  => '',
				);
			} else {
				$requiremen_info = array(
					'title' => __( 'All is Good', 'thim-core' ),
					'desc'  => __( 'Nothing wrong found', 'thim-core' ),
					'icon'  => ' reqirements-success',
				);
			}
			?>
			<div class="box box-info-update <?php echo esc_attr( $data_info['class'] ); ?>">
				<span class="icon"></span>
				<h5><?php echo $data_info['title']; ?></h5>
				<p><?php echo $data_info['desc']; ?></p>
				<?php echo $data_info['btn-update']; ?>
			</div>
			<div class="box box-info-reqirements<?php echo $requiremen_info['icon']; ?>">
				<span class="icon"></span>
				<h5><?php echo $requiremen_info['title']; ?></h5>
				<p><?php echo $requiremen_info['desc']; ?></p>
				<?php
				if ( isset( $requiremen_info['link'] ) ) {
					echo '<div class="update-notice"><a href="' . $requiremen_info['link'] . '">Resolve now</a></div>';
				}
				?>
			</div>
		</div>
	</div>
</div>
