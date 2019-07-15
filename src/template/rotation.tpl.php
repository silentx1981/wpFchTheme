<div id="fchSponsorsSwiper" class="sticky-top carousel slide" data-ride="carousel" data-interval="10000">

	<div class="carousel-inner">
		<?php
		foreach($sponsors as $sponsor) { ?>
			<div class="carousel-item <?php echo $sponsor['active'] ?? ''; ?>">
				<a href="<?php echo $sponsor['link']; ?>">
					<img class="img-thumbnail" src="<?php echo $sponsor['image'] ?>" style="max-width: 100%;">
				</a>
			</div>
		<?php } ?>
	</div>

</div>