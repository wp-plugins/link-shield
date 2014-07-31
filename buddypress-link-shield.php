<?php

// BuddyPress

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter('bp_get_activity_content_body', 'link_shield_look_for_bl_domains');

?>