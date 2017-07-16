<?php
/**
 * 扩展CI_Controller类, 目的是在处理请求逻辑之前统一为每个请求做处理
 * @author zhuang
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class SMS {
	const KEY = 'e8d8a99ec675458dd6518bcf2f40a589';

    const FORMAT = '【道生中医】您已报名：%s,时间：%s,地址：%s';

	const URL = 'http://yunpian.com/v1/sms/send.json';

	public function send($mobile, $lesson_name, $lesson_time, $lesson_address)
	{
		$encoded_text = urlencode(sprintf(self::FORMAT, $lesson_name, $lesson_time, $lesson_address));
		$post_string = 'apikey=' . self::KEY . '&text=' . $encoded_text . ' &mobile=' . $mobile;

		return json_decode($this->sock_post(self::URL, $post_string), true);
	}

	public function get_msg($lesson_name, $lesson_time, $lesson_address)
	{
		return sprintf(self::FORMAT, $lesson_name, $lesson_time, $lesson_address);
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
		$head="POST ".$info['path']." HTTP/1.0\r\n";
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

}
