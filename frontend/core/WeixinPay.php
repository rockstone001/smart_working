<?php
require_once('WxPay.Data.php');
class WeixinPay
{
	private $notify_url = '/order/notify';
	/**
	 * @param $order_id
	 * @param $amount
	 * @return mixed
	 * @desc 统一下单
	 */
	public function unifiedorder($openid, $order_id, $amount)
	{
		$input = new WxPayUnifiedOrder();
		$input->SetBody('道生课程');
		$input->SetOut_trade_no($order_id);
		$input->SetTotal_fee($amount);
		$input->SetNotify_url(config_item('index_url') . $this->notify_url);
		$input->SetTrade_type('JSAPI');
		$input->SetOpenid($openid);

		return WxPayApi::unifiedOrder($input);
	}

	public function notify($order_instance)
	{
		$msg = '';
		$rtn = WxPayApi::notify([
			$this, 'notify_result'
		], $msg, $order_instance);
		if ($msg == '' && $rtn) {
			$fhandler = fopen(dirname(__FILE__) . '/../data/pay.log', 'a');
			fwrite($fhandler, 'everything is ok!');
			fclose($fhandler);
            WxPayApi::replyNotify('<xml><return_code><![CDATA[SUCCESS]]></return_code></xml>');
            exit();
		} else {
            $fhandler = fopen(dirname(__FILE__) . '/../data/pay.log', 'a');
            fwrite($fhandler, $msg . ' | error');
            fclose($fhandler);
            WxPayApi::replyNotify('<xml><return_code><![CDATA[FAIL]]></return_code></xml>');
            exit();
        }
	}

	public function notify_result($result, $instance)
	{
		$fhandler = fopen(dirname(__FILE__) . '/../data/pay.log', 'a');
		fwrite($fhandler, http_build_query($result));
		fclose($fhandler);
		if (isset($result['result_code']) && $result['result_code'] == 'SUCCESS') {
            $instance->load->model('Order_model', 'order');
            if ($instance->order->update_order([
                'trade_type' => $result['trade_type'],
                'bank_type' => $result['bank_type'],
                'total_fee' => $result['total_fee'],
                'cash_fee' => $result['cash_fee'],
                'transaction_id' => $result['transaction_id'],
                'time_end' => $result['time_end'],
                'state' => 1,
            ], [
                'order_id' => $result['out_trade_no']
            ])) {
                //更新成功
				//发送短信
				$sms = new SMS();
				$order = $instance->order->get_one([
					'order_id' => $result['out_trade_no']
				]);
				$instance->load->model('Lesson_model', 'lesson');
				$lesson = $instance->lesson->get_one([
					'id' => $order['lesson_id']
				]);
				$sms->send($order['mobile'], $lesson['title'], date('Y-m-d H:i', strtotime($lesson['start_time'])), $lesson['address']);

                return true;
            }
		}
        return false;
	}

}
