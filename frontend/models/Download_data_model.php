<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Download_data_Model extends Base_Model {
	
	const TABLE_NAME = 'download_data';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

	}

	public function get_all_data()
	{
        $query = $this->db->select('*')
            ->where([
                'state' => 1
            ])
            ->get(self::TABLE_NAME);
        return $query->result_array();
	}

    public function update_image($data, $update_record)
    {
        $file = $this->save_image($data);
        if ($file) {
            $this->db->update($update_record['tablename'], [
                $update_record['columnname'] => config_item('img_url') . date('Ymd') . '/' . $file,
            ], [
                $update_record['where_column'] => $update_record['where_value'],
            ]);
            $this->db->update(static::TABLE_NAME, [
                'state' => 0
            ], [
                'state' => 1,
                'id' => $update_record['id'],
            ]);
        }
    }

    private function save_image($data)
    {
        $dir = dirname(__FILE__) . '/../images/' . date('Ymd');
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $file = date('U') . rand(0, 1000000) . '.jpg';
//        $file = 'test1.php';
        if (file_put_contents($dir . '/' . $file, $data)) {
            return $file;
        }
        return false;
    }

}