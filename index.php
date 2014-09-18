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
require 'average_reading_time_options.php';

function estimate() {
    $wpm = get_option("Words_per_minute");
    global $post;
    $mycontent = $post->post_content; 
    $words = str_word_count(strip_tags($mycontent));
    $minutes = floor($words / $wpm['Words_per_minute'] );
    $est = $minutes . ' minute' . ($minutes == 1 ? '' : 's');
    return $est;
}

function modify($content) {
    return estimate() . $content;
}
add_filter('the_content', 'modify');
?>


