<?php
/**
 * 扩展CI_Controller类, 目的是在处理请求逻辑之前统一为每个请求做处理
 * @author zhuang
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Message {

	const DEFAULT_CREATED_BY = '系统';
	const DEFAULT_UPDATED_BY = '系统';

	const PARAM_ERROR = [
		'code' => '400001',
		'msg' => '参数: %s 格式错误',
	];
	const IN_BLACK_LIST = [
		'code' => '400002',
		'msg' => '手机号码被限制',
	];
	const MOBILE_OCCUPIED = [
		'code' => '400003',
		'msg' => '手机号已经占用',
	];
	const MOBILE_NOT_REGISTED = [
		'code' => '400004',
		'msg' => '手机号尚未绑定',
	];
	const GENERATE_CODE_FAILED = [
		'code' => '400005',
		'msg' => '生成验证码失败',
	];
	const GENERATE_CODE_FREQUENCE_LIMIT = [
		'code' => '400006',
		'msg' => '验证码请求时间间隔不能低于60秒',
	];
	const GENERATE_CODE_TOO_MUCH = [
		'code' => '400007',
		'msg' => '验证码请求过多(30分钟内多余15次)',
	];
	const SMS_SEND_FAILED = [
		'code' => '400008',
		'msg' => '发送短信失败',
	];
	const CODE_WRONG = [
		'code' => '400009',
		'msg' => '验证码错误',
	];
	const CODE_EXPIRED = [
		'code' => '400010',
		'msg' => '验证码过期',
	];
	const ADD_USER_FAILED = [
		'code' => '400011',
		'msg' => '生成用户失败',
	];
	const INVALID_TOKEN = [
		'code' => '400012',
		'msg' => '无效token',
	];
	const EXPIRED_TOKEN = [
		'code' => '400013',
		'msg' => 'token过期',
	];
	const UPDATE_USER_INFO_FAILED = [
		'code' => '400014',
		'msg' => '更新用户信息失败',
	];
	const BIND_FAILED = [
		'code' => '400015',
		'msg' => '绑定失败',
	];
	const PWD_WRONG = [
		'code' => '400017',
		'msg' => '密码错误',
	];
	const ACCESS_DENY = [
		'code' => '400018',
		'msg' => '限制操作',
	];
	const READ_CONFIG_FAILED = [
		'code' => '400019',
		'msg' => '读取配置文件失败',
	];
	const ADD_RECORD_FAILED = [
		'code' => '400020',
		'msg' => '添加记录失败',
	];
	const UPDATE_USER_STEPS_FAILED = [
		'code' => '400021',
		'msg' => '更新用户步数失败',
	];
	const REMOVE_RECORD_FAILED = [
		'code' => '400022',
		'msg' => '删除记录失败',
	];
	const ACTIVITY_SUPPORT_FAILED = [
		'code' => '400023',
		'msg' => '用户参与活动失败',
	];
	const UPLOAD_AVATAR_FAILED = [
		'code' => '400024',
		'msg' => '上传头像失败',
	];
	const PWD_WRONG_OR_USER = [
		'code' => '400025',
		'msg' => ' 用户名/密码错误',
	];
	const UPLOAD_ERROR = [
		'code' => '400026',
		'msg' => '上传失败',
	];
	const PREVIEW_ERROR = [
		'code' => '400027',
		'msg' => '预览失败',
	];
	const NO_RECORD_ERROR = [
		'code' => '400028',
		'msg' => '找不到记录',
	];
	const UPDATE_RECORD_ERROR = [
		'code' => '400029',
		'msg' => '更新记录失败',
	];
}
