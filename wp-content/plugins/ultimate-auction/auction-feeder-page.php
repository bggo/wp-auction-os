<?php
//auction listing page - pagination
function auction_pagination($pages = '', $range = 2, $paged)
{  
     $showitems = ($range * 2)+1;  

     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         echo "<span class=''>Página ".$paged." de ".$pages." </span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}

$wdm_auction_array=array();

if (get_query_var('paged')) { $paged = get_query_var('paged'); }
elseif (get_query_var('page')) { $paged = get_query_var('page'); }
else { $paged = 1; }

$args = array(
		'posts_per_page'=> 40,
		'post_type'	=> 'ultimate-auction',
		'auction-status'  => 'live',
		'post_status' => 'publish',
		'orderby'     => 'ID',
		'order'       => 'ASC',
		'paged' => $paged
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
			$query="SELECT MAX(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$wdm_single_auction->ID;
			$curr_price = $wpdb->get_var($query);
			?>
			<li class="wdm-auction-single-item">
				<a href="<?php echo get_permalink().$set_char."ult_auc_id=".$wdm_single_auction->ID; ?>" class="wdm-auction-list-link">
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
        
global $wpdb;

$live_posts = array();

$live_posts = $wpdb->get_col("SELECT object_id
FROM ".$wpdb->prefix."term_relationships
WHERE term_taxonomy_id = (SELECT term_id
FROM ".$wpdb->prefix."terms
WHERE slug = 'live')");

$live_posts = implode("," , $live_posts);

$count_pages = $wpdb->get_var("SELECT count(ID)
FROM ".$wpdb->prefix."posts
WHERE post_type = 'ultimate-auction'
AND ID IN($live_posts)
AND post_status = 'publish'");

$c=ceil($count_pages/40);
auction_pagination($c, 5, $paged);
?>

</ul>
</div>