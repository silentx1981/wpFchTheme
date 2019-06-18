<?php

namespace wpFchTheme;

class Person
{

	public function show($personData = [])
	{
		if ($personData['mail'] !== null) {
			$personData['maillink'] = str_replace('@', '[ät-zeichen]', $personData['mail']);
			$personData['mail'] = str_replace('@', '<i class="fas fa-at"></i>', $personData['mail']);
		}

		include('template/person.tpl.php');
		return '';
	}

}