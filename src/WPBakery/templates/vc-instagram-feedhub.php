<?php
use \InstafeedHub\WPBakery\WPBakeryInit;
/**
 * @param $atts
 * @return string
 */
function instagramFeedhub($atts)
{
	?>
    <div id="vc-instagram-feedhub-<?php echo WPBakeryInit::$instaFeedId; ?>"><?php echo __('Instagram Feedhub', 'instafeedhub-wp'); ?></div>
	<?php
	WPBakeryInit::$instaFeedId++;
}

add_shortcode('vc-instagram-feedhub', 'instagramFeedhub');
