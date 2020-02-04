<?php
/**
 * Template for - Design-28
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-for-post-and-widget-pro/grid/design-28.php
 *
 * If you want to override for grid only then put it into 'grid' and folder and same for respective.
 *
 * @package Blog Designer - Post and Widget Pro
 * @version 1.2.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;
$downloadLink = get_post_custom_values('DownloadLink') ?? null;

?>

<div class="wpspw-post-grid  wpspw-medium-<?php echo $newsprogrid; ?> wpspw-columns <?php echo $css_class; ?>">
	<div class="wpspw-post-grid-content <?php if ( empty($post_featured_image) ) { echo 'no-thumb-image'; } ?>">
		<?php if ( $post_featured_image ) { ?>
			<div class="wpspw-post-image-bg" style="<?php echo $height_css; ?>">
                <?php
                if (!$downloadLink) {
                    ?>
                    <a href="<?php echo esc_url($post_link); ?>" target="<?php echo $link_target; ?>">
                        <img src="<?php echo esc_url($post_featured_image); ?>" alt="<?php the_title_attribute(); ?>" />
                    </a>
                    <?php
                } else {
                    ?>
                    <img src="<?php echo esc_url($post_featured_image); ?>" alt="<?php the_title_attribute(); ?>" />
                    <?php
                }
                ?>
			</div>
		<?php } 
		if($show_category_name && $cate_name !='') { ?>
			<div class="wpspw-post-categories"><?php echo $cate_name; ?></div>
		<?php } 
		if($post_title) { ?>
			<h2 class="wpspw-post-title">
				<a href="<?php echo esc_url($post_link); ?>" target="<?php echo $link_target; ?>"><?php echo $post_title; ?></a> 
			</h2>
		<?php } 
		if($show_date || $show_author || $show_comments) { ?>
			<div class="wpspw-post-date">
				<?php if($show_author) { ?>
					<span class="wpspw-user-img"><img src="<?php echo WPSPW_PRO_URL; ?>assets/images/user.svg" alt="" /> <a href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>" target="<?php echo $link_target; ?>"><?php the_author(); ?></a></span>
				<?php } ?>
				<?php echo ($show_author && $show_date) ? '&nbsp;' : '' ?>
				<?php if($show_date) { ?>
					<span class="wpspw-time"> <img src="<?php echo WPSPW_PRO_URL; ?>assets/images/calendar.svg" alt="" /> <?php echo get_the_date(); ?> </span>
				<?php } ?>
				<?php echo ($show_author && $show_date && $show_comments) ? '&nbsp;' : '' ?>
				<?php if(!empty($comments) && $show_comments) { ?>
					<span class="wpspw-post-comments">
						<img src="<?php echo WPSPW_PRO_URL; ?>assets/images/comment-bubble.svg" alt="" />
						<a href="<?php the_permalink(); ?>#comments"><?php echo $comments.' '.$reply;  ?></a>
					</span>
				<?php } ?>
			</div>
		<?php }
		if($show_content) { ?>
			<div class="wpspw-post-content">
				<?php if( empty($show_full_content) ) {
					if(!empty(get_the_content()) ) { ?>
                        <?php print_r(get_post_custom_values('Link')) ?>
						<div class="wpspw-post-line-1"></div>
							<div class="wpspw-post-short-content">
                                <?php
                                        echo wpspw_pro_get_post_excerpt( $post->ID, get_the_content(), $content_words_limit, $content_tail );
                                        if ($downloadLink !== [])
                                            echo '<a class="btn btn-primary" href="'.$downloadLink[0].'" target="_blank"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Download</a>';
                                ?>
                            </div>
						<div class="wpspw-post-line-2"></div>
					<?php } ?>
					<?php if($show_read_more) { ?>
						<a href="<?php echo esc_url($post_link); ?>" target="<?php echo $link_target; ?>" class="readmorebtn"><?php echo esc_html($read_more_text); ?></a>
					<?php } ?>
				<?php } else {
					the_content();
				} ?>
			</div>
		<?php } 
		if(!empty($tags) && $show_tags) { ?>
			<div class="wpspw-post-tags">
				<img src="<?php echo WPSPW_PRO_URL; ?>assets/images/price-tag.svg" alt="" />
				<?php echo $tags; ?>
			</div>
		<?php } ?>
	</div>
</div>
