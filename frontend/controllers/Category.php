<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Base_Controller {
    public $desc = '分类页';

    public $js = [
        'bootstrap-2.3.2/js/bootstrap-carousel.js', 'jcityzen.js?v=1.2'
    ];

    public $css = [
        'post.css'
    ];

	public function index($id)
	{
        $data = $this->get_list($id);
        $this->title = $data['name'];
//        print_r($data);die();
        $this->view('category/index', $data);
	}

    private function get_list($cate_id = 0)
    {
        $this->load->model('Category_model', 'cate');
        $cate = $this->cate->get_one([
            'id' => $cate_id,
            'state' => 1
        ]);
        if (!isset($cate['id'])) {
            $this->_error(Message::NO_RECORD_ERROR['code'], Message::NO_RECORD_ERROR['msg']);
        }

        $data = [
            'name' => $cate['name'],
            'main_pic' => $cate['pic'],
            'list_style' => $cate['list_style'],
        ];
        $this->load->model('Post_model', 'post');
        $data['posts'] = $this->post->get_posts_by_cate_id($cate_id);
        return $data;
    }
}
