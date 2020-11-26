<?php

/**
 * @param $atts
 * @return string
 */
function instagramFeedhub($atts)
{
	ob_start(); ?>
    <div class="wil-instagram-shopify" data-id="<?php echo esc_html($atts['vc-instagram-feedhub-input']); ?>"></div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode('vc-instagram-feedhub', 'instagramFeedhub');
