<script type="text/javascript">
jQuery(document).ready(function($){
       var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
       $('#wdm-cancel-bidder-<?php echo $bidder_id;?>').click(function(){
        
        var cnf = confirm("Are you sure to cancel last bid entry? All data related to bid and it's bidder will be deleted.");
        
        if(cnf == true){
        $(this).html("Cancelling <img src='<?php echo plugins_url('/img/ajax-loader.gif', dirname(__FILE__) );?>' />");       
	var data = {
		action:'cancel_last_bid',
                cancel_id:'<?php echo $bidder_id;?>',
                bidder_name: '<?php echo esc_js($bidder_name);?>'
	    };
	    $.post(ajaxurl, data, function(response) {
                $('#wdm-cancel-bidder-<?php echo $bidder_id;?>').html("Cancel Last Bid");
                alert(response);
                window.location.reload();
	    });
        }
        return false;
	 
        });
       
    });
</script>