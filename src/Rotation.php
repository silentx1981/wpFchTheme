<?php

namespace wpFchTheme;

class Rotation
{

	public function show($sponsors, $randomOrder = false)
	{
		if ($randomOrder && is_array($sponsors))
			shuffle($sponsors);
		$sponsors[0]['active'] = 'active';
		include('template/rotation.tpl.php');
		return "";
	}

}