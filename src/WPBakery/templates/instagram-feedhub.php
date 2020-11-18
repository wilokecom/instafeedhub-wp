<?php
/**
 * @param $atts
 */
function instagramFeedhub($atts)
{
	?>
    <div id="<?php ?>"><?php echo __('Instagram Feedhub', 'instafeedhub-wp'); ?></div>
	<?php
}

add_shortcode('instagram-feedhub', 'instagramFeedhub');