<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category_Model extends Base_Model {
	
	const TABLE_NAME = 'category';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_cate_by_parent_id() {

	}

}