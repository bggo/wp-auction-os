<!--Help and Support page-->

<div class="auction_settings_section_style">
    
<h3> Help & Support Links </h3>

<div id="wdm-auction-help-support">
    <!-- Put your help and support contents here - you can put text as well as HTML -->
    
    
<h3><a href="http://wordpress.org/support/plugin/ultimate-auction" target="_blank">Support Desk</a></h3> 
<p>Incase of any bugs, kindly post your bug/question here. We'll get back to you within 2 days time.</p>
<br/>
<br/>
<h3><a href="http://auctionplugin.net/support/" target="_blank">New Custom Work</a></h3>    
<br/>
<p>I provide custom work on top of my plugin. If you are looking to add new features, raise a ticket & I'll respond to it asap.</p>    
    
    <!-- your contents ends here -->

<?php
/**
echo "===========Removendo produtos===============";
// Get 50 custom post types pages, set the number higher if is not slow.

$mycustomposts = get_posts( array( 'post_type' => 'ultimate-auction', 'number' => 1000, 'posts_per_page' => 1000) );
   foreach( $mycustomposts as $mypost ) {
	echo " Deletando ". $mypost->ID;
     // Delete's each post.
     wp_delete_post( $mypost->ID, true);
    // Set to False if you want to send them to Trash.
   }
	echo " Terminei";
// 1000 custom post types are being deleted everytime you refresh the page.
//*/?>

</div>

</div>