//Fade images
ddsmoothmenu.init({
    mainmenuid: "menu", //menu DIV id
    orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
    classname: 'ddsmoothmenu', //class added to menu's outer DIV
    //customtheme: ["#1c5a80", "#18374a"],
    contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

//cufone
Cufon.replace({
    hover: true
})('#colRight h2')('.reply',{
    hover:true
})('h1')('h2')('h3')('h4')('h5')('h6');

//Fade images
jQuery(document).ready(function(){
    jQuery(".feature-item img, .post img, .sidebar img .recent_post li img").hover(function() {
        jQuery(this).stop().animate({
            opacity: "0.6"
        }, '5000');
    },
    function() {
        jQuery(this).stop().animate({
            opacity: "1.0"
        }, '100');
    });
});

//Fade images
jQuery(document).ready(function(){
    jQuery(".thumbnail li a img").hover(function() {
        jQuery(this).stop().animate({
            opacity: "1.0"
        }, '5000');
    },
    function() {
        jQuery(this).stop().animate({
            opacity: "0.6"
        }, '100');
    });
});
//slider
jQuery(function(){
    jQuery('#slides').slides({
        preload: false,
        preloadImage: 'images/loading.gif',
        play: 5000,
        pause: 2500,
        effect: 'fade',
        crossfade: true,
        slideSpeed: 350,
        fadeSpeed: 1000,
        hoverPause: true
    });
});


