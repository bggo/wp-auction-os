<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {
	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = 'Spartan';
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Test data
	$magpro_slider_start = array("false" => __("No", 'Spartan' ),"true" => __("Yes", 'Spartan' ));
	$homecat_array = array("hori" => __("Horizontal Layout", 'Spartan' ),"verti" => __("Vertical Layout", 'Spartan' ));
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = __('Select a page:', 'Spartan' );
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri(). '/admin/images/';
		
	$options = array();
		
		
							
	$options[] = array( "name" => "country1",
						"type" => "innertabopen");	

		$options[] = array( "name" => __("Select a Skin", 'Spartan' ),
							"type" => "groupcontaineropen");	

				$options[] = array( "name" => __("Select a Skin", 'Spartan' ),
										"desc" => __("Images for skins.", 'Spartan' ),
										"id" => "skin_style",
										"type" => "images",
										"std" => "silver",
										"options" => array(
											'silver' => $imagepath . 'silver.png',
											'black' => $imagepath . 'black.png',
											'blue' => $imagepath . 'blue.png',
											'brown' => $imagepath . 'brown.png',
											'green' => $imagepath . 'green.png',
											'orange' => $imagepath . 'orange.png',
											'pink' => $imagepath . 'pink.png',
											'purple' => $imagepath . 'purple.png',
											'red' => $imagepath . 'red.png',
											'oren' => $imagepath . 'oren.png',
											'bred' => $imagepath . 'bred.png',
											'gren' => $imagepath . 'gren.png',
											'slek' => $imagepath . 'slek.png',
											'aqua' => $imagepath . 'aqua.png',
											'bgre' => $imagepath . 'bgre.png',
											'blby' => $imagepath . 'blby.png',
											'blbr' => $imagepath . 'blbr.png',
											'brow' => $imagepath . 'brow.png',
											'yrst' => $imagepath . 'yrst.png',
											'grun' => $imagepath . 'grun.png',
											'kafe' => $imagepath . 'kafe.png',
											'krem' => $imagepath . 'krem.png',
											'grngy' => $imagepath . 'grngy.png',
											'kopr' => $imagepath . 'kopr.png',
											'yellow' => $imagepath . 'yellow.png')
										);						

										
		$options[] = array( "type" => "groupcontainerclose");

		$options[] = array( "name" => __("Logo Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

				$options[] = array( "name" => __("Upload Logo", 'Spartan' ),
									"desc" => __("Upload your logo here. max width 450px, It will replace the blog title and description.", 'Spartan' ),
									"id" => "header_logo",
									"type" => "proupgrade");	
									
				$options[] = array( "name" => __("Upload FavIcon", 'Spartan' ),
									"desc" => __("Upload your favicon here.", 'Spartan' ),
									"id" => "favicon",
									"type" => "proupgrade");														

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		
		$options[] = array( "name" => __("Color Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

				$options[] = array( "name" => __("Color for Post titles.", 'Spartan' ),
									"desc" => __("Choose a color for your post titles.", 'Spartan' ),
									"id" => "post_title_color",
									"std" => "#000000",
									"type" => "color");	
										
		$options[] = array( "type" => "groupcontainerclose");		
		

		$options[] = array( "name" => __("Adsense Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Google Adsense ID", 'Spartan' ),
										"desc" => __("Enter your full adsense id. Ex : pub-1234567890", 'Spartan' ),
										"id" => "google_adsense_id",
										"std" => "",
										"type" => "proupgrade");		
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Single Page Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Featured Image?", 'Spartan' ),
										"desc" => __("Select yes if you want to show featured image as header.", 'Spartan' ),
										"id" => "show_featured_image_single",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings under post title.", 'Spartan' ),
										"id" => "show_rat_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);										
										
					$options[] = array( "name" => __("Show Posted by and Date?", 'Spartan' ),
										"desc" => __("Select yes if you want to show Posted by and Date under post title.", 'Spartan' ),
										"id" => "show_pd_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);											
										
					$options[] = array( "name" => __("Show Categories and Tags?", 'Spartan' ),
										"desc" => __("Select yes if you want to show categories under post title.", 'Spartan' ),
										"id" => "show_cats_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
										
					$options[] = array( "name" => __("Show Social Share Buttons?", 'Spartan' ),
										"desc" => __("Select yes if you want to show social buttons under post title.", 'Spartan' ),
										"id" => "show_socialbuts_on_single",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																														

					$options[] = array( "name" => __("Show Author Bio", 'Spartan' ),
										"desc" => __("Select yes if you want to show Author Bio Box on single post page.", 'Spartan' ),
										"id" => "show_author_bio",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show RSS Box", 'Spartan' ),
										"desc" => __("Select yes if you want to show RSS box on single post page.", 'Spartan' ),
										"id" => "show_rss_box",
										"std" => "true",
										"type" => "select",
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Show Social Box", 'Spartan' ),
										"desc" => __("Select yes if you want to show social box on single post page.", 'Spartan' ),
										"id" => "show_social_box",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Next/Previous Box", 'Spartan' ),
										"desc" => __("Select yes if you want to show Next/Previous box on single post page.", 'Spartan' ),
										"id" => "show_np_box",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Related Posts Box", 'Spartan' ),
										"desc" => __("Select yes if you want to show Next/Previous box on single post page.", 'Spartan' ),
										"id" => "show_related_box",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																																								
										
		$options[] = array( "type" => "groupcontainerclose");						
		
		
		
	$options[] = array( "type" => "innertabclose");	


	$options[] = array( "name" => "country2",
						"type" => "innertabopen");	
						
		$options[] = array( "name" => __("Social Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Twitter", 'Spartan' ),
										"desc" => __("Enter your twitter id", 'Spartan' ),
										"id" => "twitter_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Redditt", 'Spartan' ),
										"desc" => __("Enter your reddit url", 'Spartan' ),
										"id" => "redit_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Delicious", 'Spartan' ),
										"desc" => __("Enter your delicious url", 'Spartan' ),
										"id" => "delicious_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Technorati", 'Spartan' ),
										"desc" => __("Enter your technorati url", 'Spartan' ),
										"id" => "technorati_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Facebook", 'Spartan' ),
										"desc" => __("Enter your facebook url", 'Spartan' ),
										"id" => "facebook_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Stumble", 'Spartan' ),
										"desc" => __("Enter your stumbleupon url", 'Spartan' ),
										"id" => "stumble_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Youtube", 'Spartan' ),
										"desc" => __("Enter your youtube url", 'Spartan' ),
										"id" => "youtube_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Flickr", 'Spartan' ),
										"desc" => __("Enter your flickr url", 'Spartan' ),
										"id" => "flickr_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("LinkedIn", 'Spartan' ),
										"desc" => __("Enter your linkedin url", 'Spartan' ),
										"id" => "linkedin_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Google", 'Spartan' ),
										"desc" => __("Enter your google url", 'Spartan' ),
										"id" => "google_id",
										"std" => "",
										"type" => "text");

							
		$options[] = array( "type" => "groupcontainerclose");											
														
	$options[] = array( "type" => "innertabclose");
	
	
	$options[] = array( "name" => "country3",
						"type" => "innertabopen");	
						
		$options[] = array( "name" => __("Custom Header", 'Spartan' ),
							"type" => "groupcontaineropen");	


					$options[] = array( "name" => __("Show custom Header?", 'Spartan' ),
										"desc" => __("Selecting yes will show custom header instead of slider", 'Spartan' ),
										"id" => "custom_header_home",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);
										
		$options[] = array( "type" => "groupcontainerclose");


		$options[] = array( "name" => __("Slider Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Select Category", 'Spartan' ),
										"desc" => __("Posts from this category will be shown in the slider.", 'Spartan' ),
										"id" => "magpro_slidercat",
										"std" => "true",
										"type" => "select",
										"options" => $options_categories);
					
					$options[] = array( "name" => __("Show slider on homepage", 'Spartan' ),
										"desc" => __("Select yes if you want to show slider on homepage.", 'Spartan' ),
										"id" => "show_magpro_slider_home",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("Show slider on Single post page", 'Spartan' ),
										"desc" => __("Select yes if you want to show slider on Single post page.", 'Spartan' ),
										"id" => "show_magpro_slider_single",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show slider on Pages", 'Spartan' ),
										"desc" => __("Select yes if you want to show slider on Pages.", 'Spartan' ),
										"id" => "show_magpro_slider_page",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show slider on Category Pages", 'Spartan' ),
										"desc" => __("Select yes if you want to show slider on Category Pages.", 'Spartan' ),
										"id" => "show_magpro_slider_archive",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);																														
					
					$options[] = array( "name" => __("Auto Start?", 'Spartan' ),
										"desc" => __("Select yes if you want the slider to start scrolling automaticaly on page load. Only applies to Accordian and Botique sliders.", 'Spartan' ),
										"id" => "magpro_slider_auto",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("How many slides?", 'Spartan' ),
										"desc" => __("Enter a number. Ex: 5 or 7", 'Spartan' ),
										"id" => "magpro_slidernumposts",
										"std" => "5",
										"class" => "mini",
										"type" => "text");										

					$options[] = array( "name" => __("Pause Duration", 'Spartan' ),
										"desc" => __("Time between slide changes. 1000 is 1 Second", 'Spartan' ),
										"id" => "magpro_slider_time",
										"std" => "7000",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Sliders Available in PRO Version", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upgrade now for these Sliders", 'Spartan' ),
										"desc" => __("Available in PRO", 'Spartan' ),
										"id" => "magpro_slider_upgrade",
										"std" => "anything",
										"type" => "proimages",
										"options" => array(
											'nivo' => $imagepath . 'nivo.png',
											'camera' => $imagepath . 'camera.png',
											'piecemaker' => $imagepath . 'piecemaker.png',
											'accordian' => $imagepath . 'accordian.png',
											'boutique' => $imagepath . 'boutique.png',	
											'videoboutique' => $imagepath . 'boutiquevid.png',	
											'ken' => $imagepath . 'ken.png',
											'ruby' => $imagepath . 'ruby.png',	
											'wilto' => $imagepath . 'wilto.png',																							
											'wiltovideo' => $imagepath . 'wiltovid.png')
										);			

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
								

	$options[] = array( "name" => "country4",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Layout Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Select a homepage layout", 'Spartan' ),
										"desc" => __("Images for layout.", 'Spartan' ),
										"id" => "homepage_layout",
										"std" => "standard",
										"type" => "images",
										"options" => array(
											'magseven' => $imagepath . 'magseven.png',
											'mageight' => $imagepath . 'mageight.png',
											'standard' => $imagepath . 'standard.png')
										);					

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Layouts Available in PRO", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upgrade now for these layouts.", 'Spartan' ),
										"desc" => __("UpGrade Now.", 'Spartan' ),
										"id" => "homepage_layout_upgrade",
										"std" => "",
										"type" => "proimages",
										"options" => array(
											'magpro' => $imagepath . 'magpro.png',
											'magvideo' => $imagepath . 'magvid.png',											
											'maglite' => $imagepath . 'maglite.png',
											'mag' => $imagepath . 'mag.png',
											'magthree' => $imagepath . 'magthree.png',
											'magfour' => $imagepath . 'magfour.png',
											'magfive' => $imagepath . 'magfive.png',
											'magsix' => $imagepath . 'magsix.png',
											'magseven' => $imagepath . 'magseven.png',
											'mageight' => $imagepath . 'mageight.png',
											'standard' => $imagepath . 'standard.png')
										);					

										
		$options[] = array( "type" => "groupcontainerclose");									
						
	$options[] = array( "type" => "innertabclose");		
	
	$options[] = array( "name" => "country6",
						"type" => "innertabopen");

		$options[] = array( "name" => __("MagPro Settings", 'Spartan' ),
							"type" => "tabheading");

	
		
		$options[] = array( "name" => __("Recent Posts", 'Spartan' ),
							"type" => "groupcontaineropen");	


					$options[] = array( "name" => __("How Many Recent Posts?", 'Spartan' ),
										"desc" => __("Enter a number like 7 or 10", 'Spartan' ),
										"id" => "magpro_recent_posts_num",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");			
		
		$options[] = array( "name" => __("Video Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Videos", 'Spartan' ),
										"desc" => __("Select yes if you want to show videos.", 'Spartan' ),
										"id" => "magpro_show_videos",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Select a Category", 'Spartan' ),
										"desc" => __("For posts in this category, You need to create a custom field called video and enter the url to video in its value field", 'Spartan' ),
										"id" => "magpro_show_videos_cat",
										"type" => "proupgrade",
										"options" => $options_categories);


					$options[] = array( "name" => __("How many Videos", 'Spartan' ),
										"desc" => __("How many Videos would you like to show.", 'Spartan' ),
										"id" => "magpro_show_videos_num",
										"std" => "3",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Top Rated/Most Popular", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Top Rated/Most popular box ?", 'Spartan' ),
										"desc" => __("Select yes or no", 'Spartan' ),
										"id" => "magpro_show_mostbox",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);


					$options[] = array( "name" => __("How many Posts", 'Spartan' ),
										"desc" => __("How many posts would you like to show.", 'Spartan' ),
										"id" => "magpro_show_mostboxnum",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Gallery", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Gallery?", 'Spartan' ),
										"desc" => __("Select yes or no", 'Spartan' ),
										"id" => "magpro_show_gallery",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Which Gallery?", 'Spartan' ),
										"desc" => __("Enter the gallery ID", 'Spartan' ),
										"id" => "magpro_galid",
										"std" => "",
										"type" => "proupgrade");


					$options[] = array( "name" => __("How many Images?", 'Spartan' ),
										"desc" => __("Enter the number of images you would like to show", 'Spartan' ),
										"id" => "magpro_galnum",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Category Boxes", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Category Boxes", 'Spartan' ),
										"desc" => __("Select yes or no", 'Spartan' ),
										"id" => "magpro_show_catbox",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Which Layout", 'Spartan' ),
										"desc" => __("Select horizontal or vertical", 'Spartan' ),
										"id" => "magpro_show_catbox_which",
										"std" => "hori",
										"type" => "proupgrade",
										"options" => $homecat_array);


					$options[] = array( "name" => __("Which Categories?", 'Spartan' ),
										"desc" => __("Enter the category ID's seperated by comma. Ex : 1, 7, 20", 'Spartan' ),
										"id" => "magpro_catbox_id",
										"std" => "",
										"type" => "proupgrade");
										
					$options[] = array( "name" => __("How many posts per box?", 'Spartan' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Spartan' ),
										"id" => "magpro_catbox_num",
										"std" => "7",
										"type" => "proupgrade");										
										
		$options[] = array( "type" => "groupcontainerclose");						
		
									
						
	$options[] = array( "type" => "innertabclose");		


	$options[] = array( "name" => "country12",
						"type" => "innertabopen");
		
		$options[] = array( "name" => __("Video Mag Settings", 'Spartan' ),
							"type" => "tabheading");
		
						
	
		
		$options[] = array( "name" => __("Recent Tab Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Recent Videos Tab?", 'Spartan' ),
										"desc" => __("Select yes if you want to show Recent Videos tab in the homepage", 'Spartan' ),
										"id" => "video_mag_recent",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	

					$options[] = array( "name" => __("How many posts?", 'Spartan' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Spartan' ),
										"id" => "video_mag_recent_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'Spartan' ),
										"desc" => __("Images for layout.", 'Spartan' ),
										"id" => "video_mag_recent_layout",
										"std" => "vidrecentone",
										"type" => "proupgrade",
										"options" => array(
											'vidrecentone' => $imagepath . 'vidone.png',
											'vidrecenttwo' => $imagepath . 'vidtwo.png',
											'vidrecentthree' => $imagepath . 'vidthree.png',
											'vidrecentfour' => $imagepath . 'vidfour.png')
										);																								
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Top Rated Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Top Rated Videos Tab?", 'Spartan' ),
										"desc" => __("Select yes if you want to show Top Rated Videos tab in the homepage", 'Spartan' ),
										"id" => "video_mag_toprated",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	

					$options[] = array( "name" => __("How many posts?", 'Spartan' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Spartan' ),
										"id" => "video_mag_toprated_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'Spartan' ),
										"desc" => __("Images for layout.", 'Spartan' ),
										"id" => "video_mag_toprated_layout",
										"std" => "vidtopratedone",
										"type" => "proupgrade",
										"options" => array(
											'vidtopratedone' => $imagepath . 'vidone.png',
											'vidtopratedtwo' => $imagepath . 'vidtwo.png',
											'vidtopratedthree' => $imagepath . 'vidthree.png',
											'vidtopratedfour' => $imagepath . 'vidfour.png')
										);																								
										
		$options[] = array( "type" => "groupcontainerclose");		
		
		$options[] = array( "name" => __("Most Popular Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Top Rated Videos Tab?", 'Spartan' ),
										"desc" => __("Select yes if you want to show Top Rated Videos tab in the homepage", 'Spartan' ),
										"id" => "video_mag_most",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	

					$options[] = array( "name" => __("How many posts?", 'Spartan' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Spartan' ),
										"id" => "video_mag_most_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'Spartan' ),
										"desc" => __("Images for layout.", 'Spartan' ),
										"id" => "video_mag_most_layout",
										"std" => "vidmostone",
										"type" => "proupgrade",
										"options" => array(
											'vidmostone' => $imagepath . 'vidone.png',
											'vidmosttwo' => $imagepath . 'vidtwo.png',
											'vidmostthree' => $imagepath . 'vidthree.png',
											'vidmostfour' => $imagepath . 'vidfour.png')
										);																							
										
		$options[] = array( "type" => "groupcontainerclose");			
		
		$options[] = array( "name" => __("Favourite Tab Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Favourite Videos Tab?", 'Spartan' ),
										"desc" => __("Select yes if you want to show Favourite Videos tab in the homepage", 'Spartan' ),
										"id" => "video_mag_fav",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Select Category", 'Spartan' ),
										"desc" => __("Posts from this category will be shown in the Favourites tab.", 'Spartan' ),
										"id" => "video_mag_fav_cat",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $options_categories);

					$options[] = array( "name" => __("How many posts?", 'Spartan' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Spartan' ),
										"id" => "video_mag_fav_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'Spartan' ),
										"desc" => __("Images for layout.", 'Spartan' ),
										"id" => "video_mag_fav_layout",
										"std" => "vidfavone",
										"type" => "proupgrade",
										"options" => array(
											'vidfavone' => $imagepath . 'vidone.png',
											'vidfavtwo' => $imagepath . 'vidtwo.png',
											'vidfavthree' => $imagepath . 'vidthree.png',
											'vidfavfour' => $imagepath . 'vidfour.png')
										);																					
										
		$options[] = array( "type" => "groupcontainerclose");		
									
		$options[] = array( "name" => __("Category Boxes", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Category Boxes", 'Spartan' ),
										"desc" => __("Select yes or no", 'Spartan' ),
										"id" => "video_mag_show_catbox",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Which Categories?", 'Spartan' ),
										"desc" => __("Enter the category ID's seperated by comma. Ex : 1, 7, 20", 'Spartan' ),
										"id" => "video_mag_catbox_id",
										"std" => "",
										"type" => "proupgrade");
										
					$options[] = array( "name" => __("How many posts per box?", 'Spartan' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Spartan' ),
										"id" => "video_mag_catbox_num",
										"std" => "2",
										"type" => "proupgrade");										
										
		$options[] = array( "type" => "groupcontainerclose");		

						
	$options[] = array( "type" => "innertabclose");	

	
	$options[] = array( "name" => "country7",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Mag Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings", 'Spartan' ),
										"id" => "show_ratings_mag",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Spartan' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Spartan' ),
										"id" => "show_postthumbnail_mag",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country8",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagLite Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings", 'Spartan' ),
										"id" => "show_ratings_maglite",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Spartan' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Spartan' ),
										"id" => "show_postthumbnail_maglite",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country13",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagThree Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings", 'Spartan' ),
										"id" => "show_ratings_magthree",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Spartan' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Spartan' ),
										"id" => "show_postthumbnail_magthree",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country14",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagFour Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings", 'Spartan' ),
										"id" => "show_ratings_magfour",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Spartan' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Spartan' ),
										"id" => "show_postthumbnail_magfour",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");		
	
	$options[] = array( "name" => "country15",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagFive Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings", 'Spartan' ),
										"id" => "show_ratings_magfive",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Spartan' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Spartan' ),
										"id" => "show_postthumbnail_magfive",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country16",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagSix Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings", 'Spartan' ),
										"id" => "show_ratings_magsix",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Spartan' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Spartan' ),
										"id" => "show_postthumbnail_magsix",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");
	
	$options[] = array( "name" => "country17",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagSeven Settings", 'Spartan' ),
							"type" => "tabheading");
		
		
		$options[] = array( "name" => __("Recent Posts Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings", 'Spartan' ),
										"id" => "show_ratings_magseven",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Spartan' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Spartan' ),
										"id" => "show_postthumbnail_magseven",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);																			

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Category Box Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings", 'Spartan' ),
										"id" => "show_ratings_magseven_cat",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Which categories in left sidebar?", 'Spartan' ),
										"desc" => __("Enter the category ID's seperated by comma. Ex : 1, 7, 20", 'Spartan' ),
										"id" => "magseven_catbox_id",
										"std" => "",
										"type" => "text");	
										
					$options[] = array( "name" => __("How many Posts per Category?", 'Spartan' ),
										"desc" => __("Enter the number of posts per category you would like to show", 'Spartan' ),
										"id" => "magseven_catbox_num",
										"std" => "7",
										"type" => "text");																											

										
		$options[] = array( "type" => "groupcontainerclose");									
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country18",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagEight Settings", 'Spartan' ),
							"type" => "tabheading");
		
		
		$options[] = array( "name" => __("Recent Posts Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings", 'Spartan' ),
										"id" => "show_ratings_mageight",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Spartan' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Spartan' ),
										"id" => "show_postthumbnail_mageight",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);																			

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Category Box Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings", 'Spartan' ),
										"id" => "show_ratings_mageight_cat",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Which categories in left sidebar?", 'Spartan' ),
										"desc" => __("Enter the category ID's seperated by comma. Ex : 1, 7, 20", 'Spartan' ),
										"id" => "mageight_catbox_id",
										"std" => "",
										"type" => "text");	
										
					$options[] = array( "name" => __("How many Posts per Category?", 'Spartan' ),
										"desc" => __("Enter the number of posts per category you would like to show", 'Spartan' ),
										"id" => "mageight_catbox_num",
										"std" => "7",
										"type" => "text");																											

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");		
	
	$options[] = array( "name" => "country9",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Standard Blog Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Spartan' ),
										"desc" => __("Select yes if you want to show ratings", 'Spartan' ),
										"id" => "show_ratings_standard",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Show Categories/Tags?", 'Spartan' ),
										"desc" => __("Select yes if you want to show categories and tags in posts", 'Spartan' ),
										"id" => "show_ctags_standard",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country5",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Sidebar Settings", 'Spartan' ),
							"type" => "tabheading");
			
		
		$options[] = array( "name" => __("Sidebar Ad Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show 300x250 ads in sidebar?", 'Spartan' ),
										"desc" => __("Select yes if you want to show 300x250 ads in sidebar. If you select yes, go to widgets page and drag/drop the ads", 'Spartan' ),
										"id" => "show_sidebar_ads",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Show 125x125 ads in sidebar?", 'Spartan' ),
										"desc" => __("Select yes if you want to show 125x125 ads in sidebar. If you select yes, go to widgets page and drag/drop the ads", 'Spartan' ),
										"id" => "show_sidebar_ads_onetwofive",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);											
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Feedburner Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show feedburner?", 'Spartan' ),
										"desc" => __("Select yes if you want to show feedburner in sidebar.", 'Spartan' ),
										"id" => "show_feedburner",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("Feedburner Id", 'Spartan' ),
										"desc" => __("Enter your feedburner id", 'Spartan' ),
										"id" => "feedburner_id",
										"std" => "",
										"type" => "proupgrade");																												
																				
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Social Settings", 'Spartan' ),
							"type" => "groupcontaineropen");
							
					$options[] = array( "name" => __("Show sidebar social and search box?", 'Spartan' ),
										"desc" => __("Selecting No will not display the entire social and search section in sidebar.", 'Spartan' ),
										"id" => "show_social_box_sidebar",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);									

					$options[] = array( "name" => __("Show RSS icon", 'Spartan' ),
										"desc" => __("Selecting No will not display RSS icon in sidebar.", 'Spartan' ),
										"id" => "show_rss_icon",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show search box in sidebar?", 'Spartan' ),
										"desc" => __("Selecting No will not display search box in sidebar.", 'Spartan' ),
										"id" => "show_search_box",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);								
										
																											
																				
		$options[] = array( "type" => "groupcontainerclose");		
		
		$options[] = array( "name" => __("Video Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Videos in sidebar?", 'Spartan' ),
										"desc" => __("Select yes if you want to show videos in sidebar.", 'Spartan' ),
										"id" => "sidebar_show_videos",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Select a Category", 'Spartan' ),
										"desc" => __("For posts in this category, You need to create a custom field called video and enter the url to video in its value field", 'Spartan' ),
										"id" => "sidebar_show_videos_cat",
										"type" => "proupgrade",
										"options" => $options_categories);


					$options[] = array( "name" => __("How many Videos", 'Spartan' ),
										"desc" => __("How many Videos would you like to show.", 'Spartan' ),
										"id" => "sidebar_show_videos_num",
										"std" => "3",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Top Rated/Most Popular", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Top Rated/Most popular box in sidebar?", 'Spartan' ),
										"desc" => __("Select yes or no", 'Spartan' ),
										"id" => "sidebar_show_mostbox",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Select the Layout Type", 'Spartan' ),
										"desc" => __("Images for layout.", 'Spartan' ),
										"id" => "tabboxsidebarlayout",
										"std" => "tabbigthumb",
										"type" => "proupgrade",
										"options" => array(
											'tabbigthumb' => $imagepath . 'vidone.png',
											'tabsmallthumb' => $imagepath . 'vidfour.png')
										);	

					$options[] = array( "name" => __("How many posts", 'Spartan' ),
										"desc" => __("How many posts would you like to show.", 'Spartan' ),
										"id" => "sidebar_show_mostboxnum",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Polls", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Polls?", 'Spartan' ),
										"desc" => __("Select yes or no", 'Spartan' ),
										"id" => "sidebar_show_poll",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);


					$options[] = array( "name" => __("Which Poll?", 'Spartan' ),
										"desc" => __("Enter the poll ID", 'Spartan' ),
										"id" => "sidebar_show_poll_id",
										"std" => "",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");												
						
	$options[] = array( "type" => "innertabclose");		
	
	$options[] = array( "name" => "country10",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("AD Settings", 'Spartan' ),
							"type" => "tabheading");		
		
		$options[] = array( "name" => __("Header Ad Settings", 'Spartan' ),
							"type" => "groupcontaineropen");	

					
					$options[] = array( "name" => __("Show Adsense?", 'Spartan' ),
										"desc" => __("If yes, adsense will be show else enter html adcode below", 'Spartan' ),
										"id" => "show_header_adsense",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Header Ad code", 'Spartan' ),
										"desc" => __("Enter the html ad code", 'Spartan' ),
										"id" => "header_ad_code",
										"type" => "proupgrade");														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country11",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Footer Settings", 'Spartan' ),
							"type" => "tabheading");		
		
		$options[] = array( "name" => __("Footer Widgets", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show footer widgets on homepage?", 'Spartan' ),
										"desc" => __("Select yes if you want to show footer widgets on homepage.", 'Spartan' ),
										"id" => "show_footer_widgets_home",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("Show footer widgets on single post pages?", 'Spartan' ),
										"desc" => __("Select yes if you want to show footer widgets on single post pages.", 'Spartan' ),
										"id" => "show_footer_widgets_single",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show footer widgets on pages?", 'Spartan' ),
										"desc" => __("Select yes if you want to show footer widgets on pages.", 'Spartan' ),
										"id" => "show_footer_widgets_page",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Show footer widgets on category pages?", 'Spartan' ),
										"desc" => __("Select yes if you want to show footer widgets on category pages.", 'Spartan' ),
										"id" => "show_footer_widgets_archive",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																													
																				
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Footer Logo", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show footer logo?", 'Spartan' ),
										"desc" => __("Select yes if you want to show logo in footer.", 'Spartan' ),
										"id" => "show_footer_logo",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

				$options[] = array( "name" => __("Upload Logo", 'Spartan' ),
									"desc" => __("Upload your logo here. Max width 250px", 'Spartan' ),
									"id" => "footer_logo",
									"type" => "proupgrade");						

										
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Search Box", 'Spartan' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show search box in footer?", 'Spartan' ),
										"desc" => __("Select yes if you want to show search box in footer.", 'Spartan' ),
										"id" => "show_footer_search",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);						

										
		$options[] = array( "type" => "groupcontainerclose");												
						
	$options[] = array( "type" => "innertabclose");			
							
						

							
		
	return $options;
}