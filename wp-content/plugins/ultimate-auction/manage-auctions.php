<?php
if( ! class_exists( 'WP_List_Table' ) ) {
require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
$this->auction_type = isset($_GET["auction_type"]) ? $_GET["auction_type"]:"live";

class Auctions_List_Table extends WP_List_Table {        
    var $allData;
    var $auction_type;
         
    function wdm_get_data(){
        if(isset($_GET["auction_type"]) && $_GET["auction_type"]=="expired")
        {
            $args = array(
                'posts_per_page'  => -1,
                'post_type'       => 'ultimate-auction',
                'auction-status'  => 'expired'
                );
        }
	else
        {
            $args = array(
                'posts_per_page'  => -1,
                'post_type'       => 'ultimate-auction',
                'auction-status'  => 'live'
                );
        }
        
        $auction_item_array = get_posts( $args );
        $data_array=array();
        
        foreach($auction_item_array as $single_auction){
            
            $act_term = wp_get_post_terms($single_auction->ID, 'auction-status',array("fields" => "names"));
            if(mktime() >= strtotime(get_post_meta($single_auction->ID,'wdm_listing_ends',true))){
				if(!in_array('expired',$act_term))
				{
					$check_tm = term_exists('expired', 'auction-status');
					wp_set_post_terms($single_auction->ID, $check_tm["term_id"], 'auction-status');
				}
            }
            
            $row = array();
            $row['ID']=$single_auction->ID;
            $row['title']=$single_auction->post_title;
            $end_date = get_post_meta($single_auction->ID,'wdm_listing_ends', true);
            $row['date_created']= "<strong> Creation Date:</strong> <br />".get_post_meta($single_auction->ID, 'wdm_creation_time', true)." <br /><br /> <strong> Ending Date:</strong> <br />".$end_date;
            $row['image_1']="<img src='".get_post_meta($single_auction->ID,'wdm_auction_thumb', true)."' width='90'";
            
            if($this->auction_type=="live")
            {
                $row['action']="<a href='?page=add-new-auction&edit_auction=".$single_auction->ID."'>Edit</a> <br /><br /> <div id='wdm-delete-auction-".$single_auction->ID."' style='color:red;cursor:pointer;'>Delete <span class='auc-ajax-img'></span></div> <br /> <div id='wdm-end-auction-".$single_auction->ID."' style='color:#21759B;cursor:pointer;'>End Auction</div>";
                require('ajax-actions/end-auction.php');
            }
            else
            $row['action']="<div id='wdm-delete-auction-".$single_auction->ID."' style='color:red;cursor:pointer;'>Delete <span class='auc-ajax-img'></span></div><br /><a href='?page=add-new-auction&edit_auction=".$single_auction->ID."&reactivate'>Reactivate</a>";
            
            //for bidding logic
            $row['bidders'] = "";
            $row_bidders = "";
            global $wpdb;
            $currency_code = substr(get_option('wdm_currency'), -3);
            $query = "SELECT * FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$single_auction->ID." ORDER BY date DESC LIMIT 5";
            $results = $wpdb->get_results($query);
            
            if(!empty($results)){
                $cnt_bidder = 0;
                foreach($results as $result){
                    $row_bidders.="<li><strong><a href='#'>".$result->name."</a></strong> - ".$currency_code." ".$result->bid."</li>";
                    if($cnt_bidder == 0 )
                    {
                        $bidder_id = $result->id;
                        $bidder_name = $result->name;
                    }
                    
                    $cnt_bidder++;
                }
                $row["bidders"] = "<div class='wdm-bidder-list-".$single_auction->ID."'><ul>".$row_bidders."</ul></div>";
                $row["bidders"] .="<div id='wdm-cancel-bidder-".$bidder_id."' style='font-weight:bold;color:#21759B;cursor:pointer;'>Cancel Last Bid</div>";
                $qry = "SELECT * FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$single_auction->ID." ORDER BY date DESC";
                $all_bids = $wpdb->get_results($qry);
                if(count($all_bids) > 5)
                $row["bidders"] .="<br />
                <a href='#' class='see-more showing-top-5' rel='".$single_auction->ID."' >See more</a>";
                require('ajax-actions/cancel-bidder.php');
            }
            else{
                $row["bidders"] = "No bids placed";
            }
          
            $start_price = get_post_meta($single_auction->ID,'wdm_opening_bid', true);
            $buy_it_now_price = get_post_meta($single_auction->ID,'wdm_buy_it_now',true);
	    
	    $row['current_price']  = "";
	    $row['final_price']  = "";
	    if(empty($start_price) && !empty($buy_it_now_price))
	    {
		$row['current_price']  = "<strong>Buy Now Price:</strong> <br />".$currency_code." ".$buy_it_now_price;
		$row['final_price']  = "<strong>Buy Now Price:</strong> <br />".$currency_code." ".$buy_it_now_price;
	    }
	    elseif(!empty($start_price))
	    {
		$query="SELECT MAX(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$single_auction->ID;
		$curr_price = $wpdb->get_var($query);
		
		if(empty($curr_price))
			$curr_price = $start_price;
            
		$row['current_price']  = "<strong>Starting Price:</strong> <br />".$currency_code." ".$start_price;
		$row['current_price'] .= "<br /><br /> <strong>Current Price:</strong><br /> ".$currency_code." ".$curr_price;
		
		$row['final_price']  = "<strong>Starting Price:</strong> <br />".$currency_code." ".$start_price;
		$row['final_price'] .= "<br /><br /> <strong>Final Price:</strong><br /> ".$currency_code." ".$curr_price;
	    }
	    
            if($this->auction_type === "expired")
            {
                $row['email_payment'] = "";
                
                if(get_post_meta($single_auction->ID,'auction_bought_status',true) === 'bought')
                {
                    $row['email_payment'] = "<span class='wdm-auction-bought'>Auction has been bought by paying Buy Now price [".$currency_code." ".$buy_it_now_price."] </span>";
                }
                
                else
                {
                    if(!empty($results))
                    {
			$reserve_price_met = get_post_meta($single_auction->ID, 'wdm_lowest_bid',true);
		    
			$bid_qry = "SELECT MAX(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$single_auction->ID;
			$winner_bid = $wpdb->get_var($bid_qry);
			
			if($winner_bid >= $reserve_price_met)
			{
			    $email_qry = "SELECT email FROM ".$wpdb->prefix."wdm_bidders WHERE bid =".$winner_bid." AND auction_id =".$single_auction->ID;
			    $winner_email = $wpdb->get_var($email_qry);
			    
			    $email_sent = get_post_meta($single_auction->ID,'auction_email_sent',true);
			    
			    $row['email_payment']  = "<strong>Status: </strong>";
			    if($email_sent === 'sent')
				$row['email_payment'] .= "<span style='color:green'>Yes</span>";
			    else
				$row['email_payment'] .= "<span style='color:red'>No</span>";
                            
				$row['email_payment'] .= "<br/><br/> <a href='' id='auction-resend-".$single_auction->ID."'>Resend</a>";
                            
			    require('ajax-actions/resend-email.php');
			}
			else
			{
			    $row['email_payment'] = "<span style='color:#D64B00'>Auction has expired without reaching its reserve price</span>";
			}
                    }
                }
            }
            
            $data_array[]=$row;
            
            require('ajax-actions/delete-auction.php');
        }
        $this->allData=$data_array;
        return $data_array;            
    }               
               
    function get_columns(){
    if($this->auction_type=="live")
    $columns =   array(
    //'ID'        => 'Auction ID',
    'image_1'   => 'Image',
    'title' => 'Title',
    'date_created' => 'Creation / Ending Date',
    'current_price' => 'Starting / Current Price',
    'bidders'   => 'Bids Placed',
    'action'    => 'Actions'
    );
    else
    $columns =   array(
    //'ID'        => 'Auction ID',
    'image_1'   => 'Image',
    'title' => 'Title',
    'date_created' => 'Creation / Ending Date',
    'final_price' => 'Starting / Final Price',
    'bidders'   => 'Bids Placed',
    'email_payment'   => 'Email For Payment',
    'action'    => 'Actions'
    );
    return $columns;  
    }
    
    function get_sortable_columns(){
        $sortable_columns = array(
                        'ID' => array('ID',false),
                        'title' => array('title',false)
                        //'date_created' => array('date_created',false)
                        );
        return $sortable_columns;
    }
    
    function prepare_items() {
    $this->auction_type = (isset($_GET["auction_type"]) && $_GET["auction_type"]=="expired")?"expired":"live";
    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    $this->_column_headers = array($columns, $hidden, $sortable);
    $this->items = $this->wdm_sort_array($this->wdm_get_data());
    }
    
    function get_result_e(){
        return $this->allData;    
    }
      
    function wdm_sort_array($args){
        if(!empty($args))
        {
        $orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'ID';
	
	if($orderby === 'title')
	    $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
	else
	    $order = 'desc';
	
        foreach ($args as $array) {
            $sort_key[] = $array[$orderby];
        }
        if($order=='asc')
            array_multisort($sort_key,SORT_ASC,$args);
        else
            array_multisort($sort_key,SORT_DESC,$args);
        } 
        return $args;
    }
    
    function column_default( $item, $column_name ) {
        switch( $column_name ) {
            case 'ID':
            case 'image_1':
            case 'title':
            case 'date_created':
            case 'action':
            case 'bidders':
            case 'current_price':
            case 'final_price':
            case 'email_payment':    
            return $item[ $column_name ];
            default:
            return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
        }
    }

}

if( isset( $_GET[ 'auction_type' ] ) ) {  
    $manage_auction_tab = $_GET[ 'auction_type' ];  
} 
else
$manage_auction_tab = 'live';  
?>
<ul class="subsubsub">
    <li><a href="?page=manage_auctions&auction_type=live" class="<?php echo $manage_auction_tab == 'live' ? 'current' : ''; ?>">Live Auctions</a>|</li>
    <li><a href="?page=manage_auctions&auction_type=expired" class="<?php echo $manage_auction_tab == 'expired' ? 'current' : ''; ?>">Expired Auctions</a>|</li>
    <li><a href="?page=manage_auctions&auction_type=csv" class="<?php echo $manage_auction_tab == 'csv' ? 'current' : ''; ?>">CSV</a></li>
</ul>
<br class="clear">
<?php
//Armengue do Lechuga

if(isset($_GET["auction_type"]) && $_GET["auction_type"]=="csv"){
	$args = array(
		'posts_per_page'  => -1,
		'post_type'	=> 'ultimate-auction',
		'orderby'     => 'ID',
		'order'       => 'ASC',
		'auction-status'  => 'expired'
		);

	$wdm_auction_array = get_posts($args);
	
	echo "produto,status,ganhador,valor<br>";
	foreach($wdm_auction_array as $wdm_single_auction){
		echo "'".$wdm_single_auction->post_title."',";
		echo "expired,";
		
		global $wpdb;
		$query="SELECT MAX(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$wdm_single_auction->ID;
		$curr_price = $wpdb->get_var($query);
	
		$email_qry = "SELECT email FROM ".$wpdb->prefix."wdm_bidders WHERE bid =".$curr_price." AND auction_id =".$wdm_single_auction->ID;
		$winner_email = $wpdb->get_var($email_qry);
		
		
		echo $winner_email.",".$curr_price."<br>";
	}

	$args = array(
		'posts_per_page'  => -1,
		'post_type'	=> 'ultimate-auction',
		'orderby'     => 'ID',
		'order'       => 'ASC',
		'auction-status'  => 'live'
		);

	$wdm_auction_array = get_posts($args);
	
	foreach($wdm_auction_array as $wdm_single_auction){
		echo "'".$wdm_single_auction->post_title."',";
		echo "live,";
		
		global $wpdb;
		$query="SELECT MAX(bid) FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$wdm_single_auction->ID;
		$curr_price = $wpdb->get_var($query);
	
		$email_qry = "SELECT email FROM ".$wpdb->prefix."wdm_bidders WHERE bid =".$curr_price." AND auction_id =".$wdm_single_auction->ID;
		$winner_email = $wpdb->get_var($email_qry);
		
		
		echo $winner_email.",".$curr_price."<br>";
	}
	
}else{
	$myListTable = new Auctions_List_Table();
	$myListTable->prepare_items();
	$myListTable->display();
}
?>