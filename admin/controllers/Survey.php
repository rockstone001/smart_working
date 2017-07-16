<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends Base_Controller {
    public $desc = '问卷管理';

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

	public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'survey_list.js']);
        $this->view('survey/index');
	}

    public function get_list()
    {
        $surveys = config_item('survey');
        $data['total'] = count($surveys);
        foreach ($surveys as $k => $s) {
            $data['rows'][$k]['id'] = $k;
            $data['rows'][$k]['title'] = $s['title'];
        }

        $this->_json($data);
    }

   public function survey_stat($id)
   {
       $this->js = array_merge($this->js, ['echarts.common.min.js', 'survey.js']);
       $this->load->model('User_survey_model', 'survey');

       $this->view('survey/survey_stat', [
           'survey' => config_item('survey')[$id],
           'stat' => $this->survey->get_stat_by_lessonid($id),
       ]);
   }
}
