<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Survey_Model extends Base_Model {
	
	const TABLE_NAME = 'user_survey';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function save($data) {
        $result = true;
        $this->db->trans_begin();
        try {
            foreach ($data as $v) {
                if (!$this->add($v)) {
                    throw new Exception('insert record failed');
                }
            }
            $this->db->trans_commit();
        } catch (Exception $e) {
            $result = false;
            $this->db->trans_rollback();
        }
        return $result;
	}

}