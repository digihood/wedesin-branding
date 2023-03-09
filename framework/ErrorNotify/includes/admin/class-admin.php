<?php

class Fatal_Error_Notify_Admin {

	

	/**
	 * Renders Settings page
	 *
	 * @access public
	 * @return mixed
	 */

	public static function settings_page() {
		$tab = (isset($_GET['tab']) &&  $_GET['tab'] ? $_GET['tab'] : null);
	
		if($tab !== 'EmailerrorNotify')return;
		// Save settings
		if ( isset( $_POST['fen_settings_nonce'] ) && wp_verify_nonce( $_POST['fen_settings_nonce'], 'fen_settings' ) ) {
			update_option( 'vgp_fen_settings', map_deep( wp_unslash( $_POST['fen_settings'] ), 'sanitize_text_field' ) );
			echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
		}

		$settings = get_option( 'vgp_fen_settings', array() );

		if ( empty( $settings ) ) {

			$settings = array(
				'notification_email' => get_option( 'admin_email' ),
				'levels'             => array(),
			);

			foreach ( fatal_error_notify()->error_levels as $level_id ) {

				// Enable fatal error by default
				if ( $level_id == 1 ) {
					$settings['levels'][ $level_id ] = true;
				} else {
					$settings['levels'][ $level_id ] = false;
				}
			}
		}

		?>

		<div class="wrap">


			<h2><?= __('Digi Error Notifikace nastavení', D1G1_BRANDING)?></h2>
		
			<form id="fen-settings" action="" method="post">
				<?php wp_nonce_field( 'fen_settings', 'fen_settings_nonce' ); ?>
				<input type="hidden" name="action" value="update">

				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?= __('Notifikační email',D1G1_BRANDING );?></th>
						<td valign="top">
							<div class="form-item">
								<input class="regular-text" type="email" name="fen_settings[notification_email]" value="<?php echo esc_attr( $settings['notification_email'] ); ?>" />
								<p class="description"><?= __('Na tuto adresu budou zasílána nakonfigurovaná oznámení o chybách.',D1G1_BRANDING );?></p>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?= __('Úrovně chyb pro upozornění',D1G1_BRANDING );?></th>
						<td>
							<fieldset class="error-levels">

								<?php foreach ( fatal_error_notify()->error_levels as $i => $level_id ) : ?>

									<?php $level_string = fatal_error_notify()->map_error_code_to_type( $level_id ); ?>

									<?php
									if ( empty( $settings['levels'][ $level_id ] ) ) {
										$settings['levels'][ $level_id ] = false;}
										?>
									

										<label for="level_<?php echo $level_string; ?>" class="checkbox">
											<input type="checkbox" name="fen_settings[levels][<?php echo $level_id; ?>]" id="level_<?php echo $level_string; ?>" value="1" <?php checked( $settings['levels'][ $level_id ] ); ?> />
											<span class="checkmark"></span><?php echo esc_html( $level_string ); ?>
										</label>
									
									

									<br />

								<?php endforeach; ?>
							</fieldset>

						</td>

				</table>

				<p class="submit">
					<input name="Submit" type="submit" class="button button-primary" value="Uložit"/>
				</p>

			</form>

		</div>

		<?php
	}


}


