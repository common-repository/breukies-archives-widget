<?php
/*
Plugin Name: Breukie's Archives Widget
Description: Breukie's Archives Widget is a wordPress widget, to replace the standard archives widget by Automattic. This widget displays your archives using the wp_get_archives function, utilizes all available parameters like type, limit and format. You can also set up to 9 intances of this widget in your sidebar(s) and you can set a (HTML) title for this wisget.
Author: Arnold Breukhoven
Version: 2.1
Author URI: http://www.arnoldbreukhoven.nl
Plugin URI: http://www.arnoldbreukhoven.nl/2007/05/breukies-archives-widget-for-wordpress
*/

function widget_breukiesarchives_init()
{
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

function widget_breukiesarchives($args, $number = 1) {
	extract($args);
	$options = get_option('widget_breukiesarchives');
	$aantalarchief = empty($options[$number]['aantalarchief']) ? '' : $options[$number]['aantalarchief'];
	$title = empty($options[$number]['title']) ? __('Archives') : $options[$number]['title'];
// Extraatjes
	$type = empty($options[$number]['type']) ? '' : $options[$number]['type'];
	$limit = empty($options[$number]['limit']) ? '' : '&limit=' . $options[$number]['limit'];
	$format = empty($options[$number]['format']) ? '' : '&format=' . $options[$number]['format'];
	$before = empty($options[$number]['before']) ? '' : '&before=' . $options[$number]['before'];
	$after = empty($options[$number]['after']) ? '' : '&after=' . $options[$number]['after'];

	echo $before_widget . $title;

	wp_get_archives("type=" . $type . "&show_post_count=" . $aantalarchief . $limit . $format . $before . $after);

	echo $after_widget;
}

function widget_breukiesarchives_control($number) {
	$options = $newoptions = get_option('widget_breukiesarchives');
	if ( $_POST["breukiesarchives-submit-$number"] ) {
		$newoptions[$number]['aantalarchief'] = strip_tags(stripslashes($_POST["breukiesarchives-aantalarchief-$number"]));
		$newoptions[$number]['title'] = stripslashes($_POST["breukiesarchives-title-$number"]);
// Extraatjes
		$newoptions[$number]['type'] = strip_tags(stripslashes($_POST["breukiesarchives-type-$number"]));
		$newoptions[$number]['limit'] = strip_tags(stripslashes($_POST["breukiesarchives-limit-$number"]));
		$newoptions[$number]['format'] = stripslashes($_POST["breukiesarchives-format-$number"]);
		$newoptions[$number]['before'] = strip_tags(stripslashes($_POST["breukiesarchives-before-$number"]));
		$newoptions[$number]['after'] = strip_tags(stripslashes($_POST["breukiesarchives-after-$number"]));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_breukiesarchives', $options);
	}
	$aantalarchief = htmlspecialchars($options[$number]['aantalarchief'], ENT_QUOTES);
	$title = htmlspecialchars($options[$number]['title'], ENT_QUOTES);
// Extraatjes
	$type = htmlspecialchars($options[$number]['type'], ENT_QUOTES);
	$limit = htmlspecialchars($options[$number]['limit'], ENT_QUOTES);
	$format = htmlspecialchars($options[$number]['format'], ENT_QUOTES);
	$before = htmlspecialchars($options[$number]['before'], ENT_QUOTES);
	$after = htmlspecialchars($options[$number]['after'], ENT_QUOTES);

?>
<center>Check <a href="http://codex.wordpress.org/Template_Tags/wp_get_archives" target="_blank">wp_get_archives</a> for help with these parameters.</center>
<br />
<table align="center" cellpadding="1" cellspacing="1" width="400">
<tr>
<td align="left" valign="middle" width="90" nowrap="nowrap">
Title Widget:
</td>
<td align="left" valign="middle">
<input style="width: 300px;" id="breukiesarchives-title-<?php echo "$number"; ?>" name="breukiesarchives-title-<?php echo "$number"; ?>" type="text" value="<?php echo $title; ?>" />
</td>
</tr>
<tr>
<td align="left" valign="middle" width="90" nowrap="nowrap">
Type:
</td>
<td align="left" valign="middle">
<select id="breukiesarchives-type-<?php echo "$number"; ?>" name="breukiesarchives-type-<?php echo "$number"; ?>" value="<?php echo $options[$number]['type']; ?>">
<?php echo "<option value=\"\">Select</option>"; ?>
<?php echo "<option value=\"monthly\"" . ($options[$number]['type']=='monthly' ? " selected='selected'" : '') .">Monthly</option>"; ?>
<?php echo "<option value=\"daily\"" . ($options[$number]['type']=='daily' ? " selected='selected'" : '') .">Daily</option>"; ?>
<?php echo "<option value=\"weekly\"" . ($options[$number]['type']=='weekly' ? " selected='selected'" : '') .">Weekly</option>"; ?>
<?php echo "<option value=\"postbypost\"" . ($options[$number]['type']=='postbypost' ? " selected='selected'" : '') .">Post by Post</option>"; ?>
</select>
</td>
</tr>
<tr>
<td align="left" valign="middle" width="90" nowrap="nowrap">
Limit:
</td>
<td align="left" valign="middle">
<input style="width: 300px;" id="breukiesarchives-limit-<?php echo "$number"; ?>" name="breukiesarchives-limit-<?php echo "$number"; ?>" type="text" value="<?php echo $limit; ?>" />
</td>
</tr>
<tr>
<td align="left" valign="middle" width="90" nowrap="nowrap">
Format:
</td>
<td align="left" valign="middle">
<select id="breukiesarchives-format-<?php echo "$number"; ?>" name="breukiesarchives-format-<?php echo "$number"; ?>" value="<?php echo $options[$number]['format']; ?>">
<?php echo "<option value=\"\">Select</option>"; ?>
<?php echo "<option value=\"html\"" . ($options[$number]['format']=='html' ? " selected='selected'" : '') .">HTML</option>"; ?>
<?php echo "<option value=\"option\"" . ($options[$number]['format']=='option' ? " selected='selected'" : '') .">Option</option>"; ?>
<?php echo "<option value=\"link\"" . ($options[$number]['format']=='link' ? " selected='selected'" : '') .">Link</option>"; ?>
<?php echo "<option value=\"custom\"" . ($options[$number]['format']=='custom' ? " selected='selected'" : '') .">Custom</option>"; ?>
</select>
</td>
</tr>
<tr>
<td align="left" valign="middle" width="90" nowrap="nowrap">
Before:
</td>
<td align="left" valign="middle">
<input style="width: 300px;" id="breukiesarchives-before-<?php echo "$number"; ?>" name="breukiesarchives-before-<?php echo "$number"; ?>" type="text" value="<?php echo $before; ?>" />
</td>
</tr>
<tr>
<td align="left" valign="middle" width="90" nowrap="nowrap">
After:
</td>
<td align="left" valign="middle">
<input style="width: 300px;" id="breukiesarchives-after-<?php echo "$number"; ?>" name="breukiesarchives-after-<?php echo "$number"; ?>" type="text" value="<?php echo $after; ?>" />
</td>
</tr>
<tr>
<td align="left" valign="middle" width="90" nowrap="nowrap">
Show Post Counts:
</td>
<td align="left" valign="middle">
<select id="breukiesarchives-aantalarchief-<?php echo "$number"; ?>" name="breukiesarchives-aantalarchief-<?php echo "$number"; ?>" value="<?php echo $options[$number]['aantalarchief']; ?>">
<?php echo "<option value=\"\">Select</option>"; ?>
<?php echo "<option value=\"1\"" . ($options[$number]['aantalarchief']=='1' ? " selected='selected'" : '') .">YES</option>"; ?>
<?php echo "<option value=\"0\"" . ($options[$number]['aantalarchief']=='0' ? " selected='selected'" : '') .">NO</option>"; ?>
</select>
<input type="hidden" id="breukiesarchives-submit-<?php echo "$number"; ?>" name="breukiesarchives-submit-<?php echo "$number"; ?>" value="1" />
</td>
</tr>
</table>
<br />
<center>Breukie's Archives Widget is made by: <a href="http://www.arnoldbreukhoven.nl" target="_blank">Arnold Breukhoven</a>.</center>
<?php
}

function widget_breukiesarchives_setup() {
	$options = $newoptions = get_option('widget_breukiesarchives');
	if ( isset($_POST['breukiesarchives-number-submit']) ) {
		$number = (int) $_POST['breukiesarchives-number'];
		if ( $number > 9 ) $number = 9;
		if ( $number < 1 ) $number = 1;
		$newoptions['number'] = $number;
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_breukiesarchives', $options);
		widget_breukiesarchives_register($options['number']);
	}
}

function widget_breukiesarchives_page() {
	$options = $newoptions = get_option('widget_breukiesarchives');
?>
	<div class="wrap">
		<form method="POST">
			<h2>Breukie's Archives Widgets</h2>
			<p style="line-height: 30px;"><?php _e('How many Breukie\'s Archives widgets would you like?'); ?>
			<select id="breukiesarchives-number" name="breukiesarchives-number" value="<?php echo $options['number']; ?>">
<?php for ( $i = 1; $i < 10; ++$i ) echo "<option value='$i' ".($options['number']==$i ? "selected='selected'" : '').">$i</option>"; ?>
			</select>
			<span class="submit"><input type="submit" name="breukiesarchives-number-submit" id="breukiesarchives-number-submit" value="<?php _e('Save'); ?>" /></span></p>
		</form>
	</div>
<?php
}

function widget_breukiesarchives_register() {
	$options = get_option('widget_breukiesarchives');
	$number = $options['number'];
	if ( $number < 1 ) $number = 1;
	if ( $number > 9 ) $number = 9;
	for ($i = 1; $i <= 9; $i++) {
		$name = array('Breukie\'s Archives %s', null, $i);
		register_sidebar_widget($name, $i <= $number ? 'widget_breukiesarchives' : /* unregister */ '', '', $i);
		register_widget_control($name, $i <= $number ? 'widget_breukiesarchives_control' : /* unregister */ '', 460, 260, $i);
	}
	add_action('sidebar_admin_setup', 'widget_breukiesarchives_setup');
	add_action('sidebar_admin_page', 'widget_breukiesarchives_page');
}
// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
widget_breukiesarchives_register();
}

// Tell Dynamic Sidebar about our new widget and its control
add_action('plugins_loaded', 'widget_breukiesarchives_init');

?>
