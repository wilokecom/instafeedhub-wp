<?php
/**
 * @param $atts
 * @return false|string
 */
function instagramFeedhub($atts)
{
	ob_start(); ?>
    <div class="wil-instagram-shopify" data-id="<?php echo esc_html($atts['kc_instafeedhub_input']); ?>">Test</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode('kc_instafeedhub', 'instagramFeedhub');