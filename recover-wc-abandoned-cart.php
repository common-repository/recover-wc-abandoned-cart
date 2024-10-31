<?php
/*Plugin Name: Recover abandoned cart for WooCommerce
Description: Recover abandoned cart for WooCommerce easily. Increase sales by recovering your lost shopping cart by customers.
Version: 2.1
Author: SKT Themes
Author URI: https://sktthemes.org/
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: recover-wc-abandoned-cart
*/
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
// Set Constants
define( 'RACART_DIR', dirname( __FILE__ ) );
define( 'RACART_URI', plugins_url( '', __FILE__ ) );
/*
* Install plugin
*/
if ( ! function_exists ( 'racart_install_cart' ) ) {
function racart_install_cart(){
  // our post type will be automatically removed, so no need to unregister it
  // clear the permalinks to remove our post type's rules
  flush_rewrite_rules();
  //Filter on by default
  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  $racart_cartemail = $wpdb->prefix .'racart_cartemail';
  $sql_racart_cartemail = "CREATE TABLE $racart_cartemail (
    ID bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fname varchar(255) NOT NULL,
    lname varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    phone varchar(255) NOT NULL,
    location varchar(255) NOT NULL,
    cart_contents longtext NOT NULL,
    cart_total varchar(255) NOT NULL,
    currency varchar(255) NOT NULL,
    session_cartrecovery varchar(255) NOT NULL,
    date_time varchar(255) NOT NULL,
    added_date varchar(255) NOT NULL
  ) $charset_collate;";
  dbDelta( $sql_racart_cartemail );
}
}
register_activation_hook( __FILE__, 'racart_install_cart' );
/*
* Deactivate plugin
*/
if ( ! function_exists ( 'racart_deactivation_cart' ) ) {
function racart_deactivation_cart(){
   // our post type will be automatically removed, so no need to unregister it
   // clear the permalinks to remove our post type's rules
   flush_rewrite_rules();
}
}
register_deactivation_hook( __FILE__, 'racart_deactivation_cart' );

// Admin enqueue
add_action( 'admin_enqueue_scripts', 'racart_admin_enqueue_cart' );
if ( ! function_exists ( 'racart_admin_enqueue_cart' ) ) {
    function racart_admin_enqueue_cart() {
        wp_enqueue_style( 'racart-cutomcss', RACART_URI .'/css/style-admin.css', 'racart-cutom-css');
        wp_enqueue_script( 'my_custom_js',  RACART_URI .'/js/admin_custom.js', array( 'jquery' ), '1.0', true );
    }
}
/*
* Enqueuing scripts and styles
*/
add_action( 'wp_enqueue_scripts', 'racart_enqueue_cart' );
if ( ! function_exists ( 'racart_enqueue_cart' ) ) {
    function racart_enqueue_cart() {
        wp_enqueue_style( 'racart-style', RACART_URI .'/css/style.css', 'racart-style-css');
        wp_enqueue_script( 'my_frontend_js',  RACART_URI .'/js/frontend.js', array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'my_cookie_js',  RACART_URI .'/js/jquery.cookie.js', array( 'jquery' ), '1.0', true );
        load_plugin_textdomain( 'recover-wc-abandoned-cart', FALSE, basename(dirname(__FILE__)).'/languages' );
    }
}
/**
* Add custom field to the checkout page
*/
include_once( RACART_DIR . '/admin/abandoned-list.php' );
include_once( RACART_DIR . '/admin/register-settings.php' );
add_action('woocommerce_cart_coupon', 'racart_recover_shop_list');
if ( ! function_exists ( 'racart_recover_shop_list' ) ) {
function racart_recover_shop_list() {
  if (!defined('WC_VERSION')) {
    } else { 
      if ( is_user_logged_in() !='') {
  }else {
    if(get_option('enable_exitintent')==1){ ?>
      <div class="racartlightbox" id="text">
        <div class="racart_box">
          <div class="racart_close"><?php echo esc_html('X');?></div>
          <div class="racart_content">
            <?php 
              if ( get_option('attachment_idpath') !='') {
            ?>
          <img src="<?php echo get_option('attachment_idpath');?>">
          <?php } 
        if ( get_option('racart_popup_title') !='') { ?>
          <h2> <?php echo esc_html(get_option('racart_popup_title'));?></h2>
          <?php } 
          if ( get_option('racart_popup_title') !='') { ?>
          <p> <?php echo esc_html(get_option('racart_popup_content'));?></p>
          <?php } ?>
          </div>
        </div>
      </div>
  <?php }
 }
  }
}
}
add_action('woocommerce_after_shop_loop_item', 'racart_shop_display_skus');
if ( ! function_exists ( 'racart_shop_display_skus' ) ) {
function racart_shop_display_skus() {
    if (!defined('WC_VERSION')) {
    } else { 
      if ( is_user_logged_in() !='') {
  }else {
    if(get_option('enable_exitintent')==1){ ?>
      <div class="racartlightbox" id="text">
        <div class="racart_box">
          <div class="racart_close">X</div>
          <div class="racart_content">
            <?php 
              if ( get_option('attachment_idpath') !='') {
            ?>
          <img src="<?php echo get_option('attachment_idpath');?>">
          <?php } 
        if ( get_option('racart_popup_title') !='') { ?>
          <h2> <?php echo esc_html(get_option('racart_popup_title'));?></h2>
          <?php } 
          if ( get_option('racart_popup_title') !='') { ?>
          <p> <?php echo esc_html(get_option('racart_popup_content'));?></p>
          <?php } ?>
          </div>
        </div>
      </div>
  <?php }
 }
  }
}
}
add_action('woocommerce_after_order_notes', 'racart_custom_checkout_field');
if ( ! function_exists ( 'racart_custom_checkout_field' ) ) {
function racart_custom_checkout_field($checkout){
  global $woocommerce;
  $cart = $woocommerce->cart;
  $cart = WC()->cart->subtotal;
  if (!defined('WC_VERSION')) {
    } else { 
      if ( is_user_logged_in() !='') {
  }else {
    if(get_option('enable_exitintent')==1){ ?>
      <div class="racartlightbox" id="text">
        <div class="racart_box">
          <div class="racart_close">X</div>
          <div class="racart_content">
            <?php 
              if ( get_option('attachment_idpath') !='') {
            ?>
            <img src="<?php echo get_option('attachment_idpath');?>">
          <?php } 
        if ( get_option('racart_popup_title') !='') { ?>
          <h2> <?php echo esc_html(get_option('racart_popup_title'));?></h2>
          <?php } 
          if ( get_option('racart_popup_title') !='') { ?>
          <p> <?php echo esc_html(get_option('racart_popup_content'));?></p>
          <?php } ?>
          </div>
        </div>
      </div>
  <?php }
 }
  }
  $currency_code = get_woocommerce_currency();
  $productid = array();
  foreach ( WC()->cart->get_cart() as $cart_item ) {
    $product = $cart_item['data'];
    $product_id = $cart_item['product_id'];
    $qty = $cart_item['quantity'];
    if(!empty($product)){
      $productid[] = $product_id;
    }
  }
  $productid_array = serialize($productid);
}
}
add_action( 'woocommerce_thankyou', 'racart_remove', 10, 1 );
if ( ! function_exists ( 'racart_remove' ) ) {
    function racart_remove( $order_id ) {
        global $woocommerce;
        global $wpdb;
        if($order_id !=''){
        $racart_cartemail = $wpdb->prefix.'racart_cartemail';
        $order = wc_get_order( $order_id );
        $billing_email  = $order->get_billing_email();
    ?>
    <div id="racart_cartemailrefresh"></div>
    <div id="racart_cartemailtime">

        <?php
            $check_session_exit = $wpdb->get_row("SELECT * FROM $racart_cartemail WHERE email='$billing_email'");
            $totalrow = $wpdb->num_rows;
            if($totalrow > 0){
                $cartrecovery_id = $check_session_exit->ID;
                $wpdb->query("DELETE FROM $racart_cartemail WHERE ID = '$cartrecovery_id'");
            }
        ?>
    </div>
    <script type="text/javascript">
        setInterval("racart_cartemail_my_function();",1000); 
        function racart_cartemail_my_function(){
            jQuery('#racart_cartemailrefresh').load(location.href + ' #racart_cartemailtime');
        }
    </script>
    <?php }
    }
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) { 
  if (is_admin()) {
  } 
} else {
  if ( ! function_exists ( 'racart_admin_alert_notice' ) ) {
  function racart_admin_alert_notice() {
    ?>
    <div class="error">
      <p><?php _e( 'The Recovery WooCommerce Abandoned Cart plugin requires WooCommerce plugin installed & activated.', 'recover-wc-abandoned-cart' ); ?></p>
    </div>
    <?php
  }
  }
  add_action( 'admin_notices', 'racart_admin_alert_notice' );
}
if(get_option('racart_setcron_email')=="1" ){
    if ( ! function_exists ( 'racart_add_cron_recurrence_interval' ) ) {
        function racart_add_cron_recurrence_interval( $schedules ) {
            $schedules['every_three_minutes'] = array(
                'interval'  => 1 * 60,
                'display'   => __( 'Every 1 Minutes', 'recover-wc-abandoned-cart' )
            );
          return $schedules;
        }
    }
    add_filter( 'cron_schedules', 'racart_add_cron_recurrence_interval' );
}
if ( ! wp_next_scheduled( 'racart_your_three_minute_action_hook' ) ) {
    wp_schedule_event( time(), 'every_three_minutes', 'racart_your_three_minute_action_hook' );
}
add_action('racart_your_three_minute_action_hook', 'racart_cron_job_send_mail');
if ( ! function_exists ( 'racart_cron_job_send_mail' ) ) {
    function racart_cron_job_send_mail() {
        global $wpdb;
        global $product;
        $racart_cartemail = $wpdb->prefix.'racart_cartemail';
        global $current_user;
        wp_get_current_user();
        $current_time = time();
        $email_hour = esc_attr( get_option('email_hour') );
        if($email_hour==24){
            $count_sec = 3481000;
            $countsec = 3600*24;
        }else{
            $count_sec = 59000;
            $countsec = 3600;
        }
        if(get_option('racart_adminemail') ==''){
            $admin_email = $current_user->user_email;
        }else{
            $admin_email = esc_attr( get_option('racart_adminemail') );
        }
        $onehr_email_subject = esc_attr( get_option('racart_onehr_email_subject') );
        $onehr_email_message = esc_attr( get_option('racart_onehr_email_message') );
        $current_date = date('y-m-d');
        $get_cartemail = $wpdb->get_results("SELECT * FROM $racart_cartemail WHERE added_date='$current_date' ORDER BY ID DESC");
        $totalrow = $wpdb->num_rows;
        if($totalrow > 0){
            foreach ($get_cartemail as $getcartemail) {
              $email = $getcartemail->email;
              $date_time = $getcartemail->date_time;
              $add_onehrtime = date("m/d/y G.i:s", $date_time+$countsec);
              if($add_onehrtime==$current_time){
                $to = $admin_email;
                $subject = $onehr_email_subject;
                $txt = $onehr_email_message;
                $headers = 'From: <'.$email.'>' . "\r\n";
                mail($to,$subject,$txt,$headers);
              }
            }
        }
    }
}
add_action( 'wp_footer', 'racart_without_file',20 );
if ( ! function_exists ( 'racart_without_file' ) ) {
function racart_without_file() {
  global $woocommerce;
  $currency_code = get_woocommerce_currency();
  $cart = $woocommerce->cart;
  $cart = WC()->cart->subtotal;
  $productid = array();
  foreach ( WC()->cart->get_cart() as $cart_item ) {
    $product = $cart_item['data'];
    $product_id = $cart_item['product_id'];
    $qty = $cart_item['quantity'];
    if(!empty($product)){
      $productid[] = $product_id;
    }
  }
  $productid_array = serialize($productid);
  if ( is_checkout() ) {
?>
    <script type="text/javascript" >
        jQuery(document).ready(function($) {
            var billingemail = jQuery('#billing_email').val();
            if(billingemail !=''){
                var fname = jQuery('#billing_first_name').val();
                var lname = jQuery('#billing_last_name').val();
                var billing_state = jQuery('#billing_state').val();
                var billing_city = jQuery('#billing_city').val();
                var billing_postcode = jQuery('#billing_postcode').val();
                var phone = jQuery('#billing_phone').val();
                var billing_email = jQuery('#billing_email').val();
                var currencycode = '<?php echo esc_html($currency_code);?>';
                var cart_total = '<?php echo esc_html($cart);?>';
                var productid = '<?php echo esc_html($productid_array);?>';
                ajaxurl = '<?php echo esc_url(admin_url( 'admin-ajax.php' )) ?>';
                var data = {
                    'action': 'racart_ineset_cartdetail',  
                    'fname':fname,'lname':lname,'billing_state':billing_state,'billing_city':billing_city,'billing_postcode':billing_postcode,'phone':phone,'billing_email':billing_email,'currencycode':currencycode,'cart_total':cart_total,'productid':productid
                };
                jQuery.ajax({
                    url: ajaxurl, 
                    type: 'POST',
                    data: data,
                    success: function (response) {              
                    }
                });
            }
            jQuery("#billing_phone").blur(function(){
                var fname = jQuery('#billing_first_name').val();
                var lname = jQuery('#billing_last_name').val();
                var billing_state = jQuery('#billing_state').val();
                var billing_city = jQuery('#billing_city').val();
                var billing_postcode = jQuery('#billing_postcode').val();
                var phone = jQuery('#billing_phone').val();
                var billing_email = jQuery('#billing_email').val();
                var currencycode = '<?php echo esc_html($currency_code);?>';
                var cart_total = '<?php echo esc_html($cart);?>';
                var productid = '<?php echo esc_html($productid_array);?>';
                ajaxurl = '<?php echo esc_url(admin_url( 'admin-ajax.php' )) ?>';
                var data = {
                  'action': 'racart_ineset_cartdetail',  
                  'fname':fname,'lname':lname,'billing_state':billing_state,'billing_city':billing_city,'billing_postcode':billing_postcode,'phone':phone,'billing_email':billing_email,'currencycode':currencycode,'cart_total':cart_total,'productid':productid
                };
                jQuery.ajax({
                    url: ajaxurl, 
                    type: 'POST',
                    data: data,
                    success: function (response) {              
                    }
                });
            });
            jQuery("#billing_email").blur(function(){
                var fname = jQuery('#billing_first_name').val();
                var lname = jQuery('#billing_last_name').val();
                var billing_state = jQuery('#billing_state').val();
                var billing_city = jQuery('#billing_city').val();
                var billing_postcode = jQuery('#billing_postcode').val();
                var phone = jQuery('#billing_phone').val();
                var billing_email = jQuery('#billing_email').val();
                var currencycode = '<?php echo esc_html($currency_code);?>';
                var cart_total = '<?php echo esc_html($cart);?>';
                var productid = '<?php echo esc_html($productid_array);?>';
                ajaxurl = '<?php echo esc_url(admin_url( 'admin-ajax.php' )) ?>';
                var data = {
                  'action': 'racart_ineset_cartdetail',  
                  'fname':fname,'lname':lname,'billing_state':billing_state,'billing_city':billing_city,'billing_postcode':billing_postcode,'phone':phone,'billing_email':billing_email,'currencycode':currencycode,'cart_total':cart_total,'productid':productid
                };
                jQuery.ajax({
                    url: ajaxurl, 
                    type: 'POST',
                    data: data,
                    success: function (response) {              
                    }
                });
            });
        });

        jQuery( window ).on( "load", function() {
            var email = jQuery('#email').val();
            if(email !=''){
                var fname = jQuery('#billing-first_name').val();
                var lname = jQuery('#billing-last_name').val();
                var billing_state = jQuery('#components-form-token-input-1').val();
                var billing_city = jQuery('#billing-city').val();
                var billing_postcode = jQuery('#billing-postcode').val();
                var phone = jQuery('#billing-phone').val();
                var email = jQuery('#email').val();
                var currencycode = '<?php echo esc_html($currency_code);?>';
                var cart_total = '<?php echo esc_html($cart);?>';
                var productid = '<?php echo esc_html($productid_array);?>';

                ajaxurl = '<?php echo esc_url(admin_url( 'admin-ajax.php' )) ?>';
                var data = {
                    'action': 'racart_ineset_cartdetail',  
                    'fname':fname,'lname':lname,'billing_state':billing_state,'billing_city':billing_city,'billing_postcode':billing_postcode,'phone':phone,'billing_email':email,'currencycode':currencycode,'cart_total':cart_total,'productid':productid
                };
                jQuery.ajax({
                    url: ajaxurl, 
                    type: 'POST',
                    data: data,
                    success: function (response) {              
                    }
                });
            }

            jQuery("#email").blur(function(){
                var fname = jQuery('#billing-first_name').val();
                var lname = jQuery('#billing-last_name').val();
                var billing_state = jQuery('#components-form-token-input-1').val();
                var billing_city = jQuery('#billing-city').val();
                var billing_postcode = jQuery('#billing-postcode').val();
                var phone = jQuery('#billing-phone').val();
                var email = jQuery('#email').val();
                var currencycode = '<?php echo esc_html($currency_code);?>';
                var cart_total = '<?php echo esc_html($cart);?>';
                var productid = '<?php echo esc_html($productid_array);?>';

                ajaxurl = '<?php echo esc_url(admin_url( 'admin-ajax.php' )) ?>';
                var data = {
                    'action': 'racart_ineset_cartdetail',  
                    'fname':fname,'lname':lname,'billing_state':billing_state,'billing_city':billing_city,'billing_postcode':billing_postcode,'phone':phone,'billing_email':email,'currencycode':currencycode,'cart_total':cart_total,'productid':productid
                };
                jQuery.ajax({
                    url: ajaxurl, 
                    type: 'POST',
                    data: data,
                    success: function (response) {              
                    }
                });
            });

            jQuery("#billing-phone").blur(function(){
                var fname = jQuery('#billing-first_name').val();
                var lname = jQuery('#billing-last_name').val();
                var billing_state = jQuery('#components-form-token-input-1').val();
                var billing_city = jQuery('#billing-city').val();
                var billing_postcode = jQuery('#billing-postcode').val();
                var phone = jQuery('#billing-phone').val();
                var email = jQuery('#email').val();
                var currencycode = '<?php echo esc_html($currency_code);?>';
                var cart_total = '<?php echo esc_html($cart);?>';
                var productid = '<?php echo esc_html($productid_array);?>';

                ajaxurl = '<?php echo esc_url(admin_url( 'admin-ajax.php' )) ?>';
                var data = {
                  'action': 'racart_ineset_cartdetail',  
                  'fname':fname,'lname':lname,'billing_state':billing_state,'billing_city':billing_city,'billing_postcode':billing_postcode,'phone':phone,'billing_email':email,'currencycode':currencycode,'cart_total':cart_total,'productid':productid
                };
                jQuery.ajax({
                    url: ajaxurl, 
                    type: 'POST',
                    data: data,
                    success: function (response) {              
                    }
                });
            });
        });
    </script> 
    <?php }
}
}
add_action("wp_ajax_racart_ineset_cartdetail" , "racart_ineset_cartdetail");
add_action("wp_ajax_nopriv_racart_ineset_cartdetail" , "racart_ineset_cartdetail");
if ( ! function_exists ( 'racart_ineset_cartdetail' ) ) {
    function racart_ineset_cartdetail(){
        global $wpdb;
        $added_date = date('y-m-d');
        $date_time = time();
        $racart_cartemail = $wpdb->prefix.'racart_cartemail';
        $fname = sanitize_text_field(isset($_POST['fname'])  ? $_POST['fname'] : '');
        $lname = sanitize_text_field(isset($_POST['lname'])  ? $_POST['lname'] : '');
        $billing_state = sanitize_text_field(isset($_POST['billing_state'])  ? $_POST['billing_state'] : '');
        $billing_city = sanitize_text_field(isset($_POST['billing_city'])  ? $_POST['billing_city'] : '');
        $billing_postcode = sanitize_text_field(isset($_POST['billing_postcode'])  ? $_POST['billing_postcode'] : '');
        $location = '';
        if($billing_state){
            $location .= $billing_state.', ';
        }
        if($billing_city){
            $location .= $billing_city.', ';
        }
        if($billing_postcode){
            $location .= $billing_postcode;
        }
        $phone = sanitize_text_field(isset($_POST['phone'])  ? $_POST['phone'] : '');
        $email = sanitize_email(isset($_POST['billing_email'])  ? $_POST['billing_email'] : '');
        $currencycode = sanitize_text_field(isset($_POST['currencycode'])  ? $_POST['currencycode'] : '');
        $cart_total = sanitize_text_field(isset($_POST['cart_total'])  ? $_POST['cart_total'] : '');
        $cart_contents = sanitize_text_field(isset($_POST['productid'])  ? $_POST['productid'] : '');
        $check_session_exit = $wpdb->get_row("SELECT * FROM $racart_cartemail WHERE email='$email'");
        $totalrow = $wpdb->num_rows;

        if($email){
            if($totalrow > 0){
              $cartrecovery_id = $check_session_exit->ID;
              $updatequery = $wpdb->query("UPDATE $racart_cartemail SET fname='$fname',lname='$lname',email='$email',phone='$phone',location='$location',cart_contents='$cart_contents',cart_total='$cart_total',currency='$currencycode',date_time='$date_time',added_date='$added_date' WHERE ID ='$cartrecovery_id'");
            }else{
              $insert_query  = $wpdb->query("INSERT INTO $racart_cartemail(fname,lname,email,phone,location,cart_contents,cart_total,currency,date_time,added_date)VALUES('$fname','$lname','$email','$phone','$location','$cart_contents','$cart_total','$currencycode','$date_time','$added_date')");
            }
        }
        wp_die();
    }
}

function racart_load_wp_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'racart_load_wp_media_files' );
?>