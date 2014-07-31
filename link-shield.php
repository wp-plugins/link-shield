<?php
// Commond functions

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter('the_content', 'link_shield_look_for_bl_domains');
add_filter('comment_text', 'link_shield_look_for_bl_domains');

function link_shield_look_for_bl_domains($text){
	$low_domain = strtolower($text); 
		
		//print_r($GLOBALS['aede_domains']);
		foreach ($GLOBALS['aede_domains'] as $blacklisteddomain) {
			$searchword = "/".$blacklisteddomain."/i";
					preg_match_all($searchword, $text, $found);
						foreach ($found[0] as $pattern) {
				$text = preg_replace('|<a (.+?)'.$pattern.'(.+?)>(.+?)</a>|i', '[' . __('link blocked thanks to AEDE Spanish tax','link-shield'). ']', $text);
				//print_r($found[0]);
						}
					} return $text;
	}
?>