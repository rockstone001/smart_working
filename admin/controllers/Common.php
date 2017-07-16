<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends Base_Controller {

    public $upload_config = [
        'upload_action' => 'longsha/medical-case/upload', /*上传附件的action*/
        'iframe_id' => 'upload_iframe', /*在dom 尾部创建的隐藏的iframe的id名*/
        'form_id' => 'upload_form', /*在dom 尾部创建的隐藏的form的id名*/
        'upload_btn_wrapper_id'=> 'upload_span', /*在页面中显示的上传控件的容器id*/
        'upload_name' => 'pic_upload', /*在页面中显示的上传控件的name*/
        'dest_path' => 'images/', /*上传文件的目录*/
        'dest_link' => '', /*上传文件之后访问该文件的链接*/
        'callback' => 'top.setAttachment', /*上传成功之后的回调函数 (写在包含上传用的iframe的父窗口或者顶层窗口中)*/
    ];

    public $preview_config = [
        'width' => 100,
        'height' => 100,
    ];

    /**
     * @desc 上传文件
     * @return string
     */
    public function upload($callback='')
    {
        $curr_date = date('Ymd');
        $_upload_config = $this->upload_config;
        $_upload_config['dest_path'] =  APPPATH . $_upload_config['dest_path'] . $curr_date . DIRECTORY_SEPARATOR;
        $_upload_config['dest_link'] = config_item('img_url') . $_upload_config['dest_link'] . $curr_date . DIRECTORY_SEPARATOR;

        try {
            if (!is_dir($_upload_config['dest_path'])) {
                if (!mkdir($_upload_config['dest_path'], 0777)) {
                    throw new \Exception('permission deny');
                }
            }
            if (!isset($_upload_config, $_upload_config['upload_name']) ) {
                throw new \Exception('upload config file error');
            } else {
                $index = $_upload_config['upload_name'];
            }

            if (!isset($_FILES[$index]) || !is_uploaded_file($_FILES[$index]['tmp_name'])) {
                throw new \Exception('upload file failed');
            }

            if (!move_uploaded_file($_FILES[$index]['tmp_name'],
                $_upload_config['dest_path'] . $_FILES[$index]['name'])) {
                throw new \Exception('directory permission deny');
            }
            $data = [
                'name' => $_FILES[$index]['name'],
                'link' => $_upload_config['dest_link'] . $_FILES[$index]['name'],
                'preview' => config_item('index_url') . '/common/preview?file=' .
                    urlencode($_upload_config['dest_link'] . $_FILES[$index]['name']),
                ];
            if (!empty($callback)) {
                echo '<script>' . $callback. '(' . json_encode($data) . ')' . '</script>';
                exit();
            } else
                $this->_success($data);
        } catch (\Exception $e) {
            $this->_error(Message::UPLOAD_ERROR['code'], $e->getMessage());
        }
    }

    /**
     * @desc 图片预览 返回略缩图
     * @param $imageName
     * @return string
     * http://192.168.1.11:8000/ci/taost/admin/index.php/common/preview/http%3A%2F%2F192.168.1.11%3A8000%2Fci%2Ftaost%2Fadmin%2Fimages%2F20161101%2F2.pic.jpg
     */
    public function preview()
    {
        $file = urldecode($_GET['file']);
        $size = $this->preview_config;
        $imageInfo = getimagesize($file);
        $supportedTypes = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];
        $quality = 50;
        try {
            if (($imageInfo !== false) && (in_array($imageInfo[2], $supportedTypes) === true)) {
//                print_r($imageInfo);
                $call = [];
                switch ($imageInfo[2]) {
                    case IMAGETYPE_GIF :
                        $call['create'] = 'imagecreatefromgif';
                        $call['out'] = 'imagegif';
                        break;
                    case IMAGETYPE_JPEG :
                        $call['create'] = 'imagecreatefromjpeg';
                        $call['out'] = 'imagejpeg';
                        break;
                    case IMAGETYPE_PNG :
                    default :
                        $call['create'] = 'imagecreatefrompng';
                        $call['out'] = 'imagepng';
                    $quality = 5;
                        break;
                }

                $image = call_user_func($call['create'], $file);

                $thumb = imagecreatetruecolor($size['width'], $size['height']);
                imagecopyresampled($thumb, $image, 0, 0, 0, 0, $size['width'], $size['height'], $imageInfo[0], $imageInfo[1]);

                call_user_func($call['out'], $thumb, null, $quality);
            } else {
                throw new \Exception('image type not support');
            }
        }catch (\Exception $e) {
            return $this->_error(Message::PREVIEW_ERROR['code'], $e->getMessage());
        }
    }

    /**
     * @desc 上传文件
     * @return string
     */
    public function upload_for_editor($callback='')
    {
        $curr_date = date('Ymd');
        $_upload_config = $this->upload_config;
        $_upload_config['dest_path'] =  APPPATH . $_upload_config['dest_path'] . $curr_date . DIRECTORY_SEPARATOR;
        $_upload_config['dest_link'] = config_item('img_url') . $_upload_config['dest_link'] . $curr_date . DIRECTORY_SEPARATOR;

        try {
            if (!is_dir($_upload_config['dest_path'])) {
                if (!mkdir($_upload_config['dest_path'], 0777)) {
                    throw new \Exception('permission deny');
                }
            }
            if (!isset($_upload_config, $_upload_config['upload_name']) ) {
                throw new \Exception('upload config file error');
            } else {
                $index = $_upload_config['upload_name'];
            }

            if (!isset($_FILES[$index]) || !is_uploaded_file($_FILES[$index]['tmp_name'])) {
                throw new \Exception('upload file failed');
            }

            if (!move_uploaded_file($_FILES[$index]['tmp_name'],
                $_upload_config['dest_path'] . $_FILES[$index]['name'])) {
                throw new \Exception('directory permission deny');
            }
            $data = [
                'name' => $_FILES[$index]['name'],
                'link' => $_upload_config['dest_link'] . $_FILES[$index]['name'],
                'preview' => config_item('index_url') . '/common/preview?file=' .
                    urlencode($_upload_config['dest_link'] . $_FILES[$index]['name']),
            ];
            if (!empty($callback)) {
                echo '<script>' . $callback. '(' . json_encode($data) . ')' . '</script>';
                exit();
            } else
                echo $_upload_config['dest_link'] . $_FILES[$index]['name'];
        } catch (\Exception $e) {
            $this->_error(Message::UPLOAD_ERROR['code'], $e->getMessage());
        }
    }
}
