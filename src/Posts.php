<?php

namespace wpFchTheme;

class Posts
{

	public function show()
	{
		$args = array(
			'numberposts' => 5,
			'offset' => 0,
			'category' => 0,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'include' => '',
			'exclude' => '',
			'meta_key' => '',
			'meta_value' =>'',
			'post_type' => 'blog_post',
			'post_status' => 'publish',
			'suppress_filters' => true
		);

		$posts = wp_get_recent_posts( $args, ARRAY_A );
		foreach ($posts as &$post) {
			$displayName = get_the_author_meta('display_name', $post['post_author']);
			$post['displayName'] = $displayName;
		}
		$posts[0]['active'] = 'active';
		include('template/posts.tpl.php');
		return "";
	}

}