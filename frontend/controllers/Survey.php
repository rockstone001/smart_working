<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends Base_Controller {
    public $desc = '问卷调查';
    public $title = '问卷调查';

    public $js = [
        'home.js', 'survey.js'
    ];

    public $css = [
        'index.css', 'survey.css'
    ];

    public function index()
    {
//        print_r(config_item('survey')); die();
        $id = isset($_GET['id']) ? $_GET['id'] : config_item('current_survey');
        $this->view('survey/index', [
            'questions' => config_item('survey')[$id]['questions'],
            'header' => config_item('survey')[$id]['header'],
            'if_answered' => $this->if_answered($id),
            'id' => $id,
        ]);
    }

    public function save()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $post = $this->input->post();
//        print_r($post);
        $data = [];
        $user = $this->get_user();
        $questions = config_item('survey')[$id]['questions'];

        if (count($questions) != count($post) || empty($id)) {
            $this->_error('400003', '参数错误');
        }
//        print_r($questions);
        for ($i = 0; $i < count($questions); $i ++) {
//            echo $post['a' . $i];
            if (in_array($questions[$i]['type'], [
                'radio', 'text'
            ])) {
                $data[] = $this->get_data($user['id'], $i, $post['a' . $i], $id);

            } elseif ($questions[$i]['type'] == 'checkbox') {
                foreach (explode(',', $post['a' . $i]) as $v) {
                    $data[] = $this->get_data($user['id'], $i, $v);
                }
            }
        }
        $this->load->model('User_survey_model', 'user_survey');
        if ($this->user_survey->save($data)) {
            $this->_success('保存成功');
        } else {
            $this->_error('400003', '保存问卷失败');
        }
    }

    private function get_data($uid, $q_id, $answer, $id)
    {
//        echo $uid . '-' . $q_id . '-' . $answer;
        return [
            'uid' => $uid,
            'survey_id' => $id,
            'q_id' => $q_id,
            'answer' => $answer,
        ];
    }

    public function if_answered($id)
    {
        $this->load->model('User_survey_model', 'user_survey');
        $user = $this->get_user();
        $data = $this->user_survey->get_one([
            'uid' => $user['id'],
            'survey_id' => $id,
        ]);
        return isset($data['id']);
    }

    public function survey_list()
    {
        $this->view('survey/list');
    }

    /**
     * @desc 获取调查列表
     */
    public function get_list()
    {
        $survey = config_item('survey');
        $data = [];
        foreach ($survey as $k => $v) {
            $data[] = [
                'id' => $k,
                'title' => $v['title'],
            ];
        }
        $this->_success($data);
    }
}
