<div>
    <?php if(isset($post_title)) { ?>
        <div>
            <h4 class="blog-title">
                <a style="text-decoration: none" href="<?php echo $post_guid; ?>">
                    <i class="fas fa-external-link-alt"></i>
				    <?php echo $post_title; ?>
                </a>
            </h4>
        </div>
    <?php } ?>
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
