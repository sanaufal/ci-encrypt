<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class profile extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Division_model');
    }

    function index() {
        $sess = $this->session->userdata('userdata');
        if ($this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';
            if ($this->input->post('action') == 'update-pass') {
                $params = array(
                    'user_pass' => md5($this->input->post('passTo'))
                );
                $data = $this->User_model->getPass($sess['user_id']);
                if (md5($this->input->post('pass')) == $data['user_pass']) {
                    $stat = $this->User_model->update($sess['user_id'], $params);
                    if ($stat == true) {
                        $ret = array('stat' => 1, 'mesg' => 'Berhasil Mengubah Password!');
                    } else {
                        $ret = array('stat' => 0, 'mesg' => 'Gagal Mengubah Password, Coba Cek Kembali');
                    }
                }
            }
            if ($this->input->post('action') == 'get-data') {
                $id = $sess['user_id'];
                $data = $this->User_model->edit($id);
                if ($data == true) {
                    $ret = array('stat' => 1, 'mesg' => 'Welcome!', 'data' => $data);
                } else {
                    $ret = array('stat' => 0, 'mesg' => 'Session Ended');
                }
            }
            if ($this->input->post('action') == 'save-contact') {
                $id = $sess['user_id'];
                $params = array(
                    'user_email' => $this->input->post('email'),
                    'user_addr' => $this->input->post('addr'),
                    'user_country' => $this->input->post('country'),
                    'user_state' => $this->input->post('state'),
                    'user_city' => $this->input->post('city'),
                    'user_phone' => $this->input->post('phone')
                );
                $data = $this->User_model->update($id, $params);
                if ($data == true) {
                    $ret = array('stat' => 1, 'mesg' => 'Berhasil Menyimpan Data');
                } else {
                    $ret = array('stat' => 0, 'mesg' => 'Gagal Menyimpan Data');
                }
            }
            if ($this->input->post('action') == 'save-profile') {
                $id = $sess['user_id'];
                $params = array(
                    'user_name' => $this->input->post('username'),
                    'user_full_name' => $this->input->post('fullname'),
                    'user_role' => $this->input->post('role'),
                    'user_gender' => $this->input->post('gender'),
                    'user_stat' => $this->input->post('stat'),
                    'user_division' => $this->input->post('divisi'),
                );
                $data = $this->User_model->update($id, $params);
                if ($data == true) {
                    $ret = array('stat' => 1, 'mesg' => 'Berhasil Menyimpan Data');
                } else {
                    $ret = array('stat' => 0, 'mesg' => 'Gagal Menyimpan Data');
                }
            }
            if ($this->input->post('action') == 'update-img') {
                $id = $sess['user_id'];
                $tempdir = 'resources/uploads/photo/';
                $upload = $this->input->post('upload');
                $image_array_1 = explode(";", $upload);
                $image_array_2 = explode(",", $image_array_1[1]);
                $data = base64_decode($image_array_2[1]);
                $imageName = time() . '.png';
                $stat = file_put_contents($tempdir . $imageName, $data);
                if ($stat) {
                    $info = $this->User_model->get_image($id);
                    if ($info && $info['user_id']) {
                        $params = array(
                            'user_photo' => $imageName
                        );
                        if (!empty($info['user_photo'])) {
                            if (file_exists($tempdir . $info['user_photo'])) {
                                unlink($tempdir . $info['user_photo']);
                            }
                        }
                        $stat2 = $this->User_model->update($id, $params);
                        if ($stat2 == true) {
                            $ret = array('stat' => 1, 'mesg' => 'Image Saved');
                        } else {
                            $ret = array('stat' => 2);
                        }
                    }
                } else {
                    $ret = array('stat' => 0);
                }
            }
            echo json_encode($ret);
        } else {
            $data['_division'] = $this->Division_model->getDivisi();
            $data['_role'] = $this->User_model->selectRoles();
            $data['_title'] = 'Profile';
            $data['_menu'] = 'profile';
            $data['_script'] = 'profile/index_js';
            $data['_view'] = 'profile/index';
            $this->load->view('layout/index', $data);
        }
    }

}
