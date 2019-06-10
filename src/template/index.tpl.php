<div class="container">
	<div class="content-background">
		<br>
		<div class="container-fluid">
			<div class="row">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="col-md">
						<h1><?php the_title(); ?></h1>
						<?php the_content(); ?>
					</div>
				<?php endwhile; ?>
				<?php endif; ?>
				<div class="col-md-4">
					<?php echo do_shortcode('[showSponsors pageid="104" display="maxi"]'); ?>
				</div>
			</div>
		</div>
		<br>
	</div>
</div>