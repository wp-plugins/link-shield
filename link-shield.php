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
        update_site_option(	'link_shield_add_nofollow_to_comments_links', @$_POST['link_shield_add_nofollow_to_comments_links']=='1' ? 1 : 0 );
        
        do_action('link_shield_save_options');
        

        // Put an settings updated message on the screen
?>
<div class="updated"><p><strong><?php _e('settings saved.', 'link-shield' ); ?></strong></p></div>
<?php
} ?>


<div class="wrap">
	<h2><?php _e( 'Links Shield', 'link-shield' ); ?></h2>
<form name="form1" method="post" action="">
	<table class="form-table">
		<tr>
			<th scope="row"><label><?php _e("Text for hidden links:", 'link-shield' ); ?> </label></th>
			<td><input type="text" name="link_shield_text_field" class="regular-text" value="<?php echo get_site_option( 'link_shield_text' ); ?>"></td>
		</tr>

		<tr>
			<th scope="row"><label><?php _e("Hide link text on Post?: ", 'link-shield' ); ?></label></th>
			<td><select name="link_shield_blog_show_link_text_field" id="link_shield_blog_show_link_text_field">
				<option value="0" <?php if (  ( get_site_option ('link_shield_blog_show_link_text') == 0 ) || ! get_site_option ('link_shield_blog_show_link_text') ) echo 'selected="selected"'; ?> ><?php _e('Replace text with "Text for hidden links"','link-shield'); ?></option>
				<option value="1" <?php if ( get_site_option ('link_shield_blog_show_link_text') == 1 ) echo 'selected="selected"'; ?>><?php _e('Show link text','link-shield'); ?></option>
</select></td>
		</tr>

		<tr>
			<th scope="row"><label><?php _e("Hide link text on Comments?: ", 'link-shield' ); ?></label></th>
				<td><select name="link_shield_blog_comments_show_link_text_field" id="link_shield_blog_comments_show_link_text_field">
						<option value="0" <?php if (  ( get_site_option ('link_shield_blog_comments_show_link_text') == 0 ) || ! get_site_option ('link_shield_blog_comments_show_link_text') ) echo 'selected="selected"'; ?> ><?php _e('Replace text with "Text for hidden links"','link-shield'); ?></option>
						<option value="1" <?php if ( get_site_option ('link_shield_blog_comments_show_link_text') == 1 ) echo 'selected="selected"'; ?>><?php _e('Show link text','link-shield'); ?></option>
</select></td>
		</tr>

		<tr>
			<th scope="row"><label><?php _e("Hide link text on bbPress?: ", 'link-shield' ); ?></label></th>
				<td><select name="link_shield_bbpress_show_link_text_field" id="link_shield_bbpresss_show_link_text_field">
			<option value="0" <?php if (  ( get_site_option ('link_shield_bbpress_show_link_text') == 0 ) || ! get_site_option ('link_shield_bbpress_show_link_text') ) echo 'selected="selected"'; ?> ><?php _e('Replace text with "Text for hidden links"','link-shield'); ?></option>
			<option value="1" <?php if ( get_site_option ('link_shield_bbpress_show_link_text') == 1 ) echo 'selected="selected"'; ?>><?php _e('Show link text','link-shield'); ?></option>
		</select></td>
		</tr>

<?php do_action('link_shield_fields_options_block'); ?>

		<tr>
			<th scope="row"><label><?php _e("Shordcode for hide text/links:", 'link-shield' ); ?></label></th>
				<td><input type="text" name="link_shield_shordcode_field" class="regular-text" value="<?php echo get_site_option( 'link_shield_shordcode' ); ?>"> <code><?php if (get_site_option( 'link_shield_shordcode' ) ) { echo '['. get_site_option( 'link_shield_shordcode' ).']Text to hide[/'. get_site_option( 'link_shield_shordcode' ).']'; } else { echo '[linkshield_hide]text to hide[/linkshield_hide]'; }?></code>
<p class="description"><?php _e('Use this Shordcode for hide links, text, text block, vides, etc to non logedin users','link-shield'); ?></p></td>
		</tr>
		
		<tr>
			<th scope="row"><label><?php _e("Add rel='nofollow' to comments reply link:", 'link-shield' ); ?></label></th>
			<td><label><input name="link_shield_add_nofollow_to_comments_links" type="checkbox" id="link_shield_add_nofollow_to_comments_links" value="1" <?php echo get_site_option('link_shield_add_nofollow_to_comments_links')=='1' ? 'checked' : ''?>><?php _e(' The reply link will include the comment ID in the URL and will send you back to the page with the comment form in place to make your reply to the comment.','link-shield'); ?><br />
			<?php _e('The problem is that search engines can follow this link on your page and will index the page the links goes to. This page is the same as the current page but will have additional query string options to take to back to the comment form. These URLs are then indexed in the search engines creating duplicate context in the search engine index.','link-shield'); ?><br />
			<?php _e('A good way to solve this problem is to add a rel="nofollow" to all your comment reply links, which tells search engines not to follow this link.','link-shield');?></label></td>

	<?php do_action('link_shield_fields'); ?>
	
</table>
<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>
</form>
</div>

<?php
 
}
	add_filter('the_content', 'link_shield_look_for_bl_domains');
	add_filter('comment_text', 'link_shield_look_for_bl_domains_comments');
	add_filter('comments_number', 'link_shield_look_for_bl_domains_comments');

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
	
	//NOFOLLOW to comments links
	
	function link_shiled_add_nofollow_to_comments_links( $link ) {
    	return str_replace( '")\'>', '")\' rel=\'nofollow\'>', $link );
}
	// Add rel="nofollow" to comment replay link if it is seleccted
	if ( get_site_option( 'link_shield_add_nofollow_to_comments_links' ) == 1 ) add_filter( 'comment_reply_link', 'link_shiled_add_nofollow_to_comments_links' );
?>