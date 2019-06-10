<div>
	<h4 class="blog-title">
		<a class="small" href="<?php echo $post_guid; ?>"><i class="fas fa-external-link-alt"></i></a>
		<?php echo $post_title; ?>
	</h4>
</div>
<?php if($post_display==='mini') { ?>
	<div style="overflow: hidden; height: 100px; max-height: 100px; min-height: 100px;">
		<?php echo $post_content ?>
	</div>
<?php } else { ?>
	<div>
		<?php echo $post_content ?>
	</div>
<?php } ?>