<?php

namespace wpFchTheme;

class Rotation
{

	public function show($sponsors)
	{
		$sponsors[0]['active'] = 'active';
		include('template/rotation.tpl.php');
		return "";
	}

}