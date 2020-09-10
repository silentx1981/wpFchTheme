<?php
/**
 * Templates Functions
 *
 * Handles to manage templates of plugin
 * 
 * @package WP Team Showcase and Slider Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Handles the team member social profiles
 * 
 * @package WP Team Showcase and Slider Pro
 * @since 1.0.0
 */
function wp_tsasp_member_social_meta( $post_id = '', $limit = 6 ) {

	// Taking some variables
	$social_html 		= '';
	$social_inr_html	= '';
	$count 				= 1;

	if( empty($post_id) || empty($limit) ) {
		return $social_html;
	}

	$prefix = WP_TSASP_META_PREFIX; // Metabox prefix

	$social_services 	= wp_tsasp_social_scrvices(); // Getting social service
	$social 			= get_post_meta( $post_id, $prefix.'social', true );
	$social 			= !empty($social) ? $social : array();

	$system_social_services = array_keys($social_services);
	$stored_social_services = array_keys($social);
	$final_social_services 	= array_unique( $stored_social_services + $system_social_services );

	// If social meta are not empty
	if( !empty($final_social_services) ) {
		foreach ($final_social_services as $s_key => $s_val) {

			$social_link_target	= '';
			$social_link 		= isset($social[$s_val]) ? $social[$s_val] : '';

			// Older backward competibility
			if( empty($social) ) {

				switch ($s_val) {
					case 'fb_link':
						$social_link = get_post_meta( $post_id, '_facebook_link', true );
						break;

					case 'gp_link':
						$social_link = get_post_meta( $post_id, '_google_link', true );
						break;

					case 'li_link':
						$social_link = get_post_meta( $post_id, '_likdin_link', true );
						break;

					case 'tw_link':
						$social_link = get_post_meta( $post_id, '_twitter_link', true );
						break;
				}
			}

			if( empty($social_link) ) continue;

			$social_data 	= isset($social_services[$s_val]) ? $social_services[$s_val] : '';
			$fa_icon 		= isset($social_data['icon']) ? $social_data['icon'] : 'fa fa-link';

			if( $s_val == 'mail' ) {
				$social_link = 'mailto:'.$social_link;
			} elseif( $s_val == 'phone' ) {
				$social_link = 'tel:'.$social_link;
			} elseif( $s_val == 'skype' ) {
				$social_link = 'skype:'.$social_link;
			} else {
				$social_link 		= esc_url( $social_link );
				$social_link_target = 'target="_blank"';
			}

			$social_inr_html .= '
							<li><a '.$social_link_target.' href="'.$social_link.'"><i class="'.$fa_icon.'"></i></a></li>';

			// Limit no of social links
			if( $limit != 'all' && $limit == $count ) {
				break;
			}

			$count++;

		} // End of for each

		// Wrapping the HTML
		if( !empty($social_inr_html) ) {
			$social_html .= '<div class="wp-tsasp-member-social">
								<ul>'.$social_inr_html.'</ul>
							</div><!-- end .wp-tsasp-member-social -->';
		}

	} // End of if

	return $social_html;
}


/**
 * Returns the path to the plugin templates directory
 *
 * @package WP Team Showcase and Slider Pro
 * @since 1.2.6
 */
function wp_tsasp_get_templates_dir() {
	return apply_filters( 'wp_tsasp_template_dir', WP_TSASP_DIR . '/templates' );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *	yourtheme/$template_path/$template_name
 *	yourtheme/$template_name
 *	$default_path/$template_name
 * 
 * @package WP Team Showcase and Slider Pro
 * @since 1.2.6
 * 
 */
function wp_tsasp_locate_template( $template_name, $template_path = '', $default_path = '', $default_template = '' ) {

	if ( ! $template_path ) {
		$template_path = trailingslashit( 'wp-team-showcase-and-slider-pro' );
	}

	if ( ! $default_path ) {
		$default_path = trailingslashit( wp_tsasp_get_templates_dir() );
	}

	// Look within passed path within the theme - this is priority.
	$template_lookup = array(
							trailingslashit( $template_path ) . $template_name,
						);

	// Adding default path to check
	if( !empty($default_template) ) {
		$template_lookup[] = trailingslashit( $template_path ) . $default_template;
	}

	// Look within passed path within the theme - this is priority
	$template = locate_template( $template_lookup );

	// Look within plugin template folder
	if ( !$template || WPOS_TEMPLATE_DEBUG_MODE ) {
		$template = $default_path . $template_name;
	}

	// If template does not exist then load passed $default_template
	if ( !empty($default_path) && !file_exists($template) ) {
		$template = $default_path . $default_template;
	}

	// Return what we found
	return apply_filters('wp_tsasp_locate_template', $template, $template_name, $template_path);
}

/**
 * Get other templates (e.g. attributes) passing attributes and including the file.
 *
 * @package WP Team Showcase and Slider Pro
 * @since 1.2.6
 */
function wp_tsasp_get_template( $template, $args = array(), $template_path = '', $default_path = '', $default_template = '' ) {

	$located = wp_tsasp_locate_template( $template, $template_path, $default_path, $default_template );

	if ( !file_exists( $located ) ) {
		return;
	}

	if ( $args && is_array($args) ) {
		extract( $args );
	}

	do_action( 'wp_tsasp_before_template_part', $template, $template_path, $located, $args );

	include( $located );

	do_action( 'wp_tsasp_after_template_part', $template, $template_path, $located, $args );
}

/**
 * Like wp_tsasp_get_template, but returns the HTML instead of outputting.
 * 
 * @package WP Team Showcase and Slider Pro
 * @since 1.2.6
 */
function wp_tsasp_get_template_html( $template_name, $args = array(), $template_path = '', $default_path = '', $default_template = '' ) {
	ob_start();
	wp_tsasp_get_template( $template_name, $args, $template_path, $default_path, $default_template );
	return ob_get_clean();
}
