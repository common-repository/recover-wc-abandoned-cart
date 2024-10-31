<?php
/*
* abandoned menu.
*/
if ( is_admin() ) {
    add_action( 'admin_menu', 'racart_abandoned_cart', 100 );
}
if ( ! function_exists ( 'racart_abandoned_cart' ) ) {
  function racart_abandoned_cart() {
    add_submenu_page( 'woocommerce', esc_html( "Abandoned carts" ), esc_html( 'Abandoned carts' ), 'manage_options', 'racart-abandonedcart', 'racart_abandoned_cart_callback' );
    add_action( 'admin_init', 'racart_register_settings' );

    add_action( 'admin_init', 'racart_enable_exitintent' );
  }
}
if ( ! function_exists ( 'racart_abandoned_cart_callback' ) ) {
function racart_abandoned_cart_callback(){
	global $wpdb;
	global $wp_session;
	global $product;
    if ( ! function_exists ( 'sanitize' ) ) {
      function sanitize( $input ) { 
        $new_input = array(); 
       foreach ( $input as $key => $val ) {      
          $new_input[ $key ] = sanitize_text_field( $val );   } 
        return $new_input;  
      }
    }
  	$racart_cartemail = $wpdb->prefix.'racart_cartemail';
  	$mode = sanitize_text_field(isset($_GET['mode'])  ? $_GET['mode'] : '');
  	$tab = sanitize_text_field(isset($_GET['tab'])  ? $_GET['tab'] : '');
  	if($mode=="delete"){
  		$delete_id = sanitize_text_field(isset($_GET['id'])  ? $_GET['id'] : '');
      $wpdb->query(
          $wpdb->prepare(
            "DELETE FROM $racart_cartemail
            WHERE ID = %d",
            intval($delete_id)
          )
      );
  		wp_redirect( "admin.php?page=racart-abandonedcart" );
  	}
  	$modeall = sanitize_text_field(isset($_POST['modeall'])  ? $_POST['modeall'] : '');
  	if ($modeall=="deleteall") {
      $selected_id = sanitize($_POST['selected_id']);
      if(is_array($selected_id)){ 
          foreach ($selected_id as $key => $id){
            $wpdb->query(
              $wpdb->prepare(
                "DELETE FROM $racart_cartemail
                WHERE ID = %d",
                intval($id)
              )
            );
          }
      }else{ 
        $id = $selected_id;
        $wpdb->query(
            $wpdb->prepare(
              "DELETE FROM $racart_cartemail
              WHERE ID = %d",
              intval($id)
            )
        );
      }
  	}
  	$racart_cartactive ="";
  	$racartcartactive ="";
  	$racart_abandoned_cart = "";
  	$racart_exitintent = "";
  	$racartactive_exitintent = "";
  	if($tab =="settings"){
  		$racart_cartactive = "racart_cartactive";
  		$racart_cartemailpage = "block";
  		$racart_abandoned_cart = "none";
  		$racart_exitintent = "none";
  	}else if($tab =="exitintent"){
  		$racartcartactive = "";
  		$racart_cartemailpage = "none";
  		$racart_abandoned_cart = "none";
  		$racart_exitintent = "block";
  		$racartactive_exitintent = "racart_cartactive";
  	}elseif($tab==""){
  		$racartcartactive = "racart_cartactive";
  		$racart_cartemailpage = "none";
  		$racart_abandoned_cart = "block";
  		$racart_exitintent = "none";
  	}
?>
<div class="racart_admin_image">
 <a href="<?php echo esc_url('https://www.sktthemes.org/themes/');?>" target="_blank"><img src="<?php echo esc_url(RACART_URI.'/images/browse-themes.png');?>"></a>
</div>
<h3><?php esc_html_e( "Abandoned carts",'recover-wc-abandoned-cart' );?></h3>
<div class="racart_cartmenu">
  <a href="<?php echo esc_url('admin.php?page=racart-abandonedcart');?>" class="<?php echo esc_attr($racartcartactive);?>"><?php esc_attr_e('Abandoned carts','recover-wc-abandoned-cart');?></a>
  <a href="<?php echo esc_url('admin.php?page=racart-abandonedcart&tab=settings');?>" class="<?php echo esc_attr($racart_cartactive);?>"><?php esc_attr_e('Settings','recover-wc-abandoned-cart');?></a>
  <a href="<?php echo esc_url('admin.php?page=racart-abandonedcart&tab=exitintent');?>" class="<?php echo esc_attr($racartactive_exitintent);?>"><?php esc_attr_e('Exit Intent','recover-wc-abandoned-cart');?></a>
  <a href="<?php echo esc_url('https://sktthemesdemo.net/documentation/recover-wc-abandoned-cart-doc');?>" target="_blank"><?php esc_attr_e('Documentation','recover-wc-abandoned-cart');?></a>
</div>
<div class="racart-cartrecovry-settings-inner" style="display: <?php echo $racart_abandoned_cart;?>;">
<?php
if ( ! function_exists ( 'racart_time_elapsed_string' ) ) {
  function racart_time_elapsed_string($ptime){
    $etime = time() - $ptime;
    if ($etime < 1){
        return '0 seconds';
    }
    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );
    foreach ($a as $secs => $str){
        $d = $etime / $secs;
        if ($d >= 1){
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
  }
}
	$get_cartemail = $wpdb->get_results("SELECT * FROM $racart_cartemail WHERE cart_total <> 0 ORDER BY ID DESC");
	$totalrow = $wpdb->num_rows;
	if($totalrow > 0){
?>
<form name="actionForm" action="" method="post"/>
  <table id="racart_catrlistcustomers" cellspacing="0px" class="table-responsive">
  	<thead>
  		<tr>
  			<th width="2%" class="racart_srno_head"><?php esc_html_e( "Sr.No",'recover-wc-abandoned-cart' );?></th>
  			<th width="10%"><?php esc_html_e( "Name",'recover-wc-abandoned-cart' );?></th>
  			<th width="25%"><?php esc_html_e( "Email",'recover-wc-abandoned-cart' );?></th>
  			<th width="8%"><?php esc_html_e( "Phone",'recover-wc-abandoned-cart' );?></th>
  			<th width="5%" class="racart_srno_head"><?php esc_html_e( "Location",'recover-wc-abandoned-cart' );?></th>
  			<th width="15%"><?php esc_html_e( "Product Name",'recover-wc-abandoned-cart' );?></th>
  			<th width="15%"><?php esc_html_e( "Cart Total",'recover-wc-abandoned-cart' );?></th>
  			<th width="10%"  class="racart_srno_head"><?php esc_html_e( "Time",'recover-wc-abandoned-cart' );?></th>
  			<th width="10%"><input type="checkbox" name="check_all" id="check_all" value=""/><?php esc_attr_e('Delete','recover-wc-abandoned-cart');?></th>
  		</tr>
  	</thead>
  	<tbody>
  		<?php
  			$g =0;
  			foreach ($get_cartemail as $getcartemail) {
  				$cart_contents = $getcartemail->cart_contents;
  				$date_time = $getcartemail->date_time;
  				$unserialize_cart_contents = unserialize($cart_contents);
  				$totalno_product = count($unserialize_cart_contents);
          $email = $getcartemail->email;

  				$g++;
          if($email !=''){
  		?>
  		<tr>
  			<td width="2%" class="racart_srno_head"><div class="racart_srno"><?php echo esc_html($g);?></div> 
        </td>
  			<td width="10%"><div class="racart_srno"><?php echo esc_html($getcartemail->fname.' '.$getcartemail->lname);?></div></td>
  			<td width="25%"><div class="racart_srno_email"><?php echo esc_html($getcartemail->email);?></div></td>
  			<td width="8%"><div class="racart_srno_name"><?php echo esc_html($getcartemail->phone);?></div></td>
  			<td width="5%" class="racart_srno_head"><div class="racart_srno_location"><?php echo esc_html($getcartemail->location);?></div></td>
  			<td width="15%"><div class="racart_srno_productname">
  				<?php
  					for ($i=0; $i <$totalno_product ; $i++) { 
  						$get_productid = $unserialize_cart_contents[$i];
  						 $attachment_ids[0] = get_post_thumbnail_id( esc_html($get_productid) );
                 $attachment = wp_get_attachment_image_src($attachment_ids[0], 'full' );
          ?>
  				<a href="post.php?post=<?php echo $get_productid?>&action=edit"><?php echo get_the_title( esc_html($get_productid ));?></a><br>
  				<?php } ?></div>
  			</td>
  			<td width="15%"><div class="racart_srno"><?php echo $getcartemail->cart_total.' '.$getcartemail->currency;?></div></td>
  			<td width="10%" class="racart_srno_head"><div class="racart_srno"><?php echo racart_time_elapsed_string($date_time);?></div></td>
  			<td width="10%"><div class="racart_srno"><input type="checkbox" name="selected_id[]" class="checkbox" value="<?php echo $getcartemail->ID; ?>"/>
  				<a href="<?php echo esc_url('admin.php?page=racart-abandonedcart&mode=delete&id='. esc_html($getcartemail->ID));?>"><?php esc_attr_e('Delete','recover-wc-abandoned-cart');?></a></div></td>
  		</tr>
  		<?php } } ?>
  	</tbody>
  	<input type="hidden" name="modeall" value="deleteall">
  	<div class="racart_alldelete">
  		<input type="submit" class="btn btn-primary" id="racart_deleteall" name="btn_delete" value="<?php esc_attr_e('Delete','recover-wc-abandoned-cart');?>"/>
  	</div>
  </table>
</form>
<?php 	}else{ ?>
<p><?php  esc_html_e( "You don't have any saved Abandoned carts yet." ,'recover-wc-abandoned-cart');?></p>
<p><?php  esc_html_e( "But do not worry, as soon as someone fills the Email or Phone number fields of your WooCommerce Checkout form and abandons the cart, it will automatically appear here." ,'recover-wc-abandoned-cart');?></p>
<?php } ?>
</div>
<div class="racart_wccartemail_page" style="display: <?php echo esc_html($racart_cartemailpage);?>;">
	<?php include_once( RACART_DIR .'/admin/cartemail.php' );?>
</div>
<div class="racart_wccartemail_emailexit" style="display: <?php echo esc_html($racart_exitintent);?>;">
	<?php include_once( RACART_DIR .'/admin/exitintent.php' );?>
</div>
<?php } } ?>