<div style="overflow: hidden; height: 300px; max-height: 300px; min-height: 300px;">
    <div>
        <h4 class="blog-title">
            <a class="small" href="<?php echo $post_guid; ?>"><i class="fas fa-external-link-alt"></i></a>
			<?php echo $post_title; ?>
        </h4>
    </div>
	<?php if($post_display==='mini') { ?>
        <div>
			<?php echo $post_content ?>
        </div>
	<?php } else { ?>
        <div>
			<?php echo $post_content ?>
        </div>
	<?php } ?>
</div>
