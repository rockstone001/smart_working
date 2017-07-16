<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu_Model extends Base_Model {
	
	const TABLE_NAME = 'menu';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

    /**
     * @return mixed
     * @desc 获取菜单  目前支持两层菜单
     */
	public function get_menu()
	{
		$data = [];
		foreach ($this->get_all_menu() as &$menu) {
            if (trim($menu['custom_link']) != '') {
                $menu['link'] = $menu['custom_link'];
            } else {
                $menu['link'] = config_item('index_url') . $menu['link'];
            }

            if ($menu['parent_id'] == 0) {
                $data[$menu['id']] = array_merge($menu, [
                    'subnav' => []
                ]);
                $data[$menu['id']]['selected'] = $this->check_menu_selected($menu);
            } else {
                $data[$menu['parent_id']]['subnav'][] = $menu;
                if ($this->check_menu_selected($menu)) {
                    $data[$menu['parent_id']]['selected'] = true;
                }
            }

		}
//        print_r($data);die();
        return $data;
	}

	private function get_all_menu()
	{
		$query = $this->db->select('id, name, parent_id, link, custom_link')
			->where([
				'state' => 1
			])->order_by('parent_id', 'asc')
            ->order_by('sequence', 'asc')
            ->get(self::TABLE_NAME);
		return $query->result_array();
	}

    private function check_menu_selected($menu=[])
    {
        $selected = false;
        switch (strtolower($this->router->class)) {
            case 'home':
                if (trim($menu['link']) == '' && trim($menu['custom_link']) == '') {
                    $selected = true;
                }
                break;
            case 'category':
                if (isset($this->router->uri->segments[2])) {
                    if (preg_match('/(category)\/(\d+)/', $menu['link'], $match)) {
                        if ($this->router->uri->segments[2] == $match[2]) {
                            $selected = true;
                        }
                    }
                }
                break;
            case 'post':
                if (isset($this->router->uri->segments[2])) {
                    if (preg_match('/(post)\/(\d+)/', $menu['link'], $match)) {
                        if ($this->router->uri->segments[2] == $match[2]) {
                            $selected = true;
                        }
                    } elseif (preg_match('/(category)\/(\d+)/', $menu['link'], $match)) {
                        $this->load->model('post_model', 'post');
                        $post_ids = $this->post->get_postid_by_cateid($match[2]);
                        if (in_array($this->router->uri->segments[2], $post_ids)) {
                            $selected = true;
                        }
                    }
                }
                break;
        }
        return $selected;
    }
}