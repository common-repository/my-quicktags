<?php
/*
Plugin Name: My Quicktags
Plugin URI: http://www.thomasnorberg.com/sitemap/my-quicktags/
Description: <strong>My Quicktags</strong>.
Version: 1.0.2
Author: Thomas Norberg
Author URI: http://www.thomasnorberg.com/contact-me/
*/
$my_quicktags_version = '1.0.2';
/*
== Installation ==
 
1. Upload the whole plugin folder mp3player.zip to the /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress by clicking "Activate".
3. Thats it then got to post/page editor and quicktags should show up at the top. 
*/
 
/*
 Copyright 2009 Thomas Norberg  (email : Tnorberg@thomasnorberg.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
global $wp_version, $my_quicktags_plugin_url, $my_quicktags_version;

$my_quicktags_plugin_url = trailingslashit( WP_PLUGIN_URL.'/'.dirname( plugin_basename(__FILE__) ));

$exit_msg='My Quicktags Plugin requires WordPress 2.5 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';

if (version_compare($wp_version,"2.5","<"))
 {
   exit ($exit_msg);
 }

/********************************
   Add quicktags generator to post/page editor.
****************************/
// WP < 2.8
if ( !function_exists('plugins_dir_url') ) :
function plugins_dir_url($file)
{
	// WP < 2.6
	if ( !function_exists('plugins_url') )
		return trailingslashit(get_option('siteurl') . '/wp-content/plugins/' . plugin_basename($file));

	return trailingslashit(plugins_url(plugin_basename(dirname($file))));
}
endif;

function my_quicktags() {
	wp_enqueue_script(
		'my_custom_quicktags',
		plugins_dir_url(__FILE__) . 'js/my-custom-quicktags.js',
		array('quicktags')
	);
}
add_action('admin_print_scripts', 'my_quicktags');

/****************************
   Add html shortcode to post/page so easier to manipulate.
****************************/
function html_encoder_css(){
   global $my_quicktags_plugin_url;
   include_once('css/html_encoder.php');
   ?><script type="text/javascript" src="<?php echo $my_quicktags_plugin_url; ?>js/html_highlight.js"></script>
   <?php
}
add_action('wp_head', 'html_encoder_css');

function html_encoder_shortcode( $atts, $content = null ) {
   global $html_encoder_num;
   $html_encoder_num = $html_encoder_num+1;
   return '<input class="htmlselectcode" onclick="toggle_visibility(\'code_map'.$html_encoder_num.'\');" value="Click here to see code!" type="button" />
          
             <div style="display: none;" id="code_map'.$html_encoder_num.'">
               <input type="button" class="htmlselectcode" value="Select Code" onclick="htmlSelectCode(\'code_highlight_'.$html_encoder_num.'\');" />
               
                <div class="html">
                 <p class="htmlencoded" id="code_highlight_'.$html_encoder_num.'">' . $content . '</p>
                </div>
             </div>';
}
add_shortcode('html_encoded', 'html_encoder_shortcode');


/****************************
   Render update info on the plugins panel if the update is available.
****************************/
        function my_quicktags_check_version($file, $plugin_data) {
            global $wp_version;
            static $this_plugin;
            $wp_version = str_replace(".","",$wp_version);
            if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);

            if ($file == $this_plugin){
                $current = $wp_version < 28 ? get_option('update_plugins') : get_transient('update_plugins');
                if (!isset($current->response[$file])) return false;

                $columns =  $wp_version < 28 ? 5 : 3;
                $url = 'http://www.thomasnorberg.com/quicktagsversion.txt';
                $update = wp_remote_fopen($url);
                if ($update != "") {
                    echo '<tr class="plugin-update-tr"><td colspan="'.$columns.'" class="plugin-update"><div class="update-message">';
                    echo $update;
                    echo '</div></td></tr>';
                }
            }
        }
add_action('after_plugin_row', 'my_quicktags_check_version', 10, 2);

/****************************
   Adds Plugin links under the description of the plugin in plugins panel.
****************************/
function my_quicktags_add_meta_links($links, $file) {

	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);

		if ($file == $this_plugin ){		

			$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7723361" title="Donate Please">' . __('Donate') . '</a>';
		}
		return $links;
	}
add_filter('plugin_row_meta', 'my_quicktags_add_meta_links', 10, 2);

?>