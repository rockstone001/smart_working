<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends Base_Controller {
    public $desc = '文章管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

	public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'list.js']);
        $this->view('post/index');
	}

    public function new_post()
    {
        $this->js = array_merge($this->js, ['wangEditor.min.js', 'post.js']);
        $this->css = array_merge($this->css, ['uniform.default.css', 'wangEditor.min.css']);

        if(!isset($_POST['title'])) {
            $this->view('post/new_post', [
                'category' => $this->get_all_category(),
                'tag' => config_item('tags')
            ]);
        } else {
            $data = $this->get_post_params();
            $this->load->model('Post_model', 'post');
            if ($this->post->add($data)) {
                $this->redirect(config_item('index_url') . '/post/index');
            } else {
                $this->_error(Message::ADD_RECORD_FAILED['code'], Message::ADD_RECORD_FAILED['msg']);
            }
        }
    }

    public function get_list()
    {
        $params = $this->get_params([
            'limit', 'offset', 'title'
        ]);

        $this->load->model('Post_model', 'post');
        $data = $this->post->get_post_list([
            'state' => 1
        ], $params['limit'], $params['offset'], $params['title']);

        $this->_json($this->format_data($data));
    }

    private function format_data($data)
    {
        $category = $this->get_all_category_2();;

        foreach ($data['rows'] as &$v) {
            $v['category'] = $category[$v['cate_id']];
        }
        return $data;
    }

    public function remove()
    {
        $params = $this->post_params([
            'post_ids'
        ]);
        $this->load->model('Post_model', 'post');
        if ($this->post->remove_batch($params['post_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->js = array_merge($this->js, ['wangEditor.min.js', 'post.js']);
        $this->css = array_merge($this->css, ['uniform.default.css', 'wangEditor.min.css']);
        if(!isset($_POST['title'])) {
            $this->view('post/new_post', array_merge($this->get_post($id), [
                'category' => $this->get_all_category(),
                'tag' => config_item('tags')
            ]));
        } else {
            $data = $this->get_post_params();
            $this->load->model('Post_model', 'post');
            if ($this->post->update($data, [
                'id' => $id
            ])) {
                $this->redirect(config_item('index_url') . '/post/index');
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }

    private function get_post_params()
    {
        $params = $this->post_params([
            'cate_id', 'title', 'sub_title', 'main_pic', 'vice_pic',
            'cols_num', 'col_1', 'col_1_class', 'col_2', 'col_2_class',
            'col_3', 'col_3_class', 'summary', 'tags', 'post_style'
        ]);
        $data = [
            'title' => $params['title'],
            'sub_title' => $params['sub_title'],
            'pic' => $params['main_pic'],
            'sub_pic' => $params['vice_pic'],
            'uid' => $this->uid,
            'cate_id' => $params['cate_id'],
            'summary' => $params['summary'],
            'tags' => implode(',', $params['tags']),
            'post_style' => $params['post_style'],
        ];
        $content[] = [
            'class' => $params['col_1_class'],
            'content' => $params['col_1']
        ];
        if ($params['cols_num'] > 1) {
            $content[] = [
                'class' => $params['col_2_class'],
                'content' => $params['col_2']
            ];
        }
        if ($params['cols_num'] > 2) {
            $content[] = [
                'class' => $params['col_3_class'],
                'content' => $params['col_3']
            ];
        }

        $data['content'] = json_encode($content);
        return $data;
    }

    private function get_post($id)
    {
        $this->load->model('Post_model', 'post');
        $post = $this->post->get_one([
            'id' => $id,
        ]);
        if (!isset($post['id'])) {
            $this->_error(Message::NO_RECORD_ERROR['code'], Message::NO_RECORD_ERROR['msg']);
        }
        $data = [
            'id' => $id,
            'title' => $post['title'],
            'sub_title' => $post['sub_title'],
            'main_pic' => $post['pic'],
            'vice_pic' => $post['sub_pic'],
            'cate_id' => $post['cate_id'],
            'summary' => $post['summary'],
            'tags' => explode(',', $post['tags']),
            'post_style' => $post['post_style'],
        ];
        $content = json_decode($post['content'], true);
        $data['cols_num'] = count($content) > 0 ? count($content) : 1;
        for ($i = 0; $i < count($content); $i ++) {
            $data['col_' . ($i + 1)] = $content[$i]['content'];
            $data['col_' . ($i + 1) . '_class'] = $content[$i]['class'];
        }
        return $data;
    }

    private function get_all_category()
    {
        $this->load->model('Category_model', 'cate');
        return $this->cate->get_all_category();
    }

    private function get_all_category_2()
    {
        $this->load->model('Category_model', 'cate');
        return $this->cate->get_all_category_2();

    }
}
