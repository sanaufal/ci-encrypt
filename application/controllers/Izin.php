<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Izin extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Izin_model');
        $this->load->model('Generator_model');
    }

    function index() {
        $sess = $this->session->userdata('userdata');
        $action = $this->input->post('action');
        if ($action) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';
            if ($this->input->post('action') == 'load') {
                $columns = array(
                    '0' => 'izin_user',
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

                $params = array(
                    'izin_stat<' => 4,
                );

                $datas = $this->Izin_model->get_all_izins($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Izin_model->get_count_izins($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            }
            if ($this->input->post('action') == 'add') {
                $tipe = $this->input->post('izin_type');
                if ($tipe == 1) {
                    $inisial = 'SAKIT';
                } else {
                    $inisial = 'IZIN';
                }
                $req_code = $this->autonumber($inisial, $tipe);
                $data = array(
                    'izin_code' => $req_code,
                    'izin_user' => $sess['user_id'],
                    'izin_date' => date('Y-m-d'),
                    'izin_type' => $this->input->post('izin_type'),
                    'izin_date_start' => date('Y-m-d', strtotime($this->input->post('izin_date_start'))),
                    'izin_date_end' => date('Y-m-d', strtotime($this->input->post('izin_date_end'))),
                    'izin_note' => $this->input->post('izin_note'),
                    'izin_image' => $this->input->post('izin_image'),
                );
                $set_data = $this->Izin_model->add_izins($data);
                if ($set_data > 0) {
                    $path = FCPATH . 'assets/media/surat/';
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
                                $compress['source_image'] = 'assets/media/surat/' . $raw_photo;
                                $compress['new_image'] = 'assets/media/surat/ ' . $raw_photo;
                                $compress['width'] = 640;
                                $this->load->library('image_lib', $compress);
                                $this->image_lib->resize();

                                $data = $this->Izin_model->get_izins($set_data);
                                if ($data && $data['izin_id']) {
                                    $params = array(
                                        'izin_image' => $raw_photo
                                    );
                                    if (!empty($data['img'])) {
                                        if (file_exists($path . $data['izin_image'])) {
                                            unlink($path . $data['izin_image']);
                                        }
                                    }
                                    $stat = $this->Izin_model->update_izins($set_data, $params);
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
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Menambahkan Data');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Tidak Berhasil Menambahkan Data');
                }
            }
            if ($this->input->post('action') == 'edit') {
                $id = $this->input->post('id');
                $data = $this->Izin_model->get_izins($id);
                $result = array('stat' => 1, 'data' => $data);
                $ret->stat = 1;
                $ret->result = $data;
            }
            if ($this->input->post('action') == 'update') {
                $id = $this->input->post('izin_id');
                $data = array(
                    'izin_user' => $this->input->post('izin_user'),
                    'izin_type' => $this->input->post('izin_type'),
                    'izin_date_start' => date('Y-m-d', strtotime($this->input->post('izin_date_start'))),
                    'izin_date_end' => date('Y-m-d', strtotime($this->input->post('izin_date_end'))),
                    'izin_note' => $this->input->post('izin_note'),
                    'izin_image' => $this->input->post('izin_image'),
                );
                $set_data = $this->Izin_model->update_izins($id, $data);
                if ($set_data == true) {
                    $path = FCPATH . 'assets/media/surat/';
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
                                $compress['source_image'] = 'assets/media/surat/' . $raw_photo;
                                $compress['new_image'] = 'assets/media/surat/ ' . $raw_photo;
                                $compress['width'] = 640;
                                $this->load->library('image_lib', $compress);
                                $this->image_lib->resize();

                                $data = $this->Izin_model->get_izins($id);
                                if ($data && $data['izin_id']) {
                                    $params = array(
                                        'izin_image' => $raw_photo
                                    );
                                    if (!empty($data['img'])) {
                                        if (file_exists($path . $data['izin_image'])) {
                                            unlink($path . $data['izin_image']);
                                        }
                                    }
                                    $stat = $this->Izin_model->add_izins($id, $params);
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
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Memperbarui Data Siswa Magang');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Tidak Berhasil Memperbarui Data Siswa Magang');
                }
            }

            echo json_encode($ret);
        } else {
            $data['date_now'] = date('d-m-Y');
            $data['_title'] = 'Form Persetujuan';
            $data['_menu'] = 'formpersetujuan';
            $data['_submenu'] = 'izin';
            $data['_script'] = 'izin/script';
            $data['_view'] = 'izin/index';
            $this->load->view('layout/index', $data);
        }
    }

    function approved() {
        $sess = $this->session->userdata('userdata');
        $action = $this->input->post('action');
        if ($action) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';
            if ($this->input->post('action') == 'edit') {
                $id = $this->input->post('id');
                $data = $this->Izin_model->get_izins($id);
                $result = array('stat' => 1, 'data' => $data);
                $ret->stat = 1;
                $ret->result = $data;
            }
            if ($this->input->post('action') == 'stat') {
                $id = $this->input->post('id');
                $data = array(
                    'izin_stat' => $this->input->post('stat'),
                    'izin_by' => $sess['user_id'],
                    'izin_process_note' => $this->input->post('p_note'),
                    'izin_date_start' => date('Y-m-d', strtotime($this->input->post('date_start'))),
                    'izin_date_end' => date('Y-m-d', strtotime($this->input->post('date_end'))),
                );
                $set_data = $this->Izin_model->update_izins($id, $data);
                if ($set_data == true) {
                    $ret->stat = 1;
                    $ret->message = 'Berhasil disetujui';
                } else {
                    $ret->message = 'Gagal disetujui';
                }
            }
            echo json_encode($ret);
        } else {
            $data['_title'] = 'Form Approved';
            $data['_menu'] = 'formpersetujuan';
            $data['_submenu'] = 'approved';
            $data['_script'] = 'izin/approved_script';
            $data['_view'] = 'izin/approved';
            $this->load->view('layout/index', $data);
        }
    }

    function print() {
        $id = $this->input->post('id');
        $data['_izin'] = $this->Izin_model->get_izins($id);
        $data['_title'] = 'Print Izin';
        $this->load->view('cetak/izin', $data);
    }

    function autonumber($inisial, $tipe) {
        $last_number = $this->Izin_model->code($tipe);
        $auto_number = $inisial . '-' . $last_number;
        return $auto_number;
    }

}
