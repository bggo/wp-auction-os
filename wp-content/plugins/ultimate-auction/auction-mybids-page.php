<?
$wdm_auction_array=array();

$args = array(
		'posts_per_page' => -1,
		'post_type'	=> 'ultimate-auction',
		'auction-status'  => 'live',
		'post_status' => 'publish',
		'orderby'     => 'ID',
		'order'       => 'ASC'
		);

	$wdm_auction_array = get_posts($args);
        
		?>
		<div class="wdm-auction-listing-container">
		
			<ul class="wdm_auctions_list">
			<li class="auction-list-menus">
				<ul>
					<li class="wdm-apn auc_single_list"><strong>Produto</strong></li>
					<li class="wdm-apt auc_single_list"><strong></strong></li>
					<li class="wdm-app auc_single_list"><strong>Valor Atual</strong></li>
					<li class="wdm-apb auc_single_list"><strong>Lances</strong></li>
					<li class="wdm-ape auc_single_list"><strong>Final</strong></li>
				</ul>
			</li>
			
		<?php
		//auction listing page container
		foreach($wdm_auction_array as $wdm_single_auction){
			global $wpdb;
			
			$current_user = wp_get_current_user();
			$uid=$current_user->user_login;	
			
			$query="SELECT MAX(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$wdm_single_auction->ID." AND name='".$uid."'";
			$lance = $wpdb->get_var($query);

			if($lance>0){

			$query="SELECT MAX(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$wdm_single_auction->ID;
			$curr_price = $wpdb->get_var($query);
			?>
			<li class="wdm-auction-single-item">
				<a href="<?php echo get_permalink(15)."?ult_auc_id=".$wdm_single_auction->ID; ?>" class="wdm-auction-list-link">
				<ul>
			<li class="wdm-apn auc_single_list">
				<div  class="wdm_single_auction_thumb">
				<img src="<?php echo get_post_meta($wdm_single_auction->ID, 'wdm_auction_thumb', true); ?>" width="100" height="80" alt="<?php echo $wdm_single_auction->post_title; ?>" />
				</div>
			</li>
			
			<li class="wdm-apt auc_single_list">
				<div class="wdm-auction-title"><?php echo $wdm_single_auction->post_title; ?></div>
			</li>
			
			<li class="wdm-app auc_single_list auc_list_center">
			<span class="wdm-auction-price wdm-mark-green">
			<?php
			$cc = substr(get_option('wdm_currency'), -3);
			$ob = get_post_meta($wdm_single_auction->ID, 'wdm_opening_bid', true);
			$bnp = get_post_meta($wdm_single_auction->ID, 'wdm_buy_it_now', true);
			
			if((!empty($curr_price) || $curr_price > 0) && !empty($ob))
				echo "R$ ". $curr_price;
			elseif(!empty($ob))
				echo "R$ ".$ob;
			elseif(empty($ob) && !empty($bnp))
				echo "Buy at R$ ".$bnp;
				?>
			</span>
			</li>
			
			<li class="wdm-apb auc_single_list auc_list_center">
			<?php
			$get_bids = "SELECT COUNT(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$wdm_single_auction->ID;
			$bids_placed = $wpdb->get_var($get_bids);
			if(!empty($bids_placed) || $bids_placed > 0)
				echo "<span class='wdm-bids-avail wdm-mark-normal'>".$bids_placed."</span>";
			else
				echo "<span class='wdm-no-bids-avail wdm-mark-red'>Nenhum Lance</span>";
			?>
			</li>
			
			<li class="wdm-ape auc_single_list auc_list_center">
				<?php
				$now = mktime(); 
				$ending_date = strtotime(get_post_meta($wdm_single_auction->ID, 'wdm_listing_ends', true));
				$act_trm = wp_get_post_terms($wdm_single_auction->ID, 'auction-status',array("fields" => "names"));
				
				$seconds = $ending_date - $now;
				
				if(in_array('expired',$act_trm))
				{
					echo "<span class='wdm-mark-red'>Expired</span>";
				}
				elseif($seconds > 0 && !in_array('expired',$act_trm))
				{
					$days = floor($seconds / 86400);
					$seconds %= 86400;

					$hours = floor($seconds / 3600);
					$seconds %= 3600;

					$minutes = floor($seconds / 60);
					$seconds %= 60;
					
					if($days > 1)
						echo "<span class='wdm-mark-normal'>". $days ." days</span>";
					elseif($days == 1)
						echo "<span class='wdm-mark-normal'>". $days ." day</span>";	
					elseif($days < 1)
					{
						if($hours > 1)
							echo "<span class='wdm-mark-normal'>". $hours ." hours</span>";
						elseif($hours == 1)
							echo "<span class='wdm-mark-normal'>". $hours ." hour</span>";
						elseif($hours < 1)
						{
							if($minutes > 1)
								echo "<span class='wdm-mark-normal'>". $minutes ." minutes</span>";
							elseif($minutes == 1)
								echo "<span class='wdm-mark-normal'>". $minutes ." minute</span>";
							elseif($minutes < 1)
							{
								if($seconds > 1)
									echo "<span class='wdm-mark-normal'>". $seconds ." seconds</span>";
								elseif($seconds == 1)
									echo "<span class='wdm-mark-normal'>". $seconds ." second</span>";
								else
									echo "<span class='wdm-mark-red'>Expired</span>";
							}
						}
					}
						
				}
				else
				{
					echo "<span class='wdm-mark-red'>Expired</span>";
				}

				?>
				<br/>
			</li>
			<div class="wdm-apd"><?php echo substr( strip_tags($wdm_single_auction->post_content),  0, 100) . " .."; ?> </div>
				</ul>
				</a>
			</li>
			<?php
		}
}
?>

</ul>
</div>