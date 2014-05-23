<?php
//handle basic plugin settings
if(!class_exists('wdm_settings'))
{
    class wdm_settings{
    
    var $auction_id;
    var $auction_type;
    
    //constructor
    public function __construct(){
        if(is_admin()){
	    //call functions required only in admin section
	    add_action('admin_menu', array($this, 'add_plugin_page'));
	    add_action('admin_init', array($this, 'wdm_page_init'));
            add_action( 'admin_notices', array($this,'wdm_admin_notices_action'));
            add_action( 'admin_enqueue_scripts', array($this,'wdm_enqueue_style') );
            add_action('wp_ajax_wdm_ajax', array($this,'wdm_ajax_callback'));
	}
	//register auction post
        add_action('init',array($this,'wdm_reg_post_contents'));
    }
    
    public function wdm_reg_post_contents(){
        //register custom post ultimate-auction
        $args = array( 'public' => true, 'show_in_menu' => false,'label' => 'Ultimate Auction' );
        register_post_type( 'ultimate-auction', $args );    
        
        //code for adding taxonomy auction-status
        $labels = array(
        'name'                => 'Auction Status'
        ); 	
        $args = array(
        'hierarchical'        => true,
        'labels'              => $labels,
        'show_ui'             => true,
        );   
        register_taxonomy(
                'auction-status',
                'ultimate-auction',
                $args
        );
        //code for adding taxonomy auction-status ends here
        
         //code for adding term live
        if(!term_exists('live', 'auction-status'))
        $r=wp_insert_term(
        'live', // the term 
        'auction-status' // the taxonomy
        );
        
        //code for adding term expired
        if(!term_exists('expired', 'auction-status'))
        $r=wp_insert_term(
        'expired', // the term 
        'auction-status' // the taxonomy
        );
       
        //enqueue validation files
		wp_enqueue_script('wdm_jq_validate', plugins_url('/js/wdm-jquery-validate.js', __FILE__ ), array('jquery'));
		wp_enqueue_script('wdm_jq_valid', plugins_url('/js/wdm-validate.js', __FILE__ ), array('jquery'));
    }
    
    //list bidders Ajax callback - 'See More' link on 'Manage Auctions' page
    public function wdm_ajax_callback(){
	
        global $wpdb;
	
	$currency_code = substr(get_option('wdm_currency'), -3);
	
        if($_POST["show_rows"] == -1)
        $query = "SELECT * FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$_POST["auction_id"]." ORDER BY date DESC";
        else
        $query = "SELECT * FROM ".$wpdb->prefix."wdm_bidders WHERE auction_id =".$_POST["auction_id"]." ORDER BY date DESC LIMIT 5";
	
        $results = $wpdb->get_results($query);
        if(!empty($results)){
            echo "<ul>";
            foreach($results as $result){
                ?>
                <li><strong><a href='#'><?php echo $result->name ?></a></strong> - <?php echo $currency_code." ".$result->bid; ?></li>
                <?php
            }
            echo "</ul>";
        }
        wp_die();
    }
    
    public function wdm_admin_notices_action(){
        settings_errors( 'test_option_group' );
    }
    
    //register menus and submenus
    public function add_plugin_page(){
	$ua_icon_url = plugins_url('img/favicon.png', __FILE__);
        add_menu_page( 'Ultimate Auction', 'Ultimate Auction', 'administrator', 'ultimate-auction', array($this, 'create_admin_page'), $ua_icon_url);
	add_submenu_page( 'ultimate-auction', 'Settings', 'Settings', 'administrator', 'ultimate-auction', array($this, 'create_admin_page') );
	add_submenu_page( 'ultimate-auction', 'Add Auction', 'Add Auction', 'administrator', 'add-new-auction', array($this, 'create_admin_page') );
        add_submenu_page( 'ultimate-auction', 'Manage Auctions', 'Manage Auctions', 'administrator', 'manage_auctions', array($this, 'create_admin_page') );
	do_action('ua_add_auction_submenu', 'ultimate-auction', array($this, 'create_admin_page'));
	add_submenu_page( 'ultimate-auction', 'Help & Support', 'Help & Support', 'administrator', 'help-support', array($this, 'create_admin_page') ); 
    }
    
    //enqueue js and style files to handle datetime picker and image upload 
    public function wdm_enqueue_style(){
        wp_enqueue_style('thickbox');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style('date-picker-style', plugins_url( '/css/jquery-ui.css', __FILE__));
        wp_enqueue_script( 'jquery-timepicker-js', plugins_url( '/js/date-picker.js', __FILE__ ), array('jquery','jquery-ui-datepicker') );
        wp_enqueue_script( 'wdm-ajax-scripts', plugins_url( '/js/wdm-ajax-scripts.js', __FILE__ ), array('jquery') );
        wp_enqueue_style( 'jquery-timepicker-css', plugins_url( '/css/jquery-time-picker.css', __FILE__ ));
    }

    public function create_admin_page(){
        ?>
	<div class="wrap" id="wdm_auction_setID">
	    <?php screen_icon('options-general'); ?>
	    <h2>Ultimate Auction</h2>
          <!--<div id="ultimate-auction-banner"><a href="http://auctionplugin.net" target="_blank"><img src="<?php echo plugins_url('/img/banner.jpg',__FILE__);?>" /></a></div>--> 
            <!--code for displaying tabbed navigation-->
            <?php
            if( isset( $_GET[ 'page' ] ) ) {  
                $active_tab = $_GET[ 'page' ];  
            } //
            else	    
            $active_tab = 'ultimate-auction';
        
            ?>
            <h2 class="nav-tab-wrapper">  
                <a href="?page=ultimate-auction" class="nav-tab <?php echo $active_tab == 'ultimate-auction' ? 'nav-tab-active' : ''; ?>">Settings</a>
		<a href="?page=add-new-auction" class="nav-tab <?php echo $active_tab == 'add-new-auction' ? 'nav-tab-active' : ''; ?>">Add Auction</a>
                <a href="?page=manage_auctions" class="nav-tab <?php echo $active_tab == 'manage_auctions' ? 'nav-tab-active' : ''; ?>">Manage Auctions</a>
		<?php do_action('ua_add_auction_tab', 'page', 'nav-tab', 'nav-tab-active', $active_tab);?>
		<a href="?page=help-support" class="nav-tab <?php echo $active_tab == 'help-support' ? 'nav-tab-active' : ''; ?>">Help & Support</a>
            </h2>  
            <!--#code for displaying tabbed navigation-->
            
            <?php
            if($active_tab=='ultimate-auction'){
            ?>
	    <form id="auction-settings-form" class="auction_settings_section_style" method="post" action="options.php">
	        <?php
		    settings_fields('test_option_group');//adds all the nonce/hidden fields and verifications	
		    do_settings_sections('test-setting-admin');
		    echo wp_nonce_field('ua_setting_wp_n_f','ua_wdm_setting_auc');
		?>
	        <?php submit_button(); ?>
	    </form>
            <?php
            }
            elseif($active_tab=='manage_auctions'){
                require_once('manage-auctions.php');
            }
	    elseif($active_tab=='add-new-auction'){
		require_once('add-new-auction.php');
	    }
	    elseif($active_tab=='help-support'){
		require_once('help-and-support.php');
	    }
	    do_action('ua_call_setting_file', $active_tab);
            ?>
	</div>
	<?php
	
	if( isset( $_GET['settings-updated'] ) ) {
	    echo "<div class='updated'><p><strong>Settings saved.</strong></p></div>";
	} 
    }
    
    //create setting sections under 'Settings' tab to handle plugin configuration options 	
    public function wdm_page_init(){
	
	//enqueue css file for admin section style
	wp_enqueue_style('ult_auc_be_css', plugins_url('/css/ua-back-end.css', __FILE__ ));
	
	register_setting(
                         'test_option_group',//this has to be same as the parameter in settings_fields
                         'wdm_auc_settings_data',//The name of an option to sanitize and save, basically add_option('wdm_auc_settings_data') 
                         array($this, 'wdm_validate_save_data')//callback function for sanitizing data
                         );
	
	 add_settings_section(
	    'payment_section_id',
	    'Payment Settings', 
	    array($this, 'print_payment_info'), 
	    'test-setting-admin' 
	);
	 
	 add_settings_field(
	    'wdm_currency_id', 
	    'Currency', 
	    array($this, 'wdm_currency_field'), 
	    'test-setting-admin', 
	    'payment_section_id' 			
	);
	
	add_settings_field(
	    'wdm_paypal_id', 
	    'PayPal Email Address', 
	    array($this, 'wdm_paypal_field'), 
	    'test-setting-admin', 
	    'payment_section_id' 			
	);
	
	add_settings_field(
	    'wdm_account_mode_id', 
	    'Account Type', 
	    array($this, 'wdm_account_field'), 
	    'test-setting-admin', 
	    'payment_section_id' 			
	);
	
	 add_settings_field(
	    'wdm_wire_transfer_id', 
	    'Wire Transfer Details', 
	    array($this, 'wdm_wire_transfer_field'), 
	    'test-setting-admin', 
	    'payment_section_id' 			
	);
	
	add_settings_field(
	    'wdm_mailing_id', 
	    'Mailing Address', 
	    array($this, 'wdm_mailing_field'), 
	    'test-setting-admin', 
	    'payment_section_id' 			
	);
	
        add_settings_section(
	    'setting_section_id',//this is the unique id for the section
	    'General Settings', //title or name of the section that appears on the page
	    array($this, 'print_section_info'), //callback function
	    'test-setting-admin' //the parameter in do_settings_sections
	);	
	
	add_settings_field(
	    'wdm_email_id', 
	    'Email for receiving bid notification', 
	    array($this, 'wdm_email_field'), 
	    'test-setting-admin', 
	    'setting_section_id' 			
	);
	
	add_settings_field(
	    'wdm_timezone_id', 
	    'Timezone', 
	    array($this, 'wdm_timezone_field'), 
	    'test-setting-admin', 
	    'setting_section_id' 			
	);
	
	add_settings_field(
	    'wdm_powered_by_id', 
	    'Powered By Ultimate Auction', 
	    array($this, 'wdm_powered_by_field'), 
	    'test-setting-admin', 
	    'setting_section_id' 			
	);
	
	//enqueue script to handle validations related to bidding logic
	wp_enqueue_script('wdm_logic_valid', plugins_url('/js/logic-validation.js', __FILE__ ), array('jquery'));
    }
    
    //save/update fields under 'Settings tab'	
    public function wdm_validate_save_data($input){
        $mid = $input;
	
	if(isset($_POST['ua_wdm_setting_auc']) && wp_verify_nonce($_POST['ua_wdm_setting_auc'],'ua_setting_wp_n_f')){
        if(is_email($mid['wdm_auction_email']))
        update_option('wdm_auction_email',$mid['wdm_auction_email']);
        else{
        add_settings_error(
        'test_option_group', // whatever you registered in register_setting
        'wdm-error', // this will be appended to the div ID
        __('Please enter a valid Email address', 'wpse'),
        'error' // error or notice works to make things pretty
        );
        $mid['wdm_auction_email']="";
        }
	
	update_option('wdm_time_zone',$mid['wdm_time_zone']);
	update_option('wdm_currency',$mid['wdm_currency']);
	update_option('wdm_paypal_address',$mid['wdm_paypal_address']);
	update_option('wdm_wire_transfer',$mid['wdm_wire_transfer']);
	update_option('wdm_mailing_address',$mid['wdm_mailing_address']);
	update_option('wdm_powered_by',$mid['wdm_powered_by']);
	update_option('wdm_account_mode',$mid['wdm_account_mode']);
    }
    else{
	die('Sorry, your nonce did not verify.');
    }
	return $mid;
    }

    //'General Settings' section 	
    public function print_section_info(){
	
    }
    
    //'Payment Settings' section 
    public function print_payment_info(){
	
    }
    
    //admin email field
    public function wdm_email_field(){ ?>
        <input class="wdm_settings_input email required" type="text" id="wdm_email_id" name="wdm_auc_settings_data[wdm_auction_email]" value="<?php echo get_option('wdm_auction_email');?>" />
    <?php }
    
    //timezone field
    public function wdm_timezone_field()
    {
	$timezone_identifiers = DateTimeZone::listIdentifiers();
    
	echo "<select class='wdm_settings_input required' id='wdm_timezone_id' name='wdm_auc_settings_data[wdm_time_zone]'>";
	echo "<option value=''>Select your Timezone</option>";
	foreach($timezone_identifiers as $time_ids) {
		$selected = (get_option('wdm_time_zone') == $time_ids) ? 'selected="selected"' : '';
		echo "<option value='$time_ids' $selected>$time_ids</option>";
	}
	echo "</select>";
	echo '<div class="ult-auc-settings-tip">Please select your local Timezone.</div>';
    }
    
    //plugin credit link field - (shown in footer of the site)
    function wdm_powered_by_field(){
	$options = array("No", "Yes");
	add_option('wdm_powered_by','Yes');
	foreach($options as $option) {
		$checked = (get_option('wdm_powered_by')== $option) ? ' checked="checked" ' : '';
		echo "<input ".$checked." value='$option' name='wdm_auc_settings_data[wdm_powered_by]' type='radio' /> $option <br />";
	}
	echo '<div class="ult-auc-settings-tip">Show a stylish footer credit at the bottom of the page on site.</div>';
    }
    
    //currency codes field
    public function wdm_currency_field(){
        $currencies = array(
			    "Australian Dollar - AUD",
			    "Canadian Dollar - CAD",
			    "Euro - EUR",
			    "British Pound - GBP",
			    "Japanese Yen - JPY",
			    "U.S. Dollar - USD",
			    "New Zealand Dollar - NZD",
			    "Swiss Franc - CHF",
			    "Hong Kong Dollar - HKD",
			    "Singapore Dollar - SGD",
			    "Swedish Krona - SEK",
			    "Danish Krone - DKK",
			    "Polish Zloty - PLN",
			    "Norwegian Krone - NOK",
			    "Hungarian Forint - HUF",
			    "Czech Koruna - CZK",
			    "Israeli New Shekel - ILS",
			    "Mexican Peso - MXN",
			    "Brazilian Real - BRL",
			    "Malaysian Ringgit - MYR",
			    "Philippine Peso - PHP",
			    "New Taiwan Dollar - TWD",
			    "Thai Baht - THB",
			    "Turkish Lira - TRY"
			    );
	
	echo "<select class='wdm_settings_input' id='wdm_currency_id' name='wdm_auc_settings_data[wdm_currency]'>";
	foreach($currencies as $currency) {
		$selected = (get_option('wdm_currency') == $currency) ? 'selected="selected"' : '';
		echo "<option value='$currency' $selected>$currency</option>";
	}
	echo "</select>";
	
    }
    
    //PayPal email address of business/merchant account
    public function wdm_paypal_field(){?>
        <input class="wdm_settings_input email" type="text" id="wdm_paypal_id" name="wdm_auc_settings_data[wdm_paypal_address]" value="<?php echo get_option('wdm_paypal_address');?>" />
    <?php
    }
    
    //PayPal account type
     public function wdm_account_field(){
	$options = array("Live", "Sandbox");
	
	add_option('wdm_account_mode','Live');
	
	foreach($options as $option) {
		$checked = (get_option('wdm_account_mode')== $option) ? ' checked="checked" ' : '';
		echo "<input ".$checked." value='$option' name='wdm_auc_settings_data[wdm_account_mode]' type='radio' /> $option <br />";
	}
	echo "<div class='ult-auc-settings-tip'>Select 'Sandbox' option when testing with your sandbox PayPal email address.</div>";
    }
    
    //Wire Transfer details field
    public function wdm_wire_transfer_field(){?>
        <textarea class="wdm_settings_input" id="wdm_wire_transfer_id" name="wdm_auc_settings_data[wdm_wire_transfer]"><?php echo get_option('wdm_wire_transfer');?></textarea>
    <br />
    <div class="ult-auc-settings-tip">Enter your wire transfer details. This will be sent to the highest bidder.</div>
    <?php
    }
    
    //Mailing address field
    public function wdm_mailing_field()
    {
	?>
        <textarea class="wdm_settings_input" id="wdm_mailing_id" name="wdm_auc_settings_data[wdm_mailing_address]"><?php echo get_option('wdm_mailing_address');?></textarea>
    <div class="ult-auc-settings-tip">Enter your mailing address where you want to receive checks by mail. This will be sent to the highest bidder.</div>
    <?php
    }
    
    //handle post meta keys
    public function wdm_post_meta($meta_key){
        if($this->auction_id!="")
        return get_post_meta($this->auction_id,$meta_key,true);
        else if(isset($_POST["update_auction"]) && !empty($_POST["update_auction"])){
            return get_post_meta($_POST["update_auction"],$meta_key,true);
        }
        else if(isset($_GET["edit_auction"]) && !empty($_GET["edit_auction"])){
            return get_post_meta($_GET["edit_auction"],$meta_key,true);
            }
        else
        return "";
    }
    
    public function wdm_set_auction($args){
	$this->auction_id=$args;	
    }
    
    public function wdm_get_post(){
        if(isset($_POST["update_auction"]) && !empty($_POST["update_auction"])){
            $auction=get_post($_POST["update_auction"]);
            $single_auction["title"]=$auction->post_title;
            $single_auction["content"]=$auction->post_content;
            return $single_auction;
        }
        else if(isset($_GET["edit_auction"]) && !empty($_GET["edit_auction"])){
            $auction=get_post($_GET["edit_auction"]);
            $single_auction["title"]=$auction->post_title;
            $single_auction["content"]=$auction->post_content;
            return $single_auction;
            }
	else if($this->auction_id!=""){
	    $auction=get_post($this->auction_id);
            $single_auction["title"]=$auction->post_title;
            $single_auction["content"]=$auction->post_content;
            return $single_auction;
	}
        $this->auction_id="";
        $single_auction["title"]="";
        $single_auction["content"]="";
        return $single_auction;
    }
    
    }
}
$wctest = new wdm_settings();
?>