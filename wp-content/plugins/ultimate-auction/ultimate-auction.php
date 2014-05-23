<?php
/*
  Plugin Name: Wordpress Auction Plugin
  Plugin URI: http://auctionplugin.net
  Description: Awesome plugin to host auctions on your wordpress site and sell anything you want.
  Author: Nitesh Singh
  Author URI: http://auctionplugin.net
  Version: 1.0.4
  License: GPLv2
  Copyright 2013 Nitesh Singh
*/

require_once('settings-page.php');
require_once('auction-shortcode.php');
require_once('send-auction-email.php');

//create a table for auction bidders on plugin activation
register_activation_hook(__FILE__,'wdm_create_bidders_table');

function wdm_create_bidders_table()
{
   require(ABSPATH . 'wp-admin/includes/upgrade.php');
   global $wpdb;
   
   $data_table = $wpdb->prefix."wdm_bidders";
   $sql = "CREATE TABLE IF NOT EXISTS $data_table
  (
   id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
   name VARCHAR(45),
   email VARCHAR(45),
   auction_id MEDIUMINT(9),
   bid DECIMAL(10,2),
   date datetime,
   PRIMARY KEY (id)
  );";
  
   dbDelta($sql);
   
   //for old table (till 'Wordpress Auction Plugin' version 1.0.2) which had 'bid' column as integer(MEDIUMINT)
   $alt_sql = "ALTER TABLE $data_table MODIFY bid DECIMAL(10,2);";
   
   $wpdb->query($alt_sql);
}

//send email Ajax callback - An automatic activity once an auction has expired
function send_auction_email_callback()
{
    require_once('email-template.php');
    
    $sent_email = ultimate_auction_email_template($_POST['auc_title'], $_POST['auc_id'], $_POST['auc_cont'], $_POST['auc_bid'], $_POST['auc_email'], $_POST['auc_url']);
    
    if(!$sent_email)
        update_post_meta($_POST['auc_id'], 'wdm_to_be_sent', '');
    
    die();
}

add_action('wp_ajax_send_auction_email', 'send_auction_email_callback');
add_action('wp_ajax_nopriv_send_auction_email', 'send_auction_email_callback');

//resend email Ajax callback - 'Resend' link on 'Manage Auctions' page
function resend_auction_email_callback()
{
    require_once('email-template.php');
    
    $res_email = ultimate_auction_email_template($_POST['a_title'], $_POST['a_id'], $_POST['a_cont'], $_POST['a_bid'], $_POST['a_em'], $_POST['a_url']);
    
    if($res_email)
        echo "Email sent successfully";
    else
        echo "Sorry, email cannot be sent";
    
    die();
}

add_action('wp_ajax_resend_auction_email', 'resend_auction_email_callback');
add_action('wp_ajax_nopriv_resend_auction_email', 'resend_auction_email_callback');

//delete auction Ajax callback - 'Delete' link on 'Manage Auctions' page
function delete_auction_callback()
{
    if($_POST["force_del"] === 'yes')
        $force = true;
    else
        $force = false;
    //echo $force;
    if(current_user_can('delete_posts'))
    {
        $del_auc = wp_delete_post($_POST["del_id"], false);
    }
    
    if($del_auc)
    {
        echo "Auction '".$_POST['auc_title']."' deleted successfully";
    }
    else
        echo "Sorry, this auction cannot be deleted";
    die();
}

add_action('wp_ajax_delete_auction', 'delete_auction_callback');
add_action('wp_ajax_nopriv_delete_auction', 'delete_auction_callback');

//end auction Ajax callback - 'End Auction' link on 'Manage Auctions' page
function end_auction_callback()
{
    $end_auc = update_post_meta($_POST['end_id'], 'wdm_listing_ends', date("Y-m-d H:i:s", time()));
    
    $check_term = term_exists('expired', 'auction-status');
    wp_set_post_terms($_POST['end_id'], $check_term["term_id"], 'auction-status');
    
    if($end_auc)
        echo "Auction '".$_POST['end_title']."' ended successfully";
    else
        echo "Sorry, this auction cannot be ended";
    die();
}

add_action('wp_ajax_end_auction', 'end_auction_callback');
add_action('wp_ajax_nopriv_end_auction', 'end_auction_callback');

//cancel bid entry Ajax callback - 'Cancel Last Bid' link on 'Manage Auctions' page
function cancel_last_bid_callback()
{
    global $wpdb;
    
    $cancel_bid = $wpdb->query( 
	$wpdb->prepare( 
		"
                DELETE FROM ".$wpdb->prefix."wdm_bidders
		 WHERE id = %d
		",
	        $_POST['cancel_id']
        )
    );
    
    if($cancel_bid)
        echo $_POST['bidder_name']."'s bid entry removed successfully";
    else
        echo "Sorry, bid entry cannot be removed";
    die();
}

add_action('wp_ajax_cancel_last_bid', 'cancel_last_bid_callback');
add_action('wp_ajax_nopriv_cancel_last_bid', 'cancel_last_bid_callback');

//place bid Ajax callback - 'Place Bid' button on Single Auction page
function place_bid_now_callback()
{
   if(is_user_logged_in()){

	//TODO: Verificar se o leilão está aberto ainda! (horario?)
    global $wpdb;
    $wpdb->hide_errors();
    
    $q="SELECT MAX(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$_POST['auction_id'];
    $next_bid = $wpdb->get_var($q);
    
    if(!empty($next_bid)){
      update_post_meta($_POST['auction_id'], 'wdm_previous_bid_value', $next_bid); //store bid value of the most recent bidder
    }
    
    if(empty($next_bid))
         $next_bid = get_post_meta($_POST['auction_id'], 'wdm_opening_bid', true);
         
    $next_bid = $next_bid + get_post_meta($_POST['auction_id'],'wdm_incremental_val',true);
    
    if($_POST['bid'] < $next_bid)
    {
       echo "inv_bid".$next_bid;
    }
    else
    {
        $palce_bid = $wpdb->insert( 
	$wpdb->prefix.'wdm_bidders', 
	array( 
		'name' => $_POST['name'], 
		'email' => $_POST['email'],
                'auction_id' => $_POST['auction_id'],
                'bid' => $_POST['bid'],
                'date' => date("Y-m-d H:i:s", time())
	), 
	array( 
		'%s', 
		'%s',
                '%d',
                '%f',
                '%s'
	) 
        );
    
	if($palce_bid)
	{
		$qry="SELECT COUNT(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$_POST['auction_id'];
		$total_bids = $wpdb->get_var($qry);
		$buy_price = get_post_meta($_POST['auction_id'], 'wdm_buy_it_now', true);
                
		if(!empty($buy_price) && $_POST['bid'] >= $buy_price)
		{
			update_post_meta($_POST['auction_id'], 'wdm_listing_ends', date("Y-m-d H:i:s", time()));
			$check_term = term_exists('expired', 'auction-status');
			wp_set_post_terms($_POST['auction_id'], $check_term["term_id"], 'auction-status');
                        update_post_meta($_POST['auction_id'], 'email_sent_imd', 'sent_imd');
			echo "Won";
		}else{
			//Ajusta +15 min se já estiver acabando
			$now = mktime();
			$ending_date = strtotime(get_post_meta($_POST['auction_id'], 'wdm_listing_ends', true));

			$seconds =  $ending_date - $now;

			if($seconds<=900){
				update_post_meta($_POST['auction_id'], 'wdm_listing_ends', date("Y-m-d H:i:s", $now+900));
			}
			echo "Placed";
		}                 
	}
    }
}
else{
   echo "Please log in to place bid";
}
	die();
}

add_action('wp_ajax_place_bid_now', 'place_bid_now_callback');
add_action('wp_ajax_nopriv_place_bid_now', 'place_bid_now_callback');

//bid notification email Ajax callback - Single Auction page
function bid_notification_callback()
{
    
            $c_code = substr(get_option('wdm_currency'), -3);
            
            //$perma_type = get_option('permalink_structure');
            //if(empty($perma_type))
            //    $char = "&";
            //else
            //    $char = "?";
            $char = $_POST['char'];
                
            $ret_url = $_POST['auc_url'].$char."ult_auc_id=".$_POST['auction_id'];
            
//Tirar emails de bid
/**
            $adm_email = get_option("wdm_auction_email");
            
            $adm_sub = "[".get_bloginfo('name')."]  A bidder has placed a bid on the product - ".$_POST['auc_name'];
            $adm_msg = "";
            $adm_msg  = "<strong>Bidder Details - </strong>";
            $adm_msg .= "<br /><br /> Bidder Name: ".$_POST['name'];
            $adm_msg .= "<br /><br /> Bidder Email: ".$_POST['email'];
            $adm_msg .= "<br /><br /> Bid Value: ".$c_code." ".round($_POST['bid'], 2);
            $adm_msg .= "<br /><br /><strong>Product Details - </strong>";
            $adm_msg .= "<br /><br /> Product URL: ".$ret_url;
            $adm_msg .= "<br /><br /> Product Name: ".$_POST['auc_name'];
            $adm_msg .= "<br /><br /> Description: <br />".$_POST['auc_desc']."<br />";
            
            $hdr = "";
            //$hdr  = "From: ". get_bloginfo('name') ." <". $adm_email ."> \r\n";
            $hdr .= "MIME-Version: 1.0\r\n";
            $hdr .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            
	    wp_mail($adm_email, $adm_sub, $adm_msg, $hdr, '');

            
            $bid_sub = "[".get_bloginfo('name')."] You recently placed a bid on the product - ".$_POST['auc_name'];
            $bid_msg = "";
            $bid_msg = "Here are the details - ";
            $bid_msg .= "<br /><br /> Product URL: ". $ret_url;
            $bid_msg .= "<br /><br /> Product Name: ".$_POST['auc_name'];
            $bid_msg .= "<br /><br /> Bid Value: R$".round($_POST['bid'], 2);
            $bid_msg .= "<br /><br /> Description: <br />".$_POST['auc_desc']."<br />";
            
            wp_mail($_POST['email'], $bid_sub, $bid_msg, $hdr, '');
**/
	    
	    //outbid email
	    global $wpdb;
	    $wpdb->hide_errors();
	    
	    $prev_bid = get_post_meta($_POST['auction_id'], 'wdm_previous_bid_value', true);
	    
	    if(!empty($prev_bid)){
	       $bidder_email  = "";
	       $email_qry = "SELECT email FROM ".$wpdb->prefix."wdm_bidders WHERE bid =".$prev_bid." AND auction_id =".$_POST['auction_id'];
	       $bidder_email = $wpdb->get_var($email_qry);
	       
	       if($bidder_email != $_POST['email']){
		  $outbid_sub = "[".get_bloginfo('name')."] Seu lance foi superado em um produto";

		  $hdr = "";
            	  //$hdr  = "From: ". get_bloginfo('name') ." <". $adm_email ."> \r\n";
            	  $hdr .= "MIME-Version: 1.0\r\n";
            	  $hdr .= "Content-type:text/html;charset=utf-8" . "\r\n";

		  $bid_msg = "";
            	  $bid_msg = "=====Detalhes=====";
            	  $bid_msg .= "<br /> Link: <a href='".$ret_url."'>".$ret_url."</a>";
            	  $bid_msg .= "<br /> Produto: ".$_POST['auc_name'];
            	  $bid_msg .= "<br /> Valor do Lance: R$".round($_POST['bid'], 2);
            	  $bid_msg .= "<br /> Descrição: <br />".$_POST['auc_desc']."<br />";

		  wp_mail($bidder_email, $outbid_sub, $bid_msg, $hdr, '');
	       }
	    }
            
	    //auction won immediately
            if(isset($_POST['email_type']) && $_POST['email_type'] === 'winner_email')
            {
                require_once('email-template.php');    
                ultimate_auction_email_template($_POST['auc_name'], $_POST['auction_id'], $_POST['auc_desc'], round($_POST['bid'], 2), $_POST['email'], $ret_url);
            }
                
	die();
}

add_action('wp_ajax_bid_notification', 'bid_notification_callback');
add_action('wp_ajax_nopriv_bid_notification', 'bid_notification_callback');

//private message Ajax callback - Single Auction page
function private_message_callback()
{
        //$perma_type = get_option('permalink_structure');
        //if(empty($perma_type))
        //    $char = "&";
        //else
        //    $char = "?";
        
        $char = $_POST['p_char'];
        
        $auc_url = $_POST['p_url'].$char."ult_auc_id=".$_POST['p_auc_id'];
        
        $adm_email = get_option('wdm_auction_email');
            
        $p_sub = "[".get_bloginfo('name')."] You have a private message from a site visitor";
        
        $msg = "";
        $msg = "Name: ".$_POST['p_name']."<br /><br />";
        $msg .= "Email: ".$_POST['p_email']."<br /><br />";
        $msg .= "Message: <br />".$_POST['p_msg']."<br /><br />";
        $msg .= "Product URL: ".$auc_url."<br />";
        
        $hdr = "";
        //$hdr  = "From: ". get_bloginfo('name') ." <". $adm_email ."> \r\n";
        $hdr .= "MIME-Version: 1.0\r\n";
        $hdr .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        
        $sent = wp_mail($adm_email, $p_sub, $msg, $hdr, '');
        
        if($sent)
            echo "Email sent successfully";
        else
            echo "Sorry, email could not be sent";
        
	die();
}

add_action('wp_ajax_private_message', 'private_message_callback');
add_action('wp_ajax_nopriv_private_message', 'private_message_callback');

//plugin credit link
add_action('wp_footer', 'wdm_plugin_credit_link');

function wdm_plugin_credit_link()
{
    add_option('wdm_powered_by', "Yes");
    
    $check_credit = get_option('wdm_powered_by');
    
    if($check_credit == "Yes")
    {
        if(!is_admin())
        echo "<center><div id='ult-auc-footer-credit'><a href='http://auctionplugin.net' target='_blank'>Powered By Ultimate Auction</a></div></center>";
    }
}

add_action('init', 'wdm_set_auction_timezone');
function wdm_set_auction_timezone()
{
    $get_default_timezone = get_option('wdm_time_zone');
    
    if(!empty($get_default_timezone))
    {
        date_default_timezone_set($get_default_timezone);
    }
    
                                    if(isset($_GET["ult_auc_id"]) && $_GET["ult_auc_id"]){
                                       
                                    $single_auction=get_post($_GET["ult_auc_id"]);
                                    
                                        $auth_key = get_post_meta($single_auction->ID, 'wdm-auth-key', true);
                                        
                                        if(isset($_GET['wdm']) && $_GET['wdm'] === $auth_key)
                                        {
                                          $terms = wp_get_post_terms($single_auction->ID, 'auction-status',array("fields" => "names"));
                                          if(!in_array('expired',$terms))
                                          {
                                             $chck_term = term_exists('expired', 'auction-status');
                                             wp_set_post_terms($single_auction->ID, $chck_term["term_id"], 'auction-status');
                                             update_post_meta($single_auction->ID, 'wdm_listing_ends', date("Y-m-d H:i:s", time()));
                                          }
                                          
                                          update_post_meta($single_auction->ID, 'auction_bought_status', 'bought');
                                          echo '<script type="text/javascript">
                                          setTimeout(function() {
                                                                alert("Thank you for buying this product.");
                                                               }, 1000);       
                                          </script>';
					  
					  //details of a product sold through buy now link
					  if(is_user_logged_in()){
					  $curr_user = wp_get_current_user();
					  $buyer_email = $curr_user->user_email;
					  $winner_name = $curr_user->user_login;
					  }
					  
					  $auction_email = get_option('wdm_auction_email');
					  $site_name = get_bloginfo('name');
					  $site_url = get_bloginfo('url');
					  $c_code = substr(get_option('wdm_currency'), -3);
					  $rec_email = get_option('wdm_paypal_address');
					  $buy_now_price = get_post_meta($single_auction->ID, 'wdm_buy_it_now', true);
					  
					  $headers = "";
					  //$headers  = "From: ". $site_name ." <". $auction_email ."> \r\n";
					  $headers .= "MIME-Version: 1.0\r\n";
					  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
					  
					  $return_url = "";
					  $return_url = strstr($_SERVER['REQUEST_URI'], 'ult_auc_id', true);
					  $return_url = $site_url.$return_url."ult_auc_id=".$_GET["ult_auc_id"];
					  
					  $auction_data = array('auc_id' => $single_auction->ID,
								 'auc_name' => $single_auction->post_title,
								 'auc_desc' => $single_auction->post_content,
								 'auc_price' => $buy_now_price,
								 'auc_currency' => $c_code,
								 'seller_paypal_email' => $rec_email,
								 'winner_email' => $buyer_email,
								 'seller_email' => $auction_email,
								 'winner_name' => $winner_name,
								 'pay_method' => 'method_paypal',
								 'site_name' => $site_name,
								 'site_url' => $site_url,
								 'product_url' => $return_url,
								 'header' => $headers
					  );
					  
					  do_action('ua_shipping_data_email', $auction_data);
                                        }
                                    }
                              

}

function wdm_ending_time_calculator($seconds)
{
   $days = floor($seconds / 86400);
   $seconds %= 86400;

   $hours = floor($seconds / 3600);
   $seconds %= 3600;

   $minutes = floor($seconds / 60);
   $seconds %= 60;
					
   $rem_tm = "";
					
   if($days > 1)
      $rem_tm = $days ." days ";
   elseif($days == 1)
      $rem_tm = $days ." day ";	
					
   if($hours > 1)
      $rem_tm .= $hours ." hrs ";
   elseif($hours == 1)
      $rem_tm .= $hours ." hr ";
						
   if($minutes > 1)
      $rem_tm .= $minutes ." mins ";
   elseif($minutes == 1)
      $rem_tm .= $minutes ." min ";
	
   if($seconds > 1)
      $rem_tm .= $seconds ." secs";
   elseif($seconds == 1)
      $rem_tm .= $seconds ." sec";
      
      return $rem_tm;
}
add_filter('comment_post_redirect', 'redirect_after_comment');
function redirect_after_comment($location)
{
return $_SERVER["HTTP_REFERER"];
}

function wdm_auction_mybids(){
	//enqueue css file for front end style
	wp_enqueue_style('wdm_auction_front_end_styling',plugins_url('css/ua-front-end.css', __FILE__));
	wp_enqueue_script('wdm-custom-js', plugins_url('js/wdm-custom-js.js', __FILE__), array('jquery'));

	require_once('auction-mybids-page.php');
}
add_shortcode('wdm_auction_mybids', 'wdm_auction_mybids');
?>