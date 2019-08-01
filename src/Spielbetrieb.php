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
		$pos1 = mb_strpos($content, '<div class="row nisObjRD">');
		$pos2 = mb_strpos($content, '<footer');
		$content = mb_substr($content, $pos1, $pos2 - $pos1, 'UTF-8');
		$content = preg_replace('/\&nbsp;/', ' ', $content);
		$content = preg_replace('#(<br\s*\/?>\s*){1,}#i', '', $content);
		$content = str_replace('<span class="sppStatusText">nicht gespielt (Gegner)</span>', 'SpielStatus=G', $content);

		$xml = simplexml_load_string($content);
		$json = json_encode($xml);
		$array = json_decode($json, true);

		$data = [
			'datum' => '',
			'datumzeit' => '',
			'nextTeam' => '',
			'nextTor' => '',
			'spiele' => [],
		];
		return json_encode($this->processArrayData($array, $data)['spiele'] ?? []);
	}

	private function processArrayData($array, $data)
	{

		foreach ($array as $key => $value) {
			if ($key === 'h4' && trim($value) === 'Aktuelle Spiele')
				$data['spiele'] = [];
			$datum = $this->processDatumToDate($value);
			if ($datum !== null) {
				$data['datum'] = $datum;
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