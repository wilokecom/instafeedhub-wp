<?php
/**
 * @param $atts
 */
function instagramFeedhub($atts)
{
	?>
    <div id="vc-instagram-feedhub"><?php echo __('Instagram Feedhub', 'instafeedhub-wp'); ?></div>
	<?php
}

add_shortcode('vc-instagram-feedhub', 'instagramFeedhub');