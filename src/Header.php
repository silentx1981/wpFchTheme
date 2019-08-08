<?php

namespace wpFchTheme;

class Header
{

	public function show()
	{
		$headerImages = [];
		for ($i = 0; $i <= 5; $i++) {
			$nr = $i == 0 ? '' : $i;
			$image = get_theme_mod("image_header_background$nr");
			if ($image)
				$headerImages[] = [
					'active' => '',
					'url' => $image,
				];
		}
		$random = rand(0, count($headerImages) - 1);
		$headerImages[$random]['active'] = 'active';
		$headerImages = [$headerImages[$random] ?? $headerImages[0]];
		include_once('template/header.tpl.php');
	}

}