<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Teacher_Model extends Base_Model {
	
	const TABLE_NAME = 'teachers';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

}