	<div class="container">
			<nav class="navbar navbar-expand-md navbar-light">

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<small>
					<?php
					wp_nav_menu( array(
						'theme_location'    => 'bottommenu',
						'depth'             => 1,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse',
						'container_id'      => 'bs-example-navbar-collapse-1',
						'menu_class'        => 'nav',
						'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
						'walker'            => new WP_Bootstrap_Navwalker(),
					) );
					?>
				</small>
			</nav>
	</div>
	<?php wp_footer(); ?>
	<br>
	</body>
</html>