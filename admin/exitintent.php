<div class="racart_intentleft">
	<form method="post" action="options.php">
		<div class="racart_cart_mailer_form">
			<?php settings_fields( 'racart-enable_exitintent-settings-group' ); ?>
			<?php do_settings_sections( 'racart-enable_exitintent-settings-group' );?>
			<div class="clear"></div>
			<div class="racart_cart_email_form_setting">
				<div class="racart_cart_email_label">
				    <label><?php esc_html_e('Enable Exit Intent :','recover-wc-abandoned-cart');?></label>
				</div>
			   	<select name="enable_exitintent">
			   		<option value="0" <?php if(get_option('enable_exitintent') =="0"){echo "selected";}?>><?php esc_attr_e('No','recover-wc-abandoned-cart');?></option>
			   		<option value="1" <?php if(get_option('enable_exitintent')=="1" ){echo "selected";}?>><?php esc_attr_e('Yes','recover-wc-abandoned-cart');?></option>
			   	</select>
			</div>
			<div class="clear"></div>
			<div class="racart_cart_email_form_setting">
		    	<div class="racart_cart_email_label">
				    <label><?php esc_html_e('Popup Title : ','recover-wc-abandoned-cart');?></label>
				</div>
			    <input type="text" class="racart_cartadminemail" name="racart_popup_title" value="<?php echo esc_attr( get_option('racart_popup_title') ); ?>" placeholder="<?php esc_attr_e('Email Popup Title','recover-wc-abandoned-cart');?>">
			</div>
			<div class="clear"></div>
			<div class="racart_cart_email_form_setting">
		    	<div class="racart_cart_email_label">
				    <label><?php esc_html_e('Popup Content : ','recover-wc-abandoned-cart');?></label>
				</div>
			    <textarea name="racart_popup_content" placeholder="<?php esc_attr_e('Enter Popup Content','recover-wc-abandoned-cart');?>" cols="50" rows="8"><?php echo esc_attr( get_option('racart_popup_content') ); ?></textarea>
			</div>
			<div class="clear"></div>
			<div class="racart_cart_email_form_setting">
				<div class="racart_cart_email_label">
					<input type="button" value="<?php esc_attr_e('Upload Logo ','recover-wc-abandoned-cart');?>" class="button-primary" id="racart_upload_image"/>
				</div>
				<input type="hidden" name="attachment_id" class="wp_attachment_id" value="" />
				<input type="hidden" name="attachment_idpath" class="attachment_idpath" value="<?php echo esc_attr( get_option('attachment_idpath') ); ?>" />
				<img src="<?php echo esc_url( get_option('attachment_idpath') ); ?>" class="image" style="display:block;margin-top:10px;"/>
			</div>
		</div>
		<?php submit_button(); ?>
	</form>
</div>
<div class="racart_intentright">
	<h3><?php esc_html_e('Exit Intent Popup Layout','recover-wc-abandoned-cart');?></h3>
	<img src="<?php echo esc_url(RACART_URI.'/images/exit_intent_preview.jpg');?>">
	<p><?php esc_html_e('Exit Intent Popup showing only non-logged user.','recover-wc-abandoned-cart');?></p>
</div>
<div class="clear"></div>
<script type="text/javascript">
	(function( $ ) {
	'use strict';
	$(function() {
		$('#racart_upload_image').click(racart_open_custom_media_window);
		function racart_open_custom_media_window() {
			if (this.window === undefined) {
				this.window = wp.media({
					title: 'Insert Image',
					library: {type: 'image'},
					multiple: false,
					button: {text: 'Insert Image'}
				});
				var self = this;
				this.window.on('select', function() {
					var response = self.window.state().get('selection').first().toJSON();
					$('.wp_attachment_id').val(response.id);
					$('.image').attr('src', response.sizes.thumbnail.url);
					$('.attachment_idpath').val(response.sizes.thumbnail.url);
                    $('.image').show();
				});
			}
			this.window.open();
			return false;
		}
	});
})( jQuery );
</script>