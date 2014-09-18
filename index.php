<?php
/*
Plugin Name: Average post reading time
Plugin URI: 
Description: A super simple WordPress plugin that count the words of the post/page, and calculate the average reading time.
Version: 1.0
Author: Nichlas Dam
Author URI: http://www.nichlasdam.dk
License: 
*/

function estimate() {
    global $post;
    $mycontent = $post->post_content; 
    $words = str_word_count(strip_tags($mycontent));
    $minutes = floor($words / 200);
    $est = $minutes . ' minute' . ($minutes == 1 ? '' : 's');
    return $est;
}

function modify($content) {
    return estimate() . $content;
}
add_filter('the_content', 'modify');
?>


