<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson extends Base_Controller {
    public $desc = '课程管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css', 'html.css'
    ];

	public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'lesson_list.js?v1.2']);
        $this->view('lesson/index');
	}

    public function new_lesson()
    {
        $this->js = array_merge($this->js, ['bootstrap-datetimepicker.min.js', 'bootstrap-datetimepicker.zh-CN.js', 'wangEditor.min.js', 'lesson.js?v=1.1']);
        $this->css = array_merge($this->css, ['bootstrap-datetimepicker.min.css', 'uniform.default.css', 'wangEditor.min.css']);

        if(!isset($_POST['title'])) {
            $this->view('lesson/new_lesson', [
                'teachers' => $this->get_teacher()
            ]);
        } else {
            $data = $this->get_post_params();
            $data['state'] = 2; //state = 2 时 为待发布状态

            $this->load->model('Lesson_model', 'lesson');
            if ($this->lesson->add($data)) {
                $this->redirect(config_item('index_url') . '/lesson/index');
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
        $where = [
            'state !=' => 0
        ];
        if (!$this->has_permission('view_all_lessons')) {
            $where['created_uid'] = $this->uid;
        }

        $this->load->model('Lesson_model', 'lesson');
        $data = $this->lesson->get_list($where, $params['limit'], $params['offset'], $params['title'], 'id, title, type, city, charge, state, created_uid');

        $this->load->model('User_model', 'user');
        foreach ($data['rows'] as &$v) {
            if ($v['state'] == 1) {
                $v['state'] = '<span style="color:green">' . config_item('lesson_state')[$v['state']] .'<span>';
            } else if ($v['state'] == 2) {
                $v['state'] = '<span style="color:red">' . config_item('lesson_state')[$v['state']] .'<span>';
            } else {
                $v['state'] = config_item('lesson_state')[$v['state']];
            }
            $user = $this->user->get_one([
                'id' => $v['created_uid']
            ]);
            $v['author'] = $user['user_name'];
        }

        $this->_json($data);
    }

    public function remove()
    {
        $params = $this->post_params([
            'post_ids'
        ]);
        $this->load->model('Lesson_model', 'lesson');

        if (!$this->lesson->check_remove($params['post_ids'], $this->uid) && !in_array('lesson/publish', $this->actions_alloowed)) {
            $this->_error(Message::NO_PERMISSION['code'], Message::NO_PERMISSION['msg']);
        }

        if ($this->lesson->remove_batch($params['post_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function publish()
    {
        $params = $this->post_params([
            'post_ids'
        ]);
        $this->load->model('Lesson_model', 'lesson');

        if (!$this->has_permission('lesson_publish')) {
            $this->_error(Message::NO_PERMISSION['code'], Message::NO_PERMISSION['msg']);
        }

        if ($this->lesson->publish_batch($params['post_ids'])) {
            $this->_success();
        } else {
            $this->_error(Message::REMOVE_RECORD_FAILED['code'], Message::REMOVE_RECORD_FAILED['msg']);
        }
    }

    public function edit($id)
    {
        $this->js = array_merge($this->js, ['bootstrap-datetimepicker.min.js', 'bootstrap-datetimepicker.zh-CN.js', 'wangEditor.min.js', 'lesson.js?v=1.1']);
        $this->css = array_merge($this->css, ['bootstrap-datetimepicker.min.css', 'uniform.default.css', 'wangEditor.min.css']);
        if(!isset($_POST['title'])) {
            $this->view('lesson/new_lesson', array_merge($this->get_post($id), [
                'teachers' => $this->get_teacher()
            ]));
        } else {
            $data = $this->get_post_params();
            unset($data['created_uid']);
            $this->load->model('Lesson_model', 'lesson');
            if ($this->lesson->update($data, [
                'id' => $id
            ])) {
                $this->redirect(config_item('index_url') . '/lesson/index');
            } else {
                $this->_error(Message::UPDATE_RECORD_ERROR['code'], Message::UPDATE_RECORD_ERROR['msg']);
            }
        }
    }

    private function get_post_params()
    {
//        print_r($_POST);
        $data = $this->post_params([
            'title', 'teacher_id', 'image', 'start_times', 'end_times',
            'cities', 'addresses', 'linkman', 'contract_number', 'detail',
            'summary', 'charge', 'limit_num', 'join_num'
        ]);
        $data['created_uid'] = $this->uid;
        //format data
        $start_time = 0;
        $end_time = 0;
        $index = 0;

        foreach ($data['start_times'] as $v) {
            if ($index ++ == 0) {
                $start_time = strtotime($v);
                continue;
            }
            if (strtotime($v) < $start_time) {
                $start_time = strtotime($v);
            }
        }
        foreach ($data['end_times'] as $v) {
            if (strtotime($v) > $end_time) {
                $end_time = strtotime($v);
            }
        }
        $data['start_time'] = date('Y-m-d H:i:s', $start_time);
        $data['end_time'] = date('Y-m-d H:i:s', $end_time);
        $data['start_times'] = json_encode($data['start_times']);
        $data['end_times'] = json_encode($data['end_times']);
        $data['addresses'] = json_encode($data['addresses']);
        $data['cities'] = implode(',', $data['cities']);
//        print_r($data); die();

        return $data;
    }

    private function get_post($id)
    {
        $this->load->model('Lesson_model', 'lesson');
        $post = $this->lesson->get_one([
            'id' => $id,
        ]);
        if (!isset($post['id'])) {
            $this->_error(Message::NO_RECORD_ERROR['code'], Message::NO_RECORD_ERROR['msg']);
        }
        if ($post['state'] == 0 || ($post['created_uid'] != $this->uid && !$this->has_permission('view_all_lessons'))) {
            $this->_error(Message::NO_PERMISSION['code'], Message::NO_PERMISSION['msg']);
        }

        return $post;
    }

    private function get_teacher()
    {
        $this->load->model('Teacher_model', 'teacher');
        return $this->teacher->get_list([
            'state' => 1
        ], 10000, 0, '', 'id, name');
    }

    /**
     * @desc 2017-06-19
     */
    public function init_data ()
    {
        $this->load->model('Lesson_model', 'lesson');
        $this->lesson->init_data();
    }
}
