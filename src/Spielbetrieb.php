<?php

namespace wpFchTheme;

use DateInterval;
use DateTime;

class Spielbetrieb
{

	public function show($url)
	{
		$iframe = '<iframe class="sfvFullHeight" src="'.$url.'" frameborder="0" scrolling="yes" style="height: 500px; width: 100%"></iframe>';
		echo $iframe;
		return '';
	}

	public function showOnlyData($attr = [])
	{
		$url = $attr['url'] ?? null;
		$file = $attr['file'] ?? null;
		$type = $attr['type'] ?? null;
		$grid = $attr['grid'] ?? 2;
		$hometeam = $attr['hometeam'] ?? null;
		if ($url === null)
			return '';

		$locale = json_decode(file_get_contents(get_template_directory().'/src/locale/de.json'), true);
		$data = $this->getData($url, $file, $hometeam);
		$spiele = json_decode($data, true);
        $slideSpiele = $this->renderSpieleForSlider(array_values($spiele['spieleliste']));
        $slideSpiele = $this->renderSpieleForSliderGrid($slideSpiele, $grid, $type);

		if ($type === 'slider')
            include('template/spielbetrieb.slider1.php');
		elseif ($type === 'grid')
            include('template/spielbetrieb.grid1.php');
		else
		    include('template/spielbetrieb.tpl.php');
	}

	private function renderSpieleForSliderGrid($spiele, $grid = 2, $type = null)
    {
        $result = [];
        $gridSpiele = [
            'Active' => false,
            'Spieltage' => [],
        ];
        foreach ($spiele as $spielkey => $spiel) {
            $gridSpiele['Spieltage'][$spielkey] = $spiel;
            if ($spiel['Active'] ?? null)
                $gridSpiele['Active'] = 'active';
            if (count($gridSpiele['Spieltage']) === (int) $grid && $type === 'slider') {
                $result[] = $gridSpiele;
                $gridSpiele = [
                    'Active' => false,
                    'Spieltage' => [],
                ];
            }
        }
        if ($gridSpiele !== [])
            $result[] = $gridSpiele;

        return $result;
    }

	private function renderSpieleForSlider($spielliste, $index = 0, $result = [])
    {
        $today = date('Y-m-d');
        $spiel = $spielliste[$index] ?? null;
        if ($spiel === null)
            return $result;

        $datum = date('Y-m-d', strtotime($spiel['Datumzeit']));
        if (!isset($result[$datum]))
            $result[$datum]['spiele'] = [];

        $result[$datum]['spiele'][] = $spiel;
        if ($spiel['Active'] ?? null)
            $result[$datum]['Active'] = true;

        return $this->renderSpieleForSlider($spielliste, $index + 1, $result);
    }

	private function getData($url, $file = null, $hometeam = null)
	{
		if ($file === null)
			return $this->loadUrlData($url, $hometeam);

		$this->loadUrlData($url, $hometeam);

		$dir = get_template_directory()."/json";
		$filePath = "$dir/$file";
		$now = new DateTime();
		$filedate = $now;
		if (file_exists($filePath))
			$filedate = new DateTime(date('Y-m-d H:i:s', filemtime($filePath)));
		if (!file_exists($filePath) || $now->add(new DateInterval('PT5M')) > $filedate) {
			$result = $this->loadUrlData($url, $hometeam);
			if ($result !== null)
				file_put_contents($filePath, $result);
			else
				$result = file_get_contents($filePath);
		} else {
			$result = file_get_contents($filePath);
		}
		return $result;
	}

	private function loadUrlData($url, $hometeam)
	{
		$content = @ file_get_contents($url);
		$content = $this->getContentData($content);
		$content = preg_replace('/\&nbsp;/', ' ', $content);
		$content = preg_replace('#(<br\s*\/?>\s*){1,}#i', '', $content);
		$content = preg_replace('/\&/', '', $content);

		do {
			$divCount = mb_substr_count($content, '<div');
			$divCountSlash = mb_substr_count($content, '</div');
			$divDiff = $divCountSlash - $divCount;
			if ($divDiff > 0) {
				$pos = mb_strrpos($content, '</div>');
				$content = mb_substr($content, 0, $pos);
			}
		} while ($divDiff > 0);

		$xmlparser = xml_parser_create();
		xml_parse_into_struct($xmlparser,$content,$values);
		xml_parser_free($xmlparser);

		$data = [
			'datum' => '',
			'datumzeit' => '',
			'nextTeam' => '',
			'rang' => '',
			'team' => '',
			'typ' => '',
			'spiele' => [],
			'spieleliste' => [],
			'rangliste' => [],
		];

		$content = $this->processContentToData($values, $data, $hometeam);
		if ($content['spiele'] === [] && $content['rangliste'] === [])
			return null;

		$content = $this->processEJuniorenRenaming($content);

		return json_encode($content);
	}

	private function processEJuniorenRenaming($content)
	{
		foreach ($content['spieleliste'] as &$spiel) {
				$posJun = strpos($spiel['Typ'], 'Junioren E');

				if (!$posJun)
					continue;
				$team = $spiel[$spiel['HomeTeam']];
				$posA = strpos($team, 'FC Hägendorf a');
				$posB = strpos($team, 'FC Hägendorf b');
				if ($posA !== false) {
					$spiel['Typ'] = $spiel['Typ']." weiss";
					$spiel[$spiel['HomeTeam']] = 'FC Hägendorf weiss';
				}
				if ($posB !== false) {
					$spiel['Typ'] = $spiel['Typ']." blau";
					$spiel[$spiel['HomeTeam']] = 'FC Hägendorf blau';
				}
		}
		return $content;
	}

	private function processContentToData($array, $data, $hometeam)
	{
		$typ = '';
		$typclass = '';
		$spielnummer = '';
		$location = '';
		$nextPunkte = false;
		$hometeamText = $hometeam;
		$today = date('Y-m-d');
		$active = null;
		foreach ($array as $key => $value) {

			if ($value['tag'] === 'H4')
				$data['spiele'] = [];
			if ($value['tag'] === 'H4' && trim($value['value']) === 'Aktuelle Spiele')
				$data['typ'] = 'AS';
			else if ($value['tag'] === 'H4' && trim($value['value']) === 'Team-Spielplan')
				$data['typ'] = 'TS';

			// Datum
			$datum = $this->processDatumToDate($value['value'] ?? '');
			if ($datum !== null) {
				$data['datum'] = $datum;
				$data['datumzeit'] = $datum." 00:00";
			} else if ($data['datum'] !== '' && $data['typ'] === 'TS') {
			    $date = date('Y-m-d', strtotime($data['datum']));
			    if ($date >= $today && $active === null)
			        $active = true;
				$data['datumzeit'] = $data['datum']." ".trim(($value['value'] ?? ''));
				$data['spiele'][$data['datumzeit']] = [
					"TeamA" => '',
					"TeamB" => '',
					"TorA" => '',
					"TorB" => '',
					"Status" => '',
					"Typ" => $typ,
					"TypClass" => $typclass,
					"Spielnummer" => $spielnummer,
					"Datumzeit" => $data['datumzeit'],
					"Location" => $location,
					"HomeTeam" => $hometeam,
                    "Active"   => $active,
				];
				$data['datum'] = '';
			} else if ($data['typ'] === 'AS' && preg_match('/^([0-9:]){5}$/', trim(($value['value'] ?? '')))) {
                $date = date('Y-m-d', strtotime($data['datum']));
                if ($date >= $today && $active === null)
                    $active = true;
				$data['datumzeit'] = $data['datum']." ".trim($value['value']);
				$data['spiele'][$data['datumzeit']] = [
					"TeamA" => '',
					"TeamB" => '',
					"TorA" => '',
					"TorB" => '',
					"Status" => '',
					"Typ" => $typ,
					"TypClass" => $typclass,
					"Spielnummer" => $spielnummer,
					"Datumzeit" => $data['datumzeit'],
					"Location" => $location,
					"HomeTeam" => $hometeam,
                    "Active"   => $active,
				];
			}
            if ($active)
                $active = false;

			$class = $value['attributes']['CLASS'] ?? '';
			preg_match('/(team[AB])/', $class, $team);
			preg_match('/(tor[AB])/', $class, $tor);
			if (($team[0] ?? '') !== '')
				$data['nextTeam'] = $team[0];
			if ($data['nextTeam'] !== '' && $class === 'tabMyTeam') {
				$team = ($data['nextTeam'] === 'teamA') ? 'TeamA' : 'TeamB';
				$data['spiele'][$data['datumzeit']][$team] = $value['value'] ?? '';
				if ($hometeam !== '' && strpos($data['spiele'][$data['datumzeit']][$team], $hometeam) !== false)
					$data['spiele'][$data['datumzeit']]['HomeTeam'] = $team;
				$data['nextTeam'] = '';
			} else if ($data['nextTeam'] !== '' && $class === 'ranCteamSpan') {
				$team = ($data['nextTeam'] === 'teamA') ? 'TeamA' : 'TeamB';
				$data['spiele'][$data['datumzeit']][$team] = $value['value'] ?? '';
				if ($hometeam !== '' && strpos($data['spiele'][$data['datumzeit']][$team], $hometeam) !== false)
					$data['spiele'][$data['datumzeit']]['HomeTeam'] = $team;
				$data['nextTeam'] = '';
			}
			if (($tor[0] ?? '') !== '') {
				$tor = ($tor[0] === 'torA') ? 'TorA' : 'TorB';
				$data['spiele'][$data['datumzeit']][$tor] = trim($value['value']) ?? '';
			}
			if ($class === 'sppStatusText')
				$data['spiele'][$data['datumzeit']]['Status'] = $value['value'] ?? '';
			if ($data['typ'] === 'TS' && $class === 'list-group-item sppTitel') {
				$typ = $value['value'];
			} else if ($data['typ'] === 'AS' && $class === 'col-xs-11 col-md-offset-1 font-small') {
				$typ = $value['value'];
				preg_match('/[0-9]{5,}/', $value['value'], $spielnummermatch);
				$spielnummermatch = $spielnummermatch[0] ?? null;
				$locationpos = strpos($value['value'], $spielnummermatch);
				$location = substr($value['value'], $locationpos + strlen($spielnummermatch));
				$data['spiele'][$data['datumzeit']]['Location'] = $location;
			}
			if (strpos($typ, 'Trainingsspiel')) {
				$typ = "Trainingsspiel";
				$typclass = "badge-secondary";
			} elseif (strpos($typ, 'Meister')) {
				$pos = strpos($typ, 'Spielnummer', 0);
				$pos = $pos === false ? strlen($typ) : $pos;
				$typ = trim(substr($typ, 0, $pos));
				$typ = $this->getTyp($typ);
				$typclass = "badge-primary";
			} elseif (strpos($typ, 'Cup')) {
				$pos = strpos($typ, 'Spielnummer', 0);
				$pos = $pos === false ? strlen($typ) : $pos;
				$typ = trim(substr($typ, 0, $pos));
				$typ = $this->getTyp($typ);
				$typclass = "badge-success";
			}
			if ($data['typ'] === 'AS' && isset($data['spiele'][$data['datumzeit']])) {
				$data['spiele'][$data['datumzeit']]['Typ'] = $typ;
				$data['spiele'][$data['datumzeit']]['TypClass'] = $typclass;
			}
			if ($data['typ'] === 'TS' && $class === 'col-xs-9 col-md-offset-3 font-small')
				$spielnummer = $value['value'] ?? '';
			if (isset($value['value']) && strpos($value['value'], 'Spielnummer') !== false)
				$spielnummer = $value['value'];
			preg_match('/[0-9]{5,}/', $spielnummer, $spielnummermatch);
			$spielnummer = $spielnummermatch[0] ?? null;
			$spielnummer = trim(str_replace('Spielnummer', '', $spielnummer));
			if (isset($data['spiele'][$data['datumzeit']]) && $spielnummer !== '')
				$data['spiele'][$data['datumzeit']]['Spielnummer'] = $spielnummer;
			if (isset($data['spiele'][$data['datumzeit']]) && $spielnummer !== '' && !isset($data['spieleliste'][$spielnummer]))
				$data['spieleliste'][$spielnummer] = $data['spiele'][$data['datumzeit']];

			if (($value['attributes']['CLASS'] ?? '') === 'ranCrang')
				$data['rang'] = $value['value'] ?? '';
			if (($value['attributes']['CLASS'] ?? '') === 'ranCteam')
				$data['nextTeam'] = 'ranCteam';
			if (!$nextPunkte && $data['nextTeam'] === 'ranCteam' && (($value['tag'] ?? '') === 'B' || ($value['tag'] ?? '') === 'A') && $value['value'] !== '0') {
				$data['team'] = $value['value'];
				$data['rangliste'][$value['value']] = [
					'rang' => $data['rang'],
					'team' => $value['value'],
					'spiele' => 0,
					'siege' => 0,
					'unentschieden' => 0,
					'niederlagen' => 0,
					'strafpunkte' => 0,
					'tore' => 0,
					'gegentore' => 0,
					'punkte' => 'x',
					'hometeam' => $hometeamText,
				];
			}
			if ($data['team'] !== '' && ($value['attributes']['CLASS'] ?? '') === 'ranCsp')
				$data['rangliste'][$data['team']]['spiele'] = $value['value'] ?? 0;
			if ($data['team'] !== '' && ($value['attributes']['CLASS'] ?? '') === 'ranCs')
				$data['rangliste'][$data['team']]['siege'] = $value['value'] ?? 0;
			if ($data['team'] !== '' && ($value['attributes']['CLASS'] ?? '') === 'ranCu')
				$data['rangliste'][$data['team']]['unentschieden'] = $value['value'] ?? 0;
			if ($data['team'] !== '' && ($value['attributes']['CLASS'] ?? '') === 'ranCn')
				$data['rangliste'][$data['team']]['niederlagen'] = $value['value'] ?? 0;
			if ($data['team'] !== '' && ($value['attributes']['CLASS'] ?? '') === 'ranCstrp')
				$data['rangliste'][$data['team']]['strafpunkte'] = $value['value'] ?? 0;
			if ($data['team'] !== '' && ($value['attributes']['CLASS'] ?? '') === 'ranCtg')
				$data['rangliste'][$data['team']]['tore'] = $value['value'] ?? 0;
			if ($data['team'] !== '' && ($value['attributes']['CLASS'] ?? '') === 'ranCte')
				$data['rangliste'][$data['team']]['gegentore'] = $value['value'] ?? 0;
			if ($value['tag'] === 'B' && $nextPunkte) {
				$data['rangliste'][$data['team']]['punkte'] = $value['value'] ?? 0;
				$nextPunkte = false;
			}
			if ($data['team'] !== '' && ($value['attributes']['CLASS'] ?? '') === 'ranCpt') {
				$nextPunkte = true;
			}
		}
		return $data;
	}

	private function getTyp($typ)
	{
		$pos = strpos($typ, '- Stärkeklasse');
		if ($pos !== false) $typ = substr($typ, 0, $pos);
		$pos = strpos($typ, '1. Stärkeklasse');
		if ($pos !== false) $typ = substr($typ, 0, $pos);
		$pos = strpos($typ, '2. Stärkeklasse');
		if ($pos !== false) $typ = substr($typ, 0, $pos);
		$pos = strpos($typ, '3. Stärkeklasse');
		if ($pos !== false) $typ = substr($typ, 0, $pos);
		$pos = strpos($typ, '- Gruppe');
		if ($pos !== false) $typ = substr($typ, 0, $pos);
		$pos = strpos($typ, '/ Gruppe');
		if ($pos !== false) $typ = substr($typ, 0, $pos);
		$pos = strpos($typ, '- Herbstrunde');
		if ($pos !== false) $typ = substr($typ, 0, $pos);
		return $typ;
	}

	private function getContentData($content)
	{
		$pos1 = mb_strrpos($content, '<div class="row nisObjRD">');
		$pos2 = mb_strpos($content, '<footer');
		$pos3 = mb_strpos($content, '<aside id="footer-widgets"');
		if ($pos3 < $pos2)
			$pos2 = $pos3;
		if (!$pos1)
			return $content;
		if (!$pos2)
			$pos2 = mb_strlen($content);
		$content = mb_substr($content, $pos1, $pos2 - $pos1, 'UTF-8');

		return $this->getContentData($content);
	}

	private function processArrayData($array, $data)
	{
		foreach ($array as $key => $value) {
			if ($key === 'h4' && !isset($data['spiele']))
				$data['spiele'] = [];
			$datum = $this->processDatumToDate($value);
			if ($datum !== null) {
				$data['datum'] = $datum;
				$data['datumzeit'] = $data['datum']." 00:00";
			}
			$status = $this->processStatus($value);
			if (!is_array($value) && preg_match('/^([0-9:]){5}$/', trim($value))) {
				$data['datumzeit'] = $data['datum']." ".trim($value);
				$data['spiele'][$data['datumzeit']] = [
					"TeamA" => "",
					"TeamB" => "",
					"Goals" => [],
					"Status" => "",
				];
			}
			if ($data['nextTeam'] !== '' && $key !== 'a' && $key !== '@attributes' && $key !== 'href') {
				$data['spiele'][$data['datumzeit']][$data['nextTeam']] = $value;
				$data['nextTeam'] = '';
			}
			if ($data['nextTor'] !== '' && $key !== '@attributes') {
				$data['spiele'][$data['datumzeit']]["Goals"] = $value;
				$data['nextTor'] = '';
			}
			if ($status !== null && isset($data['spiele'][$data['datumzeit']]))
				$data['spiele'][$data['datumzeit']]['Status'] = $status;
			if ($value === 'col-md-5 col-xs-12 teamA')
				$data['nextTeam'] = 'TeamA';
			if ($value === 'col-md-5 col-xs-12 teamB')
				$data['nextTeam'] = 'TeamB';
			if ($value === 'col-xs-1 goals')
				$data['nextTor'] = 'Goals';

			if (is_array($value))
				$data = $this->processArrayData($value, $data);
		}

		return $data;
	}

	private function processDatumToDate($datum)
	{
		if (is_array($datum))
			return null;

		$datum = trim($datum);
		if (!preg_match('/^([A-Za-z ]){3}([0-9\.]){10}$/', $datum))
			return null;

		$datum = preg_replace('/^([A-Za-z ]){3}/', '', $datum);
		$datumEx = explode('.', $datum);
		$date = mktime(0, 0, 0, $datumEx[1], $datumEx[0], $datumEx[2]);
		$datum = date('Y-m-d', $date);
		return $datum;
	}

	private function processStatus($status)
	{
		$result = null;
		if (is_array($status))
			return $result;

		if (strpos($status, 'SpielStatus=G'))
			$result = 'G';

		return $result;
	}

}
