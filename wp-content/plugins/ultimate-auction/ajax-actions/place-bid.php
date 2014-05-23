<script type="text/javascript">
jQuery(document).ready(function($){
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    
    $("#wdm-place-bid-now").click(function(){

	var bid_val = new Number;
	bid_val = $("#wdm-bidder-bidval").val().replace(",", ".");


	if(!bid_val)
	{
	    alert('Coloque o valor do lance');
	}
	else if( bid_val && isNaN(bid_val))
	{
	    alert('Coloque um valor numérico');
	}
	else
	{
	     var data = {
		action: 'place_bid_now',
		name: "<?php echo esc_js($auction_bidder_name);?>",
                email: "<?php echo $auction_bidder_email;?>",
                bid: $("#wdm-bidder-bidval").val().replace(",", "."),
                auction_id: "<?php echo $wdm_auction->ID; ?>"
	    };
	    $.post(ajaxurl, data, function(response) {
		
		var latest_bid;
		var curr_next_bid = new Number;
		curr_next_bid = "<?php echo $inc_price; ?>";
		
		if(response.indexOf("inv_bid") != -1)
		{
		    latest_bid = response.replace("inv_bid","");
		    
		    if(Number(bid_val) >= Number(curr_next_bid))
			alert("Opa, alguém acabou de fazer esse lance. Por favor, tente um maior ou igual a " + latest_bid);
		    else
		    {
			alert("Coloque um valor maior ou igual a " + latest_bid);
			return false;
		    }
		    location.reload(true);
		}
		else if(response.indexOf("Won") != -1)
		{
		    alert("Lance computado com sucesso!");
		    alert("Congratulations! You have won this auction since your bid value has reached the 'Buy Now' price.");
		    
		    var w_data = {
				    action: 'bid_notification',
				    email_type: 'winner_email',
				    name: "<?php echo esc_js($auction_bidder_name);?>",
				    email: "<?php echo $auction_bidder_email;?>",
				    bid: $("#wdm-bidder-bidval").val().replace(",", "."),
				    auction_id: "<?php echo $wdm_auction->ID; ?>",
				    auc_name: "<?php echo esc_js($wdm_auction->post_title); ?>",
				    auc_desc: "<?php echo esc_js($wdm_auction->post_content); ?>",
				    auc_url: "<?php echo get_permalink();?>",
				    char: "<?php echo $set_char;?>"
			};
			
			$.post(ajaxurl, w_data, function(resp) {location.reload(true);});
		}
		else if(response.indexOf("Placed") != -1)
		{
		    alert("Lance computado com sucesso!");
		   
		    var b_data = {
				    action: 'bid_notification',
				    name: "<?php echo esc_js($auction_bidder_name);?>",
				    email: "<?php echo $auction_bidder_email;?>",
				    bid: $("#wdm-bidder-bidval").val().replace(",", "."),
				    auction_id: "<?php echo $wdm_auction->ID; ?>",
				    auc_name: "<?php echo esc_js($wdm_auction->post_title); ?>",
				    auc_desc: "<?php echo esc_js($wdm_auction->post_content); ?>",
				    auc_url: "<?php echo get_permalink();?>",
				    char: "<?php echo $set_char;?>"
			};
			
			$.post(ajaxurl, b_data, function(r) {location.reload(true);});
		}
		else
		{
		   alert("Sorry, your bid could not be placed");
		   location.reload(true);
		}
		
                $("#wdm-bidder-bidval").val("").replace(",", ".");
		
	    });
	}
        
        return false;
        });
    
    });
</script>