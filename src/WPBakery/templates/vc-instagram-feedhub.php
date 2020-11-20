<?php
/**
 * @param $atts
 * @return string
 */
function instagramFeedhub($atts)
{
	static $instaFeedId = 0;
	$instaFeedId++;
	?>
    <div id="vc-instagram-feedhub-<?php echo $instaFeedId; ?>"><?php echo __('Instagram Feedhub', 'instafeedhub-wp'); ?></div>
	<?php
}

add_shortcode('vc-instagram-feedhub', 'instagramFeedhub');
