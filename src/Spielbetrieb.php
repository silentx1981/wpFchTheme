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
		if ($url === null)
			return '';

		$locale = json_decode(file_get_contents(get_template_directory().'/src/locale/de.json'), true);
		$data = $this->getData($url, $file);
		$spiele = json_decode($data, true);
		include('template/spielbetrieb.tpl.php');
	}

	private function getData($url, $file = null)
	{
		if ($file === null)
			return $this->loadUrlData($url);

		$dir = get_template_directory()."/json";
		$filePath = "$dir/$file";
		$now = new DateTime();
		$filedate = $now;
		if (file_exists($filePath))
			$filedate = new DateTime(date('Y-m-d H:i:s', filemtime($filePath)));
		if (!file_exists($filePath) || $now->add(new DateInterval('PT1H')) > $filedate) {
			$result = $this->loadUrlData($url);
			file_put_contents($filePath, $result);
		} else {
			$result = file_get_contents($filePath);
		}
		return $result;
	}

	private function loadUrlData($url)
	{
		$content = file_get_contents($url);
		$content = $this->getContentData($content);
		$content = preg_replace('/\&nbsp;/', ' ', $content);
		$content = preg_replace('#(<br\s*\/?>\s*){1,}#i', '', $content);
		$content = preg_replace('/\&/', '', $content);
		//$content = str_replace('<span class="sppStatusText">nicht gespielt (Gegner)</span>', 'SpielStatus=G', $content);

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
			'typ' => '',
			'spiele' => [],
		];

		return json_encode($this->processContentToData($values, $data)['spiele']);
	}

	private function processContentToData($array, $data)
	{
		foreach ($array as $key => $value) {

			if ($value['tag'] === 'H4')
				$data['spiele'] = [];
			if ($value['tag'] === 'H4' && trim($value['value']) === 'Aktuelle Spiele')
				$data['typ'] = 'AS';

			// Datum
			$datum = $this->processDatumToDate($value['value'] ?? '');
			if ($datum !== null) {
				$data['datum'] = $datum;
				$data['datumzeit'] = $datum." 00:00";
			} else if ($data['datum'] !== '' && $data['typ'] === '') {
				$data['datumzeit'] = $data['datum']." ".trim(($value['value'] ?? ''));
				$data['spiele'][$data['datumzeit']] = [
					"TeamA" => '',
					"TeamB" => '',
					"TorA" => '',
					"TorB" => '',
					"Status" => '',
				];
				$data['datum'] = '';
			} else if ($data['typ'] === 'AS' && preg_match('/^([0-9:]){5}$/', trim(($value['value'] ?? '')))) {
				$data['datumzeit'] = $data['datum']." ".trim($value['value']);
				$data['spiele'][$data['datumzeit']] = [
					"TeamA" => '',
					"TeamB" => '',
					"TorA" => '',
					"TorB" => '',
					"Status" => '',
				];
			}

			$class = $value['attributes']['CLASS'] ?? '';
			preg_match('/(team[AB])/', $class, $team);
			preg_match('/(tor[AB])/', $class, $tor);
			if (($team[0] ?? '') !== '')
				$data['nextTeam'] = $team[0];
			if ($data['nextTeam'] !== '' && $class === 'tabMyTeam') {
				$team = ($data['nextTeam'] === 'teamA') ? 'TeamA' : 'TeamB';
				$data['spiele'][$data['datumzeit']][$team] = $value['value'] ?? '';
				$data['nextTeam'] = '';
			} else if ($data['nextTeam'] !== '' && $class === 'ranCteamSpan') {
				$team = ($data['nextTeam'] === 'teamA') ? 'TeamA' : 'TeamB';
				$data['spiele'][$data['datumzeit']][$team] = $value['value'] ?? '';
				$data['nextTeam'] = '';
			}
			if (($tor[0] ?? '') !== '') {
				$tor = ($tor[0] === 'torA') ? 'TorA' : 'TorB';
				$data['spiele'][$data['datumzeit']][$tor] = $value['value'] ?? '';
			}
			if ($class === 'sppStatusText')
				$data['spiele'][$data['datumzeit']]['Status'] = $value['value'] ?? '';
		}
		return $data;
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