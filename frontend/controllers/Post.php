<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends Base_Controller {
    public $desc = '文章页';

    public $js = [
        'bootstrap-2.3.2/js/bootstrap-carousel.js','jquery.reveal.js', 'jcityzen.js?v=1.0',
    ];

    public $css = [
        'post.css'
    ];

	public function index($id)
	{
        $this->load->model('Post_model', 'post');
        $data['post'] = $this->post->get_one([
            'id' => $id
        ]);
        if (isset($data['post']['id'])) {
            $data['post']['content'] = json_decode($data['post']['content'], true);
            $data['post']['main_pic'] = $data['post']['pic'];
            $data['post']['vice_pic'] = $data['post']['sub_pic'];
            $this->title = $data['post']['title'];
            $this->view('post/index', $data);
        } else {
            $this->_error(Message::NO_RECORD_ERROR['code'], Message::NO_RECORD_ERROR['msg']);
        }
	}
}
