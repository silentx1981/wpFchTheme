<div id="fchPostsSwiper" class="sticky-top carousel slide" data-ride="carousel" data-interval="3000">
	<ol class="carousel-indicators" style="color: #ff0000;">
		<?php
		foreach($posts as $key =>$value) {
			?>
			<li data-target="#fchPostsSwiper" data-slide-to="<?php echo $key ?>" class="<?php echo $value['active']; ?>"></li>
			<?php
		}
		?>
	</ol>

	<div class="carousel-inner">
		<?php
		foreach($posts as $value) { ?>
			<div class="carousel-item <?php echo $value['active'] ?? ''; ?>">

				<div>
					<h4 class="blog-title">
						<a class="small" href="<?php echo $value['guid']; ?>"><i class="fas fa-external-link-alt"></i></a>
						<?php echo $value['post_title']; ?>
					</h4>
				</div>
				<small>
					<?php echo date('d.m.Y H:i', mktime((int) $value['post_date'])).' | '.$value['displayName']; ?>
				</small>
				<hr>
				<div style="overflow: hidden; height: 100px; max-height: 100px; min-height: 100px;">
					<?php echo $value['post_content']; ?>
				</div>
				<div style="height: 50px;"></div>

			</div>
			<?php
		}
		?>
	</div>
</div>