<?php
	global $current_user;
	wp_get_current_user();
?>
<div>
	<form method="post" action="<?php echo esc_url('options.php');?>">
		<div class="racart_cart_mailer_form">
			<?php settings_fields( 'racart-settings-group' ); ?>
    		<?php do_settings_sections( 'racart-settings-group' ); ?>
			<h4></h4>
		    <div class="racart_cart_email_form_setting">
		    	<div class="racart_cart_email_label">
				    <label><?php esc_attr_e('Send notifications about abandoned carts to this email:','recover-wc-abandoned-cart');?></label>
				</div>
				<div class="racart_mail_message_input">
				    <input type="text" class="racart_cartadminemail" name="racart_adminemail" value="<?php echo esc_attr( get_option('racart_adminemail') ); ?>" placeholder="<?php esc_attr_e('Email Address','recover-wc-abandoned-cart');?>">
				    <div class="clear"></div>
				    <div class="racart_mail_message"><?php esc_attr_e('By default, notifications will be sent to WordPress admin email -','recover-wc-abandoned-cart');?> <b><?php echo esc_html($current_user->user_email);?></b>.</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="racart_cart_email_form_setting">
				<div class="racart_cart_email_label">
				    <label><?php esc_attr_e('Set Cron Email :','recover-wc-abandoned-cart');?></label>
				</div>
				<div class="racart_mail_message_input">
				   	<select name="racart_setcron_email" id="racart_cron_emailchange">
				   		<option value="0" <?php if(get_option('racart_setcron_email') =="0"){echo "selected";}?>><?php echo esc_html__('No','recover-wc-abandoned-cart');?></option>
				   		<option value="1"  <?php if(get_option('racart_setcron_email')=="1" ){echo "selected";}?>><?php echo esc_html__('Yes','recover-wc-abandoned-cart');?></option>
				   	</select>
				   
				</div>
			</div>
			<div class="clear"></div>
			<div id="racart_cron_enable_disable">
				<div class="racart_cart_email_form_setting racart_radioset">
					<div class="racart_cart_email_label">
					    <label><?php esc_attr_e('Select Sending Email Hour :','recover-wc-abandoned-cart');?></label>
					</div>
					<input type="radio"  name="email_hour" value="1" <?php if(get_option('email_hour')==1 OR (get_option('email_hour')=='')){echo 'checked ';}?>>
	  				<label for="one_hr"><?php esc_attr_e('1 Hour','recover-wc-abandoned-cart');?></label>
						<input type="radio" name="email_hour" value="24" <?php if(get_option('email_hour')==24){echo 'checked ';}?>>
	  				<label for="tf_hour"><?php esc_attr_e('24 Hour','recover-wc-abandoned-cart');?></label>
				</div>
				<div class="racart_cart_email_form_setting">
					<div class="racart_cart_email_label">
					    <label><?php esc_attr_e('Email Subject :','recover-wc-abandoned-cart');?></label>
					</div>
				    <input type="text" class="racart_cartadminemail" name="racart_onehr_email_subject" value="<?php echo esc_attr( get_option('racart_onehr_email_subject') ); ?>" placeholder="<?php esc_attr_e('Enter Email Subject','recover-wc-abandoned-cart');?>">
				</div>
				<div class="clear"></div>
				<div class="racart_cart_email_form_setting">
					<div class="racart_cart_email_label">
					    <label><?php esc_attr_e('Email Message :','recover-wc-abandoned-cart');?></label>
					</div>
				    <textarea name="racart_onehr_email_message" placeholder="<?php esc_attr_e('Enter Email Message','recover-wc-abandoned-cart');?>" cols="50" rows="8"><?php echo esc_attr( get_option('racart_onehr_email_message') ); ?></textarea>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<?php submit_button(); ?>
	</form>
</div>