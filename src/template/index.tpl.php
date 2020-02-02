<div class="container">
	<div class="content-background">
		<br>
		<div class="container-fluid">
			<div class="row">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="col-md">
						<h1><?php the_title(); ?></h1>
						<?php the_content(); ?>
                        <?php comments_template('', true); ?>
					</div>
				<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
		<br>
	</div>
</div>
