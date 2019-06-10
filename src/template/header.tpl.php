<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//DE" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de">
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php wp_title(' - ', true, 'right'); ?> <?php bloginfo('name'); ?></title>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<?php wp_head(); ?>
	</head>
	<body  style="height: 100%; background: linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,.5)), url(<?php echo get_theme_mod('image_background'); ?>);background-repeat: no-repeat;background-size: 100% 100%; )">
	<div>&nbsp;</div>
	<div class="container">
		<nav class="navbar navbar-expand-md navbar-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topmenu_collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<?php
			wp_nav_menu( array(
				'theme_location'    => 'topmenu',
				'depth'             => 2,
				'container'         => 'div',
				'container_class'   => 'collapse navbar-collapse',
				'container_id'      => 'topmenu_collapse',
				'menu_class'        => 'nav navbar-nav',
				'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
				'walker'            => new WP_Bootstrap_Navwalker(),
			) );
			?>

		</nav>
		<div id="fchSwiper" class="sticky-top d-none d-md-block carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active" style="height: 150px; background: linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,.5)), url(<?php echo get_theme_mod('image_header_background'); ?>);background-repeat: no-repeat;background-size: 100% 100%;)">
					<a href="<?php bloginfo('url'); ?>">
						<img src="<?php echo get_theme_mod('image_header_logo'); ?>" style="position:absolute; top:20px; left:10px; height: 120px;z-index:9999">
					</a>
				</div>
				<div class="carousel-item" style="height: 150px; background: linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,.5)), url(<?php echo get_theme_mod('image_header_background2'); ?>);background-repeat: no-repeat;background-size: 100% 100%; )">
					<a href="<?php bloginfo('url'); ?>">
						<img src="<?php echo get_theme_mod('image_header_logo'); ?>" style="position:absolute; top:20px; left:10px; height: 120px;z-index:9999">
					</a>
				</div>
			</div>
		</div>
	</div>