<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Survey_Model extends Base_Model {
	
	const TABLE_NAME = 'user_survey';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_stat_by_lessonid($survey_id)
	{
        $ci = get_instance();
        $ci->load->model('Users_Model', 'users');
		$sql = "select count(*) as num, q_id, answer, uid from user_survey where survey_id = $survey_id group by q_id, answer";
		$query = $this->db->query($sql);
		$rows = $query->result_array();
		$data = [];
		$survey = config_item('survey')[$survey_id]['questions'];

//        print_r($survey); die();
		foreach ($rows as $row) {
            if ($survey[$row['q_id']]['type'] != 'text') {
                $data[$row['q_id']][$row['answer']] = $row['num'];
            } else {
                $user = $ci->users->get_one([
                    'id' => $row['uid']
                ]);
                $data[$row['q_id']][$row['answer']] = [
                    'nickname' => $user['nickname'],
                    'avatar' => $user['headimgurl']
                ];
            }

		}
//		print_r($data); die();
		return $data;
	}


}