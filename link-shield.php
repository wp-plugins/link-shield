<?php
// Commond functions

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
	// Add Link Shield Menu

	if (is_multisite() ) {
		add_action('network_admin_menu', 'link_shield_network_menu');
	} else {
		add_action('admin_menu', 'link_shield_menu');
	}
	
	function link_shield_menu() {
		add_options_page( 'Link Shield Options', 'Link Shield', 'manage_options', 'link_shield_menu_options', 'link_shield_menu_options' );
	}
	
	function link_shield_network_menu() {
		add_submenu_page('settings.php', 'Link Shield Options', 'Link Shield', 'manage_options', 'link_shield_menu_options', 'link_shield_menu_options');
		}
	
	
	// mt_settings_page() displays the page content for the Test settings submenu
	function link_shield_menu_options() {

    	//must check that the user has the required capability 
		if (!current_user_can('manage_options')){
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}

    // variables for the field and option names 
   // $link_shield_text = 'link_shield_text';
   // $link_shield_text_field = 'link_shield_text';

    // Read in existing option value from database
   // $opt_val = get_site_option( $link_shield_text );
   if( isset( $_POST[ 'link_shield_text_field' ]) || isset( $_POST[ 'link_shield_shordcode_field' ]) || isset( $_POST[ 'link_shield_blog_show_link_text_field' ]) || isset( $_POST[ 'link_shield_blog_comments_show_link_text_field' ]) || isset( $_POST[ 'link_shield_buddypress_show_link_text_field' ]) || isset( $_POST[ 'link_shield_bbpress_show_link_text_field' ]) ) {
        // Read their posted value
        $opt_link_shield_text							= @$_POST[ 'link_shield_text_field' ];
        $opt_link_shield_shordcode						= @$_POST[ 'link_shield_shordcode_field' ];
        $opt_link_shield_blog_show_link_text			= @$_POST[ 'link_shield_blog_show_link_text_field' ];
        $opt_link_shield_blog_comments_show_link_text	= @$_POST[ 'link_shield_blog_comments_show_link_text_field' ];
        $opt_link_shield_bbpress_show_link_text			= @$_POST[ 'link_shield_bbpress_show_link_text_field' ];

		// Save the posted value in the database
        update_site_option( 'link_shield_text', $opt_link_shield_text );
        update_site_option( 'link_shield_shordcode', $opt_link_shield_shordcode );
        update_site_option( 'link_shield_blog_show_link_text', $opt_link_shield_blog_show_link_text );
        update_site_option( 'link_shield_blog_comments_show_link_text', $opt_link_shield_blog_comments_show_link_text );
        update_site_option( 'link_shield_bbpress_show_link_text', $opt_link_shield_bbpress_show_link_text );
        
        do_action('link_shield_save_options');
        

        // Put an settings updated message on the screen
?>
<div class="updated"><p><strong><?php _e('settings saved.', 'link-shield' ); ?></strong></p></div>
<?php
}

    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . _e( 'Links Shield', 'link-shield' ) . "</h2>";

    // settings form
    
    ?>

<form name="form1" method="post" action="">

<p><?php _e("Text for hidden links:", 'link-shield' ); ?> 
<input type="text" name="link_shield_text_field" value="<?php echo get_site_option( 'link_shield_text' ); ?>" size="20">
</p><hr />

<p><?php _e("Hide link text on Post?: ", 'link-shield' ); ?>
<select name="link_shield_blog_show_link_text_field" id="link_shield_blog_show_link_text_field">
	<option value="0" <?php if (  ( get_site_option ('link_shield_blog_show_link_text') == 0 ) || ! get_site_option ('link_shield_blog_show_link_text') ) echo 'selected="selected"'; ?> ><?php _e('Replace text with "Text for hidden links"','link-shield'); ?></option>
	<option value="1" <?php if ( get_site_option ('link_shield_blog_show_link_text') == 1 ) echo 'selected="selected"'; ?>><?php _e('Show link text','link-shield'); ?></option>
</select></p><hr />

<p><?php _e("Hide link text on Comments?: ", 'link-shield' ); ?>
<select name="link_shield_blog_comments_show_link_text_field" id="link_shield_blog_comments_show_link_text_field">
	<option value="0" <?php if (  ( get_site_option ('link_shield_blog_comments_show_link_text') == 0 ) || ! get_site_option ('link_shield_blog_comments_show_link_text') ) echo 'selected="selected"'; ?> ><?php _e('Replace text with "Text for hidden links"','link-shield'); ?></option>
	<option value="1" <?php if ( get_site_option ('link_shield_blog_comments_show_link_text') == 1 ) echo 'selected="selected"'; ?>><?php _e('Show link text','link-shield'); ?></option>
</select></p><hr />

<p><?php _e("Hide link text on bbPress?: ", 'link-shield' ); ?>
		<select name="link_shield_bbpress_show_link_text_field" id="link_shield_bbpresss_show_link_text_field">
			<option value="0" <?php if (  ( get_site_option ('link_shield_bbpress_show_link_text') == 0 ) || ! get_site_option ('link_shield_bbpress_show_link_text') ) echo 'selected="selected"'; ?> ><?php _e('Replace text with "Text for hidden links"','link-shield'); ?></option>
			<option value="1" <?php if ( get_site_option ('link_shield_bbpress_show_link_text') == 1 ) echo 'selected="selected"'; ?>><?php _e('Show link text','link-shield'); ?></option>
		</select></p><hr />

<?php do_action('link_shield_fields_options_block'); ?>

<p><?php _e("Shordcode for hide text/links:", 'link-shield' ); ?> 
<input type="text" name="link_shield_shordcode_field" value="<?php echo get_site_option( 'link_shield_shordcode' ); ?>" size="20">
</p> <code><?php if (get_site_option( 'link_shield_shordcode' ) ) { echo '['. get_site_option( 'link_shield_shordcode' ).']Text to hide[/'. get_site_option( 'link_shield_shordcode' ).']'; } else { echo '[linkshield_hide]text to hide[/linkshield_hide]'; }?></code> <?php _e('Use this Shordcode for hide links, text, text block, vides, etc to non logedin users','link-shield'); ?><hr />

	<?php do_action('link_shield_fields'); ?>

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
</div>

<?php
 
}

	add_filter('the_content', 'link_shield_look_for_bl_domains');
	add_filter('comment_text', 'link_shield_look_for_bl_domains_comments');

	// Hide links on Blog post
	function link_shield_look_for_bl_domains($text){
		$low_domain = strtolower($text);
		if (!get_site_option( 'link_shield_text' ) ) { $link_shield_text =  __('link blocked thanks to AEDE Spanish tax','link-shield'); } else { $link_shield_text = get_site_option( 'link_shield_text' ); }
		
			//print_r($GLOBALS['aede_domains']);
			foreach ($GLOBALS['aede_domains'] as $blacklisteddomain) {
				$searchword = "/".$blacklisteddomain."/i";
					preg_match_all($searchword, $text, $found);
						foreach ($found[0] as $pattern) {
							if ( get_site_option ('link_shield_blog_show_link_text') == 1){
								$text = preg_replace('|<a (.+?)'.$pattern.'(.+?)>(.+?)</a>|i', '$3', $text);
								} else {
									$text = preg_replace('|<a (.+?)'.$pattern.'(.+?)>(.+?)</a>|i', '[' .$link_shield_text. ']', $text);
								}
							//print_r($found[0]);
						}
					} return $text;
	}
	
	// Hide links on Comments Blog post
	function link_shield_look_for_bl_domains_comments($text){
		$low_domain = strtolower($text);
		if (!get_site_option( 'link_shield_text' ) ) { $link_shield_text =  __('link blocked thanks to AEDE Spanish tax','link-shield'); } else { $link_shield_text = get_site_option( 'link_shield_text' ); }
		
			//print_r($GLOBALS['aede_domains']);
			foreach ($GLOBALS['aede_domains'] as $blacklisteddomain) {
				$searchword = "/".$blacklisteddomain."/i";
					preg_match_all($searchword, $text, $found);
						foreach ($found[0] as $pattern) {
							if ( get_site_option ('link_shield_blog_comments_show_link_text') == 1){
								$text = preg_replace('|<a (.+?)'.$pattern.'(.+?)>(.+?)</a>|i', '$3', $text);
								} else {
									$text = preg_replace('|<a (.+?)'.$pattern.'(.+?)>(.+?)</a>|i', '[' .$link_shield_text. ']', $text);
								}
							//print_r($found[0]);
						}
					} return $text;
	}
	
	// Hide links on bbPress
	function link_shield_look_for_bl_domains_bbpress($text){
		$low_domain = strtolower($text);
		if (!get_site_option( 'link_shield_text' ) ) { $link_shield_text =  __('link blocked thanks to AEDE Spanish tax','link-shield'); } else { $link_shield_text = get_site_option( 'link_shield_text' ); }
		
			//print_r($GLOBALS['aede_domains']);
			foreach ($GLOBALS['aede_domains'] as $blacklisteddomain) {
				$searchword = "/".$blacklisteddomain."/i";
					preg_match_all($searchword, $text, $found);
						foreach ($found[0] as $pattern) {
							if ( get_site_option ('link_shield_bbpress_show_link_text') == 1){
								$text = preg_replace('|<a (.+?)'.$pattern.'(.+?)>(.+?)</a>|i', '$3', $text);
								} else {
									$text = preg_replace('|<a (.+?)'.$pattern.'(.+?)>(.+?)</a>|i', '[' .$link_shield_text. ']', $text);
								}
							//print_r($found[0]);
						}
					} return $text;
	}
	
	// Shordcode for hide content
	function link_shield_hide_link_shordcode( $atts , $content = null ) {

	// Code
		if (is_user_logged_in()) {
			return $content;
			} else {
				return __('Debes identificarte para ver este contenido','');
				}
			}

	if ( ! get_site_option ('link_shield_shordcode')) {
		add_shortcode( 'linkshield_hide' , 'link_shield_hide_link_shordcode' );
		} else {
			add_shortcode( get_site_option ('link_shield_shordcode') , 'link_shield_hide_link_shordcode' );
			}
?>