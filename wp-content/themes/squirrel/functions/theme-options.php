<?php

add_action('init', 'squirrel_options');
if (!function_exists('squirrel_options')) {

    function squirrel_options() {
        // VARIABLES
        $themename = function_exists( 'wp_get_theme' ) ? wp_get_theme() : get_current_theme();
        $themename = $themename['Name'];
        $shortname = "of";
        // Populate OptionsFramework option in array for use in theme
        global $of_options;
        $of_options = squirrel_get_option('of_options');
        // Background Defaults
        $background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat', 'position' => 'top center', 'attachment' => 'scroll');
        //Stylesheet Reader
        $alt_stylesheets = array("black" => "black", "blue" => "blue", "green" => "green", "grass" => "grass", "maroon" => "maroon", "orange" => "orange", "purple" => "purple", "red" => "red");
        // Pull all the categories into an array
        $options_categories = array();
        $options_categories_obj = get_categories();
        foreach ($options_categories_obj as $category) {
            $options_categories[$category->cat_ID] = $category->cat_name;
        }

        // Pull all the pages into an array
        $options_pages = array();
        $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
        $options_pages[''] = 'Select a page:';
        foreach ($options_pages_obj as $page) {
            $options_pages[$page->ID] = $page->post_title;
        }

        // If using image radio buttons, define a directory path
        $imagepath = get_template_directory() . '/images/';

        $options = array(
            array("name" => "General Settings",
                "type" => "heading"),
            array("name" => "Custom Logo",
                "desc" => "Choose your own logo. Optimal Size: 300px Wide by 90px Height.",
                "id" => "squirrel_logo",
                "type" => "upload"),
            array("name" => "Custom Favicon",
                "desc" => "Specify a 16px x 16px image that will represent your website's favicon.",
                "id" => "squirrel_favicon",
                "type" => "upload"),
            array("name" => "Tracking Code",
                "desc" => "Paste your Google Analytics (or other) tracking code here.",
                "id" => "squirrel_analytics",
                "std" => "",
                "type" => "textarea"),
            //Home page heading
            array("name" => "Homepage Heading",
                "type" => "heading"),
            //First Heading
            array("name" => "First Heading",
                "desc" => "Enter your text for first heading.",
                "id" => "squirrel_first_head",
                "std" => "",
                "type" => "textarea"),
            //Second Heading
            array("name" => "Second Heading",
                "desc" => "Enter your text for second heading.",
                "id" => "squirrel_second_head",
                "std" => "",
                "type" => "textarea"),
            //Slider Setting
            array("name" => "Top Feature Setting",
                "type" => "heading"),
            array("name" => "Top Feature Image",
                "desc" => "Choose your image for top feature image. Optimal size is 580px wide and 325px height.",
                "id" => "squirrel_image1",
                "std" => "",
                "type" => "upload"),
            //Slider Heading       
            array("name" => "Top Feature Heading",
                "desc" => "Enter your text for feature heading.",
                "id" => "squirrel_slidehead",
                "std" => "",
                "type" => "textarea"),
            //Slider Description
            array("name" => "Top Feature Description",
                "desc" => "Enter your text for feature description.",
                "id" => "squirrel_slidedesc",
                "std" => "",
                "type" => "textarea"),
            //Homepage two cols
            array("name" => "Homepage Two Cols",
                "type" => "heading"),
            array("name" => "Homepage Left Col Heading",
                "desc" => "Enter your text for home page left col.",
                "id" => "squirrel_leftcolhead",
                "std" => "",
                "type" => "textarea"),
            array("name" => "Homepage Left Col Description",
                "desc" => "Enter your text for home page left col description.",
                "id" => "squirrel_leftcoldesc",
                "std" => "",
                "type" => "textarea"),
            array("name" => "Homepage Right Col Heading",
                "desc" => "Enter your text for right col heading.",
                "id" => "squirrel_rightcolhead",
                "std" => "",
                "type" => "textarea"),
            array("name" => "Homepage Right Col Description",
                "desc" => "Enter your text for right col description.",
                "id" => "squirrel_rightcoldesc",
                "std" => "",
                "type" => "textarea"),
            //Home page fullwidth cols
            array("name" => "Homepage Fullwidth Col",
                "type" => "heading"),
            array("name" => "Full Col Heading",
                "desc" => "Enter your text for full col heading",
                "id" => "squirrel_fullcolhead",
                "std" => "",
                "type" => "textarea"),
            array("name" => "Full Col Description",
                "desc" => "Enter your text for full col description",
                "id" => "squirrel_fullcoldesc",
                "std" => "",
                "type" => "textarea")
        );
        squirrel_update_option('of_template', $options);
        squirrel_update_option('of_themename', $themename);
        squirrel_update_option('of_shortname', $shortname);
    }

}
?>
