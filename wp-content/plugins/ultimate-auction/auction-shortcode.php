<?php
function wdm_auction_listing($id){
	
	
	//enqueue css file for front end style
	wp_enqueue_style('wdm_auction_front_end_styling',plugins_url('css/ua-front-end.css', __FILE__));
	wp_enqueue_script('wdm-custom-js', plugins_url('js/wdm-custom-js.js', __FILE__), array('jquery'));
	
	//check the permalink from database and append variable to the auction single pages accordingly
	$perma_type = get_option('permalink_structure');
	
	if(is_front_page() || is_home())
	$set_char = "?";
	elseif(empty($perma_type))
	$set_char = "&";
	else
	$set_char = "?";

	if(isset($id) && $id){
		$theID=$id;
	}
	if(isset($_GET["ult_auc_id"]) && $_GET["ult_auc_id"]){
		$theID=$_GET["ult_auc_id"];
	}

	if(isset($theID) && $theID){
		
		//if single auction page is found do the following
		global $wpdb;
		$wpdb->hide_errors();
		$wdm_auction=get_post($theID);
		if($wdm_auction){
		//update single auction page url on single auction page visit - if the permalink type is updated we should have appropriate url to be sent in email 	
		update_post_meta($wdm_auction->ID, 'current_auction_permalink', get_permalink().$set_char."ult_auc_id=".$wdm_auction->ID);
		 
		 //check if start price/opening bid price is set
		$to_bid = get_post_meta($wdm_auction->ID, 'wdm_opening_bid', true);
		
		//check if buy now price is set
		$to_buy = get_post_meta($wdm_auction->ID, 'wdm_buy_it_now', true); 
		
		//latest highest/current price
		$query="SELECT MAX(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$wdm_auction->ID;
		$curr_price = $wpdb->get_var($query);
		if(empty($curr_price))
			$curr_price = get_post_meta($wdm_auction->ID,'wdm_opening_bid',true);
			
		//total no. of bids	
		$qry="SELECT COUNT(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$wdm_auction->ID;
		$total_bids = $wpdb->get_var($qry);
		
		//buy now price
		$buy_now_price = get_post_meta($wdm_auction->ID,'wdm_buy_it_now',true);
		
		//get currency code
		$currency_code = "R$";//substr(get_option('wdm_currency'), -3);
		?>
		
		<!--main forms container of single auction page-->
		 <div class="wdm-ultimate-auction-container">

<a href="javascript:history.back()" class="button-voltar">Voltar</a>
			<div class="wdm-image-container">
					<img class="auction-main-img"  src="<?php echo get_post_meta($wdm_auction->ID,'wdm_auction_thumb',true); ?>" width="265" height="210px"/>
					<img class="auction-small-img" src="<?php echo get_post_meta($wdm_auction->ID,'wdm-image-1',true); ?>" width="60" height="65"/>
					<img class="auction-small-img" src="<?php echo get_post_meta($wdm_auction->ID,'wdm-image-2',true); ?>" width="60" height="65"/>
					<img class="auction-small-img" src="<?php echo get_post_meta($wdm_auction->ID,'wdm-image-3',true); ?>" width="60" height="65"/>
					<img class="auction-small-img" src="<?php echo get_post_meta($wdm_auction->ID,'wdm-image-4',true); ?>" width="60" height="65"/>
			</div> <!--wdm-image-container ends here-->
			
			<div class="wdm_single_prod_desc">
			    
			    <div class="wdm-single-auction-title">
				<?php echo $wdm_auction->post_title; ?>
			    </div> <!--wdm-single-auction-title ends here-->
			    
			<?php //get auction-status taxonomy value for the current post - live/expired
			$active_terms = wp_get_post_terms($wdm_auction->ID, 'auction-status',array("fields" => "names"));
			
			//incremented price value
			$inc_price = $curr_price + get_post_meta($wdm_auction->ID,'wdm_incremental_val',true);
			
			//if the auction has reached it's time limit, expire it
			if((mktime() >= strtotime(get_post_meta($wdm_auction->ID,'wdm_listing_ends',true)))){
				if(!in_array('expired',$active_terms))
				{
					$check_term = term_exists('expired', 'auction-status');
					wp_set_post_terms($wdm_auction->ID, $check_term["term_id"], 'auction-status');
				}
				
			}
			
			$now = mktime(); 
		        $ending_date = strtotime(get_post_meta($wdm_auction->ID, 'wdm_listing_ends', true));
			
			//display message for expired auction
			if((mktime() >= strtotime(get_post_meta($wdm_auction->ID,'wdm_listing_ends',true))) || in_array('expired',$active_terms)){
				
				$seconds =  $now - $ending_date;
				
				$rem_tm = wdm_ending_time_calculator($seconds);	
			    
			    ?>
			    <div class="wdm-auction-ending-time">Ended at: <span class="wdm-single-auction-ending"><?php echo $rem_tm;?> ago </span></div>
			    
			    <?php
			    if(!empty($to_bid)){?>
				   
				   <div class="wdm_bidding_price" style="float:left;">
						 <strong><?php echo $currency_code." ".$curr_price; ?></strong>
				   </div>
				   <div id="wdm-auction-bids-placed" class="wdm_bids_placed" style="float:right;">
					<a href="#wdm-tab-anchor-id" id="wdm-total-bids-link"><?php echo ($total_bids == 1) ? $total_bids." Lance" : $total_bids." Lances"; ?></a>
				   </div>
			
				   <br />
				   
			<?php }
			    
			    $bought = get_post_meta($wdm_auction->ID, 'auction_bought_status', true);
			    
			    if($bought === 'bought'){
				   echo '<div class="wdm-mark-red">This auction has been bought by paying Buy Now price ['.$currency_code.' '.$buy_now_price.'] </div>';
			    }
			    else{
				   $cnt_qry = "SELECT COUNT(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$wdm_auction->ID;
				   $cnt_bid = $wpdb->get_var($cnt_qry);
				   if($cnt_bid > 0)
				   {
					  $res_price_met = get_post_meta($wdm_auction->ID, 'wdm_lowest_bid',true);
				   
					  $win_bid = "";
					  $bid_q = "SELECT MAX(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$wdm_auction->ID;
					  $win_bid = $wpdb->get_var($bid_q);
				   
					  if($win_bid >= $res_price_met){
						 $winner_name  = "";
						 $name_qry = "SELECT name FROM ".$wpdb->prefix."wdm_bidders WHERE bid =".$win_bid." AND auction_id =".$wdm_auction->ID;
						 $winner_name = $wpdb->get_var($name_qry);
						 echo '<div class="wdm-mark-red">Este produto foi vendido para '.$winner_name.' por R$'.$win_bid.'</div>';
					  }
					  else
					  {
						 echo '<div class="wdm-mark-red">Este leilão terminou sem nenhum ganhador</div>';
					  }
				   }
				   else
				   {
					  if(empty($to_bid))
						 echo '<div class="wdm-mark-red">Este leilão terminou sem nenhum ganhador</div>';
					  else 	 
						 echo '<div class="wdm-mark-red">Este leilão terminou sem nenhum ganhador</div>';	
				   }
			    }
			    
			}
			
			else{
				//prepare a format and display remaining time for current auction
				
				$seconds = $ending_date - $now;
				
				$rem_tm = wdm_ending_time_calculator($seconds);	
				
				
			?>
			<!--form to place bids-->
				
				<div class="wdm-auction-ending-time">Termina em: <span class="wdm-single-auction-ending"><?php echo $rem_tm;?> </span></div>

<?php				
$qry="SELECT name FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$wdm_auction->ID." AND bid=".$curr_price;
$nome = $wpdb->get_var($qry);
?>

				<?php if(!empty($to_bid)) {?>
				<div id="wdm_place_bid_section">
				<div class="wdm_bidding_price" style="float:left;">
						 <strong><?php echo "R$ ".$curr_price."</strong>"; 
if($nome !=""){
echo " (".$nome.")"; 
}?>
				</div>
				<div id="wdm-auction-bids-placed" class="wdm_bids_placed" style="float:right;">
					<a href="#wdm-tab-anchor-id" id="wdm-total-bids-link"><?php echo ($total_bids == 1) ? $total_bids." Lance" : $total_bids." Lances"; ?></a>
				</div>
				<?php 
				if($curr_price >= get_post_meta($wdm_auction->ID,'wdm_lowest_bid',true)){
				?>
				<br />
				<div class="wdm_reserved_note wdm-mark-green" style="float:left;">
					<em></em>
				</div>
				<?php }
				else{
					?>
					<div class="wdm_reserved_note wdm-mark-red" style="float:left;">
					<em></em>
					</div>
					<?php
				}
				if(is_user_logged_in()) {
				   $curr_user = wp_get_current_user();
				   $auction_bidder_name = $curr_user->user_login;
				   $auction_bidder_email = $curr_user->user_email;
				?>
				<br />
				<form action="<?php echo dirname(__FILE__); ?>" style="margin-top:20px;">
					<div class="wdm_bid_val" style="float:left;">
						<label for="wdm-bidder-bidval">Valor: </label>
						<input type="text" id="wdm-bidder-bidval" style="width:85px;" placeholder="<?php echo "R$";?>" />
						<br /><span class="wdm_enter_val_text" style="float:right;">
						<small>(Entre <?php echo $inc_price; ?> ou mais)</small>
						</span>
					</div>
					<div class="wdm_place_bid" style="float:right;">
						<input type="submit" value="Enviar Lance" id="wdm-place-bid-now" />
					</div>
					
				</form>
				<?php
				   require_once('ajax-actions/place-bid.php'); //file to handle ajax requests related to bid placing form
				}
				else{
				  ?>
				   <br />
					<div class="wdm_bid_val" style="float:left;">
						<label for="wdm-bidder-bidval">Bid Value: </label>
						<input type="text" id="wdm-bidder-bidval" style="width:85px;" placeholder="<?php echo "in ".$currency_code;?>" />
						<br /><span class="wdm_enter_val_text" style="float:right;">
						<small>(Enter <?php echo $inc_price; ?> or more)</small>
						</span>
					</div>
					
				   <div class="wdm_place_bid" style="float:right;padding-top:6px;">
					  <a class="wdm-login-to-place-bid" href="<?php echo wp_login_url(site_url( $_SERVER['REQUEST_URI'] )); ?>" title="Login">Place Bid</a>
				   </div>
				<?php }?>
				</div> <!--wdm_place_bid_section ends here-->
				<?php }?>
				<br />
				<?php if(!empty($to_buy) || $to_buy > 0){
				   $a_key = get_post_meta($wdm_auction->ID, 'wdm-auth-key', true);
				   
				   $acc_mode = get_option('wdm_account_mode');
	
				   if($acc_mode == 'Sandbox')
					  $pp_link  = "https://sandbox.paypal.com/cgi-bin/webscr";
				   else
					  $pp_link  = "https://www.paypal.com/cgi-bin/webscr";
				   if(is_user_logged_in()){?>
				<!--buy now button-->
				<div id="wdm_buy_now_section">
					<div id="wdm-buy-line-above" >
				<form action="<?php echo $pp_link; ?>" method="post" target="_top">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="charset" value="utf-8" />
				<input type="hidden" name="business" value="<?php echo get_option('wdm_paypal_address');?>">
				<!--<input type="hidden" name="lc" value="US">-->
				<input type="hidden" name="item_name" value="<?php echo $wdm_auction->post_title;?>">
				<input type="hidden" name="amount" value="<?php echo $buy_now_price; ?>">
				<?php $shipping_field = '';
				      echo apply_filters('ua_product_shipping_cost_field', $shipping_field, $wdm_auction->ID);
				?>
				<input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>">
				<input type="hidden" name="return" value="<?php echo get_permalink().$set_char."ult_auc_id=".$wdm_auction->ID; ?>">
				<input type="hidden" name="button_subtype" value="services">
				<input type="hidden" name="no_note" value="0">
				<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
				<input type="submit" value="Buy it now for <?php echo $currency_code." ".$buy_now_price;?>" id="wdm-buy-now-button">
				</form>
					</div>
			        </div> <!--wdm_buy_now_section ends here-->
				
				<script type="text/javascript">
				   jQuery(document).ready(function(){
				   jQuery("#wdm_buy_now_section form").click(function(){
				   var cur_val = jQuery("#wdm_buy_now_section form input[name='return']").val();
				   jQuery("#wdm_buy_now_section form input[name='return']").val(cur_val+"&wdm="+"<?php echo $a_key;?>");
				   });
		
			    });
			       </script>
				<?php }
				else{?>
				   <div id="wdm_buy_now_section">
					  <div id="wdm-buy-line-above" >
					  <a class="wdm-login-to-buy-now" href="<?php echo wp_login_url(site_url( $_SERVER['REQUEST_URI'] )); ?>" title="Login">
						 Buy it now for <?php echo $currency_code." ".$buy_now_price;?>
					  </a>
					  </div>
				   </div>
				   <?php
				   }
				}
				   do_action('ua_add_shipping_cost_view_field', $wdm_auction->ID); //SHP-ADD hook to add new product data
				}
				?>
			    </div> <!--wdm_single_prod_desc ends here-->
			
		</div> <!--wdm-ultimate-auction-container ends here-->
		
		<div id="wdm_auction_desc_section">
			<div class="wdm-single-auction-description">
				<strong>Descrição</strong>
				<br />
				<?php echo $wdm_auction->post_content; ?>
			</div>
			
		</div> <!--wdm_auction_desc_section ends here-->
			
		<?php 	
			require_once('auction-description-tabs.php'); //file to display current auction description tabs section
		?>
		<!--script to show small images in main image container-->
		<script type="text/javascript">
		jQuery(document).ready(function(){
		jQuery(".wdm-image-container img.auction-small-img").click(function(){
			var src = jQuery(this).attr("src");
			jQuery("img.auction-main-img").attr("src",src);
			});
		});
		</script>
		<?php
	}
	}
	else{
		//file auction listing page
		require_once('auction-feeder-page.php');	
	}	
}

//shortcode to display entire auction posts on the site
add_shortcode('wdm_auction_listing', 'wdm_auction_listing');
?>