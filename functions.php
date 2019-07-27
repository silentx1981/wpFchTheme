<?php

require __DIR__."/vendor/autoload.php";

global $wp_customize;

// JavaScript-Files
function wps_scripts()
{
	/* JQuery */
	wp_enqueue_script(
		'jqueryslim',
		get_template_directory_uri() . '/js/jquery-3.2.1.slim.min.js',
		array(),
		'3.2.1',
		true
	);

	/* Bootstrap JS */
	wp_enqueue_script(
		'bootstrap',
		get_template_directory_uri() . '/js/bootstrap.min.js',
		array('jquery'),
		'4.0.0',
		true
	);

	wp_enqueue_script(
		'wpfchtheme',
		get_template_directory_uri() . '/js/wpFchTheme.js',
		array(),
		'0.1.1',
		true
	);
}
add_action('wp_enqueue_scripts', 'wps_scripts');

// Meta-Data
function addMeta() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
}
add_action( 'wp_head', 'addMeta' );

function wpb_custom_new_menu() {
	register_nav_menus(
		array(
			'topmenu' => __( 'Top Menu' ),
			'bottommenu' => __( 'Bottom Menu' )
		)
	);
}
add_action( 'init', 'wpb_custom_new_menu' );

function header_customize_register($wp_customize) {

	// Add and manipulate theme images to be used.
	$wp_customize->add_section('section_header', array(
		"title" => 'Header',
		"priority" => 28,
		"description" => __( 'Header-Einstellungen', 'theme-slug' )
	));

	$wp_customize->add_setting('image_header_background', array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'image_header_background', array(
			'label' => __( 'Header-Hintergrund-Bild', 'theme-slug' ),
			'section' => 'section_header',
			'settings' => 'image_header_background',
		))
	);

	$wp_customize->add_setting('image_header_background2', array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'image_header_background2', array(
			'label' => __( 'Header-Hintergrund-Bild2', 'theme-slug' ),
			'section' => 'section_header',
			'settings' => 'image_header_background2',
		))
	);

	$wp_customize->add_setting('image_header_background3', array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'image_header_background3', array(
			'label' => __( 'Header-Hintergrund-Bild3', 'theme-slug' ),
			'section' => 'section_header',
			'settings' => 'image_header_background3',
		))
	);

	$wp_customize->add_setting('image_header_background4', array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'image_header_background4', array(
			'label' => __( 'Header-Hintergrund-Bild4', 'theme-slug' ),
			'section' => 'section_header',
			'settings' => 'image_header_background4',
		))
	);

	$wp_customize->add_setting('image_header_background5', array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'image_header_background5', array(
			'label' => __( 'Header-Hintergrund-Bild5', 'theme-slug' ),
			'section' => 'section_header',
			'settings' => 'image_header_background5',
		))
	);

	$wp_customize->add_setting('image_header_logo', array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'image_header_logo', array(
			'label' => __( 'Header-Logo', 'theme-slug' ),
			'section' => 'section_header',
			'settings' => 'image_header_logo',
		))
	);
}

function background_customize_register($wp_customize) {

	// Add and manipulate theme images to be used.
	$wp_customize->add_section('section_background', array(
		"title" => 'Background',
		"priority" => 35,
		"description" => __( 'Background-Einstellungen', 'theme-slug' )
	));

	$wp_customize->add_setting('image_background', array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'image_background', array(
			'label' => __( 'Background-Image', 'theme-slug' ),
			'section' => 'section_background',
			'settings' => 'image_background',
		))
	);

}

function allgemein_customize_register($wp_customize) {

	$wp_customize->add_section('section_allgemein', array(
		"title" => 'Allgemein',
		"priority" => 36,
		"description" => __( 'Allgemeine Einstellungen', 'theme-slug' )
	));

	$wp_customize->add_setting('default_avatar', array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'default_avatar', array(
			'label' => __( 'Default Avatar', 'theme-slug' ),
			'section' => 'section_allgemein',
			'settings' => 'default_avatar',
		))
	);
}

add_action( 'customize_register', 'header_customize_register' );
add_action( 'customize_register', 'background_customize_register');
add_action( 'customize_register', 'allgemein_customize_register');


function showPosts()
{
	require_once __DIR__."/vendor/autoload.php";
	require_once __DIR__."/src/Posts.php";

	ob_start();
	$posts = new \wpFchTheme\Posts();
	$posts->show();
	return ob_get_clean();
}
add_shortcode('showPosts', 'showPosts');


function showPage($attrs = [])
{
	require_once __DIR__."/vendor/autoload.php";
	require_once __DIR__."/src/Pages.php";

	ob_start();
	$pageId = $attrs['pageid'] ?? null;
	$pages = new \wpFchTheme\Pages();
	$pages->show($pageId);
	return ob_get_clean();
}
add_shortcode('showPage', 'showPage');

function showSponsors($attrs = [])
{
	require_once __DIR__."/vendor/autoload.php";
	require_once __DIR__."/src/Sponsors.php";

	ob_start();
	$sponsors = new \wpFchTheme\Sponsors();
	//$sponsors->show();
	$pageId = $attrs['pageid'] ?? null;
	$pageTitle = $attrs['pagetitle'] ?? null;
	$display = $attrs['display'] ?? null;
	$pages = new \wpFchTheme\Pages();
	$pages->show($pageId, $pageTitle, $display, true);
	return ob_get_clean();
}
add_shortcode('showSponsors', 'showSponsors');

function showRotation($attrs = [])
{
	require_once __DIR__."/vendor/autoload.php";
	require_once __DIR__."/src/Rotation.php";

	ob_start();
	$json = $attrs['json'] ?? null;
	$rotation = new \wpFchTheme\Rotation();
	$json = str_replace('%5b', '[', $json);
	$json = str_replace('%5d', ']', $json);
	$json = str_replace("'", '"', $json);
	$rotation->show(json_decode($json, true), true);
	return ob_get_clean();
}
add_shortcode('showRotation', "showRotation");

function showSpielbetrieb($attrs = [])
{
	require_once __DIR__."/vendor/autoload.php";
	require_once __DIR__."/src/Spielbetrieb.php";

	ob_start();
	$url = $attrs['url'] ?? null;
	$spielbetrieb = new \wpFchTheme\Spielbetrieb();
	$spielbetrieb->show($url);
	return ob_get_clean();
}
add_shortcode('showSpielbetrieb', 'showSpielbetrieb');

function showSpielbetriebData($attrs = [])
{
	require_once __DIR__."/vendor/autoload.php";
	require_once __DIR__."/src/Spielbetrieb.php";

	ob_start();
	$spielbetrieb = new \wpFchTheme\Spielbetrieb();
	$spielbetrieb->showOnlyData($attrs);
	return ob_get_clean();
}
add_shortcode('showSpielbetriebData', 'showSpielbetriebData');

function showPerson($attrs = [])
{
	require_once __DIR__."/vendor/autoload.php";
	require_once __DIR__."/src/Person.php";

	ob_start();
	$personData = [];
	$personData['name'] = $attrs['name'] ?? null;
	$personData['vorname'] = $attrs['vorname'] ?? null;
	$personData['mail'] = $attrs['mail'] ?? null;
	$personData['mobile'] = $attrs['mobile'] ?? null;
	$personData['phone'] = $attrs['phone'] ?? null;
	$personData['avatar'] = $attrs['avatar'] ?? null;
	$personData['funktion'] = $attrs['funktion'] ?? null;
	$person = new \wpFchTheme\Person();
	$person->show($personData);
	return ob_get_clean();
}
add_shortcode('showPerson', 'showPerson');
