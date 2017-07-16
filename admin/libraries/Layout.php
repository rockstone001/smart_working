<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Layout
{

    private $obj;
    private $layout;

    public $desc = '网站描述';

    public function __construct($layout = "main")
    {
        $this->obj =& get_instance();
        $this->layout = 'layout/' . $layout;
    }

    public function setLayout($layout)
    {
        $this->layout = 'layout/' . $layout;
    }

    public function view($view, $data = null, $return = false)
    {
        $data['content_for_layout'] = $this->obj->load->view($view, $data, true);

        if ($return) {
            $output = $this->obj->load->view($this->layout, $data, true);
            return $output;
        } else {
            $this->obj->load->view($this->layout, $data, false);
        }
    }
}