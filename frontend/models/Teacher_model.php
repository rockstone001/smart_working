<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Teacher_Model extends Base_Model {
	
	const TABLE_NAME = 'teachers';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_teacher_by_lesson_id($lesson_id)
	{
		$this->db->select('teachers.*');
		$this->db->from('teachers');
		$this->db->join('lessons', 'teachers.id = lessons.teacher_id');
		$this->db->where([
			'lessons.id' => $lesson_id
		]);
		$query = $this->db->get();
		return $query->row_array();
	}

}