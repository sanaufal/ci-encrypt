<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('Partner_model');
        $this->load->library('session');
    }

    function index() {
        $action = $this->input->post('action');
        if ($action) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            if ($this->input->post('action') == 'load') {
                $columns = array(
                    0 => 'partner_sekolah'
                );
                $limit = $this->input->post('length');
                $start = $this->input->post('start');
                $order = $columns[$this->input->post('order')[0]['column']];
                $dir = $this->input->post('order')[0]['dir'];

                $search = [];
                if ($this->input->post('search')['value']) {
                    $s = $this->input->post('search')['value'];
                    foreach ($columns as $k => $v) {
                        $search[$v] = $s;
                    }
                }

                $params = array();
                $datas = $this->Partner_model->get_all_partner($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Partner_model->get_count_partner($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            }
            if ($this->input->post('action') == 'save') {
                $params = array(
                    'partner_sekolah' => $this->input->post('partner_sekolah'),
                    'partner_address' => $this->input->post('partner_address'),
                    'partner_pic'=> $this->input->post('partner_pic'),
                    'partner_phone' => $this->input->post('partner_phone'),
                );
                $id = $this->Partner_model->add_partner($params);
                if ($id > 0) {
                    $path = FCPATH . 'assets/media/image/logo/';
                    $config['image_library'] = 'gd2';
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'png|svg|jpg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->input->post('upload') != "undefined") {
                        if ($this->upload->do_upload('upload')) {
                            $upload = $this->upload->data();
                            $raw_photo = $upload['raw_name'] . "-" . time() . $upload['file_ext'];
                            $old_name = $upload['full_path'];
                            $new_name = $path . $raw_photo;
                            if (rename($old_name, $new_name)) {
                                //compress
                                $compress['image_library'] = 'gd2';
                                $compress['source_image'] = 'assets/media/image/logo/' . $raw_photo;
                                $compress['new_image'] = 'assets/media/image/logo/' . $raw_photo;
                                $compress['width'] = 640;
                                $this->load->library('image_lib', $compress);
                                $this->image_lib->resize();

                                $data = $this->Partner_model->get_partner($id);
                                if ($data && $data['partner_id']) {
                                    $params = array(
                                        'partner_img' => $raw_photo
                                    );
                                    if (!empty($data['partner_img'])) {
                                        if (file_exists($path . $data['partner_img'])) {
                                            unlink($path . $data['partner_img']);
                                        }
                                    }
                                    $stat = $this->Partner_model->update_partner($id, $params);
                                    if ($stat == true) {
                                        $ret = array('stat' => 1, 'data' => $stat, 'mesg' => 'update to database');
                                    } else {
                                        $ret = array('stat' => 0, 'data' => $stat, 'mesg' => 'Error');
                                    }
                                }
                            }
                        } else {
                            $ret = array('stat' => 0, 'mesg' => $this->upload->display_errors());
                        }
                    } else {
                        $ret = array('stat' => 1, 'mesg' => 'insert');
                    }
                }
            }
            if ($this->input->post('action') == 'edit'){
                $id = $this->input->post('id');
                $data = $this->Partner_model->get_partner($id);
                $result = array('stat' => 1, 'data' =>$data);
                $ret->stat=1;
                $ret->result = $data;
            }
            if ($this->input->post('action') == 'update'){
                $id = $this->input->post('pertner_id');
                $data = array(
                    'partner_id' => $this->input->post('partner_id'),
                    'partner_sekolah' => $this->input->post('partner_sekolah'),
                    'partner_address' => $this->input->post('partner_address'),
                    'partner_pic' => $this->input->post('partner_pic'),
                    'partner_phone' => $this->input->post('partner_phone'),
                    'partner_img' => $this->input->post('partner_img'),
                );
                $set_data = $this->Partner_model->update_partner($id, $data);
                if ($set_data == true) {
                    $path = FCPATH . 'assets/media/image/logo/';
                    $config['image_library'] = 'gd2';
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'png|jpg|svg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->input->post('upload') != "undefined") {
                        if ($this->upload->do_upload('upload')) {
                            $upload = $this->upload->data();
                            $raw_photo = $upload['raw_name'] . "-" . time() . $upload['file_ext'];
                            $old_name = $upload['full_path'];
                            $new_name = $path . $raw_photo;
                            if (rename($old_name, $new_name)) {
                                //compress
                                $compress['image_library'] = 'gd2';
                                $compress['source_image'] = 'assets/media/image/logo/' . $raw_photo;
                                $compress['new_image'] = 'assets/media/image/logo/ '. $raw_photo;
                                $compress['width'] = 640;
                                $this->load->library('image_lib', $compress);
                                $this->image_lib->resize();

                                $data = $this->Partner_model->get_partner($id);
                                if ($data && $data['partner_id']) {
                                    $params = array(
                                        'partner_img' => $raw_photo
                                    );
                                    if (!empty($data['img'])) {
                                        if (file_exists($path . $data['partner_img'])) {
                                            unlink($path . $data['partner_img']);
                                        }
                                    }
                                    $stat = $this->Partner_model->update_partner($id, $params);
                                    if ($stat == true) {
                                        $ret = array('stat' => 1, 'data' => $stat, 'mesg' => 'update to database');
                                    } else {
                                        $ret = array('stat' => 0, 'data' => $stat, 'mesg' => 'Error');
                                    }
                                }
                            }
                        } else {
                            $ret = array('stat' => 0, 'mesg' => $this->upload->display_errors());
                        }
                    } else {
                        $ret = array('stat' => 1, 'mesg' => 'insert');
                    }
                }
                 if ($set_data == true) {
                     $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Data Berhasil Diperbarui');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Tidak Berhasil Memperbarui Data');
                }
            }
            echo json_encode($ret);
        } else {
            $data['_title'] = 'Program';
            $data['_menu'] = 'programmagang';
            $data['_submenu'] = 'partner';
            $data['_script'] = 'partner/index_js';
            $data['_view'] = 'partner/index';
            $this->load->view('layout/index', $data);
        }
    }

}
