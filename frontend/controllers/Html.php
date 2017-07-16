<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Html extends Base_Controller {
    public $desc = '文章页';
	public $js = [
		'bootstrap-2.3.2/js/bootstrap-carousel.js', 'jcityzen.js?v=1.0'
	];

	public function index($file)
	{
		$this->setLayout('html');
		$this->view('html/index', [
			'file' => $file
		]);
	}
}
