<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_Model extends Base_Model {
	
	const TABLE_NAME = 'users';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}
}