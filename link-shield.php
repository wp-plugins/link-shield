<?php
// Commond functions

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
	// Add Link Shield Menu

	add_action('admin_menu', 'link_shield_menu');
	function link_shield_menu() {
		add_options_page( 'Link Shield Options', 'Link Shield', 'manage_options', 'link_shield_menu_options', 'link_shield_menu_options' );
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
   if( isset( $_POST[ 'link_shield_text_field' ]) ) {
        // Read their posted value
        $opt_link_shield_text = @$_POST[ 'link_shield_text_field' ];

        // Save the posted value in the database
        update_site_option( 'link_shield_text', $opt_link_shield_text );

        // Put an settings updated message on the screen
?>
<div class="updated"><p><strong><?php _e('settings saved.', 'link-shield' ); ?></strong></p></div>
<?php
}

    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Links Shield', 'menu-test' ) . "</h2>";

    // settings form
    
    ?>

<form name="form1" method="post" action="">

<p><?php _e("Text for hidden links:", 'link-shield' ); ?> 
<input type="text" name="link_shield_text_field" value="<?php echo get_site_option( 'link_shield_text' ); ?>" size="20">
</p><hr />

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
</div>

<?php
 
}

	add_filter('the_content', 'link_shield_look_for_bl_domains');
	add_filter('comment_text', 'link_shield_look_for_bl_domains');

	function link_shield_look_for_bl_domains($text){
		$low_domain = strtolower($text);
		if (!get_site_option( 'link_shield_text' ) ) { $link_shield_text =  __('link blocked thanks to AEDE Spanish tax','link-shield'); } else { $link_shield_text = get_site_option( 'link_shield_text' ); }
		
			//print_r($GLOBALS['aede_domains']);
			foreach ($GLOBALS['aede_domains'] as $blacklisteddomain) {
				$searchword = "/".$blacklisteddomain."/i";
					preg_match_all($searchword, $text, $found);
						foreach ($found[0] as $pattern) {
							$text = preg_replace('|<a (.+?)'.$pattern.'(.+?)>(.+?)</a>|i', '[' .$link_shield_text. ']', $text);
							//print_r($found[0]);
						}
					} return $text;
	}
?>