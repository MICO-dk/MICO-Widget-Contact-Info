# MICO Widget Contact Info.

A simple widget that allows you to display an optional image with a title, name, phone number and email address.

## Filters

### mico_widget_contact_info_image_html
If you need to change the html output in order to utilize custom theme sizes, or new srcset syntax.

```PHP
<?php 
function electric_boogie_change_contact_info_widget_image_size($image_html, $image_id) {
	
	// We use outputbuffer, because the electric_boogie_post_thumbnail echo's the html, 
	// and we need to 'return' it.
	ob_start();
	electric_boogie_post_thumbnail( $image_id );
	$image_html = ob_get_clean();
	
	return $image_html;
}
add_filter( 'mico_widget_contact_info_image_html', 'electric_boogie_change_contact_info_widget_image_size', 10, 2);
?>
```