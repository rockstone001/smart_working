<?php
/**
 * 扩展CI_Controller类, 目的是在处理请求逻辑之前统一为每个请求做处理
 * @author zhuang
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Location {
	const AK = 'TVjlj0uiMO1GZndzkeK88juDpvz4D0Yl';

	const URL = 'http://api.map.baidu.com/geocoder/v2/';

	const URL_WEATHER = 'http://api.map.baidu.com/telematics/v3/weather';

	public function geo($longitude, $latitude)
	{
		$location = '';
		$post_string = 'output=json&ak=' . self::AK . '&location=' . $latitude . ',' . $longitude;
		$data = json_decode($this->sock_post(self::URL, $post_string), true);
		if (isset($data['status']) && !$data['status']) {
			isset($data['result']['addressComponent']['province']) && $location = $data['result']['addressComponent']['province'];
		}
		return $location;
	}

	public function weather($location)
	{
		$weather = '';
		$temperature = 0;

		$post_string = 'location=' . $location . '&output=json&ak=' . self::AK;
		$data = json_decode($this->sock_get(self::URL_WEATHER, $post_string), true);
		if (isset($data['error']) && !$data['error']) {
			if (isset($data['results'][0]['weather_data'][0])) {
				$weather_data = $data['results'][0]['weather_data'][0];
				$weather = $weather_data['weather'];
				if (preg_match('/：(\d*)℃/', $weather_data['date'], $match)) {
					isset($match[1]) && $temperature = $match[1];
				}
			}
		}
		return [
			'weather' => $weather,
			'temperature' => $temperature
		];
	}

	/**
	 * @param $url
	 * @param $query
	 * @return string
	 * @desc 发送socket请求
	 */
	private function sock_post($url, $query)
	{
		$data = "";
		$info=parse_url($url);
		$fp=fsockopen($info["host"],80,$errno,$errstr,30);
		if(!$fp){
			return $data;
		}
		$head="POST ".$info['path'] . " HTTP/1.0\r\n";
		$head.="Host: ".$info['host']."\r\n";
		$head.="Referer: http://".$info['host'].$info['path']."\r\n";
		$head.="Content-type: application/x-www-form-urlencoded\r\n";
		$head.="Content-Length: ".strlen(trim($query))."\r\n";
		$head.="\r\n";
		$head.=trim($query);
		$write=fputs($fp,$head);
		$header = "";
		while ($str = trim(fgets($fp,4096))) {
			$header.=$str;
		}
		while (!feof($fp)) {
			$data .= fgets($fp,4096);
		}
		return $data;
	}

	private function sock_get($url, $query)
	{
		$data = "";
		$info=parse_url($url);
		$fp=fsockopen($info["host"],80,$errno,$errstr,30);
		if(!$fp){
			return $data;
		}
		$head="GET ".$info['path'] . '?' . $query . " HTTP/1.0\r\n";
		$head.="Host: ".$info['host']."\r\n";
		$head.="Referer: http://".$info['host'].$info['path']."\r\n";
		$head.="Content-type: application/x-www-form-urlencoded\r\n";
//		$head.="Content-Length: ".strlen(trim($query))."\r\n";
		$head.="\r\n";

		$write= fputs($fp,$head);
		$header = "";
		while ($str = trim(fgets($fp,4096))) {
			$header.=$str;
		}
		while (!feof($fp)) {
			$data .= fgets($fp,4096);
		}
		return $data;
	}
}
