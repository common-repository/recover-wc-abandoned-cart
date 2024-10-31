<?php
if ( ! function_exists ( 'racart_register_settings' ) ) {
	function racart_register_settings() {
		register_setting( 'racart-settings-group', 'racart_adminemail' );
		register_setting( 'racart-settings-group', 'racart_onehr_email_subject' );
		register_setting( 'racart-settings-group', 'racart_onehr_email_message' );
		register_setting( 'racart-settings-group', 'enable_exitintent' );
		register_setting( 'racart-settings-group', 'email_hour' );
		register_setting( 'racart-settings-group', 'racart_setcron_email' );
		
	}
}
if ( ! function_exists ( 'racart_enable_exitintent' ) ) {
	function racart_enable_exitintent() {
		register_setting( 'racart-enable_exitintent-settings-group', 'enable_exitintent' );
		register_setting( 'racart-enable_exitintent-settings-group', 'racart_popup_title' );
		register_setting( 'racart-enable_exitintent-settings-group', 'racart_popup_content' );
		register_setting( 'racart-enable_exitintent-settings-group', 'attachment_idpath' );
	}
}
?>