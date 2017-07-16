<?php
/**
 * 扩展CI_Controller类, 目的是在处理请求逻辑之前统一为每个请求做处理
 * @author zhuang
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Tools {

	public static function is_mobile($mobile)
	{
		return preg_match('/^\d{11}$/', $mobile);
	}

	public static function is_number($param)
	{
		return preg_match('/^(-)*\d+$/', $param);
	}

	public static function is_safe($param)
	{
		return true;
	}

	public static function is_password($param)
	{
		return preg_match('/^.{6,20}$/', $param);
	}

	public static function is_date($param)
	{
		return preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $param);
	}

    public static function is_datetime($param)
    {
        return preg_match('/^\d{4}-\d{1,2}-\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/', $param);
    }

	public static function is_float($param)
	{
		return preg_match('/^(-)*\d+\.*\d*$/', $param);
	}

    public static function is_int($param)
    {
        return preg_match('/^(-)*\d+$/', $param);
    }

    public static function get_client_ip()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');

        } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
