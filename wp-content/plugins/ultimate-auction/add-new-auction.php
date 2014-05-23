<?php
$post_id;
if(!empty($_POST)){
    if(isset($_POST['ua_wdm_add_auc']) && wp_verify_nonce($_POST['ua_wdm_add_auc'],'ua_wp_n_f')){
    $auction_title=(!empty($_POST["auction_title"])) ? ($_POST["auction_title"]):'';
    $auction_content=(!empty($_POST["auction_description"])) ? ($_POST["auction_description"]):'';
    
    $auc_end_tm = isset($_POST["end_date"]) ? strtotime($_POST["end_date"]) : 0;
    $blog_curr_tm = strtotime(date("Y-m-d H:i:s", time()));
    
    if(($auc_end_tm > $blog_curr_tm) && $auction_title!="" && $auction_content!=""){
        global $post_id;
        $is_update=false;
        $reactivate=false;
        
        //update auction mode
        if(isset($_POST["update_auction"]) && !empty($_POST["update_auction"]) && !isset($_GET["reactivate"])){
            $post_id=$_POST["update_auction"];
            
            $args=array(
                        'ID'    => $post_id,
                        'post_title' => $auction_title,
                        'post_content' => $auction_content
                        );
            wp_update_post( $args );
            $is_update = true;
            
        }
        //reactivate auction mode
        elseif(isset($_POST["update_auction"]) && !empty($_POST["update_auction"]) && isset($_GET["reactivate"]))
        {
            $args = array(
            'post_title'    => wp_strip_all_tags( $auction_title ),//except for title all other fields are sanitized by wordpress
            'post_content'  => $auction_content,
            'post_type'     => 'ultimate-auction',
            'post_status'   => 'publish'
            );
            $post_id = wp_insert_post($args);
            $this->wdm_set_auction($post_id);
            $this->auction_id=$post_id;
            $reactivate = true;
        }
        //create/add auction mode
        else{
            $args = array(
                'post_title'    => wp_strip_all_tags( $auction_title ),//except for title all other fields are sanitized by wordpress
                'post_content'  => $auction_content,
                'post_type'     => 'ultimate-auction',
                'post_status'   => 'publish'
                );
            $post_id = wp_insert_post($args);
            $this->wdm_set_auction($post_id);
            $this->auction_id=$post_id;
            }

        if($post_id){
	    $get_default_timezone = get_option('wdm_time_zone');
    
	    if(!empty($get_default_timezone))
	    {
		date_default_timezone_set($get_default_timezone);
	    }
	    
            echo '<div id="message" class="updated fade">';
            echo "<p><strong>Auction ";
            if($is_update)
		echo "updated";
            elseif($reactivate)
	    {
		echo "reactivated";
		update_post_meta($post_id, 'wdm-auth-key',md5(time().rand()));
		add_post_meta($post_id, 'wdm_creation_time', date("Y-m-d H:i:s", time()));
	    }
            else
	    {
		echo "created";
		update_post_meta($post_id, 'wdm-auth-key',md5(time().rand()));
		add_post_meta($post_id, 'wdm_creation_time', date("Y-m-d H:i:s", time()));
	    }
            echo " successfully. Auction id is ".$post_id."</strong></p></div>";
            
            $temp = term_exists('live', 'auction-status');
            wp_set_post_terms($post_id, $temp["term_id"], 'auction-status');
            
            //update options
	    for($u=1; $u<=4; $u++)
	    {
		update_post_meta($post_id, "wdm-image-".$u,$_POST["auction_image_".$u]);
	    }
        
	    
	    update_post_meta($post_id, 'wdm-main-image',$_POST["auction_main_image"]);
            update_post_meta($post_id, 'wdm_listing_ends', $_POST["end_date"]);
            update_post_meta($post_id, 'wdm_opening_bid', round($_POST["opening_bid"], 2));
            update_post_meta($post_id, 'wdm_lowest_bid', round($_POST["lowest_bid"], 2));
            update_post_meta($post_id, 'wdm_buy_it_now', round($_POST["buy_it_now_price"], 2));
            update_post_meta($post_id, 'wdm_incremental_val', round($_POST["incremental_value"], 2));
            update_post_meta($post_id, 'wdm_payment_method', $_POST["payment_method"]);
			for($im=1; $im<=4; $im++)
			{
				if(get_post_meta($post_id,'wdm-main-image',true) == 'main_image_'.$im)
					{
						$main_image = get_post_meta($post_id,'wdm-image-'.$im,true);
						update_post_meta($post_id, 'wdm_auction_thumb', $main_image);
					}
			}
	   
	}
    }
    elseif($auc_end_tm <= $blog_curr_tm)
    {
		
    ?>	<div id="message" class="error">
	    <p><strong>Please enter a future date/time.</strong></p>
	</div>
    <?php
	
    }
    else{
    ?> 
    <div id="message" class="error"><p><strong>Auction title and Auction description cannot be left blank</strong></p></div>
    <?php
    }
}
else{
    die('Sorry, your nonce did not verify.');
}
}
$wdm_post=$this->wdm_get_post();

//Currency Code
$currency_code = substr(get_option('wdm_currency'), -3);
?>

<!--form to add/update an auction-->
<form id="wdm-add-auction-form" class="auction_settings_section_style" action="" method="POST">
    <?php
    if($wdm_post["title"]!="")
    echo "<h3>Update Auction</h3>";
    else
    echo "<h3>Add New Auction</h3>";
    ?>
    <table class="form-table">
    <tr valign="top">
        <th scope="row">
            <label for="auction_title">Product Title</label>
        </th>
        <td>
            <input name="auction_title" type="text" id="auction_title" class="regular-text" value="<?php echo $wdm_post["title"];?>"/>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="auction_description">Product Description</label>
        </th>
        <td>
            <textarea name="auction_description" type="text" id="auction_description" cols="50" rows="10" class="large-text code"><?php echo $wdm_post["content"];?></textarea>
        </td>
    </tr>
	<?php for($p=1; $p<=4; $p++)
	{
		$single_img = $this->wdm_post_meta("wdm-image-".$p);
		
		echo '<tr valign="top">
        <th scope="row">
            <label for="auction_image_'.$p.'">Product Image '.$p.'</label>
        </th>
        <td>
            <input name="auction_image_'.$p.'" type="text" id="auction_image_'.$p.'" class="regular-text wdm_image_'.$p.'_url url" value="'.$single_img.'"/>
            <input name="wdm_upload_image_'.$p.'_button" id="wdm_image_'.$p.'_url" class="button wdm_auction_image_upload" type="button" value="Select File"/>
        </td>
    </tr>';
	}
	?>
    
	    <tr valign="top">
        <th scope="row">
            <label for="auction_main_image">Thumbnail Image</label>
        </th>
        <td>
            <select id="auction_main_image" name="auction_main_image">
                <?php for($m=1; $m<=4; $m++)
				{
				?>
				<option value="main_image_<?php echo $m;?>" <?php echo $this->wdm_post_meta("wdm-main-image") == "main_image_".$m ? "selected" : "";?>>Product Image <?php echo $m;?></option>
				<?php 
				}
				?>
            </select>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="opening_bid">Opening Bid</label>
        </th>
        <td>
            <?php echo $currency_code;?>
            <input name="opening_bid" type="text" id="opening_bid" class="small-text number" min="0" value="<?php echo $this->wdm_post_meta('wdm_opening_bid');?>"/>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="lowest_bid">Lowest Price to Accept</label>
        </th>
        <td>
            <?php echo $currency_code;?>
            <input name="lowest_bid" type="text" id="lowest_bid" class="small-text number" min="0" value="<?php echo $this->wdm_post_meta('wdm_lowest_bid');?>"/>
	    <div>
		<span class="ult-auc-settings-tip">Set Reserve price for your auction.</span>
	    <a href="" class="auction_fields_tooltip"><strong>?</strong>
	    <span>A reserve price is the lowest price at which you are willing to sell your item. If you don’t want to sell your item below a certain price, you can a set a reserve price. The amount of your reserve price is not disclosed to your bidders, but they will see that your auction has a reserve price and whether or not the reserve has been met. If a bidder does not meet that price, you're not obligated to sell your item.
	    <br /><strong>Why have a reserve price?</strong><br />
	    Many sellers have found that too high a starting price discourages interest in their item, while an attractively low starting price makes them vulnerable to selling at an unsatisfactorily low price. A reserve price helps with this.
	    </span>
	    </a>
	    </div>
	</td>
    </tr>
        <tr valign="top">
        <th scope="row">
            <label for="incremental_value">Incremental Value</label>
        </th>
        <td>
            <?php echo $currency_code;?>
            <input name="incremental_value" type="text" id="incremental_value" class="small-text number" min="0" value="<?php echo $this->wdm_post_meta('wdm_incremental_val');?>"/>
	    <div class="ult-auc-settings-tip">Set an amount from which next bid should start.</div>
	</td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="end_date">Ending Date</label>
        </th>
        <td>
            <input name="end_date" type="text" id="end_date" class="regular-text" readOnly  value="<?php echo $this->wdm_post_meta('wdm_listing_ends');?>"/>
	    <?php $def_timezone = get_option('wdm_time_zone');
	    if(!empty($def_timezone))
		echo 'Current blog time is <strong>'.date("Y-m-d H:i:s", time()).'</strong> Timezone: <strong>'.$def_timezone.'</strong>';
	    else 
		echo 'Please select your Timezone at <a href="'.admin_url('admin.php?page=ultimate-auction').'">Settings </a> Tab of the plugin.';
	    ?> 
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="buy_it_now_price">Buy Now Price</label>
        </th>
        <td>
	    <div class="paypal-config-note-text" style="float: right;width: 530px;">
		
		<span class="pp-please-note">Please note:</span> <br />
		
		<span class="pp-url-notification">
		    It is mandatory to set an auto return URL (if not already set) in your PayPal account for proper functioning of this feature.
		</span>
		
		<a href="" class="auction_fields_tooltip"><strong>?</strong>
		<span style="width: 370px;margin-left: -90px;">
		    Whenever a visitor clicks on 'Buy it Now' button, he is redirected to PayPal where he can make payment for this product/auction.
		    <br />
		    After making payment he is again redirected to your site if return URL has been set into your PayPal account and then only auction can be expired.
		</span>
		</a>
		<br />
		<a href="" id="how-set-pp-auto-return">How to set return URL?</a>
		<br />
		<div id="wdm-steps-to-be-followed" style="display: none;">
		<br />
		    1. i) Log in to your PayPal account <a href='https://www.paypal.com/us/cgi-bin/webscr?cmd=_account' target='_blank'>Live</a>
		    / <a href='https://sandbox.paypal.com/us/cgi-bin/webscr?cmd=_account' target='_blank'>Sandbox</a>.<br />
		    ii) Click the <strong>Profile</strong> subtab under <strong>My Account</strong>.<br />
		    iii) Click the <strong>My Selling Tools</strong> link in the left column.<br />
		    iv) Under the <strong>Selling Online</strong> section, click the <strong>Update</strong> link in the row for <strong>Website Preferences</strong>.<br />
		    
		    OR
		    
		    <br />
		   
		    If you are unable to find/open above section in your account, click on the following link to directly open above page -
		    <span class="pp-url-notification">
			(Please make sure that you have logged into your account before clicking the link since if you log in after clicking it, you might be redirected to main Profile page)
		    </span>
		    
		    <a href='https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-website-payments' target='_blank'>Live</a>
		    / <a href='https://www.sandbox.paypal.com/us/cgi-bin/webscr?cmd=_profile-website-payments' target='_blank'>Sandbox</a>
		    
		   <br />
		   <br />
		   2. The <strong>Website Payment Preferences</strong> page appears, click the <strong>On</strong> radio button to enable <strong>Auto Return</strong>.<br />
		   <br />
		   3. Set an URL in <strong>Return URL</strong> box. e.g. you can set URL of your current site i.e. <?php echo get_bloginfo('url');?><br />
		    <span class="pp-url-notification">(If the URL is not properly formatted or cannot be validated, PayPal will not activate Auto Return)</span> <br />
		   <br /> 4. Scroll down and click the <strong>Save</strong> button.
		</div>
		
	    </div>
            <?php echo $currency_code;?>
            <input name="buy_it_now_price" type="text" id="buy_it_now_price" class="small-text number" min="1" value="<?php echo $this->wdm_post_meta('wdm_buy_it_now');?>"/>
            <div class="ult-auc-settings-tip" >Visitors can buy your auction by making payments via PayPal.</div>
	    
	</td>
    </tr>
    <?php do_action('ua_add_shipping_cost_input_field'); //SHP-ADD hook to add new price field ?>
    <tr valign="top">
        <th scope="row">
            <label for="payment_method">Payment Method</label>
        </th>
        <td>
            <?php   $paypal_enabled = get_option('wdm_paypal_address');
                    $wire_enabled = get_option('wdm_wire_transfer');
                    $mailing_enabled = get_option('wdm_mailing_address');
            ?>
            <select id="payment_method" name="payment_method">
                <option id="wdm_method_paypal" value="method_paypal" <?php if($this->wdm_post_meta('wdm_payment_method') == "method_paypal") echo "selected"; if(empty($paypal_enabled)) echo "disabled='disabled'";?>>PayPal</option>
                <option id="wdm_method_wire_transfer" value="method_wire_transfer" <?php if($this->wdm_post_meta('wdm_payment_method') == "method_wire_transfer") echo "selected"; if(empty($wire_enabled)) echo "disabled='disabled'";?>>Wire Transfer</option>
                <option id="wdm_method_mailing" value="method_mailing" <?php if($this->wdm_post_meta('wdm_payment_method') == "method_mailing") echo "selected"; if(empty($mailing_enabled)) echo "disabled='disabled'";?>>By Cheque</option>
            </select>
	    <div class="ult-auc-settings-tip">Only those methods will be active for which you’ve entered details inside plugin’s settings page.</div>
        </td>
    </tr>
    </table>
    <?php
    global $post_id;
    if(isset($_GET["edit_auction"]) && !empty($_GET["edit_auction"])){//user came here from manage auction table
        echo "<input type='hidden' value='".$_GET["edit_auction"]."' name='update_auction'>";
    }
    else if($post_id != "")//user came here after clicking on submit button
    echo "<input type='hidden' value='".$post_id."' name='update_auction'>";
    echo wp_nonce_field('ua_wp_n_f','ua_wdm_add_auc');
    ?>
    
    <?php submit_button(); ?>
</form>

<!--script to handle image upload and date picker functionality-->
<script type="text/javascript">
    jQuery(document).ready(function($){
        var x;
        jQuery(".wdm_auction_image_upload").click(function(){
            tb_show('', 'media-upload.php?type=image&TB_iframe=true');
            x=jQuery(this).attr("id");
            return false;
            });
        
        window.send_to_editor = function(html) {
            imgurl = jQuery('img',html).attr('src');
            jQuery('.'+x).val(imgurl);
            tb_remove();
            }
           
        jQuery('#end_date').datetimepicker({
            timeFormat: "HH:mm:ss",
            dateFormat : 'yy-mm-dd'
            });
	
	jQuery("#how-set-pp-auto-return").click(
	    function(){
		jQuery("#wdm-steps-to-be-followed").slideToggle('slow');
		jQuery("html, body").animate({scrollTop: jQuery("#wdm-steps-to-be-followed").offset().top});
		return false;
	    }
         );
        });
</script>