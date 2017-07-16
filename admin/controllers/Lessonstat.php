<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lessonstat extends Base_Controller {
    public $desc = '报名管理';

    public $js = [
    ];

    public $css = [
        'index.css',  'bootstrap-table.min.css'
    ];

	public function index()
	{
        $this->js = array_merge($this->js, ['bootstrap-table.min.js', 'bootstrap-table-zh-CN.min.js', 'stat_list.js']);
        $this->view('lessonstat/index');
	}

    public function get_list()
    {
        $params = $this->get_params([
            'limit', 'offset', 'title'
        ]);

        $where = [
            'state' => 1
        ];
        if (!$this->has_permission('view_all_lessonstat')) {
            $where['created_uid'] = $this->uid;
        }

        $this->load->model('Lesson_model', 'lesson');
        $data = $this->lesson->get_list($where, $params['limit'], $params['offset'], $params['title'], 'id, title, charge, join_num', 'title');

        $this->_json($data);
    }


    public function detail($id)
    {
        $this->load->model('Lesson_model', 'lesson');
        $this->load->model('Order_model', 'order');
        $this->js = array_merge($this->js, ['stat.js']);
        $lesson = $this->lesson->get_one([
            'id' => $id
        ]);
        if (!$this->has_permission('view_all_lessonstat') && $lesson['created_uid'] != $this->uid) {
            $this->_error(Message::NO_PERMISSION['code'], Message::NO_PERMISSION['msg']);
        }

        $this->view('lessonstat/detail', array_merge($lesson, [
            'orders' => $this->order->get_order_list([
                'orders.state' => 1,
                'orders.lesson_id' => $id
            ], 1000)
        ]));

    }

    public function export($id) {
//        echo chr(ord('A') + 1);
//        die();
        if (!$this->has_permission('export_userinfo')) {
            $this->_error(Message::NO_PERMISSION['code'], Message::NO_PERMISSION['msg']);
        }
        $this->load->model('Lesson_model', 'lesson');
        $lesson = $this->lesson->get_one([
            'id' => $id,
        ]);

        $this->load->model('User_info_model', 'userinfo');
        $data = $this->userinfo->get_users_by_lessonid($id);

        $format_data = [];
        $title = '';
        foreach ($data as $row) {
            $format_data[$row['city'] . '-' . $row['start_time']. '-' . $row['address']][] = $row;
            if (empty($row['city'])) {
                $title = $lesson['city'] . '-' . $lesson['start_time']. '-' . $lesson['address'];
            }
        }
        require_once dirname(__FILE__) . '/../PHPExcel/Classes/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator("daosheng")
            ->setLastModifiedBy("daosheng")
            ->setTitle("User Info")
            ->setSubject("User Info")
            ->setDescription("User Info")
            ->setKeywords("office 2007 openxml php User Info")
            ->setCategory("Test result file");

        $index = 1;
        foreach ($format_data as $key => $data) {
            if (!empty($title)) {
                $key = $title;
            }
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $index, $key);
            $excel->getActiveSheet(0)->getStyle('A' . $index)->applyFromArray([
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FF7F24')
                )
            ]);
            $index ++;
            if (count($data) > 0) {
                $keys = array_keys($data[0]);
                for ($i = 0; $i < count($keys); $i ++) {
                    if (in_array($keys[$i], ['city', 'address', 'start_time', 'end_time'])) {
                        continue;
                    }
                    $column = chr(ord('A') + $i) . $index;
                    $excel->setActiveSheetIndex(0)->setCellValue($column, $keys[$i]);
                    $excel->getActiveSheet(0)->getStyle($column)->applyFromArray([
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'd4d4d4')
                        )
                    ]);
                }
                $index ++;
            }
            foreach ($data as $row) {
                $i = 0;
                foreach ($row as $k => $v) {
                    if (in_array($k, ['city', 'address', 'start_time', 'end_time'])) {
                        continue;
                    }
                    $column = chr(ord('A') + ($i ++)) . $index;
                    $excel->setActiveSheetIndex(0)->setCellValue($column, $v);
                }
                $index ++;
            }
        }
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $lesson['title'] . '-UserInfo.xls"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
}
