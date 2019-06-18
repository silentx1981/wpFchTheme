<?php

namespace wpFchTheme;

class Spielbetrieb
{

	public function show($url)
	{
		$iframe = '<iframe class="sfvFullHeight" src="'.$url.'" frameborder="0" scrolling="yes" style="height: 500px; width: 100%"></iframe>';
		echo $iframe;
		return '';
	}

}