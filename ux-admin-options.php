<?php
/**
 * General settings administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

if ( ! current_user_can( 'manage_options' ) )
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );

$title = __('UX admin');
$parent_file = 'options-general.php';
/* translators: date and time format for exact current time, mainly about timezones, see http://php.net/date */
$timezone_format = _x('Y-m-d G:i:s', 'timezone date format');

?>
<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>
<form action="options.php" method="post">
<?php settings_fields('ux-admin'); ?>
<h3><label for="ux-geocoder-gmap_api_key">Google Maps API key</label></h3>
<p>Please enter a valid Google Maps API key for <?php echo get_option('home'); ?>/. (<a href="https://developers.google.com/maps/documentation/javascript/">Sign up for the Google Maps API.</a>)</p>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><label for="ux-geocoder-gmap_api_key">Google Maps API key V2</label></th>
<td><input type="text" id="ux-geocoder-gmap_api_key" name="ux-geocoder-gmap_api_key" value="<?php echo get_option('ux-geocoder-gmap_api_key'); ?>" class="large-text" />
<p class="description">Used internally by UX geocoder.</p></td>
</tr>
<tr valign="top">
<th scope="row"><label for="ux-geocoder-gmap_api_key_v3">Google Maps API key V3</label></th>
<td><input type="text" id="ux-geocoder-gmap_api_key_v3" name="ux-geocoder-gmap_api_key_v3" value="<?php echo get_option('ux-geocoder-gmap_api_key_v3'); ?>" class="large-text" />
<p class="description">The Google Maps Javascript API Version 3 is now the official Javascript API.</p></td>
</tr>
</tbody></table>

<?php do_settings_sections('ux-admin'); ?>

<?php submit_button(); ?>


</form>
</div>