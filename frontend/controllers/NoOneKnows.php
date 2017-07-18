<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NoOneKnows extends Base_Controller {

    public function download_image()
    {
        $this->load->model('Download_data_model', 'download_data');
        $data = $this->download_data->get_all_data();
        $wechat = new WeChat();
        foreach ($data as $v) {
            $data = $wechat->getMedia($v['server_id']);
            $json = json_decode($data, true);
            if (!isset($json['errcode'])) {
                $this->download_data->update_image($data, $v);
            }
        }
    }
}





