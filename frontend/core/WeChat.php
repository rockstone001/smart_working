<?php
class WeChat
{
	private $app_id = 'wx1690f79552ac0979';
	private $app_secret = '4407e585ab2a497e8cb2396ffa6db952';
	private $api_host = 'https://api.weixin.qq.com/cgi-bin/';
	private $accessTokenFile = '/accessTokenWechat.log';
	private $ticketFile = '/ticketWechat.log';
	private $token = 'SmartWorking2017';

	private $urlParams = array();


	public function __construct()
	{
		$this->accessTokenFile = dirname(__FILE__).$this->accessTokenFile;
		$this->ticketFile = dirname(__FILE__).$this->ticketFile;
		$this->urlParams = array(
			'access_token' => $this->getAccessToken()
		);
	}

    public function valid()
    {

//        (new Messages())->save_voice([]);

//        $model = new Messages();
//        print_r($model);
//        $model->save_voice([]);
//        die('fuck');
        $echoStr = $_GET["echostr"];



        //valid signature , option
        if($this->checkSignature()){
//            $this->responseMsg();
            echo $echoStr;
            exit;
        } else {
            die('something wrong');
        }
    }

	public function getAppID()
	{
		return $this->app_id;
	}

	public function getAppSecret()
	{
		return $this->app_secret;
	}


	/**
     * 获取accessToken
     * 先从本地获取， 如果找不到就刷新接口
	**/
	public function getAccessToken()
	{
		if (file_exists($this->accessTokenFile)) {
			$accessToken = json_decode(file_get_contents($this->accessTokenFile), true);
			if (isset($accessToken['expires_in']) && $accessToken['expires_in'] > date('U')) {
				return $accessToken['access_token'];
			}
		}
		$accessToken = $this->refreshAccessToken();
		return $accessToken['access_token'];
	}

	/**
	 * 创建menu
	**/
	public function createMenu($menu)
	{
		return $this->getResponse('menu/create', $this->urlParams, $menu);
	}

	/**
	 * 删除menu
	**/
	public function deleteMenu()
	{
		return $this->getResponse('menu/delete', $this->urlParams);
	}

	/**
	 * 获取素材列表
	 * @param $type in [image, video, voice, news]
	**/
	public function getAllMaterial($type='news')
	{
		$postParams = array(
			'type' => $type,
		    'offset' => 0,
		    'count' => 20
		);
		$data = $this->getResponse('material/batchget_material', $this->urlParams, json_encode($postParams, JSON_UNESCAPED_UNICODE));
		print_r($data);
	}

	/**
	 * 新增素材
	**/
	public function addNewMaterial($type='news', $data='')
	{
		$data = $this->getResponse('material/add_news', $this->urlParams, $data);
		print_r($data);

	}

	/**
	 * 获取用户信息
	**/
	public function getUserInfo($openID=null)
	{
		$userInfo = array();
		if (isset($openID)) {
			$this->urlParams['openid'] = $openID;
			$this->urlParams['lang'] = 'zh_CN';
			$data = $this->getResponse('user/info', $this->urlParams);
			return json_decode($data, true);
		}
	}

	public function getTicket()
	{
		if (file_exists($this->ticketFile)) {
			$ticket = json_decode(file_get_contents($this->ticketFile), true);
			if (isset($ticket['expires_in']) && $ticket['expires_in'] > date('U')) {
				return $ticket['ticket'];
			}
		}
		$ticket = $this->refreshTicket();
		return $ticket['ticket'];
//		https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi
	}

	private function refreshTicket()
	{
		$this->urlParams['type'] = 'jsapi';
		$ticket = json_decode($this->getResponse('ticket/getticket', $this->urlParams), true);
		$ticket['expires_in'] = date('U') + 7190;

		$fh = fopen($this->ticketFile, 'w');
		if ($fh) {
			$loopNumMax = 5;
			$lock = true;
			while (!flock($fh, LOCK_EX)) {
				sleep(1);
				$loopNumMax --;
				if ($loopNumMax < 0) {
					$lock = false;
					break;
				}
			}
			if ($lock) {
				fwrite($fh, json_encode($ticket));
				flock($fh, LOCK_UN);
			}
			fclose($fh);
		}
		return $ticket;
	}

	/**
     * 刷新accessToken 
	**/
	private function refreshAccessToken()
	{
		$accessToken = json_decode($this->getResponse('token', array(
			'grant_type' => 'client_credential', 'appid' => $this->app_id, 'secret' => $this->app_secret
			)), true);
		$accessToken['expires_in'] += date('U');

		$fh = fopen($this->accessTokenFile, 'w');
		if ($fh) {
			$loopNumMax = 5;
			$lock = true;
			while (!flock($fh, LOCK_EX)) {
				sleep(1);
				$loopNumMax --;
				if ($loopNumMax < 0) {
					$lock = false;
					break;
				}
			}
			if ($lock) {
				fwrite($fh, json_encode($accessToken));
				flock($fh, LOCK_UN);
			}
			fclose($fh);
		}
		return $accessToken;
	}

	/**
	 * 通用接口
	 * 调用微信api获取返回
	**/
	private function getResponse($method, $params=array(), $postField='')
	{
		$url = $this->api_host.$method;
		$paramStr = '';
		while (list($key, $val) = each($params)) {
			$paramStr .= '&'.$key.'='.$val;
		}
		$paramStr = empty($paramStr)?'':'?'.substr($paramStr, 1);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url.$paramStr);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_HEADER, false); //输出头文件信息
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if (!empty($postField)) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postField);
		}
		return curl_exec($ch);
	}

	public function responseMsg()
	{
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

		//extract post data
		if (!empty($postStr)){
			/* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
			libxml_disable_entity_loader(true);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword = trim($postObj->Content);
			$time = time();
			$sourceMsgType = $postObj->MsgType;
			$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
			switch ($sourceMsgType) {
				case 'text':
					$text = '您好，稍后我们将回复您的消息！';
					break;
				case 'image':
					$text = '您好，您的图片我们已经收到！';
					break;
				case 'event':
					$event = $postObj->Event;
					$key = $postObj->EventKey;
					$text = '这是一个'.$event.'事件， key='.$key;
					if ($key == 'subMenu-1-1') { /*特殊事件响应*/
						$title = '最新活动';
						$textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[news]]></MsgType>
                            <ArticleCount>1</ArticleCount>
                            <Articles>
                                <item>
                                <Title><![CDATA[%s]]></Title>
                                <Description><![CDATA[]]></Description>
                                <PicUrl><![CDATA[https://mmbiz.qlogo.cn/mmbiz/QpGPl5Y5Pl9N5clkEribdxyib72KUeu7KdrHdbbRvU4xAYlcxn81iaUicsUgDdQJRib0XnwJhjjsu2y1pr00j9ebFHQ/0?wx_fmt=jpeg]]></PicUrl>
                                <Url><![CDATA[http://www.zz2020.com/wechat/link.php?openID=".$fromUsername."]]></Url>
                                </item>
                            </Articles>
                            </xml>";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $title);
						echo $resultStr;
					}
					break;
                case 'voice':
                    $text = '您好，您的留言 我们已经收到! 稍后回复!';
                    $text .= (new Messages())->save_voice($postObj);
                    break;
				default:
					$text = '您好，稍后我们将回复您的消息！';
					break;
			}
			$text .= $keyword;
			$msgType = "text";
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $text);
//            var_dump($resultStr);
			echo $resultStr;

		}else {
			echo "";
			exit;
		}
	}

	private function checkSignature()
	{
		// you must define TOKEN by yourself

		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];

		$token = $this->token;
		$tmpArr = array($token, $timestamp, $nonce);

//        print_r($tmpArr);
		// use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	public function goto_auth($redirect_url, $scope='snsapi_userinfo')
	{
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize';
		$params = [
			'appid' => $this->app_id,
			'redirect_uri' => $redirect_url,
			'response_type' => 'code',
			'scope' => $scope,
			'state' => '2016',
		];
		$url .= '?' . http_build_query($params) . '#wechat_redirect';
		header('location:' . $url);
	}

	public function get_auth_access_token($code)
	{
		$this->api_host = 'https://api.weixin.qq.com/sns/';
		return json_decode($this->getResponse('oauth2/access_token', [
			'appid' => $this->app_id,
			'secret' => $this->app_secret,
			'code' => $code,
			'grant_type' => 'authorization_code'
		]), true);
	}

	public function refresh_token($refresh_token)
	{
		$this->api_host = 'https://api.weixin.qq.com/sns/';
		return json_decode($this->getResponse('oauth2/refresh_token', [
			'appid' => $this->app_id,
			'grant_type' => 'refresh_token',
			'refresh_token' => $refresh_token
		]), true);
	}

	public function get_user_info($access_token, $openid)
	{
		$this->api_host = 'https://api.weixin.qq.com/sns/';
		return json_decode($this->getResponse('userinfo', [
			'access_token' => $access_token,
			'openid' => $openid,
			'lang' => 'zh_CN',
		]), true);
	}

	public function sendMsg($to_users, $text)
	{
//		https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=ACCESS_TOKEN
		$postParams = array(
			'touser' => $to_users,
			'msgtype' => 'text',
			'text' => [
				'content' => $text
			],
		);
		$data = $this->getResponse('message/mass/send', $this->urlParams, json_encode($postParams, JSON_UNESCAPED_UNICODE));
		print_r($data);
	}

	public function getMedia($serverID)
	{
		$rtn_url = '';
		$this->urlParams['media_id'] = $serverID;
		$data = $this->getResponse('media/get', $this->urlParams);
		return $data;

		if (isset($data['video_url'])) {
			$rtn_url = $data['video_url'];
		} else {
			var_dump($data);
		}
		return $rtn_url;
	}
}